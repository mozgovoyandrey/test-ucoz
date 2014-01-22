<?php
/**
 * Created by MOZGOVOY.NET
 * User: Mozgovoy Andrey
 * Date: 22.01.14
 * Time: 12:04
 */

include_once "config.php";

$mysql = connectDB($config['mysql_host'],$config['mysql_login'],$config['mysql_pass'],$config['mysql_db']);

$mess_add = '';
$mess_rest = '';

if ($_POST['add']){
    if (!empty($_POST['email']) && !empty($_POST['phone'])){
        if (validateEmail($_POST['email'])){
            $result = addInDB($_POST['email'], $_POST['phone']);
            if ($result === false){
                $text = "Данные успешно добавлены в базу.";
            } elseif($result === 1){
                $text = "За указанным Email уже закреплен номер телефона. Для востановления номера воспользуйтесь формой расположеной ниже.";
            } else {
                $text = "При добавлении данных произошла ошибка. Приносим извинения за неудобства.";
            }
        } else {
            $text = "Вы указали некорректный email.";
        }
    } else {
        $text = "Вы не заполнили одно из полей.";
    }

    $mess_add = '<div class="mess add"><p><span>'.$text.'</span></p></div>';
}
if ($_GET['rest']){
    if (!empty($_GET['email'])){
        if (validateEmail($_GET['email'])){
            restorePhone($_GET['email']);
            $text = "На указанный Вами e-mail был отправлен закрепленный за ним номер телефона.";
        } else {
            $text = "Вы указали некорректный email.";
        }
    } else {
        $text = "Вы не указали email для востановления.";
    }

    $mess_rest = '<div class="mess rest"><p><span>'.$text.'</span></p></div>';
}


header("Content-Type: text/html; charset=utf-8");
$page = '<html><head><title>База данных</title><link href="/test3/style.css" rel="stylesheet" type="text/css"> </head><body>
<h2>Запись в базу данных</h2>
<form action="'.$_SERVER["SCRIPT_NAME"].'" method="post">
<label for="email">Email</label><input type="text" name="email" value=""><br/>
<label for="phone">Телефон</label><input type="text" name="phone" value=""><br/>
<input type="submit" name="add" value="Добавить">
</form>'
.$mess_add
.'<hr>
<h2>Востановление телефона</h2>
<form action="'.$_SERVER["SCRIPT_NAME"].'" method="get">
<label for="email">Email</label><input type="text" name="email" value=""><br/>
<input type="submit" name="rest" value="Востановить">
</form>'
.$mess_rest
.'</body></html>';

echo $page;

function connectDB ($host, $login, $pass, $db){
    $mysql = mysql_connect($host,$login,$pass);
    if (!$mysql) {
        die('Ошибка соединения: ' . mysql_error());
    }
    $db_selected = mysql_select_db($db, $mysql);
    if (!$db_selected) {
        die ('Не удалось выбрать базу : ' . mysql_error());
    }
    mysql_query("SET NAMES utf8");
    mysql_query("SET CHARACTER SET utf8");

    return $mysql;
}

/**
 * Проверка E-Mail на корректность
 * @param $email
 * @return bool
 */
function validateEmail($email){
    if (preg_match('/\A[^@]+@([^@\.]+\.)+[^@\.]+\z/', $email)){
        return true;
    } else {
        return false;
    }
}

/**
 * Добавление данных в базу
 * Возвращает false в случае удачного добавления или код ошибки в случае неудачи
 * 1 - Запись уже присутствует в базе
 * 2 - Ошибка в запросе
 *
 * @param $email
 * @param $phone
 * @return bool|int
 */
function addInDB($email, $phone){
    $hemail = md5($email);
    $sql = "SELECT * FROM `ucoz_test3` WHERE email = '".$hemail."' LIMIT 1";
    $res = mysql_query($sql);
    if (mysql_num_rows($res) == 0){
        $encDataBin = mcrypt_encrypt(MCRYPT_BLOWFISH, $email, $phone, MCRYPT_MODE_ECB);
        $encDataStr = bin2hex($encDataBin);
        $sql = "INSERT INTO `ucoz_test3` (`id`, `email`, `phone`) VALUES (NULL ,  '".$hemail."',  '".$encDataStr."');";
        if (mysql_query($sql)){
            return false;
        } else {
            return 2;
        }
    } else {
        return 1;
    }

    //echo $hemail.' // '.$encDataStr;
}

/**
 * Востановление номера телефона по Email
 * Возвращает false в случае удачного востановления или код ошибки в случае неудачи
 * 1 - Не найден указанный email
 *
 * @param $email
 * @return bool|int
 */
function restorePhone($email){
    $hemail = md5($email);
    $sql = "SELECT * FROM `ucoz_test3` WHERE email = '".$hemail."' LIMIT 1";
    $res = mysql_query($sql);
    if (mysql_num_rows($res) == 1){
        $row = mysql_fetch_assoc($res);
        $encDataBin = pack("H*" , $row['phone']);
        $phone = mcrypt_decrypt(MCRYPT_BLOWFISH, $email, $encDataBin, MCRYPT_MODE_ECB);
        mail($email,"Востановление номера телефона", $phone);
        return false;
    } else {
        return 1;
    }
}