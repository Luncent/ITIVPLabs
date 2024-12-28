<?php

if (isset($_POST['mode'])) {
    setcookie(htmlspecialchars($_POST['userLogin']), password_hash(htmlspecialchars($_POST['mode']),PASSWORD_DEFAULT), time() + (60*60*24 * 7),"/");
}
header("Location: ../views/tasksPage.php");
?>