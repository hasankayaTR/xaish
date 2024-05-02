<?php
$servername = "localhost";  // MySQL sunucu adı
$username = "username";  // MySQL kullanıcı adı
$password = "password";  // MySQL şifre
$dbname = "dbname";  // Kullanmak istediğiniz veritabanı adı

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Veritabanına bağlanırken hata oluştu: " . $e->getMessage());
}


