<?php include 'db.php'; ?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XAISH</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="/assets/xaish.css">

    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">

    <!-- DataTables JavaScript ve jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
</head>
<script async src="https://www.googletagmanager.com/gtag/js?id=G-GQBE61D04R"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-GQBE61D04R');
</script>
<header>
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow fixed-top">
        <div class="container">
			<a class="navbar-brand" href="/"><strong>XAISH</strong></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto text-center">
					<li class="nav-item">
                        <a class="nav-link" href="/"><i class="fa-solid fa-house"></i> Anasayfa</a>
                    </li>
					<li class="nav-item">
                        <a class="nav-link" href="/main/aggrtrade"><i class="fa-solid fa-chart-column"></i> AggrTrade</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/main/izole-hesap"><i class="fa-solid fa-calculator"></i> Poz
                            Hesaplama</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="https://t.me/kingofbtc"><i class="fab fa-telegram"></i> Telegram</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="https://x.com/dogetoyevski"><i class="fab fa-x-twitter"></i> dogetoyevksi</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<body>
    <div id="loader">
        <div class="loader-spinner"></div>
    </div>
    
