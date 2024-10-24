document.addEventListener('DOMContentLoaded', function() {
    // Получаем элементы
    const modal = document.getElementById("myModal");
    const closeButtons = document.getElementsByClassName("closeModal");
    const userInfo = document.getElementById("userInfo");

    // Обработчик событий для кнопок
    document.querySelectorAll('.openModal').forEach(button => {
        button.onclick = function() {
            const id = this.getAttribute('data-id');
            const title = this.getAttribute('data-title');
            const description = this.getAttribute('data-description');

            const htmlContent = `
                <input type="hidden" name="taskId" value="${id}">
                <div class="mb-3">
                    <label for="formGroupExampleInput" class="form-label">Задание</label>
                    <label for="formGroupExampleInput" class="form-label">${title}</label>
                </div>
                <div class="mb-3">
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="description">${description}</textarea>
                </div>
            `;
            // Обновляем содержимое модельного окна
            userInfo.innerHTML = htmlContent;
            modal.style.display = "block"; // Открываем модельное окно
        }
    });


    for (let i = 0; i < closeButtons.length; i++) {
        closeButtons[i].onclick = closeModal;
    }
    // Закрытие модельного окна
    function closeModal() {
        modal.style.display = "none";
    }
});