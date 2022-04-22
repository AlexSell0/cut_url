<?php
    include_path("config.php");

function include_path($file){
    $path = $_SERVER['DOCUMENT_ROOT'];
    $path .= "/includs/" .$file;
    include_once($path);
}

function get_url($page = ""){
    return HOST . "/$page";
};

function db(){
    try{
        return new PDO("mysql:host=" . DB_HOST ."; dbname=" . DB_NAME . "; charset=utf8", DB_USER, DB_PASS, [
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }catch (PDOException $e){
        die($e -> getMessage());
    }

}

function db_query($sql = "", $exec = false){
    if(empty($sql)) return false;

    if($exec){
        return db() -> exec($sql);
    }

    return db() -> query($sql);
}

function get_user_count(){
    return db_query("SELECT COUNT(id) FROM `users`;") -> fetchColumn();
}

function get_views_count(){
    return db_query("SELECT SUM(`views`) FROM `links`;") -> fetchColumn();
}

function get_links_count(){
    return db_query("SELECT COUNT(id) FROM `links`;") -> fetchColumn();
}

function get_link_info($url){
    if(empty($url)) return [];
    return db_query("SELECT * FROM `links` WHERE `short_link` = '$url'") -> fetch();
}

function get_link_user_info($link){
    if(empty($link)) return [];
    return db_query("SELECT * FROM `links` WHERE `long_link` = '$link'") -> fetch();
}

function get_link_user_id($id){
    if(empty($id)) return [];
    return db_query("SELECT * FROM `links` WHERE `id` = '$id'") -> fetch();
}

function update_views($url){
    if(empty($url)) return false;
    return db_query("UPDATE `links` SET `views` = `views` + 1  WHERE `short_link` = '$url';", true);
}

//Сообщения об ошибках
function message($str, $sucssess = false){
    $class = 'alert-danger';

    if($sucssess === true){
        $class = 'alert-success';
    }

    $_SESSION['message'] = '
    <div class="alert '. $class .' alert-dismissible fade show mt-3" role="alert">
    ' . $str . '
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
}

//для регистрации пользователя
function get_user_info($login){
    if(empty($login)) return [];
    return db_query("SELECT * FROM `users` WHERE `login` = '$login';") -> fetch();
}

function add_user($login, $pass){
    if(empty($login) || empty($pass)) return [];
    $password = password_hash($pass, PASSWORD_DEFAULT);

    db_query("INSERT INTO `users` (`id`, `login`, `pass`) VALUES (NULL, '$login', '$password');", true);

    return true;
}

//Валидация логин
function validation_login($user){
    if (preg_match('#^[a-zA-Z]{2,4}[\w_\-\.@]{0,10}$#', $user) == 1) {
        return true;
    }else{
        message("Вы ввели неверное имя пользователя, пожалуйста, попробуйте еще раз");
        header("Location: register.php");
        return false;
        die;
    }

}

//Валидация пароль
function validation_pass($pass){
    if (preg_match('#^[\w_\-\.@!\$%\?@]{6,10}$#', $pass) === 1) {
        return true;
    }else{
        message("Вы ввели неккоректный пароль. Пароль должен содержать не менее 6 символов и может содержать буквы английского алфавита, цифры и символы _-.@!$%?@");
        header("Location: register.php");
        return false;
        die;
    }

}

function register_user($auth_data){
    if(empty($auth_data) || !isset($auth_data['login']) || empty($auth_data['login']) || !isset($auth_data['pass']) || !isset($auth_data['pass2']) ){
        return false;
    }
    
    $user = get_user_info($auth_data['login']);

    if(!empty($user)){
        message("Пользователь " . $auth_data['login'] ." с таким именем уже существует");
        header("Location: register.php");
        die;
    };

    if($auth_data['pass'] !== $auth_data['pass2']){
        message("Пароли не совпадают");
        header("Location: register.php");
        die;
    };

    if (validation_login($auth_data['login']) !== true || validation_pass($auth_data['pass']) !== true){
        return false;
    }

    if(add_user($auth_data['login'], $auth_data['pass']) === true){
        message("Пользователь с именем " . $auth_data['login'] . " успешно зарегестрирован", true);
        header("Location: register.php");
        die;
    };

    return true;
}

//Логирование пользователя
function password_veryfy($pass, $pass2){
    if (password_verify($pass, $pass2)) return true;
}

function login_user($auth_data){

    if(empty($auth_data) || !isset($auth_data['login']) || empty($auth_data['login']) || !isset($auth_data['pass']) || empty($auth_data['pass']) ){
        message("Логин или пароль не может быть пустым");
        header("Location: login.php");
        die;
    }

    $user = get_user_info($auth_data['login']);

    if(empty($user)){
        message("Логин или пароль не верный");
        header("Location: login.php");
        die;
    }

    if(password_veryfy($auth_data['pass'], $user['pass'])){
        $_SESSION["user"] = $user;
        header("Location: profile.php");
        die;
    }else{
        message("Пароль не верный");
        header("Location: login.php");
        die;
    }

}

//Вставка ссылок в профиль
function ger_user_links($id){
    if(empty($id)) return [];
    return db_query("SELECT * FROM `links` WHERE `user_id` = '$id';") -> fetchAll();
}

function set_table($links){
    if(empty($links)) return [];

    $str = '';

    foreach($links as $key => $value){
        $num = $key + 1;

        $str .= "
        <tr>
            <th scope=\"row\">$num</th>
            <td><a href=\"{$value['long_link']}\" target=\"_blank\">{$value['long_link']}</a></td>
            <td class=\"short-link\">".get_url($value['short_link']) ."</td>
            <td>".$value['views']."</td>
            <td>
                <a href=\"#\" class=\"btn btn-primary btn-sm copy-btn\" title=\"Скопировать в буфер\" data-clipboard-text=\"".get_url($value['short_link'])."\"><i class=\"bi bi-files\"></i></a>
                <a href=\"". get_url("includs/edit.php?id=".$value['id']."&url=".$value['long_link']."") ."\" class=\"btn btn-warning btn-sm\" title=\"Редактировать\"><i class=\"bi bi-pencil\"></i></a>
                <a href=\"". get_url("includs/delete.php?id=".$value['id']."") ."\" class=\"btn btn-danger btn-sm\" title=\"Удалить\"><i class=\"bi bi-trash\"></i></a>
            </td>
        </tr>
        ";
    }

    echo $str;}

    //Удаление ссылок
    function delete_link($id){
        if(empty($id)) return false;
        return db_query("DELETE FROM `links` WHERE `links`.`id` = $id", true);
    }


    //Поиск
    function search_link($id, $link){
        if(empty($id) || empty($link)) return [];
        return db_query("SELECT * FROM `links` WHERE ((`user_id` LIKE '$id') AND (`long_link` LIKE '$link'));") -> fetch();
    }

    function prover($link){
        if (preg_match('#^https?://(www\.)?[a-zA-Z_-]+[a-zA-Z]+\.[a-zA-Z/]{2,5}#', $link) == 1){
            return true;
        }else{
            return false;
        }
    }

    //Добавление ссылки
    function add_link($id, $link){
        $short = generate_string();

        //Проверяем чтоб ссылка была не пустая и валидная
        if(empty($id) || empty($link)){
            return false;
        }else if(!prover($link)){
            message("Вы ввели некоректную ссылку, введите ссылку в формате http://site.ru");
            header("Location: /profile.php");
            die;
        };

        $url = search_link($id, $link);
        //Проверяем есть ли такия ссылка в базе данных
        if($id == $url['user_id'] && $link == $url['long_link']){
            message("Ссылка ".$link." уже создана, пожалуйста используйте ее");
            header("Location: /profile.php");
            die;
        }

        return db_query("INSERT INTO `links` (`id`, `user_id`, `long_link`, `short_link`, `views`) VALUES (NULL, '$id', '$link', '$short', '0')", true);
    }

    function generate_string($size = 6){
        $new_string = str_shuffle(URL_CHARS);
        $new_string = substr($new_string, 0, $size);
        return $new_string;
    }

    //Редактирование ссылки
    function edit_links($id, $link){
        if(empty($id) || empty($link)){
            return false;
        }else if(!prover($link)){
            message("Вы ввели некоректную ссылку, введите ссылку в формате http://site.ru");
            header("Location: /profile.php");
            die;
        };
        return db_query("UPDATE `links` SET `long_link` = '$link' WHERE `id` = '$id';", true);
    }