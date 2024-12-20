const errorMsg = document.getElementById("errorMsg");

function showError(message) {
    errorMsg.style.display = "flex"; 
    errorMsg.querySelector("p").textContent = message; 
}

document.getElementById('profilePictureForm').onsubmit = async function(event) {
    event.preventDefault(); // Предотвращаем отправку формы

    const file = document.getElementById("pictureFile");
    if(file.files.length>0){
    const formData = new FormData(this);
    const reader = new FileReader();
    reader.onload = async function(event) {
        console.log("Файл прочитан");

        const response = await fetch('../Controlers/setUserPicture.php', {
            method: 'POST',
            body: formData
        })
        .then(response=>response.json())
        .then(data =>{
            if(data.success){
                location.reload();
            }
            else{
                showError(data.message);
            }
        })
        .catch(error, data=>{
            alert("Ошибка запроса"+error.message);
            console.log(data);
        });
    };

    reader.onerror = function(error) {
        showError("Ошибка доступа к файлу при загрузке.");
        console.error("Ошибка чтения файла:", error);
    };

    reader.readAsDataURL(file.files[0]);
}
else{
    showError("Выберите файл.");
    console.error("Ошибка чтения файла:");
}



   
    /*const formData = new FormData(this);
    const response = await fetch('../Controlers/setUserPicture.php', {
        method: 'POST',
        body: formData
    })
    .then(response=>response.json())
    .then(data =>{
        if(data.success){
            location.reload();
        }
        else{
            showError(data.message);
        }
    })
    .catch(error, data=>{
        alert("Ошибка запроса"+error.message);
        console.log(data);
    });*/
};

document.getElementById('bioForm').onsubmit = async function(event) {
    event.preventDefault(); // Предотвращаем отправку формы

    const file = document.getElementById("bioFile");
    if(file.files.length>0){
    const formData = new FormData(this);
    const reader = new FileReader();
    reader.onload = async function(event) {
        console.log("Файл прочитан");

        const response = await fetch('../Controlers/setUserBio.php', {
            method: 'POST',
            body: formData
        })
        .then(response=>response.json())
        .then(data =>{
            if(data.success){
                location.reload();
            }
            else{
                showError(data.message);
            }
        })
        .catch(error, data=>{
            alert("Ошибка запроса"+error.message);
            console.log(data);
        });
    };

    reader.onerror = function(error) {
        showError("Ошибка доступа к файлу при загрузке.");
        console.error("Ошибка чтения файла:", error);
    };

    reader.readAsDataURL(file.files[0]);
}
else{
    showError("Выберите файл.");
    console.error("Ошибка чтения файла:");
}

    /*const formData = new FormData(this);
    const response = await fetch('../Controlers/setUserBio.php', {
        method: 'POST',
        body: formData
    })
    .then(response=>response.json())
    .then(data =>{
        if(data.success){
            location.reload();
        }
        else{
            showError(data.message);
        }
    })
    .catch(error, data=>{
        alert("Ошибка запроса"+error.message);
        console.log(data);
    });*/
};