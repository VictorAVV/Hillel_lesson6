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

echo htmlspecialchars(getSiteCode($siteUrl));
?>