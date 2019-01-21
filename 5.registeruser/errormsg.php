<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        Error message.
    </title>
    <link rel='stylesheet' href='/css/bootstrap.css' type='text/css' media='all'>
    <link rel='stylesheet' href='/css/getuserage.css' type='text/css' media='all'>
</head>
<body>
    <div id="blokForma" class="container">
        <h3 class="errorh3">Ошибка.</h3>
            <?php
            if ($nameErr) alert("имя");
            if ($surnameErr) alert("фамилию");
            if ($countryErr) alert("страну");
            if ($cityErr) alert("город");
            if ($emailErr) alert("электронную почту");
            ?>
            <div class="alert-link">
                <a href="./index.html" class="alert-link">Вернуться назад и ввести данные заново</a>.
            </div>
    </div>
</body>

</html>

<?php 
function alert($alertErr) {
    echo "<div class='alert'>Вы ввели неправильно <b>$alertErr</b></div>";
}
?>