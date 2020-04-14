<?php 

if(isset($_SESSION['mail'])){
    echo '<div class="container shadow p-3 mt-2 bg-primary text-white">';
  echo "Hoş geldin <b>".$_SESSION['ad']."</b> | ";
  echo "<a class='btn btn-sm btn-success' href='cikis.php' class='text-white'>Çıkış Yap</a></div>";
  echo '
<div class="container mt-2 p-3 veri-ekle card shadow">

<div class="card bg-dark mt-4 mb-4 p-3 text-white">
   <h3 class="border text-center p-2">Kayıtlı Veriler</h3>';
   #kayıt ekleme bölümü buradan aşağısı
if(isset($_GET['basariyla-silindi'])){
    echo "Kayıt başarıyla silindi...";
}
   #kayıt listeleme
$stmt = $db->prepare("SELECT * FROM yazilar");
$stmt->execute();
$yazilar = $stmt->get_result(); 
if ($yazilar->num_rows > 0){
    while($cikti = $yazilar->fetch_array()){
        $sira = $cikti['icerik_id'];
        $baslik = $cikti['baslik'];
        $metin = $cikti['metin'];
        echo '<li>'.$baslik.' <a class="btn btn-warning btn-sm" href="goruntule.php?icerik_id='.$sira.'">Görüntüle</a> <a class="btn btn-info btn-sm" href="card.php?icerik_id='.$sira.'">Card Aç</a> <a class="btn btn-warning btn-sm" href="veri-sil.php?icerik_id='.$sira.'">Sil</a> <a class="btn btn-warning btn-sm" href="veri-guncelle.php?icerik_id='.$sira.'">Güncelle</a></li>';

    }
}else{
    echo "Sonuç bulunamadı";
}


echo '</div>';
#kayıt ekleme bölümü buradan aşağısı
if(isset($_GET['basariyla-eklendi'])){
    echo "Kayıt eklendi";
}

 if(isset($_POST['ekle'])){        
$stmt = $db->prepare("INSERT INTO yazilar VALUES (?,?,?,?,?,?)");
$stmt->bind_param("isssss", $icerik_id, $baslik, $metin, $sekil, $resim_url, $yazi_url);
$icerik_id = "";
$baslik = $_POST['baslik'];
$metin = $_POST['metin'];
$sekil = $_POST['sekil'];
$resim_url = $_POST['resim_url'];
$yazi_url = $_POST['yazi_url'];
$stmt->execute();
header ("Location: ./?basariyla-eklendi");
exit();
$stmt->close();
$db->close();
}

echo '<h3 class="border text-center p-2">Veri Ekle</h3>
<form action="" method="post">
<input type="text" name="baslik" class="form-control mt-2" placeholder="Başlık" required>
<textarea type="text" name="metin" class="form-control mt-2" rows="5" placeholder="Metin" required></textarea>
<select class="form-control mt-2" id="kartlar" name="sekil">
<option value="summary">Summary Card</option>
<option value="summary_large_image">Summary Large İmage Card</option>
</select>
<input type="text" name="resim_url" class="form-control mt-2" placeholder="Resim URL" required>
<input type="text" name="yazi_url" class="form-control mt-2" placeholder="Yazı URL" required>
<input type="submit" name="ekle" class="btn btn-dark mt-2 btn-block" value="Kayıt Ekle">
</form>
</div>

';
   
   
}else {
    echo '<div class="container mt-2 p-5 text-center card shadow">';
  include 'giris-yap.php';
  echo '</div>';
}
 ?>

  