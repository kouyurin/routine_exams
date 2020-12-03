<?php
if(isset($_POST["area"])){
	$area = $_POST["area"];
}
//var_dump($area);//
$areas = [""=>"-- 地域を選んでください --","福岡"=>"福岡","神戸"=>"神戸","伊豆"=>"伊豆"];
$dsn = "mysql:host=localhost;dbname=restaurantdb;charset=utf8";
$user = "restaurantdb_admin";
$password = "admin123";
$pdo = new PDO($dsn,$user,$password);
if($area == ""){
	$query = "SELECT * FROM restaurants";
}else{
	$query = "SELECT * FROM restaurants WHERE area Like '$area'";
}
$res = $pdo->prepare($query);
$res->execute();
$datas = [];
$datas = $res->fetchAll(PDO::FETCH_ASSOC);
unset($res);
unset($pdo);
/*var_dump($datas);*/
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8" />
	<title>レストランレビュサイト - 小テスト</title>
	<link rel="stylesheet" href="../assets/css/style.css" />
	<link rel="stylesheet" href="../assets/css/list.css" />
</head>
<body id="list">
	<header>
		<h1>レストラン レビュ サイト</h1>
	</header>
	<main>
		<article>
			<div class="clearfix">
			<h2>レストラン一覧</h2>
			<section class="entry">
				<form action="list.php" method="post">
					<select name="area">
						<?php foreach($areas as $are=>$ar){ ?>
						<option value="<?php echo $are; ?>" <?php if($are == $area){echo "selected";}?>><?php echo $ar; ?></option>
						<?php } ?>
					</select>
					<input type="submit" value="検索" />
				</form>
			</section>
			</div>
			<section class="result">
				<p><?php echo count($datas);?>件のレストランが見つかりました。</p>
				<?php foreach ($datas as $data){?>
				<table class="list">
					<tr>
						<td class="photo"><img name="image" alt="「<?php echo $data['name']; ?>」の写真" src="../pages/img/<?php echo $data['image']; ?>"></td>
						<td class="info">
							<dl>
								<dt name="name"><?php echo $data['name']; ?></dt>
								<dd name="description"><?php echo $data['description']; ?></dd>
							</dl>
						</td>
						<td class="link"><a href="detail.php?id=<?php echo $data['id']; ?>">詳細</a></td>
					</tr>
				</table>
				<?php } ?>
			</section>
		</article>
	</main>
	<footer>
		<div class="copyright">&copy; 2020 the applied course of web system development</div>
	</footer>
</body>
</html>