<? include 'header.php' ?>
 
<?php
if(isset($_POST['kayit'])){
  $isim = $_POST['ad'];
  $posta = $_POST['mail'];
  $sifre = $_POST['sifre'];
  $sifredogrula = $_POST['ikincisifre'];
 
if(empty($isim) || empty($posta) || empty($sifre) || empty($sifredogrula)){
  header("Location: uye-kayit.php?hata=girislerbos");
  exit();
}
else if(!filter_var($posta, FILTER_VALIDATE_EMAIL)){
  header("Location: uye-kayit.php?hata=mailhatali");
  exit();
}
else if($sifre !== $sifredogrula){
  header("Location: uye-kayit.php?hata=sifrelereslesmedi");
  exit();
 
}else{
  $stmt = $db->prepare("INSERT INTO uye (ad, mail, sifre) VALUES (?,?,?)");
  if($stmt === false) die("Bağlantı Hatası:".$db->error);
  $kriptosifre = password_hash($sifre, PASSWORD_DEFAULT);
  $stmt->bind_param("sss", $isim, $posta, $kriptosifre);
  $stmt->execute();
  header("Location: uye-kayit.php?kayit=basarli");
  exit();
  $stmt->close();
  $db->close();
 
}
}
 ?>
 

 <div class="container border mt-4 bg-info p-4">
 <?php
if(isset($_GET['kayit'])){
  if($_GET['kayit'] == "basarli"){
  echo "Üye kaydı tamamlandı. Giriş yapmak için lütfen <a class='text-white' href='/'> buraya tıklayın...</a>";
}
}
 ?>
<form action="" method="post">
<input class="form-control mt-2" type="text" name="ad" placeholder="İsminiz">
<input class="form-control mt-2" type="text" name="mail" placeholder="E-Posta Adresi">
<input class="form-control mt-2" type="password" name="sifre" placeholder="Şifre">
<input class="form-control mt-2" type="password" name="ikincisifre" placeholder="Tekrar Şifre">
<input class="form-control mt-2 btn btn-success btn-block" type="submit" value="Kullanıcı ekle" name="kayit">
</form>
</div>
<?php include 'footer.php' ?>