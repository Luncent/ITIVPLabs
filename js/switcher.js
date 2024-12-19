const toggleCircle = document.getElementById('toggleCircle');
const taskButtons = document.querySelectorAll('.taskButton');
const updateButtonTasks = document.querySelectorAll('.updateButtonTask');
const updateButtonModals = document.querySelectorAll('.updateButtonModal');
const warningMessage = document.getElementById('warningMessage');

let isRemote = "<?php  $_COOKIE['work_mode'] == 'remote' ? 'true' : 'false'; ?>";

// Функция для установки cookie
function setCookie(name, value, days) {
    const expires = new Date(Date.now() + days * 86400 * 1000).toUTCString();
    document.cookie = `${name}=${value}; expires=${expires}; path=/`;
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

// Проверка cookie при загрузке страницы
document.addEventListener('DOMContentLoaded', () => {
    if (!getCookie('work_mode')) {
        showWarning();
    }
});

// Обработчик клика на круглом элементе
toggleCircle.addEventListener('click', () => {
    if (isRemote === 'true') {
        toggleCircle.style.left = '5px';
        setCookie('work_mode', 'office', 30);
        isRemote = 'false';
    } else {
        toggleCircle.style.left = '145px';
        setCookie('work_mode', 'remote', 30);
        isRemote = 'true';
    }

    // Скрыть предупреждение и активировать кнопки
    hideWarning();
});

// Постоянная проверка наличия cookie
setInterval(() => {
    if (!getCookie('work_mode')) {
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
    warningMessage.textContent = 'none';
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