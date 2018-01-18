<?php
if($_SESSION['pass'] == null) {
    redirect('login.php');
}

if (md5($_SESSION['pass']) != $adminpassword) {
    redirect('login.php?a=wp');
	}