<?php
//5. Сделать форму регистрации пользователя с полями:
// Имя, Фамилия, e-mail, Город, Страна. 
// В обработчике формы написать код сохранения данных пользователя в файл.
// Если регистрация была произведена с Украины,
// то в файл с именем ukraine.txt, иначе - other.txt. 
// Файл должен содержать регистрационные данные пользователей с дополнительной строкой:
// дата и время регистрации в формате 1029-Jan-18 18:00

ini_set('date.timezone', 'Europe/Kiev');

$nameErr = $surnameErr = $emailErr = $countryErr = $cityErr = false;

$pathToUkraineDB = "ukraine.txt";
$pathToOtherDB = "other.txt";

if (!isset($_POST['name']) || !isset($_POST['email'])) {
    header('Location: index.html'); 
}

function getClientIp() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return filter_var($ip, FILTER_VALIDATE_IP);
}

function isUkraineIp($ip) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, "https://ipapi.co/$ip/country/");
    curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.102 YaBrowser/18.11.1.805 Yowser/2.5 Safari/537.36');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $out = curl_exec($curl);
    curl_close($curl);
    if ($out == "UA") {
        return true;
    }
    return false;
}

$name = trim($_POST['name']);
if (!preg_match("/^([a-zA-Zа-яА-ЯёЁ' ])+/", $name) || strlen($name) > 40) {
    $nameErr = true;
}
$surname = "";
if (isset($_POST['surname'])) {
    if (!preg_match("/^([a-zA-Zа-яА-ЯёЁ' ])*/", $_POST['surname']) || strlen($_POST['surname']) > 40) {
        $surnameErr = true;
    } else {
        $surname = trim($_POST['surname']);
    }
}
$email = trim($_POST['email']);
if (strlen($email) == 0 || strlen($email) > 50 || !preg_match("/[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+.[a-zA-Z]{2,4}/", $email)) {
    $emailErr = true;
}
$country = "";
if (isset($_POST['country'])) {
    if (strlen($_POST['country']) > 40) {
        $countryErr = true;
    } else {
        $country = trim($_POST['country']);
    }
}
$city = "";
if (isset($_POST['city'])) {
    if (strlen($_POST['city']) > 40) {
        $cityErr = true;
    } else {
        $city = trim($_POST['city']);
    }
}

if ($nameErr || $surnameErr || $emailErr || $countryErr || $cityErr) {
    require_once('errormsg.php');
} else {

    $clientIp = getClientIp();

    if ($clientIp && isUkraineIp($clientIp)) {
        $pathToDB = $pathToUkraineDB;
    } else {
        $pathToDB = $pathToOtherDB;
    }

    $handle = fopen($pathToDB, 'a+');
        fwrite($handle, json_encode(
            array(
                "name" => $name,
                "surname" => $surname,
                "email" => $email,
                "country" => $country,
                "city" => $city,
                "date" => date('Y-M-d H:i')
            )
        ).PHP_EOL);
    fclose($handle);

    require_once('okmsg.php');
}
?>