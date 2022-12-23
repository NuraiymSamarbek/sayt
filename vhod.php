<br>

	<a href='auto.php' class='a1'><font color='black'>Вход<font></a>
	<a href='reg.php' class='a1'><font color='black'>Регистрация<font></a>
	<?


if ($_SESSION['login'] != ''){
?>
	<form action='index.php' method='post'>
		<input type='submit' name='vihod' value = 'Выход' class='a1'>
	</form>
<?
}
if ($_SESSION['status'] == 1){
?>
	<a href='admin.php' class='a6'><font color='black'>Админка<font></a>
<?
}
?>
