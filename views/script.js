// Configurações globais
const CONFIG = {
    apiUrl: 'https://api.sistemadeponto.com/v1',
    recognitionThreshold: 0.7,
    maxAttempts: 3
};

// Elementos da DOM
const elements = {
    video: document.getElementById('video'),
    canvas: document.getElementById('canvas'),
    captureBtn: document.getElementById('capture-btn'),
    recognitionOverlay: document.getElementById('recognition-overlay'),
    employeeName: document.getElementById('employee-name')
};

// Estado da aplicação
let state = {
    currentUser: null,
    isRecognizing: false,
    recognitionAttempts: 0
};

// Inicialização da câmera
async function initCamera() {
    try {
        const stream = await navigator.mediaDevices.getUserMedia({ 
            video: { 
                width: 1280, 
                height: 720,
                facingMode: 'user' 
            } 
        });
        elements.video.srcObject = stream;
    } catch (err) {
        console.error('Erro ao acessar a câmera:', err);
        showNotification('error', 'Permissão de câmera negada. Por favor, habilite o acesso à câmera.');
    }
}

// Simulação de reconhecimento facial
function simulateRecognition() {
    state.isRecognizing = true;
    state.recognitionAttempts++;
    
    elements.recognitionOverlay.classList.remove('hidden');
    elements.employeeName.textContent = 'João Silva (TI)';

    // Simular tempo de processamento
    setTimeout(() => {
        if (state.recognitionAttempts >= CONFIG.maxAttempts) {
            showNotification('error', 'Falha no reconhecimento. Tente novamente ou contate o administrador.');
        } else {
            showNotification('success', 'Funcionário reconhecido com sucesso!');
            registerAttendance();
        }
        
        elements.recognitionOverlay.classList.add('hidden');
        state.isRecognizing = false;
    }, 3000);
}

// Registrar ponto
function registerAttendance() {
    // Simular chamada à API
    console.log('Ponto registrado para:', elements.employeeName.textContent);
    showNotification('success', 'Ponto registrado com sucesso!');
}

// Mostrar notificação
function showNotification(type, message) {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} fixed top-4 right-4 z-50`;
    notification.innerHTML = `
        <div class="flex items-center">
            <i class="fas fa-${type === 'success' ? 'check' : 'exclamation'} mr-2"></i>
            <span>${message}</span>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.classList.add('opacity-0', 'transition-opacity', 'duration-300');
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Navegação entre páginas
function navigateTo(page) {
    window.location.href = `${page}.html`;
}

// Event Listeners
document.addEventListener('DOMContentLoaded', () => {
    if (elements.video) {
        initCamera();
    }
    
    if (elements.captureBtn) {
        elements.captureBtn.addEventListener('click', simulateRecognition);
    }
});

// Exportar para testes (se necessário)
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        initCamera,
        simulateRecognition,
        registerAttendance,
        showNotification
    };
}