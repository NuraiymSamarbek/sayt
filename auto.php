<?php
session_start();
if ($_POST['vihod']=='Выход'){
	$_SESSION['login']='';
	$_SESSION['pass']='';
	$_SESSION['status']='';
}
?>
<html>
        <head>
            <title>SakhaFood</title>
            <link rel="stylesheet" type="text/css" href="style.css">
        </head>
		<?php
	
		//подключение к бд
		include 'connect.php';
		?>
        <body>
        <!-- Шапка -->
        <header>
            <!-- Logo -->
            <div class='Logo'>
                <img src='image/ovosh.png' alt='logo' class='image_logo'>
            </div>
            <!-- Name -->
            <div class='name'>
                <h1><font face='franklin gothic medium'>SakhaFood<font></h1>
            </div>
            <!-- vhod -->
            <div class='vhod'>
				<?
				include 'vhod.php';
				?>
			</div>
         </header>
			<!-- Menu -->
			<nav>
			<?php
			include 'nav.php'
			?>
			</nav>

	<!--Основная Часть-->
		<main>
			<section class='left'>
				<!-- Категории товаров -->
                <?
                //запрос на отображение категорий
                $query="SELECT * FROM kategory";
                //отправка запроса
                $result=mysqli_query($conn,$query);
                //цикл с выводом данных из БД
                while($row=mysqli_fetch_array($result)){
                ?>
                <form action='index.php' method='post'>
                    <input type='submit' name='kategory' value='<? echo $row[1]; ?>'>
                </form>
                <?
                }
                ?>
				<form action='index.php' method='post'>
                    <input type='submit' name='kategory' value='Все товары'>
                </form>
			</section>
			<section class='center'>
				<?
				//Отображение нажатия кнопки
				if ($_POST['auto']=='Войти'){
					//получение значения переменных
					$login=$_POST['login'];
					$pass=$_POST['pass'];
					//запрос на поиске пользователя
						$query="SELECT * FROM `user` WHERE `login` = '$login' AND `pass` = '$pass'";
						//отправляем запрос
						$result=mysqli_query($conn, $query);
						//Проверка на пользователя в бд
						$num=mysqli_num_rows($result);
						if ($num==1){
							//Добавляем ланные в сессию
							$_SESSION['login']=$login;
							$_SESSION['pass']=$pass;
								
							//проверка статуса
							$row=mysqli_fetch_array($result); 
							
							$_SESSION['status']=$row['8'];//у всех номер отличается
							//отправка запроса
							
							//Сообщение пользователю
							echo "<p>Вы успешно вошли!</p><br>";
							echo "<p><a href='LK.php' class='a3'>Личный кабинет</a></p>";
							
							//доступ к фдмине
							if ($_SESSION['status']==1){
								echo "<p><a href='admin.php' class='a3'>Пройдите в админ панель!</a></p>";
							}
						}
							else{
								echo "<p>Данные не верны!</p>";
								echo "<p><a href='auto.php' class='a3'>Попробуйте еще раз</a></p>";
						}
				}
				else{
					
				?>
				<!--Форма авторизации-->	
				<center>
					<table>
						<form action = 'auto.php' method='post'>
							<tr>
								<td>Введите логин</td>
								<td><input type = 'text' name = 'login' class='a2' placeholder='login'></td>
							</tr>
							<tr>
								<td>Введите пароль</td>
								<td><input type = 'password' name = 'pass' class='a2' placeholder='password'></td>
							</tr>
							<tr>
								<td colspan = '2'>
								<input type = 'submit' name = 'auto' value='Войти'>
								</td>
							</tr>
						</form>
					</table>
				</center>
				<?
				}
				?>
			</section>

			<section class='right'>
				<img src='image/zxc.png' alt='rek_time' class='rek_time'>
			</section>
		</main>
		<!--Podval-->
		<footer>
			<div class='dannie'>
				<p>г. Якутск, Республика Саха (Якутия)<p>
				<p>8924-366-80-07<p>
			</div>
			<div class='ssilka'>
				<p>Партнер:<p><a href='https://vk.com/osyyyk' class=''><font color='black'>VKontakte<font></a>
			</div>
				<div class=''>
			
			</div>
		</footer>
		
	</body>
</html>