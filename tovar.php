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
		<style>
		p.dline{
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
		include 'nav.php';
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
				//получение переменных
				$id_tov=$_POST['id_tov'];
				$query1="SELECT * FROM `tovar` WHERE `id`='$id_tov'";
				//отправка запроса
				$result=mysqli_query($conn,$query1);
				//цикл с выводом данных из БД
				$row=mysqli_fetch_array($result);
				?>
				<div class='tovar'>
					<div class='tovar_img'>
						<img src='image/<? echo $row[4];?>'width='320' height='280' alt='tovar' class='scale'>
					</div>
					<div class='tovar_about'>
						<h1><font size='4'><? echo $row[1]; ?><font><h1>
						<p><font size='5'><? echo $row[3];?> <font face='Arial'>₽</font><font><p>
						<p><font size='2'>В наличии: <? echo $row[7];?><font><p>
						<p><font size='2'>Свежесть: <? echo $row[6];?>%<font><p>
						<form action='korzina.php' method='post'>
							<input type='hidden', name='id_tov' value='<? echo $row[0]; ?>'>
							<input type='submit', name='korzina' value='В корзину'>
						</form>
					</div>
				</div>
				<div class='tovar_all2'>
					<h2>О товаре</h2>
					<p><font size='3'><? echo $row[5];?><font><p>
				</div>
				<div class='tovar_all'>
					<h1>Описание<h1>
					<p align='left'><font size='2'><? echo $row[8];?><font></p>
				</div>
				
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