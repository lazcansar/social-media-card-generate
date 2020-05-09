<?php
@session_start();
include 'baglan.php';
if(isset($_SESSION['mail'])){//Oturum başlangıcı mail ile gerçekleştirilmiş mi?
//Evet gerçekleştirildi.
@include 'header.php';
echo '<div class="container shadow p-3 mt-2 bg-primary text-white">';
echo "Hoş geldin <b>".$_SESSION['ad']."</b> | ";
echo "<a class='btn btn-sm btn-success' href='cikis.php' class='text-white'>Çıkış Yap</a></div>";
echo '<div class="container card p-4">';
if(isset($_POST['icerik_id']) && isset($_POST['baslik'])){
  $stmt = $db->prepare("UPDATE yazilar SET baslik=?, metin=?, sekil=?, resim_url=?, yazi_url=? WHERE icerik_id=?");
  $stmt->bind_param("sssssi", $_POST['baslik'], $_POST['metin'], $_POST['sekil'], $_POST['resim_url'], $_POST['yazi_url'], $_POST['icerik_id']);
  $stmt->execute();
  header ("Location: ./?basariyla-guncellendi");
}elseif(isset($_GET['icerik_id']) && ! empty($_GET['icerik_id'])){
  $stmt = $db->prepare("SELECT * FROM yazilar WHERE icerik_id=?");
  $stmt->bind_param("i", $_GET['icerik_id']);
  $stmt->execute();
  $sonuc = $stmt->get_result();
  $veri = $sonuc->fetch_array();
  echo '<form action="" method="post">
  <input type="hidden" name="icerik_id" value="'.$veri['icerik_id'].'"/>
  <input type="text" name="baslik" class="form-control mt-2" placeholder="Başlık" required value="'.$veri['baslik'].'">
  <textarea type="text" name="metin" class="form-control mt-2" rows="5" placeholder="Metin" required>'.$veri['metin'].'</textarea>
  <select class="form-control mt-2" id="kartlar" name="sekil">
  <option value="summary">Summary Card</option>
  <option value="summary_large_image">Summary Large İmage Card</option>
  </select>
  <input type="text" name="resim_url" class="form-control mt-2" placeholder="Resim URL" required value="'.$veri['resim_url'].'">
  <input type="text" name="yazi_url" class="form-control mt-2" placeholder="Yazı URL" required value="'.$veri['yazi_url'].'">
  <input type="submit" name="ekle" class="btn btn-dark mt-2 btn-block" value="Kayıt Güncelle">
  </form></div>';
}else{
  echo 'Bilgiler eksik!';
}

}else {//Oturum başlangıcı gerçekleştirilmemiş ise!
echo '<div class="container mt-4 p-5 text-center card shadow">';
  include 'giris-yap.php';
  echo '</div>';
}
 
?>

<?php
include 'footer.php';
?>