<?php include 'adminheader.php'; ?>

<?php
// Veritabanından açık olan işlemleri çek
$stmt = $pdo->prepare("SELECT * FROM islem_liste WHERE acik_mi = 1");
$stmt->execute();
$acikIslemler = $stmt->fetchAll();
?>

<?php
// Bakiye bilgisini çekmek için bir sorgu yapabilirsiniz.
// Bu örnek olarak varsayılan bakiye olarak 400 kullanıyor.
$bakiyeSorgu = $pdo->prepare("SELECT bakiye FROM ayarlar");
$bakiyeSorgu->execute();
$bakiye = $bakiyeSorgu->fetchColumn();
?>

<?php
// Form gönderildiyse işlemleri yap
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Formdan gelen verileri al
    $islemID = $_POST['islem_id'];
    $kapanis = $_POST['kapanis'];

    // İşlemi kapat ve kar/zarar hesapla
    $stmt = $pdo->prepare("SELECT * FROM islem_liste WHERE islem_id = ?");
    $stmt->execute([$islemID]);
    $islem = $stmt->fetch();

    // Adet ve long/short durumunu dikkate alarak işlem boyutunu hesapla
    $adet = $islem['adet'];
    $islemBoyutu = ($islem['long_short'] === 'Long') ? $adet : -$adet;

    $karZarar = $islemBoyutu * ($kapanis - $islem['acilis']);

    // Bakiyeyi güncelle
    $bakiye += $karZarar;

    // Bakiyeyi ayarlara kaydet
    $updateBakiye = $pdo->prepare("UPDATE ayarlar SET bakiye = ?");
    $updateBakiye->execute([$bakiye]);

    // İşlemi kapat
    $kapatStmt = $pdo->prepare("UPDATE islem_liste SET kapanis = ?, kar_zarar = ?, acik_mi = 0 WHERE islem_id = ?");
    $kapatStmt->execute([$kapanis, $karZarar, $islemID]);

    // Uyarı mesajını göster
    echo '<script>alert("İşlem başarıyla kapatıldı. Kar/Zarar: ' . $karZarar . '");</script>';
    
    // Formun tekrar gönderilmesini önlemek için sayfayı yönlendir
    echo '<script>window.location.href = "/admin/main/islemkapat.php";</script>';
}
?>

<header class="masthead">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12 text-center">
                <h2>Açık Olan İşlemler</h2>

                <?php if ($acikIslemler): ?>
                    <!-- Açık işlemler varsa -->
				<div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Tarih</th>
                                <th>Parite</th>
                                <th>Açılış</th>
                                <th>Adet</th>
                                <th>Kapanış</th>
                                <th>Long/Short</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($acikIslemler as $row): ?>
                                <tr>
                                    <td><?= $row['tarih'] ?></td>
                                    <td><?= $row['parite'] ?></td>
                                    <td><?= $row['acilis'] ?></td>
                                    <td><?= $row['adet'] ?></td>
                                    <!-- Kapanış fiyatını buraya ekleyebilirsiniz -->
                                    <td>
                                        <form action="/admin/main/islemkapat.php" method="post">
                                            <input type="hidden" name="islem_id" value="<?= $row['islem_id'] ?>">
                                            <input type="text" name="kapanis" required>
                                            <button type="submit" class="btn btn-primary">Kapat</button>
                                        </form>
                                    </td>
                                    <td><?= $row['long_short'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
					</table>
				</div>
                <?php else: ?>
                    <!-- Açık işlem yoksa -->
                    <p>Açık işlem bulunmamaktadır.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>


<?php include 'footer.php'; ?>
