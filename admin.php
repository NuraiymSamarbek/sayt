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
		<?
		include 'nav.php';
		?>
		<!-- Menu -->

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
				<h3>Добавить<h3>
				<form action='admin.php' method='post'>
					<input type='submit' name='kat_add' value='Добавить категорию'>
				</form>
				<form action='admin.php' method='post'>
					<input type='submit' name='tov_add' value='Добавить товар'>
				</form>
            </section>
			<section class='center'>
				<?
				if ($_SESSION['status']=='1'){	
				?>
				<h2>Админ-панель</h2>
					<table>
				<?
				//проверка нажатия кнопки
				if ($_POST['kat_add']=='Добавить категорию'){
					?>
					<form action='admin.php' method='post'>
						<input type='text' name='name' placeholder='Название категории' class='a5'>
						<input type='submit' name='kat_add2' value='Добавить категорию'>
					</form>
					<?
				}
				//проверка нажатия кнопки
				if ($_POST['kat_add2']=='Добавить категорию'){
					//получение переменных
					$name=$_POST['name'];
					//запрос на добавление категории
					$query="INSERT INTO `kategory` (`name`) VALUES ('$name')";
					$result=mysqli_query($conn, $query);
					echo "<h3>Категория добавлена</h3><br>";
					echo "<h3><a href='admin.php' class='a3'>Обновить странциу</a></h3>";
				}
					?>
					
				<?
				//проверка нажатия кнопки
				if ($_POST['tov_add']=='Добавить товар'){
					?>
					<form action='admin.php' method='post'>
							<input type='text' name='name' placeholder='Наименование товара' class='a5'><br><br>
							<select name='kat' class='a5'>
							<?								//запрос на отображение категорий
							$query="SELECT * FROM `kategory`";
							//отправка запроса
							$result=mysqli_query($conn, $query);
							//цикл с выводом данных из БД
							while($row=mysqli_fetch_array($result)){
							?>
								<option value='<? echo $row[1]; ?>'><? echo $row[1]; ?></option>
							<?
							}
						
							?>
							</select><br><br>
								<input type='number' name='price' placeholder='Цена' class='a5'><br><br>
								<input type='file' name='image'><br><br>
								<input type='text' name='about' placeholder='Краткое описание' class='a5'><br><br>
								<input type='number' name='fresh' placeholder='Свежесть' class='a5'><br><br>
								<input type='number' name='nal' placeholder='В наличии' class='a5'><br><br>
								<input type='text' name='all' placeholder='Полное описание' class='a5'><br><br>
								<input type='submit' name='tov_add2' value='Добавить товар' class='a5'>
						
					</form>
					<?
				}
				//проверка нажатия кнопки
				if ($_POST['tov_add2']=='Добавить товар'){
					//получение переменных
					$name=$_POST['name']; 
					$kategory=$_POST['kat'];
					$price=$_POST['price'];
					$image=$_POST['image'];
					$about=$_POST['about'];
					$fresh=$_POST['fresh'];
					$nal=$_POST['nal'];
					$all=$_POST['all'];
					//запрос на добавление товара
					$query="INSERT INTO `tovar`(`name`, `kategory`, `price`, `image`, `about`, `fresh`, `nal`, `all`)
					VALUES ('$name', '$kategory', '$price', '$image', '$about', '$fresh', '$nal', '$all')";
					$result=mysqli_query($conn, $query);
					echo "<h3>Товар добавлен</h3><br>";
					echo "<p><a href='admin.php' class='a3'>Обновить странциу</a></p>";
				
				}
					?>
					</table>
				<?
				if($_POST['kat_del']=='Удалить'){
					$id=$_POST['id'];
					?>
					<h3>Вы уверены, что хотите удалить категорию?</h3>
					<form action='admin.php' method='post'>
						<input type='hidden' name='id' value='<? echo $id;?>' class='a5'>
						<input type='submit' name='kat_del2' class='a3' value='Удалить категорию'>
					</form>
					<form action='admin.php' method='post'>
						<input type='submit' value='Нет'>
					</form>
					<?
				}
				//проверка нажатия кнопки
				if ($_POST['kat_del2']=='Удалить категорию'){
					//получение переменных
					$id=$_POST['id'];
					//запрос на добавление категории
					$query="DELETE FROM `kategory` WHERE `id`='$id'";
					$result=mysqli_query($conn, $query);
					echo "<h3>Категория удалена</h3><br>";
					echo "<h3><a href='admin.php' class='a3'>Обновить странциу</a></h3>";
				}
				
				if($_POST['kat_red']=='Изменить'){
					$id=$_POST['id'];
					//запрос на отображение категорий
					$query="SELECT * FROM `kategory` WHERE `id`='$id'";
					//отправка запроса
					$result=mysqli_query($conn,$query);
					//цикл с выводом данных из БД
					while($row=mysqli_fetch_array($result)){
					?>
					<form action='admin.php' method='post'>
						<input type='hidden' name='id' value='<? echo $row[0]; ?>' class='a5'>
						<input type='text' name='name' value='<? echo $row[1]; ?>'>
						<input type='submit' name='kat_red2' value='Изменить категорию'>
					</form>
					<?
					}
				}
				
				if($_POST['kat_red2']=='Изменить категорию'){
					$id=$_POST['id'];
					$name=$_POST['name'];
					$query="UPDATE `kategory` SET `name`='$name' WHERE `id`='$id'";
					$result=mysqli_query($conn, $query);
					echo "<p>Категория изменена</p><br>";
					echo "<p><a href='admin.php' class='a3'>Обновить странциу</a></p>";
				
				}
				?>
				
				<?
				if($_POST['user_red']=='Изменить'){
					//получение переменных
					$id=$_POST['id'];
					//запрос на отображение категории
					$query="SELECT * FROM `user` WHERE `id`='$id'";
					//отправка зпроса
					$result=mysqli_query($conn, $query);
					//цикл с выводом данных из бд
					$row=mysqli_fetch_array($result);
					?>
					<form action="admin.php" method="post">
						<h3>Изменение пользователя</h3>
						<br>
						<form action="admin.php" method="post">
							<table border=1>
								<tr>
									<input type="hidden" name="id" value="<? echo $row[0]; ?>">
								</tr>
								<tr>
									<input type="file" name="img">
									<input type="hidden" name="id" value="<? echo $row[9]; ?>">
								</tr>
								<tr>
									<td>Логин</td>
									<td><input type="text" name="login" value="<? echo $row[1]?>" class='a5'></td>
								</tr>

								<tr>
									<td>Почта</td>
									<td><input type="text" name="mail" value="<? echo $row[3]?>" class='a5'></td>
								</tr>
								<tr>
									<td>Пароль</td>
									<td><input type="text" name="pass" value="<? echo $row[2]?>" class='a5'></td>
								</tr>
								<tr>
									<td>ФИО</td>
									<td><input type="text" name="fio" value="<? echo $row[5]?>" class='a5'></td>
								</tr>
								<tr>
									<td>Адрес</td>
									<td><input type="text" name="addres" value="<? echo $row[4]?>" class='a5'></td>
								</tr>
								<tr>
									<td>Телефон</td>
									<td><input type="number" name="phone" value="<? echo $row[6]?>" class='a5'></td>
								</tr>
								<tr>
									<td>Дата рождения</td>
									<td><input type="date" name="bd" value="<? echo $row[7]?>" class='a5'></td>
								</tr>
								<tr>
									<td>Статус</td>
									<td><input type="number" name="status" value="<? echo $row[8]?>" class='a5'></td>
								</tr>
								<tr>
									<input type="submit" name="user_red2" value="Изменить пользователя"></td>
								</tr>
							</table>
						</form>
					<?
					}	
					if($_POST['user_red2']=='Изменить пользователя'){
					//получение переменных
						$id=$_POST['id'];
						$img=$_POST['img'];
						$login=$_POST['login'];
						$mail=$_POST['mail'];
						$pass=$_POST['pass'];
						$fio=$_POST['fio'];
						$addres=$_POST['addres'];
						$phone=$_POST['phone'];
						$hb=$_POST['bd'];
						$status=$_POST['status'];
						//запрос на изменение товара
						$query="UPDATE `user` SET `img`='$img', `login`='$login', `mail`='$mail', `pass`='$pass', `fio`='$fio',`adres`='$adres',`tel`='$tel',`hb`='$hb',`status`='$status' WHERE `id`=$id'";
						//отправка зпроса
						$result=mysqli_query($conn, $query);
						//сообщение
						echo "<p>Пользователь изменен</p>";
						echo "<p><a href='admin.php' class='a3'> Обновите страницу</a></p>";
					}

					if($_POST['tov_del']=='Удалить'){
						$id=$_POST['id'];
						?>
						<h3>Вы уверены, что хотите удалить товар?</h3>
						<form action='admin.php' method='post'>
							<input type='hidden' name='id' value='<? echo $id;?>' class='a3'>
							<input type='submit' name='tov_del2' value='Удалить товар'>
						</form>
						<form action='admin.php' method='post'>
							<input type='submit' value='Нет'>
						</form>
					<?	
					}
					
					if($_POST['zak_red']=='Изменить'){
						$id=$_POST['id'];
						?>
						<form action="admin.php" method="post">
							<input type="hidden" name='id' value='<? echo $id; ?>'>
							<p>Статус заказа</p>
							<select name='status'>
								<option value='Подтвержден'>Подтвержден</option>
								<option value='Отменен'>Отменен</option>
							</select>
							<input type='submit' name='zak_red2' value='Изменить статус'>
						</form>
						<?
					}
					if($_POST['zak_red2']=='Изменить статус'){
						$id=$_POST['id'];
						$status=$_POST['status'];
						$query="UPDATE `zakaz` SET `status`='$status' WHERE `id`='$id'";
						$result=mysqli_query($conn, $query);
						echo "<p>Статус изменен</p><br>";
						echo "<p><a href='admin.php' class='a3'>Обновить страницу</a></p>";
					}
					
					if($_POST['zak_del']=='Удалить'){
						$id=$_POST['id'];
						?>
						<p>Вы уверены, что хотите удалить категорию?</p>
						<form action='admin.php' method='post'>
							<input type='hidden' name='id' value='<? echo $id;?>' class='a5'>
							<input type='submit' name='zak_del2' class='a3' value='Удалить заказ'>
						</form>
						<form action='admin.php' method='post'>
							<input type='submit' value='Нет'>
						</form>
						<?
					}
					if($_POST['zak_del2']=='Удалить заказ'){
						$id=$_POST['id'];
						$query="DELETE FROM `zakaz` WHERE `id`='$id'";
						$result=mysqli_query($conn, $query);
						echo "<p>Заказ удален</p><br>";
						echo "<p><a href='admin.php' class='a3'> Обновит страницу</a></p>";
					}
				?>
					<?
					if($_POST['user_del']=='Удалить'){
						$id=$_POST['id'];
						?>
						<h3>Вы уверены, что хотите удалить пользователя?</h3>
						<form action='admin.php' method='post'>
							<input type='hidden' name='id' value='<? echo $id;?>' class='a3'>
							<input type='submit' name='user_del2' value='Удалить пользователя'>
						</form>
						<form action='admin.php' method='post'>
							<input type='submit' value='Нет'>
						</form>
						<?
					}
					//проверка нажатия кнопки
					if ($_POST['user_del2']=='Удалить пользователя'){
						//получение переменных
						$id=$_POST['id'];
						//запрос на удаление товара
						$query="DELETE FROM `user` WHERE `id`='$id'";
						$result=mysqli_query($conn, $query);
						echo "<h3>Пользователь удален</h3><br>";
						echo "<p><a href='admin.php' class='a3'>Обновить странциу</a></p>";
					}
					
					//проверка нажатия кнопки
					if ($_POST['tov_del2']=='Удалить товар'){
						//получение переменных
						$id=$_POST['id'];
						//запрос на удаление товара
						$query="DELETE FROM `tovar` WHERE `id`='$id'";
						$result=mysqli_query($conn, $query);
						echo "<h3>Товар удален</h3><br>";
						echo "<p><a href='admin.php' class='a3'>Обновить странциу</a></p>";
					}
					
					?>
					<?
					if($_POST['tov_red']=='Изменить'){
						$id=$_POST['id'];
						//запрос на отображение категорий
						$query="SELECT * FROM `tovar` WHERE `id`='$id'";
						//отправка запроса
						$result=mysqli_query($conn,$query);
						//цикл с выводом данных из БД
						$row=mysqli_fetch_array($result);
						?>
						<form action='admin.php' method='post'>
							<input type='hidden' name='id' value='<? echo $row[0]; ?>' class='a5'>
							<input type='file' name='image'>
							<input type='submit' name='tov_red2' value='Изменить изображение'>
						</form>
						<form action='admin.php' method='post'>
							<input type='hidden' name='id' value='<? echo $row[0]; ?>'>
							<p>Наименование товара</p>
							<input type='text' name='name' class='a5' value='<? echo $row[1]; ?>'>
							<p>Цена</p>
							<input type='number' name='price' class='a5' value='<? echo $row[3]; ?>'>
						
							<p>Краткое описание</p>
							<input type='text' name='about' class='a5' value='<? echo $row[5]; ?>'>
							<p>В наличии</p>
							<input type='number' name='stock' class='a5' value='<? echo $row[6]; ?>'>
							<p>Полное описание</p>
							<input type='text' name='all' class='a5' value='<? echo $row[7]; ?>'>
							<p>Категория</p>
							<select name='kategory' class='a5'>
							<?								//запрос на отображение категорий
							$query="SELECT * FROM `kategory`";
							//отправка запроса
							$result=mysqli_query($conn, $query);
							//цикл с выводом данных из БД
							while($row=mysqli_fetch_array($result)){
							?>
								<option value='<? echo $row[1]; ?>'><? echo $row[1]; ?></option>
							<?
							}
						
							?>
							</select>
							<input type='submit' name='tov_red3' value='Изменить данные'>
						</form>
						<?
					}
					if($_POST['tov_red2']=='Изменить изображение'){
					$id=$_POST['id'];
					$img=$_POST['image'];
					$query="UPDATE `tovar` SET `image`='$img' WHERE `id`='$id'";
					$result=mysqli_query($conn, $query);
					echo "<p>Изображение изменено</p><br>";
					echo "<p><a href='admin.php' class='a3'>Обновить странциу</a></p>";
					}
					
					if($_POST['tov_red3']=='Изменить данные'){
						$id=$_POST['id'];
						$name=$_POST['name'];
						$price=$_POST['price'];
						$stock=$_POST['stock'];
						$kategory=$_POST['kategory'];
						$about=$_POST['about'];
						$all=$_POST['all'];
						$query="UPDATE `tovar` SET `name`='$name',`kategory`='$kategory', `price`='$price', `about`='$about',`stock`='$stock',`all`='$all' WHERE `id`='$id'";
						$result=mysqli_query($conn, $query);
						echo "<p>Данные изменены</p><br>";
						echo "<p><a href='admin.php' class='a3'>Обновить странциу</a></p>";
					}
					?>
				<h3>Категории</h3>
				<table border=1>
					<tr> 
						<th>Наименование</th>
						<th></th>
						<th></th>
					</tr>
					<?
					//запрос на отображение категорий
					$query="SELECT * FROM kategory";
					//отправка запроса
					$result=mysqli_query($conn,$query);
					//цикл с выводом данных из БД
					while($row=mysqli_fetch_array($result)){
						?>
						<tr>
							<td><? echo $row[1];?></td>
							<td>
								<form action='admin.php' method='post'>
									<input type='hidden' name='id' value='<? echo $row[0]; ?>'>
									<input type='submit' name='kat_red' value='Изменить'>
								</form>
							</td>
							<td>
								<form action='admin.php' method='post'>
									<input type='hidden' name='id' value='<? echo $row[0]; ?>'>
									<input type='submit' name='kat_del' value='Удалить'>
								</form>
							</td>
						</tr>
						<?
					}
					?>
				</table>
				
				
				<h3>Товары</h3>
				<table>
					<tr>
						<th>Изображение</th>
						<th>Наименование</th>
						<th>Категория</th>
						<th>Цена</th>
						<th>Краткое описание</th>
						<th>В наличии</th>
						<th>Свежесть</th>
						<th>Полное описание</th>
						<th></th>
						<th></th>
					</tr>
					<?
					//получение переменных
					$query="SELECT * FROM `tovar`";
					//отправка запроса
					$result=mysqli_query($conn,$query);
					//цикл с выводом данных из БД
					while($row=mysqli_fetch_array($result)){
						?>
						<tr>
							<td>
							</td>
						</tr>
						<tr>
							<td>
							</td>
						</tr>
						<tr>
							<td><img src='image/<? echo $row[4];?>' class='tovar_mini'></td>
							<td><? echo $row[1];?></td>
							<td><? echo $row[2];?></td>
							<td><? echo $row[3];?></td>
							<td><? echo $row[5];?></td>
							<td><? echo $row[7];?></td>
							<td><? echo $row[6];?>%</td>
							<td><? echo $row[8];?></td>
							<td>
								<form action='admin.php' method='post'>
									<input type='hidden' name='id' value='<? echo $row[0]; ?>'>
									<input type='submit' name='tov_red' value='Изменить'>
								</form>
							</td>
							<td>
								<form action='admin.php' method='post'>
									<input type='hidden' name='id' value='<? echo $row[0]; ?>'>
									<input type='submit' name='tov_del' value='Удалить'>
								</form>
							</td>
						</tr>
						<?
					}
					?>
				</table>

				<h3>Пользователи</h3>
				<table>
					<tr>
						<th>Аватар</th>
						<th>ФИО</th>
						<th>Логин</th>
						<th>Почта</th>
						<th>Пароль</th>
						<th>Адрес</th>
						<th>Телефон</th>
						<th>Дата рождения</th>
						<th>Статус</th>		
						<th></th>
						<th></th>
					</tr>
					<?
					//получение переменных
					$query="SELECT * FROM `user`";
					//отправка запроса
					$result=mysqli_query($conn,$query);
					//цикл с выводом данных из БД
					while($row=mysqli_fetch_array($result)){
						?>
						<tr>
							<td>
							</td>
						</tr>
						<tr>
							<td>
							</td>
						</tr>
						<tr>
							<td><img src='image/<? echo $row[9];?>' class='tovar_mini'></td>
							<td><? echo $row[4];?></td>
							<td><? echo $row[1];?></td>
							<td><? echo $row[2];?></td>
							<td><? echo $row[3];?></td>
							<td><? echo $row[5];?></td>
							<td><? echo $row[6];?></td>
							<td><? echo $row[7];?></td>
							<td><? echo $row[8];?></td>
							<td>
								<form action='admin.php' method='post'>
									<input type='hidden' name='id' value='<? echo $row[0]; ?>'>
									<input type='submit' name='user_red' value='Изменить'>
								</form>
							</td>
							<td>
								<form action='admin.php' method='post'>
									<input type='hidden' name='id' value='<? echo $row[0]; ?>'>
									<input type='submit' name='user_del' value='Удалить'>
								</form>
							</td>
						</tr>
					
						<?
					}
					?>
				</table>
				<h3>Заказы</h3>
				<table>
					<tr>
						<th>№</th>
						<th>Изображение</th>
						<th>Наименование</th>
						<th>Цена</th>
						<th>Количество</th>
						<th>Краткое описание</th>
						<th>Дата</th>
						<th>Логин</th>
						<th>Статус</th>
						<th></th>
						<th></th>
					</tr>
					<?
					//получение переменных
					$query="SELECT * FROM `zakaz`";
					//отправка запроса
					$result=mysqli_query($conn,$query);
					//цикл с выводом данных из БД
					while($row=mysqli_fetch_array($result)){
						?>
						<tr>
							<td>
							</td>
						</tr>
						<tr>
							<td>
							</td>
						</tr>
						<tr>
							<td><? echo $row[1];?></td>
							<td><img src='image/<? echo $row[3];?>' class='tovar_mini'></td>
							<td><? echo $row[2];?></td>
							<td><? echo $row[4];?></td>
							<td><? echo $row[5];?></td>
							<td><? echo $row[6];?></td>
							<td><? echo $row[7];?></td>
							<td><? echo $row[8];?></td>
							<td><? echo $row[9];?></td>
							<td>
								<?
								if ($row[9]=='Новый'){
								?>
									<form action='admin.php' method='post'>
										<input type='hidden' name='id' value='<? echo $row[0]; ?>'>
										<input type='submit' name='zak_red' value='Изменить'>
									</form>
								<?
								}
								?>
							</td>
							<td>
							<?
								if ($row[9]=='Новый'){
								?>
								<form action='admin.php' method='post'>
									<input type='hidden' name='id' value='<? echo $row[0]; ?>'>
									<input type='submit' name='zak_del' value='Удалить'>
								</form>
								<?
								}
								?>
							</td>
						</tr>
						<?
					}
					?>
				</table>
				
				<?
				}
				else
				{
					echo '<p>У вас нет доступа</p><br>';
					echo "<p><a href='auto.php' class='a2'>Aвторизуйтесь еще раз</a></p>";
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