document.addEventListener('DOMContentLoaded', function() {
    // Получаем элементы
    const modal = document.getElementById("myModal");
    const closeButtons = document.getElementsByClassName("closeModal");
    const userInfo = document.getElementById("userInfo");

    // Обработчик событий для кнопок
    document.querySelectorAll('.openModal').forEach(button => {
        button.onclick = function() {
            const id = this.getAttribute('data-id');
            const dayOfWeek = this.getAttribute('data-dayOfWeek');
            const startTime = this.getAttribute('data-startTime');
            const endTime = this.getAttribute('data-endTime');
            const department = this.getAttribute('data-department');

            const htmlContent = `
                <input type="hidden" name="id" value="${id}">
                <div class="mb-3">
                    <label for="formGroupExampleInput" class="form-label">ID</label>
                    <label for="formGroupExampleInput" class="form-label">${id}</label>
                </div>
                <div class="mb-3">
                    <label for="formGroupExampleInput2" class="form-label">Отдел</label>
                    <label for="formGroupExampleInput" class="form-label">${department}</label>
                </div>
                <div class="mb-3">
                    <label for="formGroupExampleInput2" class="form-label">День недели</label>
                    <select class="form-control" name="day" id="options">
                        <option value="Понедельник">Понедельник</option>
                        <option value="Вторник">Вторник</option>
                        <option value="Среда">Среда</option>
                        <option value="Четверг">Четверг</option>
                        <option value="Пятница">Пятница</option>
                        <option value="Суббота">Суббота</option>
                        <option value="Воскресенье">Воскресенье</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="formGroupExampleInput2" class="form-label">Начало смены</label>
                    <input type="text" class="form-control" name="startTime" id="formGroupExampleInput2" value="${startTime}">
                </div>
                <div class="mb-3">
                    <label for="formGroupExampleInput2" class="form-label">Конец смены</label>
                    <input type="text" class="form-control" name="endTime" id="formGroupExampleInput2" value="${endTime}">
                </div>
            `;
            // Обновляем содержимое модельного окна
            userInfo.innerHTML = htmlContent;
            document.getElementById("options").value = dayOfWeek;
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