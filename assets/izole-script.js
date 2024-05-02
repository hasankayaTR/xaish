function hesapla() {
        // Form verilerini al
        var entryPrice = document.getElementById("entryPrice").value;
        var liquidationPrice = document.getElementById("liquidationPrice").value;
        var lossAmount = document.getElementById("lossAmount").value;

        // Hesaplamaları yap
        var quantity = lossAmount / (entryPrice - liquidationPrice);
        var minLeverage = 1 / Math.abs((entryPrice - liquidationPrice) / entryPrice);

        // Sonuçları ekrana yazdır
        var positionType = (quantity < 0) ? 'Short ↓' : 'Long ↑';
        var buttonColor = (positionType == 'Long ↑') ? 'success' : 'danger';
        var buttonText = "<strong>" + positionType + "</strong>";

        var sonuclarHTML = "<div class='mt-4 text-center'>";
        sonuclarHTML += "<h4>Sonuçlar</h4>";
        sonuclarHTML += "<div class='table-responsive'>";
        sonuclarHTML += "<table class='table table-light'>";
        sonuclarHTML += "<thead><tr><th scope='col'>Pozisyon</th><th scope='col'>Adet</th>";
        sonuclarHTML += "<th scope='col'>Size (USDT)</th><th scope='col'>Min Kaldıraç</th></tr></thead>";
        sonuclarHTML += "<tbody><tr><td><button type='button' class='btn btn-" + buttonColor + "'>" + buttonText + "</button></td>";
        sonuclarHTML += "<td>" + Math.abs(quantity) + "</td>";
        sonuclarHTML += "<td>$" + Math.abs(quantity * entryPrice) + "</td>";
        sonuclarHTML += "<td>" + Math.ceil(minLeverage) + "x</td></tr></tbody>";
        sonuclarHTML += "</table></div></div>";

        // Ekrana yazdır
        document.getElementById("sonuclar").innerHTML = sonuclarHTML;
    }

    // Input değerleri değiştiğinde otomatik hesapla
    document.getElementById("entryPrice").addEventListener("input", hesapla);
    document.getElementById("liquidationPrice").addEventListener("input", hesapla);
    document.getElementById("lossAmount").addEventListener("input", hesapla);