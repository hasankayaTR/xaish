
<?php
$stmt = $pdo->prepare("SELECT * FROM bilgiler ORDER BY id DESC");
$stmt->execute();
$guncellemeBilgileri = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">
  <section class="py-5">
    <div class="accordion" id="guncellemeAccordion">
      <!-- Versiyon Günlüğü -->
      <div class="accordion-item">
        <h2 class="accordion-header" id="versiyonHeader">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#versiyonCollapse" aria-expanded="false" aria-controls="versiyonCollapse"><strong>
          Versiyon Günlüğü</strong>
        </button>
      </h2>
      <div id="versiyonCollapse" class="accordion-collapse collapse" aria-labelledby="versiyonHeader" data-bs-parent="#guncellemeAccordion">
        <div class="accordion-body">
          <?php foreach ($guncellemeBilgileri as $bilgi): ?>
            <p>• <?= $bilgi['aciklama'] ?> - <?= $bilgi['versiyon'] ?></p>
          <?php endforeach; ?>
        </div>
      </div>
    </div>

    <!-- Planlanan Güncellemeler -->
    <div class="accordion-item">
      <h2 class="accordion-header" id="planlananHeader">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#planlananCollapse" aria-expanded="false" aria-controls="planlananCollapse"><strong>
        Planlanan Güncellemeler</strong>
      </button>
    </h2>
    <div id="planlananCollapse" class="accordion-collapse collapse" aria-labelledby="planlananHeader" data-bs-parent="#guncellemeAccordion">
      <div class="accordion-body">
        <p>• Siz söyleyin :)  ↓ </p>
      </div>
    </div>
  </div>

</div>

<br>


</section>
</div>

<div class="container" style="text-align: center;">
  <a class="btn btn-secondary" href="https://t.me/xaishcom" role="button" style="text-align: center;">
    Öneride Bulun ya da Bug Bildir <i class="fab fa-telegram"></i> </a>
  </div>

  <div class="container" style="text-align: center; padding: 20px 20px 20px 20px;">
    <div class="btn-group" role="group" aria-label="Politika Butonları">
        <button type="button" class="btn btn-outline-secondary me-3" data-bs-toggle="modal" data-bs-target="#privacyModal">
            Gizlilik Politikası
        </button>

        <!-- Sorumluluk Reddi -->
        <button type="button" class="btn btn-outline-secondary me-3" data-bs-toggle="modal" data-bs-target="#sorumlulukModal">
            Sorumluluk Reddi Beyanı
        </button>

        <!-- Button trigger modal for Cookie Policy -->
        <button type="button" class="btn btn-outline-secondary me-3" data-bs-toggle="modal" data-bs-target="#cookieModal">
            Çerez Politikası
        </button>
    </div>

    <p class="text-muted" style="margin-top: 1rem;">© 2023 XAISH. Tüm hakları saklıdır.</p>


</div>

  <!-- Privacy Policy Modal -->
  <div class="modal fade" id="privacyModal" tabindex="-1" aria-labelledby="privacyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="privacyModalLabel">Gizlilik Politikası</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <h6>Kişisel Bilgilerin Toplanması ve Kullanımı</h6>
          <p>XAISH, kullanıcıların gizliliğini önemsemekte olup, siteyi kullanırken toplanan kişisel bilgileri en üst düzeyde koruma taahhüdünde bulunur. Sitemizi ziyaret ettiğinizde, IP adresiniz, tarayıcı türü, işletim sistemi ve benzeri bilgiler otomatik olarak kaydedilebilir. Ancak, bu bilgiler sizi tanımlamak amacıyla değil, sadece sitemizi daha iyi anlamak ve iyileştirmek amacıyla kullanılır.</p>
          <h6>Çerez Kullanımı</h6>
          <p>XAISH, kullanıcı deneyimini artırmak ve sitemizi geliştirmek amacıyla çerezleri kullanabilir. Çerezler, tarayıcınıza küçük metin dosyaları olarak yerleştirilen bilgilerdir. Bu bilgiler, tercihlerinizi hatırlamamıza ve gelecekteki ziyaretlerinizi daha verimli hale getirmemize yardımcı olur. Çerezleri istediğiniz zaman tarayıcınızın ayarlarından devre dışı bırakabilirsiniz.</p>
          <h6>Üçüncü Taraf Bağlantıları</h6>
          <p>XAISH, sitemizden bağlantı verdiğimiz üçüncü taraf sitelerin gizlilik politikalarını kontrol etmez. Bu sitelerin içeriği veya gizlilik uygulamalarıyla ilgili sorumluluk kabul etmiyoruz. Bu nedenle, başka siteleri ziyaret etmeden önce ilgili sitelerin gizlilik politikalarını incelemenizi öneririz.</p>
          <h6>Değişiklikler</h6>
          <p>XAISH, gizlilik politikasını güncelleme hakkını saklı tutar. Bu politikadaki değişiklikler sayfada yayınlandığı anda geçerli olacaktır. Bu nedenle, düzenli aralıklarla bu sayfayı kontrol etmeniz önerilir.</p>
        </div>
      </div>
    </div>
  </div>


  <!-- Sorumlulk Reddi Modal -->
  <div class="modal fade" id="sorumlulukModal" tabindex="-1" aria-labelledby="sorumlulukModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="sorumlulukModalLabel">Sorumluluk Reddi Beyanı</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>XAISH, kripto vadeli işlemleri takip etme amacıyla kullanılan bir platformdur. Ancak, bu işlemlere girmek tamamen kullanıcının kendi inisiyatifindedir. Lütfen aşağıdaki hususları dikkatlice okuyun ve anlayın:</p>
          <h6>1. Finansal Riskler</h6>
          <p>Kripto vadeli işlemleri finansal risk içerir ve olumsuz piyasa koşulları nedeniyle zarar yaşanabilir. Kullanıcılar, bu platformu kullanarak gerçekleştirdikleri işlemlerin finansal sonuçlarından tamamen kendileri sorumludur.</p>
          <h6>2. Bilgi ve Deneyim</h6>
          <p>Platformumuzu kullanmadan önce, kullanıcıların kripto vadeli işlemleri ve genel finansal piyasa koşulları hakkında yeterli bilgiye sahip olmaları önemlidir. Aynı zamanda, kullanıcıların deneyim seviyelerini dikkate almaları ve risk toleranslarını değerlendirmeleri gerekmektedir.</p>
          <h6>3. Karar Verme Süreci</h6>
          <p>Platformumuz, kullanıcılara kripto vadeli işlemleri takip etme yeteneği sağlar. Ancak, bu işlemleri gerçekleştirme ve yönetme kararı tamamen kullanıcıya aittir. Platform, yatırım tavsiyesi sağlamaz ve kullanıcılar kendi bağımsız finansal danışmanlarına danışmalıdır.</p>
          <h6>4. Platform Güncellemeleri</h6>
          <p>XAISH, platform özelliklerini ve kullanıcı deneyimini iyileştirmek amacıyla düzenli olarak güncellemeler yapabilir. Kullanıcılar, güncellemeleri düzenli olarak kontrol etmeli ve değişikliklere göre hareket etmelidir.</p>
          <p>Kullanıcılar, bu platformu kullanarak gerçekleştirdikleri işlemlerin sonuçlarından tamamen kendileri sorumludur. XAISH, kullanıcıların finansal kararlarının sonuçlarından dolayı doğrudan veya dolaylı sorumluluk kabul etmez. Lütfen finansal kararlarınızı dikkatlice değerlendirin ve gerektiğinde bağımsız bir finansal danışmana başvurun.</p>
          <p>Bu sorumluluk reddi beyanı, kullanıcıların platformumuzu kullanırken bilinçli bir şekilde hareket etmelerini sağlamak üzere oluşturulmuştur.</p>
          <p>Son güncelleme tarihi: [15.12.2023]</p>
        </div>
      </div>
    </div>
  </div>



  <!-- Cookie Policy Modal -->
  <div class="modal fade" id="cookieModal" tabindex="-1" aria-labelledby="cookieModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="cookieModalLabel">Çerez Politikası</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <h6>Çerez Kullanımı ve Amaçları</h6>
          <p>XAISH, kullanıcı deneyimini iyileştirmek ve sitemizi daha etkili hale getirmek için çerezleri kullanır. Bu çerezler, ziyaretçilerin tercihlerini hatırlamamıza, siteyi nasıl kullandıklarını anlamamıza ve kullanıcı dostu içerik sunmamıza yardımcı olur. Çerezlerin kullanımı, kullanıcıların tarayıcı ayarlarından kontrol edilebilir.</p>
          <h6>Çerez Türleri</h6>
          <p>Sitemizde kullanılan çerezler, oturum çerezleri ve kalıcı çerezleri içerebilir. Oturum çerezleri, tarayıcı kapatıldığında silinen geçici çerezlerdir. Kalıcı çerezler ise belirli bir süre boyunca kullanıcı tarafından silinmeden saklanan çerezlerdir.</p>
          <h6>Çerez Ayarları</h6>
          <p>Kullanıcılar, tarayıcı ayarları aracılığıyla çerezleri kabul etme veya reddetme seçeneğine sahiptir. Ancak, çerezleri devre dışı bırakmak, sitemizin bazı özelliklerini kullanılamaz hale getirebilir. Çerez tercihlerinizi ayarlamak için tarayıcı ayarlarınızı kontrol etmeniz önerilir.</p>
          <p>Bu politikaların güncellenmesi durumunda, güncel versiyonlarına erişmek için lütfen xaish.com adresini ziyaret edin.</p>
        </div>
      </div>
    </div>
  </div>
</body>

</html>

<!-- DataTables JavaScript ve jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

<!-- Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>


<script src="../assets/loader.js"></script>
