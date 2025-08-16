import cv2
import mediapipie as mp
import numpy as np

mp_face_mesh = mp.solutions.face_mesh

def get_face_landmarks(image):
    with mp_face_mesh.FaceMesh(static_image_mode=True, max_num_faces=1, refine_landmarks=True) as face_mesh:
        img_rgb = cv2.cvtColor(image, cv2.COLOR_BGR2RGB)
        results = face_mesh.process(img_rgb)

        if results.multi_face_landmarks:
            landmarks = results.multi_face_landmarks[0]
            return [(lm.x, lm.y, lm.z) for lm in landmarks.landmark]
        else:
            return None

cap = cv2.VideoCapture(0)
print("Pressione 'c' para capturar a imagem do rosto...")

while True:
    ret, frame = cap.read()
    cv2.imshow("Captura - pressione 'c'", frame)

    if cv2.waitKey(1) & 0xFF == ord('c'):
        img_capturada = frame.copy()
        break

cap.release()
cv2.destroyAllWindows()

img_referencia = cv2.imread("face_referencia.jpg")
if img_referencia is None:
    print("Erro: Não foi possível carregar a imagem 'face_referencia.jpg'")
    exit()

landmarks1 = get_face_landmarks(img_capturada)
landmarks2 = get_face_landmarks(img_referencia)

if not landmarks1 or not landmarks2:
    print("Rosto não detectado em uma das imagens.")
    exit()

def compare_faces(lm1, lm2):
    lm1 = np.array(lm1)
    lm2 = np.array(lm2)
    diff = np.linalg.norm(lm1 - lm2, axis=1)
    return np.mean(diff)

similaridade = compare_faces(landmarks1, landmarks2)


print(f"Distância média entre os rostos: {similaridade:.4f}")
if similaridade < 0.02:
    print("✅ Rostos são semelhantes!")
else:
    print("❌ Rostos diferentes.")

