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
				if ($_SESSION['login']!=''){
				?>
				
				
				<h2>Личный кабинет</h2>
				<?
				$login=$_SESSION['login'];

				if ($_POST['img']=='Сохранить'){
					//принимаем переменные
					$avatar=$_POST['avatar'];
					//запрос на редактирование аватар
					$query="UPDATE `user` SET `img`='$avatar' WHERE `login`='$login'";
					$result= mysqli_query($conn, $query);
				}
				if ($_POST['save'] == 'Сохранить'){
					$login=$_POST['login'];
					$pass=$_POST['pass'];
					$mail=$_POST['mail'];
					$addres=$_POST['addres'];
					$fio=$_POST['fio'];
					$phone=$_POST['phone'];
					$bd=$_POST['bd'];
					$query="UPDATE `user` SET `login`='$login', `pass`='$pass', `mail`='$mail', `fio`='$fio', `addres`='$addres', `phone`='$phone', `bd`='$bd' WHERE `login`='$login'";
					$result=mysqli_query($conn, $query);
				
				}
				$query="SELECT * FROM `user` WHERE `login`='$login'";
				$result=mysqli_query($conn, $query);
				$row=mysqli_fetch_array($result);
				?>
					<img src='image/<? echo $row[9];?>' alt='avatar' class='avatar'>
					<form action='LK.php' method='post'>
						<input type='file' name='avatar'>
						<input type='submit' name='img' value='Сохранить'>
					</form>
					<div>
					<form action='LK.php' method='post'>
						<table>
							<tr>
								<td>
									<label>Логин</label>
								</td>
							</tr>
							<tr>
								<td>
									<input type='text' class='a3' name='login' value= '<? echo $row[1];?>'>
								</td>
							</tr>
							<tr>
								<td>
									<label>Почта</label>
								</td>
							</tr>
							<tr>
								<td>
									<input type='mail' class='a3' name='mail' value= '<? echo $row[3];?>'>
								</td>
							</tr>
							<tr>
								<td>
									<label>Пароль</label>
								</td>
							</tr>
							<tr>
								<td>
									<input type='password' class='a3' name='pass' value= '<? echo $row[2];?>'>
								</td>
							</tr>
							<tr>
								<td>
									<label>ФИО</label>
								</td>
							</tr>
							<tr>
								<td>
									<input type='text' class='a3' name='fio' value= '<? echo $row[5];?>'>
								</td>
							</tr>
							<tr>
								<td>
									<label>Адрес доставки</label>
								</td>
							</tr>
							<tr>
								<td>
									<input type='text' class='a3' name='addres' value= '<? echo $row[4];?>'>
								</td>
							</tr>
							<tr>
								<td>
									<label>Телефон</label>
								</td>
							</tr>
							<tr>
								<td>
									<input type='number' class='a3' name='phone' value= '<? echo $row[6];?>'>
								</td>
							</tr>
							<tr>
								<td>
									<label>Дата рождения</label>
								</td>
							</tr>
							<tr>
								<td>
									<input type='text' class='a3' name='bd' value= '<? echo $row[7];?>'>
								</td>
							</tr>
							<tr>
								<td>
									<input type='submit' name='save' value='Сохранить'>
								</td>
							</tr>
							
						</table>
					</form>
					</div>
					
				<p>История заказов<p>
				<table>
					<tr>
						<td>
						</td>

						<td>
							Изображение
						</td>
						<td>
							Наименование
						</td>
						<td>
							Описание
						</td>
						<td>
							Количество
						</td>
						<td>
							Цена за ед.
						</td>
						<td>
							Итоговая цена
						</td>
						<td>
							Дата
						</td>
						
					</tr>
					<?
					//проверка на "Оформить заказ"
					if ($_POST['zakaz']=='Оформить заказ'){
					
						$login=$_SESSION['login'];
						//проверка наличие и количество товаров в корзине
						$query1 = "SELECT * FROM `korzina` WHERE `login`='$login'";
						//отправка запроса в бд
						$result1=mysqli_query($conn,$query1);
						while($row=mysqli_fetch_array($result1)){
							$id_tov=$row[1];
							$name=$row[2];
							$img=$row[3];
							$price=$row[4];
							$kolvo=$row[5];
							$about1=$row[6];
							$date=date("y-m-d");
						}
							//запрос на формирование заказа
							$query="INSERT INTO `zakaz`(`id_tov`, `name`, `img`, `price`, `kolvo`, `about1`, `date`, `login`, `status`)
								VALUES ('$id_tov', '$name', '$img', '$price', '$kolvo', '$about1', '$date', '$login', 'Новый')";

							$result=mysqli_query($conn,$query);
						}	
						$query2="DELETE FROM `korzina` WHERE `login`='$login'";
						$result2=mysqli_query($conn,$query2);
					}
					if ($_SESSION['login']!=''){
						$login=$_SESSION['login'];
						$i=1;
						$query2="SELECT * FROM `zakaz`";
						//отправка запроса
						$result2=mysqli_query($conn,$query2);
						//цикл с выводом данных из БД
						while($row2=mysqli_fetch_array($result2)){
						?>
							<tr>

								<td><? echo $i++; ?></td>
								<td><img src='image/<? echo $row2[3]; ?>' alt='tovar' class='tovar_mini'></td>
								<td>
									<? echo $row2[2]; ?>
								</td>
								<td>
									<? echo $row2[4]; ?>
								</td>
								<td>
									<? echo $row2[5]; ?>
								</td>
								<td>
									<? echo $row2[4]; ?>
								</td>
								<td>
									<? echo $row2[5]*$row2[4];?>
								</td>
								<td>
									<? echo $row2[7]; ?>
								</td>
							</tr>
					<?
					}
				}

					?>
				</table>
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