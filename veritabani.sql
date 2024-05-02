-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost:3306
-- Üretim Zamanı: 02 May 2024, 22:05:20
-- Sunucu sürümü: 10.3.39-MariaDB
-- PHP Sürümü: 8.2.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `beta_kingo`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ayarlar`
--

CREATE TABLE `ayarlar` (
  `ayar_id` int(11) NOT NULL,
  `bakiye` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `ayarlar`
--

INSERT INTO `ayarlar` (`ayar_id`, `bakiye`) VALUES
(1, '181.5419');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `bilgiler`
--

CREATE TABLE `bilgiler` (
  `id` int(11) NOT NULL,
  `versiyon` varchar(20) NOT NULL,
  `aciklama` text CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
  `tarih` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `bilgiler`
--

INSERT INTO `bilgiler` (`id`, `versiyon`, `aciklama`, `tarih`) VALUES
(1, 'V.1.0.0', 'İzole Poz Hesaplayıcı oluşturuldu.', '2023-12-11 00:13:16'),
(2, 'V.1.0.6', 'Yeni tasarım eklendi ve sayfalar düzenlendi.', '2023-12-11 00:13:16'),
(3, 'V.1.0.9', 'İşlemler sayfası ve tablosu eklendi.', '2023-12-11 00:13:16'),
(4, 'V.1.1.1', 'Header menüsü düzenlendi.', '2023-12-11 00:13:16'),
(5, 'V.1.1.2', 'Bug fix ve performans iyileştirmeleri.', '2023-12-11 00:13:16'),
(6, 'V.1.1.5', 'İşlemlere kasa bakiyesi eklendi ve mobil uyumluluk sorunları giderildi.', '2023-12-11 00:13:16'),
(7, 'V.1.1.8', 'İşlemler tablosuna liq fiyatı, pozisyon için gerekli min kaldıraç ve işlem hacmi eklendi.', '2023-12-11 00:13:16'),
(8, 'V.1.1.9', 'İzole pozisyon hesaplama aracına min gerekli kaldıraç eklendi.', '2023-12-11 00:13:16'),
(10, 'V.1.2.0', 'İşlem tablosunu Excel dosyası olarak indirebilmek için buton eklendi.', '2023-12-11 01:54:30'),
(11, 'V.1.2.3', 'Açık ve kapalı işlemleri ayırt edilebilmesi için filtreleme ve satır rengi eklendi.', '2023-12-11 01:55:16'),
(12, 'V.1.2.5', 'İşlem arama ve sayfalama filtreleri eklendi.', '2023-12-11 01:57:41'),
(13, 'V.1.2.8', 'Aggr-trade eklendi ve header menüsü düzenlendi.', '2023-12-11 03:34:29'),
(14, 'V.1.2.9', 'İzole Poz Hesaplayıcı hesapla butonu kaldırıldı, artık inputlara göre anında hesaplayacak.', '2023-12-13 09:58:49'),
(15, 'V.1.3.2', 'Gerçekleşmeyen kar/zarar ve son fiyat eklendi. ', '2023-12-13 22:35:14'),
(16, 'V.1.3.7', 'Kasadaki gerçekleşen, anlık durum ve başlangıç değişim yüzdesi eklendi.', '2023-12-14 02:46:02'),
(17, 'V.1.4.0', 'Bug fix ve performans iyileştirmeleri yapıldı.', '2023-12-14 02:47:07'),
(18, 'V.1.4.2', 'Tradingview grafik butonu eklendi.', '2023-12-14 12:29:18'),
(19, 'V.1.4.5', 'Tabloyu yenile butonu eklendi. Tarayıcı önbelleği ve çerezleri temizleyiniz.', '2023-12-14 14:33:10'),
(20, 'V.1.4.7', 'Güncel Fiyat için artık Binance Futures API kullanılıyor. API\'nin verimli kullanımı için kapalı olan işlemler fiyatı çekilmeyecek.', '2023-12-16 02:04:52'),
(21, 'V.1.4.8', 'Açık olan işlemler artık tablonun en üstünde görünecek ve devamında açılış tarihine göre sıralanacak.', '2023-12-16 02:08:06'),
(22, 'V.1.4.9', 'Grafik butonu artık XXXUSDT.P (vadeli) grafiğe yönlendirecek.', '2023-12-16 02:09:26'),
(23, 'V.1.5.0', 'Tablo liq olan işlemlerin satır arkaplanı açık kırmızı olacak şekilde güncellendi.', '2023-12-16 17:49:32'),
(24, 'V.1.5.2', 'Bazı istatistik durumları eklendi.', '2023-12-19 02:34:33');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `fiyatlar`
--

CREATE TABLE `fiyatlar` (
  `fiyat_id` int(11) NOT NULL,
  `symbol` text NOT NULL,
  `price` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `islem_liste`
--

CREATE TABLE `islem_liste` (
  `islem_id` int(11) NOT NULL,
  `tarih` date NOT NULL DEFAULT current_timestamp(),
  `parite` varchar(255) NOT NULL,
  `acilis` text NOT NULL,
  `liq_fiyat` text NOT NULL,
  `kar_zarar` decimal(10,2) DEFAULT NULL,
  `kapanis` text DEFAULT NULL,
  `long_short` varchar(10) NOT NULL,
  `acik_mi` int(11) NOT NULL DEFAULT 1,
  `adet` text NOT NULL,
  `marjin` text NOT NULL,
  `kaldirac` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Tablo döküm verisi `islem_liste`
--

INSERT INTO `islem_liste` (`islem_id`, `tarih`, `parite`, `acilis`, `liq_fiyat`, `kar_zarar`, `kapanis`, `long_short`, `acik_mi`, `adet`, `marjin`, `kaldirac`) VALUES
(6, '2023-12-08', 'XTZ', '0.91', '0.60', 11.61, '0.95', 'Long', 0, '270', '', ''),
(8, '2023-12-08', 'BAL', '4.29', '2.93', -15.65, '4.03', 'Long', 0, '60.20', '', ''),
(9, '2023-12-08', 'CRV', '0.69', '0.39', -35.38, '0.5570', 'Long', 0, '266', '', ''),
(10, '2023-12-08', 'RUNE', '6.37', '6.90', 79.04, '5.85', 'Short', 0, '152', '', ''),
(12, '2023-12-09', 'INJ', '19.26', '20.20', -71.91, '20.20', 'Short', 0, '76.5', '', ''),
(33, '2023-12-12', 'TRB', '108.50', '114', -18.18, '111.00', 'Short', 0, '7.27', '40', '20'),
(36, '2023-12-14', 'KNC', '0.715', '0.55', 4.85, '0.725', 'Long', 0, '484.8', '80', '5'),
(39, '2023-12-14', 'SOL', '72.90', '77.85', -22.68, '75.60', 'Short', 0, '8.4', '40', '16'),
(40, '2023-12-15', 'DYDX', '2.863', '2.458', 25.26, '3.12', 'Long', 0, '98.28', '40', '7'),
(42, '2023-12-18', 'DYDX', '2.90', '2.60', -20.00, '2.80', 'Long', 0, '200', '30', '20'),
(44, '2023-12-18', 'LINK', '14.20', '13.48', 24.96, '14.8', 'Long', 0, '41.6', '30', '20'),
(45, '2023-12-18', 'DYDX', '2.88', '2.73', 8.00, '2.92', 'Long', 0, '200', '60', '10'),
(46, '2023-12-19', 'DYDX', '2.925', '2.7787', -29.99, '2.7787', 'Long', 0, '205', '30', '20'),
(47, '2023-12-19', 'RUNE', '5.1', '4.58', 16.15, '5.38', 'Long', 0, '57.69', '30', '10'),
(48, '2023-12-20', 'TRB', '143', '157.3', -29.89, '157.3', 'Short', 0, '2.09', '30', '10'),
(51, '2023-12-21', 'ZRX', '0.3787', '0.336', -24.85, '0.336', 'Long', 0, '582', '', ''),
(52, '2023-12-21', 'YFI', '8420', '7484', -8.54, '8100', 'Long', 0, '0.02670', '', ''),
(53, '2024-01-01', 'SOL', '104.35', '97.99', -15.01, '97.99', 'Long', 0, '2.36', '', ''),
(54, '2024-01-01', 'KNC', '0.725', '0.57', -50.35, '0.57', 'Long', 0, '324.816', '', ''),
(55, '2024-01-01', 'ZRX', '0.3718', '0.3358', -24.65, '0.3358', 'Long', 0, '684.64', '', ''),
(62, '2024-03-04', 'LDO', '3.36', '1.56', -54.74, '2.9', 'Long', 0, '119', '', ''),
(63, '2024-02-28', 'ETH', '3450', '1400', 90.60, '3971', 'Long', 0, '0.1739', '', ''),
(64, '2024-03-03', 'BTC', '64260', '34000', 37.26, '68400', 'Long', 0, '0.009', '', ''),
(65, '2024-03-11', 'ETH', '3971', '2600', -56.38, '3710', 'Long', 0, '0.216', '', ''),
(67, '2024-03-20', 'ETH', '3234', '2550', 14.45, '3344', 'Long', 0, '0.1314', '', ''),
(68, '2024-03-17', 'ETH', '3200', '2500', 45.38, '3500', 'Long', 0, '0.15125', '', ''),
(69, '2024-03-25', 'LDO', '3.16', '158', 14.80, '3.30', 'Long', 0, '105.69', '', ''),
(70, '2024-03-26', 'LDO', '2.60', '2.00', NULL, NULL, 'Long', 1, '165.45', '', '');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanicilar`
--

CREATE TABLE `kullanicilar` (
  `id` int(11) NOT NULL,
  `kullanici_adi` varchar(50) NOT NULL,
  `sifre` varchar(255) NOT NULL,
  `admin_mi` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `kullanicilar`
--

INSERT INTO `kullanicilar` (`id`, `kullanici_adi`, `sifre`, `admin_mi`) VALUES
(1, 'admin', '$2y$10$9urtwmyJFivckU464FPHfeFtaYKyr3D5j1KkqR8vjW/Qy3wq3sSL2', 1);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `ayarlar`
--
ALTER TABLE `ayarlar`
  ADD PRIMARY KEY (`ayar_id`);

--
-- Tablo için indeksler `bilgiler`
--
ALTER TABLE `bilgiler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `fiyatlar`
--
ALTER TABLE `fiyatlar`
  ADD PRIMARY KEY (`fiyat_id`);

--
-- Tablo için indeksler `islem_liste`
--
ALTER TABLE `islem_liste`
  ADD PRIMARY KEY (`islem_id`);

--
-- Tablo için indeksler `kullanicilar`
--
ALTER TABLE `kullanicilar`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kullanici_adi` (`kullanici_adi`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `ayarlar`
--
ALTER TABLE `ayarlar`
  MODIFY `ayar_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `bilgiler`
--
ALTER TABLE `bilgiler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Tablo için AUTO_INCREMENT değeri `fiyatlar`
--
ALTER TABLE `fiyatlar`
  MODIFY `fiyat_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `islem_liste`
--
ALTER TABLE `islem_liste`
  MODIFY `islem_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- Tablo için AUTO_INCREMENT değeri `kullanicilar`
--
ALTER TABLE `kullanicilar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
