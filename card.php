<?php
include 'baglan.php';
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
        $sekil = $cikti['sekil'];
        $resim = $cikti['resim_url'];
        $baglanti = $cikti['yazi_url'];
        echo '<html>
        <head>
<meta name="twitter:card" content="'.$sekil.'" />
<meta name="twitter:site" content="@yucebilgi" />
<meta name="twitter:creator" content="@yucebilgi" />
<meta property="og:url" content="'.$baglanti.'" />
<meta property="og:title" content="'.$baslik.'" />
<meta property="og:description" content="'.$metin.'" />
<meta property="og:image" content="'.$resim.'" />
<meta http-equiv = "refresh" content = "0; url = '.$baglanti.'" />
        </head>        
        </html>';

    }
}else{
    echo "Sonuç bulunamadı";
}
    }
        
    ?>