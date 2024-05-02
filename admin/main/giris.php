<?php
// Oturumu başlat
session_start();

include 'header.php';

// Hata raporlamayı etkinleştir
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Eğer form gönderildiyse
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Kullanıcının girdiği bilgileri alın
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Kullanıcıyı veritabanında kontrol et
    $stmt = $pdo->prepare("SELECT * FROM kullanicilar WHERE kullanici_adi = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    // Kullanıcı varsa ve şifre doğruysa giriş yap
    if ($user && password_verify($password, $user['sifre']) && $user['admin_mi'] == 1) {
        // Admin giriş yaptı, oturumu başlat
        $_SESSION['admin_id'] = $user['id'];

        // Yönlendirme yap
        header("Location: /admin/main/yonet");
        exit;
    } else {
        echo "<script>alert('Kullanıcı adı veya şifre hatalı veya admin değilsiniz!');</script>";
    }
}
?>

<header class="masthead">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12 text-center">
                <div id="girisForm">
                    <h2>Giriş Yap</h2>
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="username" class="form-label">Kullanıcı Adı:</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Şifre:</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Giriş Yap</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>


<?php include 'footer.php'; ?>
