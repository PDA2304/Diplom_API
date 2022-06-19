<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Приложение</title>
</head>
<style>

    body {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        margin-top: 16%;
    }
    .container {
        text-align: center;
    }
 .flex {
    display: flex;
    margin: 0 auto;
    width: 36%;
    align-items: flex-end;
    align-content: flex-start;
    justify-content: center;
 }
 .phone {
    display: flex;
    background-color: hsl(208deg 56% 47% / 32%);
    align-content: center;
    border: 1px solid gray;
    padding: 10px;
    align-items: center;
 }
 p {
     padding: 0;
 }
 img {
     margin-right: 10px;
 }
 .text {
     text-align: center;
 }
 .p  {
     font-size: 18px;
 }
 .block {
     display: block;
     width: 1%;
 }
</style>
<body>
    <div class="text">
        <h1>Менеджер паролей от компании "Праймтек"</h1>
    </div>

    <div class="container">

        <p class="p">Скачайте приложение для своей платформы!</p>
        <div class="flex">
            <a href="dowloand/passmanager.apk"> 
                <div class="android phone">
                    <div> <img src="img/unnamed.png" width="50px" height="50px"> </div>
                    <div>
                        <p>Скачайте <br> для Android</p>
                    </div>
                </div>
            </a>
            <div class="block">
            </div>
            <a href="dowloand/windows.rar">
                <div class="apple phone">
                    <div> <img src="img/44.png" width="50px" height="50px"> </div>
                    <div>
                        <p>Скачайте <br> для Windows</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</body>
</html>
