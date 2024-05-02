<?php
// Veritabanından açık olan işlemleri çek
$stmt = $pdo->prepare("SELECT * FROM islem_liste ORDER BY acik_mi DESC, tarih DESC");
$stmt->execute();
$acikIslemler = $stmt->fetchAll();


// Binance API'den son fiyatları çek
$apiUrl = "https://fapi.binance.com/fapi/v1/ticker/price?symbol="; // Değiştirilen kısım
$prices = array();

foreach ($acikIslemler as $row) {
  $symbol = $row['parite'] . 'USDT';

    // İşlem açık mı kontrolü
  if ($row['acik_mi'] == 1) {
    $ch = curl_init($apiUrl . $symbol);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $apiResponse = curl_exec($ch);
    curl_close($ch);

    $priceData = json_decode($apiResponse, true);

        // Hata kontrolü
    $prices[$symbol] = isset($priceData['price']) ? round($priceData['price'], 3) : 'N/A';
  }
}
?>

<div class="container">
  <div class="row">
    <div class="col-12 text-center" style="margin-top: 5rem;">
      <?php if ($acikIslemler): ?>
        <!-- İşlemler tablosu -->
        <div class="table-responsive">
          <div id="refreshStatus"></div>
          <table class="table table-hover" id="islemlerTable">
            
            <thead>
              <tr>
                <th>Tarih</th>
                <th>Güncel</th>
                <th>Parite</th>
                <th>Açılış</th>
                <th>Liq</th>
                <th>Adet</th>
                <th>Kaldıraç</th>
                <th>Hacim</th>
                <th>Kar/Zarar</th>
                <th>Kapanış</th>
                <th>Long/Short</th>
                <th>Grafik</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($acikIslemler as $row): ?>
                <?php $araplanClass = ($row['liq_fiyat'] == $row['kapanis']) ? 'style="background-color: #ff919175;"' : ''; ?>
                <tr <?php echo ($row['acik_mi'] == 1) ? 'class="islem-acik"' : 'class="islem-kapali"'; ?> <?= $araplanClass ?>>
                  <td><?= $row['tarih'] ?></td>
                  <td>
                    <?= ($row['acik_mi'] == 1) ? $prices[$row['parite'] . 'USDT'] : 'İşlem Kapalı'; ?>
                    <?php $sonFiyat = $prices[$row['parite'] . 'USDT'] ?>
                  </td>
                  <td><?= $row['parite'] ?></td>
                  <td><?= $row['acilis'] ?></td>
                  <td><?= $row['liq_fiyat'] ?></td>
                  <td><?= $row['adet'] ?></td>
                  <td>
                    <?php
                    $acilisFiyati = $row['acilis'];
                    $liqFiyat = $row['liq_fiyat'];
                    $minKaldirac = abs(($acilisFiyati - $liqFiyat) / $acilisFiyati);
                    echo number_format(ceil(1 / $minKaldirac)) . 'x';
                    ?>
                  </td>
                  <td>
                    <?php
                    $sizeUSDT = $acilisFiyati * $row['adet'];
                    echo '$' . round($sizeUSDT , 2);
                    ?>
                  </td>
                  <td>
                    <?php if ($row['acik_mi'] == 1): ?>
                      <?php
                      $isLong = ($row['long_short'] === 'Long');
                      $karZarar = ($isLong) ? ($sonFiyat - $acilisFiyati) * $row['adet'] : ($acilisFiyati - $sonFiyat) * $row['adet'];
                      $buttonClass = ($karZarar > 0) ? 'btn-warning' : 'btn-warning';
                      ?>
                      <button type="button" class="btn <?= $buttonClass ?> btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="İşlem Açık - Olası Kar/Zarar Tutarı">
                        <strong><?= ($karZarar > 0) ? '+$' . round($karZarar, 2) : '-$' . round(abs($karZarar), 2) ?></strong>
                      </button>
                    <?php else: ?>
                      <?php
                      $karZarar = $row['kar_zarar'];
                      $buttonClass = ($karZarar > 0) ? 'btn-success' : 'btn-danger';
                      ?>
                      <button type="button" class="btn <?= $buttonClass ?> btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="İşlem Kapalı - Kar/Zarar Tutarı">
                        <strong><?= ($karZarar > 0) ? '+$' . round($karZarar, 2) : '-$' . round(abs($karZarar), 2) ?></strong>
                      </button>
                    <?php endif; ?>
                  </td>
                  <td>
                    <?php
                    if ($row['acik_mi'] == 1) {
                      echo 'İşlem Açık';
                    } else {
                      echo $row['kapanis'];
                    }
                    ?>
                  </td>
                  <td>
                    <?php
                    $buttonClass = ($row['long_short'] === 'Long') ? 'btn-success' : 'btn-danger';
                    $buttonText = ($row['long_short'] === 'Long') ? 'Long' : 'Short';
                    ?>
                    <button type="button" class="btn <?= $buttonClass ?>"><?= $buttonText ?></button>
                  </td>

                  <?php
                      // Grafik görüntüle butonu
                  $symbol = $row['parite'] . 'USDT';
                  $grafikUrl = 'https://tr.tradingview.com/chart/?symbol=BINANCE%3A' . $symbol . '.P';
                  ?>

                  <td>
                    <a class="btn btn-outline-dark" href="<?= $grafikUrl ?>" target="_blank"><i class="fa-solid fa-chart-line"></i></a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <?php
                    // Açıklama butonları
        $acikIslemSayisi = count(array_filter($acikIslemler, function ($item) {
          return $item['acik_mi'] == 1;
        }));

        $kapaliIslemSayisi = count(array_filter($acikIslemler, function ($item) {
          return $item['acik_mi'] == 0;
        }));
        ?>

        <div class="mt-3">
          <div class="btn-group" role="group" aria-label="İşlem Türü Seçenekleri">
            <button class="btn btn-outline-secondary me-1" onclick="filterTable('acik')">Açık İşlemler: <span class="badge bg-secondary"><?= $acikIslemSayisi ?></span> </button>
            <button class="btn btn-outline-secondary me-1" onclick="filterTable('kapali')">Kapanan İşlemler: <span class="badge bg-secondary"> <?= $kapaliIslemSayisi ?></span> </button>
            <button class="btn btn-outline-secondary me-1" onclick="filterTable('tum')">Tüm İşlemler: <span class="badge bg-secondary"> <?= $acikIslemSayisi + $kapaliIslemSayisi ?> </span> </button>
          </div>
			
			
			
			
			


			
			
			
			
			
        </div>
        <?php
    // Kasa bakiyesini çek
        $bakiyeSorgu = $pdo->prepare("SELECT bakiye FROM ayarlar");
        $bakiyeSorgu->execute();
        $kasaBakiye = $bakiyeSorgu->fetchColumn();
        ?>
        <?php
                    // Gerçekleşmeyen kar/zararı hesaplamak için bir değişken tanımlayın
        $gerceklesenmeyenKarZarar = 0;

        if ($acikIslemler) {
                        // Açık işlemler varsa, gerçekleşmeyen kar/zararı hesapla
          foreach ($acikIslemler as $row) {
                            // İşlem açık mı kontrolü
            if ($row['acik_mi'] == 1) {
                                // Paritenin son fiyatını al ve gerçekleşmeyen kar/zararı hesapla
              $symbol = $row['parite'] . 'USDT';
              $sonFiyat = isset($prices[$symbol]) ? $prices[$symbol] : null;

              if ($sonFiyat !== null) {
                $isLong = ($row['long_short'] === 'Long');
                $gerceklesenmeyenKarZarar += ($isLong) ? ($sonFiyat - $row['acilis']) * $row['adet'] : ($row['acilis'] - $sonFiyat) * $row['adet'];
              }
            }
          }
        }

                    // Gerçekleşmeyen bakiyeyi hesapla ve toplam bakiyeye ekle
        $toplamBakiye = $kasaBakiye + $gerceklesenmeyenKarZarar;
        ?>
        <?php
// Başlangıç kasa bakiyesi
        $baslangicKasaBakiyesi = 400;

// Yüzde değişim oranını hesapla
        $yuzdeDegisim = (($kasaBakiye + $gerceklesenmeyenKarZarar) - $baslangicKasaBakiyesi) / $baslangicKasaBakiyesi * 100;
        ?>

        <div class="btn-group" role="group" aria-label="İşlem Türü Seçenekleri" style="margin-top: 1rem;">
          <button class="btn btn-success me-1" id="gerceklesenButton" disabled><strong>Gerçekleşen: $<?= round($kasaBakiye, 2) ?> </strong></button>
          <button class="btn btn-warning me-1" id="anlikButton" disabled><strong>Anlık: $<?= round($kasaBakiye + $gerceklesenmeyenKarZarar, 2) ?></strong></button>
          <button class="btn btn-info me-1" id="degisimButton" disabled><strong>Değişim: <?= round($yuzdeDegisim, 2) ?>%</strong></button>
        </div>

        
        <div class="container" style="margin-top: 1rem;">
          <div class="btn-group" role="group" aria-label="Tablo İşlemleri">
            <button type="button" id="yenileButton" class="btn btn-outline-primary me-1" onclick="tabloyuYenile()">
              <i class="fa-solid fa-rotate-right"></i> Tabloyu Yenile
              <span id="refreshStatus"></span>
            </button>

            <button type="button" class="btn btn-outline-success me-1" onclick="exportToExcel()">
              <i class="fa-regular fa-file-excel"></i> Excel'e Aktar
            </button>
          </div>
        </div>
		




        <div class="container" style="margin-top: 1rem;">
          <p><strong>Gerçekleşen:</strong> Kapanan işlemler ile kasa durumu.<p>
            <p><strong>Anlık:</strong> Henüz kapanmamış işlemler ile kasa durumu.</p>
            <p><strong>Değişim:</strong> $400 başlangıç kabul eder ve anlık kasa ile karşılaştırır.</p>
          </div>
		
		
		
		<div class="container" style="margin-top: 1rem;">
  <?php if ($acikIslemler): ?>
    <?php
    // Karlı, zararlı ve hala açık işlem sayılarını bul
    $karliIslemSayisi = count(array_filter($acikIslemler, function ($item) {
      return $item['acik_mi'] == 0 && $item['kar_zarar'] > 0;
    }));

    $zararliIslemSayisi = count(array_filter($acikIslemler, function ($item) {
      return $item['acik_mi'] == 0 && $item['kar_zarar'] < 0;
    }));

    $halaAcikIslemSayisi = count(array_filter($acikIslemler, function ($item) {
      return $item['acik_mi'] == 1;
    }));

    // Toplam işlem sayısı
    $toplamIslemSayisi = count($acikIslemler);

    // Karlı, zararlı ve hala açık işlemlerin yüzdesini bul
    $karliIslemYuzdesi = ($toplamIslemSayisi > 0) ? ($karliIslemSayisi / $toplamIslemSayisi) * 100 : 0;
    $zararliIslemYuzdesi = ($toplamIslemSayisi > 0) ? ($zararliIslemSayisi / $toplamIslemSayisi) * 100 : 0;
    $halaAcikIslemYuzdesi = ($toplamIslemSayisi > 0) ? ($halaAcikIslemSayisi / $toplamIslemSayisi) * 100 : 0;

    // Yüzde değerlerini ondalık olarak düzeltilmiş haliyle kullan
    $karliIslemYuzdesi = round($karliIslemYuzdesi, 2);
    $zararliIslemYuzdesi = round($zararliIslemYuzdesi, 2);
    $halaAcikIslemYuzdesi = round($halaAcikIslemYuzdesi, 2);
    
    // Kapanan toplam işlem sayısı
    $kapananToplamIslemSayisi = count(array_filter($acikIslemler, function ($item) {
      return $item['acik_mi'] == 0;
    }));

    // Karlı işlem sayısı
    $karliIslemSayisi = count(array_filter($acikIslemler, function ($item) {
      return $item['acik_mi'] == 0 && $item['kar_zarar'] > 0;
    }));

    // Zararlı işlem sayısı
    $zararliIslemSayisi = count(array_filter($acikIslemler, function ($item) {
      return $item['acik_mi'] == 0 && $item['kar_zarar'] < 0;
    }));

    // Win Rate hesapla
    $winRate = ($kapananToplamIslemSayisi > 0) ? ($karliIslemSayisi / $kapananToplamIslemSayisi) * 100 : 0;

    // Win Rate'i ondalık olarak düzeltilmiş haliyle kullan
    $winRate = round($winRate, 2);

    // Win Rate'i hesapla ve düğmeyi etkinleştirme durumunu belirle
    $isWinRateEnabled = ($kapananToplamIslemSayisi > 0 && ($karliIslemSayisi > 0 || $zararliIslemSayisi > 0));
    ?>

    <div class="container" style="margin-top: 2rem;">
      <h2>İstatistikler</h2>
      
      <div class="progress" style="margin-bottom: 1rem; height: 2rem;">
        <div class="progress-bar bg-success" role="progressbar" style="width: <?= $karliIslemYuzdesi ?>%;" aria-valuenow="<?= $karliIslemYuzdesi ?>" aria-valuemin="0" aria-valuemax="100"><?= $karliIslemSayisi ?> Karlı</div>
        <div class="progress-bar bg-danger" role="progressbar" style="width: <?= $zararliIslemYuzdesi ?>%;" aria-valuenow="<?= $zararliIslemYuzdesi ?>" aria-valuemin="0" aria-valuemax="100"><?= $zararliIslemSayisi ?> Zararlı</div>
        <div class="progress-bar progress-bar-striped bg-warning" role="progressbar" style="width: <?= $halaAcikIslemYuzdesi ?>%;" aria-valuenow="<?= $halaAcikIslemYuzdesi ?>" aria-valuemin="0" aria-valuemax="100"><?= $halaAcikIslemSayisi ?> Hala Açık</div>
      </div>
      
      <div class="d-grid gap-2 d-md-flex justify-content-center">
        <button class="btn btn-outline-success" disabled><i class="fa-solid fa-percent" ></i> WinRate: %<?= $winRate ?> </button>
		</div>		
    </div>
  <?php endif; ?>
</div>
		
		
        <?php else: ?>
          <!-- Açık işlem yoksa -->
          <p>Açık işlem bulunmamaktadır.</p>
        <?php endif; ?>

      </div>
    </div>
  </div>

  <script src="../assets/liste.js"></script>
