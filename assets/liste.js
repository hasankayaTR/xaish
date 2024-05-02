$(document).ready(function () {
    initTable();
  });

  function initTable() {
    $('#islemlerTable').DataTable({
      "order": [], // Başlangıçta herhangi bir sıralama yapma
      "paging": true, // Sayfalama etkin
      "lengthMenu": [5, 10, 20, 50, 100], // Gösterilecek satır sayısını belirle
      "pageLength": 10, // Sayfa başına gösterilecek maksimum satır sayısı
      "language": { // Dil ayarları
        "sDecimal": ",", // Virgülle ayrılmış ondalık sayılar
        "sEmptyTable": "Tabloda herhangi bir veri mevcut değil",
        "sInfo": "Toplam _TOTAL_ kayıttan _START_ - _END_ arasındaki kayıtlar gösteriliyor",
        "sInfoEmpty": "Gösterilecek kayıt yok",
        "sInfoFiltered": "(_MAX_ kayıt içerisinden bulunan)",
        "sInfoPostFix": "",
        "sInfoThousands": ".",
        "sLengthMenu": "Sayfada _MENU_ işlem göster",
        "sLoadingRecords": "Yükleniyor...",
        "sProcessing": "İşleniyor...",
        "sSearch": "Ara:",
        "sZeroRecords": "Eşleşen kayıt bulunamadı",
        "oPaginate": {
          "sFirst": "İlk",
          "sLast": "Son",
          "sNext": "Sonraki",
          "sPrevious": "Önceki"
        },
        "oAria": {
          "sSortAscending": ": artan sütun sıralamasını aktifleştir",
          "sSortDescending": ": azalan sütun sıralamasını aktifleştir"
        }
      },
      "dom": '<"top"f>rt<"bottom"pl><"clear">' 
    });
  }

  function exportToExcel() {
    var allTables = document.querySelectorAll('.table'); // Assuming each page has a table with the 'table' class
    var combinedHTML = '';

    allTables.forEach(function (table) {
        combinedHTML += table.outerHTML;
    });

    var blob = new Blob([combinedHTML], { type: 'application/vnd.ms-excel' });
    var a = document.createElement('a');
    a.href = window.URL.createObjectURL(blob);
    a.download = 'islem_listesi.xls';
    a.click();
}

  function filterTable(type) {
    // Tüm satırları gizle
    $('#islemlerTable tbody tr').hide();

    // Belirli bir tip için satırları göster
    if (type === 'acik') {
      $('#islemlerTable tbody tr.islem-acik').show();
    } else if (type === 'kapali') {
      $('#islemlerTable tbody tr.islem-kapali').show();
    } else {
      // Tüm satırları göster
      $('#islemlerTable tbody tr').show();
    }
  }

  function tabloyuYenile() {
  // Buton ve durum elementlerini al
  var yenileButton = $('#yenileButton');
  var gerceklesenButton = $('#gerceklesenButton');
  var anlikButton = $('#anlikButton');
  var degisimButton = $('#degisimButton');

  // Orijinal buton metnini sakla
  var orijinalButtonText = yenileButton.html();

  // Yükleniyor mesajını göster
  yenileButton.html('<i class="fa-solid fa-spinner"></i> Yenileniyor...');

  $.get(window.location.href)
    .done(function (veri) {
      console.log('Başarılı - Alınan Veri:', veri);

      // Tablo ve pagination bilgilerini al
      var tablo = $(veri).find('#islemlerTable');
      var tbody = tablo.find('tbody');
      var pagination = $(veri).find('.pagination');

      // DataTables'ı başlat ve tabloyu güncelle
      $('#islemlerTable').DataTable().destroy(); // DataTables'ı temizle
      $('#islemlerTable tbody').html(tbody.html()); // Tabloyu güncelle
      initTable(); // DataTables'ı tekrar başlat

      // Pagination bilgisini güncelle ve tekrar ekle
      $('.pagination').replaceWith(pagination);

      // Gerçekleşen, Anlık ve Değişim değerlerini güncelle
      var gerceklesenDeger = $(veri).find('#gerceklesenButton').html();
      var anlikDeger = $(veri).find('#anlikButton').html();
      var degisimDeger = $(veri).find('#degisimButton').html();

      // Tamamlandı mesajını göster
      yenileButton.html('<i class="fa-regular fa-circle-check"></i> Tablo yenilendi');

      // Belirli bir süre sonra (örneğin, 2 saniye) orijinal buton metnine geri dön
      setTimeout(function () {
        yenileButton.html(orijinalButtonText);
      }, 2000); // Gerekirse bu gecikmeyi ayarlayın

      // Gerçekleşen, Anlık ve Değişim butonlarını güncelle
      gerceklesenButton.html(gerceklesenDeger);
      anlikButton.html(anlikDeger);
      degisimButton.html(degisimDeger);
    })
    .fail(function (hata) {
      console.error('Tablo yenileme hatası:', hata);

      // Gerekirse bir hata mesajı göster
      yenileButton.html('<i class="fa-solid fa-circle-exclamation"></i> Hata.');

      // Belirli bir süre sonra (örneğin, 2 saniye) orijinal buton metnine geri dön
      setTimeout(function () {
        yenileButton.html(orijinalButtonText);
      }, 2000); // Gerekirse bu gecikmeyi ayarlayın
    })
    .always(function () {
      console.log('Yenileme isteği tamamlandı.');
    });
}


