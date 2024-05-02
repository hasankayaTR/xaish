<?php include 'main/header.php'; ?>

<header class="masthead">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12 text-center">
                <h2>İzole Pozisyon Hesaplama</h2>

                <div class="mb-3">
                    <label for="entryPrice" class="form-label">Giriş Fiyatı:</label>
                    <input type="text" class="form-control" id="entryPrice" name="entryPrice" placeholder="örn: 0.90" required>
                </div>
                <div class="mb-3">
                    <label for="liquidationPrice" class="form-label">Likidasyon Fiyatı:</label>
                    <input type="text" class="form-control" id="liquidationPrice" name="liquidationPrice" placeholder="örn: 0.60" required>
                </div>
                <div class="mb-3">
                    <label for="lossAmount" class="form-label">Riske Edilecek Miktar (USDT):</label>
                    <input type="text" class="form-control" id="lossAmount" name="lossAmount" placeholder="örn: 80" required>
                </div>

                <div id="sonuclar" class="mt-4 text-center">
                    <!-- Hesaplama sonuçları -->
                </div>
            </div>
        </div>
    </div>
</header>

<?php include 'main/footer.php'; ?>

<script src="../assets/izole-script.js"></script>
