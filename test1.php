<?php
/**
 * User: Mozgovoy Andrey
 * Date: 21.01.14
 * Time: 15:35
 */


header("Content-Type: text/html; charset=utf-8");

if (!empty($_GET['filename'])){
    $filename = $_GET['filename'];
// Проверяем корректность имени запрашиваемого файла
    if (preg_match('/^[a-zA-Z0-9\.\+-_]+$/', $filename)){

        $domen = parse_url($_SERVER['HTTP_REFERER']);

        setcookie("referrer", $domen["host"], 0, $_SERVER["SERVER_NAME"]);

        header("Content-Disposition: attachment; filename=$filename");
        header("Accept-Ranges: bytes");
        header("Content-type: application/octet-stream");

        readfile("test1/file.doc");
    } else {
        echo "Запрашиваемый файл отсутствует";
    }
} else {
    $form =  "<form action = '".$_SERVER["SCRIPT_NAME"]."' method='get'>"
        . "<label>Название файла: </label><input type = 'text' name = 'filename'><br />"
        . "<input type = 'submit' value = 'Скачать'>"
        . "</form><br/><br/>";


    echo '<html><head></head><body>';
    echo $form;
    echo "Значение referrer: ".$_COOKIE['referrer'];
    echo '</body></html>';
}
exit;