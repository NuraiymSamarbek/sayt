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
                <img src='image/st2.png' alt='logo' class='image_logo'>
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
				//проверка нажатия кнопки
				if ($_POST['reg'] == 'Зарегистрироваться'){
					//получение значения переменных
					$login=$_POST['login'];
					$pass1=$_POST['pass1'];
					$pass2=$_POST['pass2'];
					$mail=$_POST['mail'];
					$addres=$_POST['addres'];
					$fio=$_POST['fio'];
					$phone=$_POST['phone'];
					$bd=$_POST['bd'];
					$status=$_POST['status'];
					$avatar=$_POST['avatar'];

					if ($pass1 != $pass2){
						echo "<p>Пароль не верен!</p>";
					}
					else{
						$pass=$pass1;
					
						//запрос на поиск пользователя
						$query = "SELECT * FROM `user` WHERE `login`='$login'";
						//отправка запроса
						$result = mysqli_query($conn, $query);
						//цикл с выводом данных из бд
						$num = mysqli_num_rows($result);
						if ($num>0){ 
							echo "<p>Пользователь с таким именем уже зарегистрирован<p>";
						}
						else{
							$pass=$pass1;
							//запрос на добавление пользователя
							$query = "INSERT INTO `user` (`login`, `pass`, `mail`, `addres`, `fio`, `phone`, `bd`, `status`, `avatar`) 
								VALUES('$login', '$pass', '$mail', '$addres', '$fio', '$phone', '$bd', '0', '1.png')";
							$result = mysqli_query($conn, $query);
							echo "<p>Пользователь успешно зарегистрирован</p><br>";
							echo "<p><a href='LK.php' class='a1'>Личный кабинет</a></p>";
							}
						}
					}
				else
				{
				?>
				
				<center>
					<table>
						<form action='reg.php', method='post'>
							<tr>
								<td>Логин</td>
								<td><input type='text' name='login' placeholder='Введите логин' class='a2'></td>
							</tr>
							<tr>
								<td>
									E-mail
								</td>
								<td>
									<input type='mail' name='mail' placeholder='Почта' class='a2'>
								</td>
							</tr>
							<tr>
								<td>Введите пароль</td>
								<td><input type='password' name='pass1' placeholder='Пароль' class='a2'></td>
							</tr>
							<tr>
								<td>
									Повторить пароль
								</td>
								<td>
									<input type='password' name='pass2' placeholder='Повторить пароль' class='a2'>
								</td>
							</tr>
							<tr>
								<td>
									ФИО
								</td>
								<td>
									<input type='text' name='fio' placeholder='ФИО' class='a2'>
								</td>
							</tr>
							<tr>
								<td>
									Адрес
								</td>
								<td>
									<input type='text' name='addres' placeholder='Адрес' class='a2'>
								</td>
							</tr>
								<td>
									Телефон
								</td>
								<td>
									<input type='number' name='phone' placeholder='Телефон' class='a2'>
								</td>
							</tr>
							<tr>
								<td>
									Дата рождения
								</td>
								<td>
									<input type='date' name='bd' class='a2'>
								</td>
							</tr>
							<tr>
								<td colspan='2'>
									<input type='submit' name='reg' value='Зарегистрироваться'>
								</td>
							</tr>	
							<tr>
								<td colspan='2'>
									<input type='checkbox' name='polz' ><label>Пользовательское соглашение</label>
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