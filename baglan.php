<?php
$db = @new mysqli("localhost", "root", "", "sosyal");
if($db->connect_error){
    die("Bağlantı Hatası:" . $db->connect_error);
}
?>