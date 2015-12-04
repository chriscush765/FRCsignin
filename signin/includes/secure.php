<?php
if($_SESSION['pass'] == null) {
    redirect('login');
}

if (md5($_SESSION['pass']) != $adminpassword) {
    redirect('login.php?a=wp');
	}