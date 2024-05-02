<?php include 'adminheader.php'; ?>
<?php
// Güncelleme bilgilerini getir
$stmt = $pdo->prepare("SELECT * FROM bilgiler ORDER BY id DESC");
$stmt->execute();
$guncellemeBilgileri = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Formdan gelen verileri işle
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["ekle"])) {
        $versiyon = $_POST["versiyon"];
        $aciklama = $_POST["aciklama"];

        // Veritabanına ekleme işlemi
        $ekleStmt = $pdo->prepare("INSERT INTO bilgiler (versiyon, aciklama) VALUES (:versiyon, :aciklama)");
        $ekleStmt->bindParam(':versiyon', $versiyon);
        $ekleStmt->bindParam(':aciklama', $aciklama);

        if ($ekleStmt->execute()) {
            // Ekleme başarılıysa, sayfayı yenile
            header("Location: /admin/main/guncelleme.php");
        } else {
            // Ekleme başarısızsa, hata mesajını görüntüle
            echo "Ekleme işlemi sırasında bir hata oluştu.";
        }
    } elseif (isset($_POST["sil"])) {
        $id = $_POST["sil"];

        // Veritabanından silme işlemi
        $silStmt = $pdo->prepare("DELETE FROM bilgiler WHERE id = :id");
        $silStmt->bindParam(':id', $id);

        if ($silStmt->execute()) {
            // Silme başarılıysa, sayfayı yenile
            header("Location: /admin/main/guncelleme.php");
        } else {
            // Silme başarısızsa, hata mesajını görüntüle
            echo "Silme işlemi sırasında bir hata oluştu.";
        }
    }
}
?>

<header class="masthead">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12 text-center">
                <!-- Güncelleme Ekleme Formu -->
                <form method="POST" action="/admin/main/guncelleme.php" class="mb-4">
                    <div class="mb-3">
                        <label for="versiyon" class="form-label">Versiyon:</label>
                        <input type="text" name="versiyon" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="aciklama" class="form-label">Açıklama:</label>
                        <textarea name="aciklama" class="form-control" required></textarea>
                    </div>
                    <button type="submit" name="ekle" class="btn btn-primary">Ekle</button>
                </form>

                <!-- Güncelleme Bilgileri Listesi
                <ul class="list-group">
                    <?php foreach ($guncellemeBilgileri as $bilgi): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?= $bilgi['versiyon'] ?> - <?= $bilgi['aciklama'] ?>
                            <form method="POST" action="admin/main/guncelleme.php" style="display: inline;">
                                <input type="hidden" name="sil" value="<?= $bilgi['id'] ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Sil</button>
                            </form>
                        </li>
                    <?php endforeach; ?>
                </ul> -->
            </div>
        </div>
    </div>
</header>

<?php include 'footer.php'; ?>
