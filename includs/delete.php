<?php
    //усли url установлен и он не пустой
    if(!isset($_GET['id']) && empty($_GET['id'])){
        header("Location: /profile.php");
        die;
    }

    include_once 'functions.php';

    $url = get_link_user_id($_GET['id']);
    if($url['user_id'] != $_SESSION['user']['id']){
        message("Вы не можете удалить эту ссылку");
        header("Location: /profile.php");
    }

    delete_link($url['id']);
    message("Ссылка успешно удалена", true);

    header("Location: /profile.php");
    die;