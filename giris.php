<?php
include ('baglan.php');
?>
 
<?php
if(isset($_POST['giris'])){
$posta = $_POST['mail'];
$sifre = $_POST['sifre'];
 
if(empty($posta) || empty($sifre)){
  header("Location: index.php?hata=girdilerbos");
  exit();
}else{
 
$stmt = $db->prepare("SELECT * FROM uye WHERE mail=?");
if($stmt === false) die("Bağlantı Hatası:".$db->error);
$stmt->bind_param("s", $posta);
$stmt->execute();
$sonuc = $stmt->get_result();
if($veri = $sonuc->fetch_assoc()){
$sifrekontrol = password_verify($sifre, $veri['sifre']);
if($sifrekontrol == false){
  header("Location: index.php?hata=sifrehatali");
  exit();
}
else if($sifrekontrol == true){
  session_start();
  $_SESSION['mail'] = $veri['mail'];
  $_SESSION['ad'] = $veri['ad'];
  header("Location: index.php");
  exit();
}
 
}else{
  header("Location: index.php");
  exit();
}
}
}else{
  header("Location: index.php?hata=uyeyok");
  exit();
}
 
 
 
?>