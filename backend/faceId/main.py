from flask import Flask, request, jsonify
from flask_cors import CORS
import base64
import sqlite3
import numpy as np
import cv2
from skimage.metrics import structural_similarity as ssim

app = Flask(__name__)
CORS(app)

def base64ParaImg(valorBase64):
    try:
        if "base64," in valorBase64:
            valorBase64 = valorBase64.split("base64,")[1]

        missing_padding = len(valorBase64) % 4
        if missing_padding:
            valorBase64 += '=' * (4 - missing_padding)

        img_data = base64.b64decode(valorBase64)
        np_arr = np.frombuffer(img_data, np.uint8)
        img = cv2.imdecode(np_arr, cv2.IMREAD_COLOR)

        return img
    except Exception as e:
        print(f"Erro ao converter base64 para imagem: {e}")
        return None

def preprocess(img):
    # Redimensiona para 224x224
    img_resized = cv2.resize(img, (224, 224))

    # Converte para escala de cinza
    gray = cv2.cvtColor(img_resized, cv2.COLOR_BGR2GRAY)

    # Equalização do histograma para melhorar contraste (ajuda com iluminação)
    equalized = cv2.equalizeHist(gray)

    # Aplicar um filtro bilateral para preservar bordas e reduzir ruído
    filtered = cv2.bilateralFilter(equalized, d=9, sigmaColor=75, sigmaSpace=75)

    return filtered

def compararImagem(img1, img2):
    try:
        img1_prep = preprocess(img1)
        img2_prep = preprocess(img2)

        score, _ = ssim(img1_prep, img2_prep, full=True)
        print(f"compararImagem - SSIM score: {score}")
        return score
    except Exception as e:
        print(f"Erro na comparação: {e}")
        return 0

@app.route('/comparacao', methods=['POST'])
def compare():
    data = request.get_json()
    print("compare - dados recebidos:", data)

    nova_imagem_base64 = data.get('faceId')
    id_funcionario = data.get('idFuncionario')

    if not nova_imagem_base64 or not id_funcionario:
        return jsonify({'erro': 'Dados incompletos'}), 400

    nova_img = base64ParaImg(nova_imagem_base64)
    if nova_img is None:
        return jsonify({'erro': 'Falha ao decodificar imagem recebida'}), 400

    try:
        db_path = r'C:\xampp\htdocs\dataBase\bancoDados.db'
        conn = sqlite3.connect(db_path)
        cursor = conn.cursor()
        cursor.execute("SELECT FACEID FROM FUNCIONARIOS WHERE ID_FUNCIONARIO = ?", (id_funcionario,))
        row = cursor.fetchone()
        conn.close()
    except Exception as e:
        return jsonify({'erro': f'Erro ao acessar banco de dados: {e}'}), 500

    if not row:
        return jsonify({'erro': 'Imagem base do banco não encontrada'}), 404

    imagem_base_b64 = row[0]
    imagem_base = base64ParaImg(imagem_base_b64)

    if imagem_base is None:
        return jsonify({'erro': 'Falha ao decodificar imagem do banco'}), 500

    score = compararImagem(nova_img, imagem_base)

    # Threshold mais alto para aumentar a precisão
    threshold = 0.82
    resultado = 'IGUAL' if score >= threshold else 'DIFERENTE'

    return jsonify({
        'success': resultado == 'IGUAL',
        'resultado': resultado,
        'score': float(f"{score:.4f}")
    })

if __name__ == '__main__':
    app.run(debug=True)
