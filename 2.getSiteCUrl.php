<?php
// 2. Написать функцию, которая принимает адрес страницы сайта,
// а возвращает ее исходный код (с использованием cURL)

$siteUrl = "http://php.net/manual/ru/curl.examples-basic.php";

function getSiteCode($url) {
    
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($curl, CURLOPT_TIMEOUT, 5);
    $result = curl_exec($curl);
    curl_close($curl);   
    return $result;
    
}
echo '<pre>'; //<pre> - для вывода отформатированного текста - с несколькими пробелами, табуляцией и переносом строк
echo htmlspecialchars(getSiteCode($siteUrl));
echo '<pre/>';

/* Если загружается сайт в кодировке 1251, то нужно указать хэдер:
    header('Content-type: text/html; charset=windows-1251');
и указать кодировку страницы в htmlspecialchars:
    htmlspecialchars($result, ENT_QUOTES, "windows-1251");
*/

?>
