<?php
// Oturumu başlat
session_start();

include 'db.php';

// Hata raporlamayı etkinleştir
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Giriş yapmış adminin kontrolü
$adminLoggedIn = isset($_SESSION['admin_id']);

// Eğer çıkış yap butonuna tıklandıysa
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    // Oturumu sonlandır
    session_destroy();

    // Ana sayfaya yönlendir
    header("Location: /");
    exit;
}

// Eğer admin giriş yapmamışsa ve bu sayfa admin sayfasıysa giriş sayfasına yönlendir
if (!$adminLoggedIn && strpos($_SERVER['REQUEST_URI'], '/admin/') !== false) {
    header("Location: /admin/main/giris");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XAISH ADMIN</title>
    <!-- Bootstrap CSS -->
	<link rel="stylesheet" href="/assets/xaish.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
	<!-- jQuery kütüphanesi -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow fixed-top">
        <div class="container">
            <a class="navbar-brand" href="/admin/main/yonet">XAISH ADMIN</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive"
            aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto">
                <?php if ($adminLoggedIn): ?>
                    <!-- Giriş yapmış adminse -->
				<li class="nav-item">
                    	<a class="nav-link" href="/admin/main/islemekle">İşlem Ekle</a>
              	  </li>
				<li class="nav-item">
                    	<a class="nav-link" href="/admin/main/islemduzenle">İşlem Düzenle</a>
              	  </li>
				<li class="nav-item">
                    	<a class="nav-link" href="/admin/main/islemkapat">İşlem Kapat</a>
              	  </li>
				<li class="nav-item">
                    	<a class="nav-link" href="/admin/main/guncelleme">Güncelleme Ekle</a>
              	  </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?action=logout">Çıkış Yap</a>
                    </li>
                <?php else: ?>
                    <!-- Giriş yapmamış adminse -->
                    <li class="nav-item active">
                        <a class="nav-link" href="admin/main/giris">Giriş Yap</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<!-- Diğer HTML içeriği buraya gelebilir -->

</body>

</html>
