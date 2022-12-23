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
		<style>p.dline{
			line-height: 1.5;
		} 
		P{
			line-height:0.6em;
		}
		</style>
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
				<h2>Корзина</h2>
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
						
					</td>
					<td>
						
					</td>
					<td>
						Цена за ед.
					</td>
					
					<td>
						Итоговая цена
					</td>
				</tr>
				
				<?
				//получение переменных
				$id_tov=$_POST['id_tov'];
				//запрос на отображение товаров
				$query1="SELECT * FROM `tovar` WHERE `id`='$id_tov'";
				$result=mysqli_query($conn,$query1);
				$row=mysqli_fetch_array($result);
				$img=$row[4];
				$name=$row[1];
				$about1=$row[5];
				$kolvo=[1];
				$price=$row[3];
				$login=$_SESSION['login'];
			
				if ($_SESSION['login'] =='') echo "<p><a href='auto.php'>Пройдите авторизацию</a><p>";
				else{

					if ($_POST['korzina'] == 'В корзину') {
						//проверка наличие и количество товаров в корзине
						$query4 = "SELECT * FROM `korzina` WHERE `id_tov` = '$id_tov' AND `login`='$login'";
							
						//отправка запроса в бд
						$result4=mysqli_query($conn,$query4);
						//сама проверка 
						$num=mysqli_num_rows($result4);
						if ($num>0){
							//определяем кол-во в бд
							$row=mysqli_fetch_array($result4);
							//рибавляем еще
							$kolvo = $row[5] + 1;
							//меняем в бд + 1
							$query5="UPDATE `korzina` SET `kolvo`='$kolvo' WHERE `id_tov`= '$id_tov' AND `login`='$login'";
							$result5=mysqli_query($conn,$query5);
						}
						else {
							//запрос на добавление товаров
							$query2= "INSERT INTO `korzina`(`id`, `id_tov`, `img`, `name`, `about1`, `kolvo`, `price`, `login`) 
								VALUES (NULL, '$id_tov', '$img', '$name', '$about1', '1', '$price', '$login')";								
							//отправка запроса
							$result2=mysqli_query($conn,$query2);
						}
					}

						//кнопка > 
					if ($_POST['plus']=='>') {
						//получение переменных
						$id_tov=$_POST['id_tov'];
						//величение товрара на 1
						$kolvo=$_POST['kolvo']+1;
						$query="UPDATE `korzina` SET `kolvo`='$kolvo' WHERE `id_tov`= '$id_tov' AND `login`='$login'";
						
						
						//тправка запроса
						$result=mysqli_query($conn,$query);
					}
					//кнопка <
					if ($_POST['minus']=='<'){
						//получение переменных
						$id_tov=$_POST['id_tov'];
						if ($_POST['kolvo']==1){
							//если товар 1, то удаляем его
							$query="DELETE FROM `korzina` WHERE `id_tov`='$id_tov' AND `login`='$login'";
						}
						else{
							//уменьшаем товар на 1
							$kolvo=$_POST['kolvo']-1;
							$query="UPDATE `korzina` SET `kolvo`='$kolvo' WHERE `id_tov`= '$id_tov' AND `login`='$login'";
						}
						//отправка запроса
						$result=mysqli_query($conn,$query);
						}
							
						//запрос на отображение корзины
					$query3 ="SELECT * FROM `korzina` WHERE `login`='$login'";
					//счетчик
					$i=1;
					//отправка запроса
					$result3=mysqli_query($conn,$query3);
					//цикл с выводом данных из БД
					while($row2=mysqli_fetch_array($result3)){
						?>
						<tr>
							<td>
								<? echo $i++; ?>
							</td>
							<td>
								<img src='image/<? echo $row2[2]; ?>' alt='tovar' class='tovar_mini'>
							</td>
							<td>
								<? echo $row2[3]; ?>;
							</td>
							<td>
								<? echo $row2[4]; ?>
							</td>
							<td>
								<form action = 'korzina.php' method='post'>
									<input type='hidden' name='id_tov' value='<? echo $row2[1]; ?>'>
									<input type='hidden' name='kolvo' value='<? echo $row2[5]; ?>'>
									<input type = 'submit' class='a1' name = 'minus' value = '<'>
								</form>
									
							</td>
							<td>
								<? echo $row2[5]; ?>
							</td>
							<td>
								<form action = 'korzina.php' method='post'>
									<input type='hidden' name='id_tov' value='<? echo $row2[1]; ?>'>
									<input type='hidden' name='kolvo' value='<? echo $row2[5]; ?>'>
									<input type = 'submit'  class='a1' name = 'plus' value = '>'>
								</form>
							</td>
							<td>
								<? echo $row2[6]; ?>
							</td>
							<td>							
								<? echo $row2[5]*$row2[6]; $summ=$row2[5]*$row2[6]; ?>
							</td>
						</tr>
						<?	
					}
				}
				?>
					<tr>
						<td colspan=3>
							Итоговая сумма: <? echo $summ;?>
						</td>
						<td colspan=3>
							<form action ='LK.php' method='post'>
								<input type ='submit' name='zakaz' value='Оформить заказ'>
							</form>
						</td>
					</tr>
				</table>
			</section>
			<section class='right'>
				<center>
					<img src='image/zxc.png' alt='rek_time' class='rek_time'>
				</center>
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