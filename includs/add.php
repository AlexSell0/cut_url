<?php
    include_once 'functions.php';
    
    if(isset($_POST['link']) && !empty($_POST['link'])){
        add_link($_SESSION['user']['id'], $_POST['link']);
        message("Ссылка успешно создана", true);
    }

    header("Location: /profile.php");
    die;
