<?php include 'adminheader.php'; ?>

<?php
// Veritabanından açık olan işlemleri çek
$stmt = $pdo->prepare("SELECT * FROM islem_liste WHERE acik_mi = 1");
$stmt->execute();
$acikIslemler = $stmt->fetchAll();
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
                                    <th>Liq Fiyatı</th>
                                    <th>Long/Short</th>
                                    <th>Düzenle</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($acikIslemler as $row): ?>
                                    <tr>
                                        <td><?= $row['tarih'] ?></td>
                                        <td><?= $row['parite'] ?></td>
                                        <td><?= $row['acilis'] ?></td>
                                        <td><?= $row['adet'] ?></td>
                                        <td><?= $row['liq_fiyat'] ?></td>
                                        <td><?= $row['long_short'] ?></td>
                                        <td>
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#duzenleModal<?= $row['islem_id'] ?>">Düzenle</button>
                                        </td>
                                    </tr>

                                    <!-- Düzenleme Modalı -->
<div class="modal fade" id="duzenleModal<?= $row['islem_id'] ?>" tabindex="-1" aria-labelledby="duzenleModalLabel<?= $row['islem_id'] ?>" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="duzenleModalLabel<?= $row['islem_id'] ?>">İşlemi Düzenle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="/admin/main/islemduzenle">
                    <input type="hidden" name="islem_id" value="<?= $row['islem_id'] ?>">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="tarih" class="form-label">Tarih:</label>
                            <input type="date" class="form-control" name="tarih" value="<?= $row['tarih'] ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="parite" class="form-label">Parite:</label>
                            <input type="text" class="form-control" name="parite" value="<?= $row['parite'] ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="acilis" class="form-label">Açılış:</label>
                            <input type="text" class="form-control" name="acilis" value="<?= $row['acilis'] ?>" required>
                        </div>
						<div class="col-md-6">
                            <label for="liq_fiyat" class="form-label">Liq Fiyatı:</label>
                            <input type="text" class="form-control" name="liq_fiyat" value="<?= $row['liq_fiyat'] ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="adet" class="form-label">Adet:</label>
                            <input type="text" class="form-control" name="adet" value="<?= $row['adet'] ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="long_short" class="form-label">Long/Short:</label>
                            <select class="form-select" name="long_short" required>
                                <option value="Long" <?= ($row['long_short'] == 'Long') ? 'selected' : '' ?>>Long</option>
                                <option value="Short" <?= ($row['long_short'] == 'Short') ? 'selected' : '' ?>>Short</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" name="duzenle">Kaydet</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Düzenleme Modalı Bitiş -->


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

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Formdan gelen verileri al
    $islemID = $_POST['islem_id'];
    $liqFiyat = $_POST['liq_fiyat'];
    $tarih = $_POST['tarih'];
    $parite = $_POST['parite'];
    $acilis = $_POST['acilis'];
    $adet = $_POST['adet'];
    $longShort = $_POST['long_short'];

    // Güncelleme işlemini gerçekleştir
    $updateStmt = $pdo->prepare("UPDATE islem_liste SET liq_fiyat = ?, tarih = ?, parite = ?, acilis = ?, adet = ?, long_short = ? WHERE islem_id = ?");
    $updateStmt->execute([$liqFiyat, $tarih, $parite, $acilis, $adet, $longShort, $islemID]);

    // Başarı mesajını göster
    echo '<script>alert("İşlem başarıyla güncellendi!");</script>';
	
    echo '<script>window.location.href = "/admin/main/islemduzenle";</script>';

}
?>

<?php include 'footer.php'; ?>
