<?php
session_start();
if ($_POST['vihod']=='Выход'){
	$_SESSION['login']='';
	$_SESSION['pass']='';
	$_SESSION['status']='';
}
?>
<nav>
        <div class=''>
            <a href='index.php' class='a2'><font color='black'>Главная<font></a>
        </div>
        <div class=''>
            <a href='o_nas.php' class='a2'><font color='black'>О нас<font></a>
        </div>
        <div class=''>
            <a href='kontakt.php' class='a2'><font color='black'>Контакты<font></a>
        </div>
        <?
        if ($_SESSION['login']!=''){
        ?>
        <div class=''>
            <a href='LK.php' class='a2'><font color='black'>Личный кабинет<font></a>
        </div>
        <div class=''>
            <a href='korzina.php' class='a2'><font color='black'>Корзина<font></a>
        </div>
        <?
        }
        ?>
        
</nav> 