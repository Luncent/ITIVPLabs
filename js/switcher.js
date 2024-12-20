const toggleCircle = document.getElementById('toggleCircle');
const taskButtons = document.querySelectorAll('.taskButton');
const updateButtonTasks = document.querySelectorAll('.updateButtonTask');
const updateButtonModals = document.querySelectorAll('.updateButtonModal');
const warningMessage = document.getElementById('warningMessage');
const login = document.getElementById("login").textContent;

// Функция для установки cookie
function setCookie(value) {
    document.cookie = `${login}=${value}; max-age=604800;  path=/`;
}

// Функция для получения cookie
function getCookie(name) {
    const cookies = document.cookie.split('; ').reduce((acc, cookie) => {
        const [key, value] = cookie.split('=');
        acc[key] = value;
        return acc;
    }, {});
    return cookies[name];
}

let isRemote = getCookie(login) == 'remote' ? 'true' : 'false';


// Проверка cookie при загрузке страницы
document.addEventListener('DOMContentLoaded', () => {
    if (!getCookie(login)) {
        showWarning();
    }
});

// Обработчик клика на круглом элементе
toggleCircle.addEventListener('click', () => {
    if (isRemote === 'true') {
        toggleCircle.style.left = '5px';
        setCookie('office');
        isRemote = 'false';
    } else {
        toggleCircle.style.left = '145px';
        setCookie('remote');
        isRemote = 'true';
    }

    // Скрыть предупреждение и активировать кнопки
    hideWarning();
});

// Постоянная проверка наличия cookie
setInterval(() => {
    if (!getCookie(login)) {
        showWarning();
    }
}, 1000);

// Функция показа предупреждения
function showWarning() {
    warningMessage.style.display = 'block';
    taskButtons.forEach((button) => {
        button.classList.add('disabled');
        button.disabled = true;
    });

    updateButtonTasks.forEach((button) => {
        button.classList.add('disabled');
        button.disabled = true;
    });

    updateButtonModals.forEach((button) => {
        button.classList.add('disabled');
        button.disabled = true;
    });
}

// Функция скрытия предупреждения
function hideWarning() {
    warningMessage.style.display = 'none';
    taskButtons.forEach((button) => {
        button.classList.remove('disabled');
        button.disabled = false;
    });

    updateButtonTasks.forEach((button) => {
        button.classList.remove('disabled');
        button.disabled = false;
    });

    updateButtonModals.forEach((button) => {
        button.classList.remove('disabled');
        button.disabled = false;
    });
}