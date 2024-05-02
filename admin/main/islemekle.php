<?php include 'adminheader.php'; ?>

<?php
// Form gönderildiyse işlemleri yap
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Formdan gelen verileri al
    $tarih = $_POST['tarih'];
    $parite = $_POST['parite'];
    $acilis = $_POST['acilis'];
	$liq_fiyat = $_POST['liq_fiyat'];
	$adet = $_POST['adet'];
    $longshort = $_POST['longshort'];

    // Veritabanına işlemi ekle
    $stmt = $pdo->prepare("INSERT INTO islem_liste (tarih, parite, acilis, liq_fiyat, adet, long_short) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$tarih, $parite, $acilis, $liq_fiyat, $adet, $longshort]);

    // Eklenen işlemin ID'sini al
    $islemID = $pdo->lastInsertId();

    // İşlem başarıyla eklenmişse
if ($islemID) {
    echo '<script>alert("İşlem başarıyla eklendi! İşlem ID: ' . $islemID . '")</script>';
} else {
    echo '<script>alert("İşlem eklenirken bir hata oluştu")</script>';
}

}
?>

<header class="masthead">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12 text-center">
                <h2>İşlem Ekle</h2>
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="tarih" class="form-label">Tarih:</label>
                        <input type="date" class="form-control" id="tarih" name="tarih" required>
                    </div>
                    <div class="mb-3">
                        <label for="parite" class="form-label">Parite:</label>
                        <input type="text" class="form-control" id="parite" name="parite" required>
                    </div>
                    <div class="mb-3">
                        <label for="acilis" class="form-label">Açılış:</label>
                        <input type="text" class="form-control" id="acilis" name="acilis" required>
                    </div>
					<div class="mb-3">
                        <label for="liq_fiyat" class="form-label">Liq Fiyat:</label>
                        <input type="text" class="form-control" id="liq_fiyat" name="liq_fiyat" required>
                    </div>
					<div class="mb-3">
                        <label for="adet" class="form-label">Adet:</label>
                        <input type="text" class="form-control" id="adet" name="adet" required>
                    </div>
                    <div class="mb-3">
                        <label for="longshort" class="form-label">Long/Short:</label>
                        <select class="form-select" id="longshort" name="longshort" required>
                            <option value="Long">Long</option>
                            <option value="Short">Short</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">İşlemi Ekle</button>
                </form>
            </div>
        </div>
    </div>
</header>


<?php include 'footer.php'; ?>
