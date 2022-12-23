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
				include 'vhod.php'
				?>
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
				<form action='index.php' method='post'>
					<input type='text' class='a1' name='search_text' placeholder='Поиск'>
					<input type='submit' class='a1' name='search' value='Поиск'>
				</form>
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
				<h2>Товары</h2>
				<h3>Сортировать по
					<form action='index.php' method='post'>
						<input type='submit' name='price' value='Цене'>
						<input type='submit' name='nal' value='Наличию'>
						<input type='submit' name='fresh' value='Свежести'>
					</form>
				</h3>
				<?
				//получение переменных
				$kategory=$_POST['kategory'];
				//проверка переменной
				if ($_POST['kategory']=='Все товары')
				{
					//запрос на отображение товаров
					$query1="SELECT * FROM `tovar`";
				}
				elseif ($_POST['kategory']!='')
				{
					//запрос на отображение товаров
					$query1="SELECT * FROM `tovar` WHERE `kategory`='$kategory' ";
				}
				elseif ($_POST['price']=='Цене')
				{
					$i=$_SESSION['chethik'];
					$i++;
					$_SESSION['chethik']=$i;
					if($i%2==0)
						$query1="SELECT * FROM `tovar` ORDER BY `tovar`.`price` ASC";
					else
						$query1="SELECT * FROM `tovar` ORDER BY `tovar`.`price` DESC";
				}
				elseif ($_POST['nal']=='Наличию')
				{
					$i=$_SESSION['chethik'];
					$i++;
					$_SESSION['chethik']=$i;
					if($i%2==0)
						$query1="SELECT * FROM `tovar` ORDER BY `tovar`.`nal` ASC";
					else
						$query1="SELECT * FROM `tovar` ORDER BY `tovar`.`nal` DESC";
				}
				elseif ($_POST['fresh']=='Свежести')
				{
					$i=$_SESSION['chethik'];
					$i++;
					$_SESSION['chethik']=$i;
					if($i%2==0)
						$query1="SELECT * FROM `tovar` ORDER BY `tovar`.`fresh` ASC";
					else
						$query1="SELECT * FROM `tovar` ORDER BY `tovar`.`fresh` DESC";
				}
				elseif ($_POST['search']=='Поиск')
				{
					$search_text=$_POST['search_text'];
					$query1="SELECT * FROM `tovar` WHERE `name` LIKE '%$search_text%' ";
				}
				else
				{
					//запрос на отображение товаров
					$query1="SELECT * FROM `tovar` ";
				}
				//отправка запроса
				$result=mysqli_query($conn,$query1);
				//цикл с выводом данных из БД
				while($row=mysqli_fetch_array($result)){
				?>
				<div class='tovar'>	
					<div class='tovar_img'>
						<form action='tovar.php' method='post'>
							<input type="image" name="image" src='image/<? echo $row[4];?>'width='320' height='280' alt='tovar' class='scale'>
					</div>
					<div class='tovar_about'>
						<h1><font size='4'><? echo $row[1]; ?><font><h1>
						<p><font size='5'><? echo $row[3];?> <font face='Arial'>₽</font><font><p>
						<p><font size='2'><? echo $row[5];?><font><p>
						<p><font size='2'>В наличии: <? echo $row[7];?><font><p>
						<p><font size='2'>Cвежесть: <? echo $row[6];?>%<font><p>
						<form action='tovar.php' method='post'>
							<input type='submit', name='all' value='Подробнее'>
							<input type='hidden', name='id_tov' value='<? echo $row[0]; ?>'>
						</form>
					</div>
				</div>
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
				<p>8914-262-50-51 (с 9 до 21)<p>
			</div>
			<div class='ssilka'>
				<p>Партнер:<p><a href='https://vk.com/osyyyk' class=''><font color='black'>VKontakte<font></a>
			</div>
				<div class=''>
			
			</div>
		</footer>
		
	</body>
</html>