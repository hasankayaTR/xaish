// Sayfa yüklendikten 3 saniye sonra loader'ı kaldır
window.addEventListener('load', function () {
  setTimeout(function () {
    var loader = document.getElementById('loader');
    loader.style.display = 'none';
  }, 1500); // 3000 milisaniye (3 saniye)
});