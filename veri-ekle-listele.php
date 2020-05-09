<?php 
/*eski listeleme 
echo '<li class="mt-3">'.$baslik.' <a class="btn btn-warning btn-sm" href="goruntule.php?icerik_id='.$sira.'">Görüntüle</a> <a class="btn btn-info btn-sm" href="card.php?icerik_id='.$sira.'">Card Aç</a> <a class="btn btn-warning btn-sm" href="veri-sil.php?icerik_id='.$sira.' " onclick="return confirm('.$onay.')">Sil</a> <a class="btn btn-warning btn-sm" href="veri-guncelle.php?icerik_id='.$sira.'">Güncelle</a></li>';
*/
if(isset($_SESSION['mail'])){
    echo '<div class="container shadow p-3 mt-2 bg-primary text-white">';
  echo "Hoş geldin <b>".$_SESSION['ad']."</b> | ";
  echo "<a class='btn btn-sm btn-success' href='cikis.php' class='text-white'>Çıkış Yap</a>";
  if(isset($_GET['basariyla-silindi'])){
    echo '<div class="mt-2">Kayıt başarılı bir şekilde silindi!</div>';
}
if(isset($_GET['basariyla-eklendi'])){
  echo '<div class="mt-2">Kayıt başarılı bir şekilde eklendi!</div>';
}
  echo "</div>";
  
  echo '
<div class="container mt-2 p-3 veri-ekle card shadow">

<div class="card bg-dark mt-4 mb-4 p-3">
   <h3 class="text-center kayitli-veriler p-2">Son Eklenen Kayıtlı Veriler</h3>
   <div class="row row-cols-1 row-cols-md-3">';

   #kayıt listeleme
   $stmt = $db->prepare("SELECT count(*) FROM yazilar");
   $stmt->execute();
   $sonuc = $stmt->get_result();
   if($sonuc->num_rows < 1) die('Kayıt bulunamadı');
   
   $sayfa_sayisi = $sonuc->fetch_array(MYSQLI_NUM);
   $limit = 3;
   
   $ofset = isset($_GET['sayfa']) ? $_GET['sayfa'] : 0;
   
   $stmt = $db->prepare("SELECT * FROM yazilar ORDER BY icerik_id DESC LIMIT ? OFFSET ?");
   $stmt->bind_param("ii", $limit, $ofset);
   $stmt->execute();
   $sonuc = $stmt->get_result();
   
   while($cikti = $sonuc->fetch_array()){
       $sira = $cikti['icerik_id'];
       $baslik = $cikti['baslik'];
       $resim = $cikti['resim_url'];
       $metin = $cikti['metin'];
       $basliku= 29;
       $basliko = mb_substr($baslik,0,$basliku);
       $aciklamauzunluk = 70;
       $aciklamaozet=mb_substr($metin,0,$aciklamauzunluk);
       $onay = "'Silmek istediğinize emin misiniz?'";
       echo '  <div class="col mb-4 mt-4">
       <div class="card">
         <img src="'.$resim.'" class="card-img-top" alt="...">
         <div class="card-body">
           <h5 class="card-title">'.$basliko.'</h5>
           <p class="card-text">'.$aciklamaozet.'...</p>
           <a class="btn btn-warning btn-sm" href="goruntule.php?icerik_id='.$sira.'">Görüntüle</a> <a class="btn btn-info btn-sm" href="card.php?icerik_id='.$sira.'">Card Aç</a> <a class="btn btn-warning btn-sm" href="veri-sil.php?icerik_id='.$sira.' " onclick="return confirm('.$onay.')">Sil</a> <a class="btn btn-warning btn-sm" href="veri-guncelle.php?icerik_id='.$sira.'">Güncelle</a>
         </div>
       </div>
     </div>';  
   
   }
   echo '</div>
   <nav aria-label="Page navigation example">
     <ul class="pagination justify-content-center">
       <li class="page-item disabled">
         <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Önceki</a>
       </li>';
   if($sayfa_sayisi[0] > $limit){
       $x = 0;
       for($i = 0; $i < $sayfa_sayisi[0]; $i += $limit){
           $x++;
           echo "<li class='page-item'><a class='page-link' href='?sayfa=$i'>$x</a></li>";
       }
   }


echo '
      <a class="page-link" href="#">Sonraki</a>
    </li>
  </ul>
</nav>
</div>';
//****Buradan aşağısı kayıt listeleme için kullanılıyor. Buradan aşağısına elleme bu şekilde kalsın. Karışıklık olmasın önemli çünkü... */
#kayıt ekleme bölümü buradan aşağısı


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

  