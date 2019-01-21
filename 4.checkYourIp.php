<?php
//4. В файле spam.txt содержится список ip-адресов,
// разделенных запятой (ip1,ip2 ...). 
// Написать функцию определения является ли текущий ip-адрес в списке.

$spamList = 'spam.txt';

function getClientIp() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

if (file_exists($spamList) && filesize($spamList) > 0) {

    $clientIp = getClientIp();
    
    if (filter_var($clientIp, FILTER_VALIDATE_IP)) {        
        //убираем возможные пробелы и переносы строк в спамлисте
        $spamArray = explode(',', str_replace(array(" ","\n", "\r", "\r\n"), "", file_get_contents($spamList)));
        
        if (empty($spamArray)) {
            echo "Error. Spamlist is empty!";
        } else {
            if (in_array($clientIp,$spamArray)) {
                echo "Warning. IP $clientIp exist in spamlist.";
            } else {
                echo "IP $clientIp not found in spamlist.";
            }
        }
    } else {
        echo "Error. Client IP $clientIp is not valid! ";
    }
} else {
    echo "Error. File $spamList not found or empty!";
}

?>