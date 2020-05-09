<?php
//Form Fonksiyonları Başlangıcı
function form($action="", $method="post"){
return "<form action='$action' method='$method'>\n";
}
function form_close(){
    return "</form>\n";
}
function form_input($type, $name, $class){
    return "<input type='$type' name='$name' class='$class'><br>\n";
}
//Form Fonksiyonları Bitişi

//Link Fonksiyonu
function baglanti($class, $baglanti, $title){
    global $target;
    return "<a href='$baglanti' class='$class' title='$title' $target>\n";
}
//resim fonksiyonu
function img($src, $class, $alt){
    return "<img src='$src' class='$class' alt='$alt'>";
}

/**
 * Sayfalama Fonksiyonu şablon niteliğinde eklenmiştir.
 */
$stmt = $db->prepare("SELECT count(*) FROM yazilar"); ///tablo içini say
   $stmt->execute(); //sorgu çalıştır
   $sonuc = $stmt->get_result(); //sonuc değişkenine bağla
   if($sonuc->num_rows < 1) die('Kayıt bulunamadı'); //kayıt sayısı 1 den küçükse uyarı
   
   $sayfa_sayisi = $sonuc->fetch_array(MYSQLI_NUM); //
   $limit = 3; //içerik çıktı limiti
   
   $ofset = isset($_GET['sayfa']) ? $_GET['sayfa'] : 0;
   
   $stmt = $db->prepare("SELECT * FROM yazilar ORDER BY icerik_id DESC LIMIT ? OFFSET ?");
   $stmt->bind_param("ii", $limit, $ofset);
   $stmt->execute();
   $sonuc = $stmt->get_result();
   
   while($cikti = $sonuc->fetch_array()){
       $sira = $cikti['icerik_id'];
       $baslik = $cikti['baslik'];
       $resim = $cikti['resim_url'];
       $onay = "'Silmek istediğinize emin misiniz?'";
       
   
   if($sayfa_sayisi[0] > $limit){
       $x = 0;
       for($i = 0; $i < $sayfa_sayisi[0]; $i += $limit){
           $x++;
           echo "<li class='page-item'><a class='page-link' href='?sayfa=$i'>$x</a></li>";
       }
   }

 /**
 * Sayfalama Fonksiyonu şablon niteliğinde bitmiştir.
 */
?>
