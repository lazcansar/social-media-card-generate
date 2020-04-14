<?php
session_start();
include 'baglan.php';

if(isset($_SESSION['mail'])){
  #kayıt sil!
    if(isset($_GET['icerik_id'])){
$gor = $_GET['icerik_id'];
$stmt = $db->prepare("UPDATE FROM yazilar WHERE icerik_id= '$gor'");
$stmt->execute();
header ("Location: ./?basariyla-silindi");
exit();
$stmt->close();
$db->close();
}
}else {
echo '<div class="container mt-4 p-5 text-center card shadow">';
  include 'giris-yap.php';
  echo '</div>';
}


   
?>