<?php include 'header.php'; ?>

<?php

if(isset($_SESSION['mail'])){
   #kayıt sil!
    if(isset($_GET['icerik_id'])){
$gor = $_GET['icerik_id'];
$stmt = $db->prepare("SELECT * FROM yazilar WHERE icerik_id= '$gor'");
$stmt->execute();
$yazilar = $stmt->get_result(); 
if ($yazilar->num_rows > 0){
    while($cikti = $yazilar->fetch_array()){
        $sira = $cikti['icerik_id'];
        $baslik = $cikti['baslik'];
        $metin = $cikti['metin'];
        $resim = $cikti['resim_url'];
        $yazi = $cikti['yazi_url'];
        echo '<div class="container text-center mt-2 border bg-light p-3">';
        echo "<h1>".$baslik."</h1>";
        echo '</div>';
        echo '<div class="container mt-2 bg-light p-3">';
        echo '<div class="row">';
        echo '<div class="col-md-4">';
        echo '<img src="'.$resim.'" class="img-fluid">';        
        echo '</div>';
        echo '<div class="col-md-4 p-4" id="yazi-alani">';
        echo $metin;        
        echo '</div>';
        echo '<div class="col-md-4 p-4" id="url-alani">';
        echo '<a href="'.$yazi.'">'.$baslik.'</a>';        
        echo '</div>';
        echo '</div>';
        echo '</div>';

    }
}else{
    echo "Sonuç bulunamadı";
}
    }
}else {
  echo '<div class="container mt-2 p-5 text-center card shadow">';
  include 'giris-yap.php';
  echo '</div>';
}
    ?>

    <?php include 'footer.php'; ?>