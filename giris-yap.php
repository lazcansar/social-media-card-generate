<?php
include ('baglan.php');
?>
<form action="giris.php" method="post">
 
<input type="text" name="mail" class="form-control mt-2" placeholder="Mail adresi Girin!" required>

<input type="password" name="sifre" class="form-control mt-2" placeholder="Şifrenizi Yazın..." required>
<input type="submit" class="btn btn-info btn-block mt-2" name="giris" value="giriş yap">
</form>