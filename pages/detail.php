<?php
$id = $_GET['id'];
//var_dump($id);
$dsn = "mysql:host=localhost;dbname=restaurantdb;charset=utf8";
$user = "restaurantdb_admin";
$password = "admin123";
$pdo = new PDO($dsn,$user,$password);
$querys = "SELECT * FROM restaurants WHERE id = $id";
$querys1 = "SELECT * FROM reviews WHERE restaurant_id = $id";
$querys2 = "SELECT * FROM reviews";
$res = $pdo->prepare($querys);
$res1 = $pdo->prepare($querys1);
$res2 = $pdo->prepare($querys2);
$res->execute();
$res1->execute();
$res2->execute();
$datase = [];
$da = [];
$da1 = [];
$datase = $res->fetchAll(PDO::FETCH_ASSOC);
$da = $res1->fetchAll(PDO::FETCH_ASSOC);
$da1 = $res2->fetchAll(PDO::FETCH_ASSOC);

//var_dump($da);
$cou = count($da1);
$cou++;
$reviewer = $_POST["name"];
$commnets = $_POST["comments"];
$point = $_POST["point"];
$time = date("Y-m-d H:i:s");
if($revicount != $revicount or $reviewer == "" or $commnets == ""){

}else{
	$sql = "INSERT INTO reviews (id, restaurant_id, reviewer, comment, point, posted_at) VALUES ($cou,$id,'$reviewer','$commnets',$point,'$time')";
}
$pstmt = $pdo->prepare($sql);
$pstmt->execute();
unset($res);
unset($res1);
unset($res2);
unset($pstmt);
unset($pdo);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8" />
	<title>レストランレビュサイト - 小テスト</title>
	<link rel="stylesheet" href="../assets/css/style.css" />
	<link rel="stylesheet" href="../assets/css/detail.css" />
</head>
<body id="detail">
	<div class="p-wrapper">
	<header>
		<h1><a href="list.php">レストラン レビュ サイト</a></h1>
	</header>
	<main>
		<article class="detail">
			<h2>レストラン詳細</h2>
			<section>
			<?php foreach ($datase as $date){?>
				<table class="list">
					<tr>
						<td class="photo"><img name="image" src="../pages/img/<?php echo $date['image']; ?>" /></td>
						<td class="info">
							<dl>
								<dt name="name"><?php echo $date['name']; ?></dt>
								<dd name="description">
								<?php echo $date['description']; ?>
								</dd>
							</dl>
						</td>
					</tr>
				</table>
			<?php } ?>
			</section>
		</article>
		<article class="reviews">
			<h2>レビュ一覧</h2>
			<section>
				<?php foreach($da as $das){?>
				<dl class="review">
					<dt name="point"><?php $p = $das['point']; for($i = 0;$i < $p;$i++){echo "★";}for($j = 0;$j < 5-$p;$j++){echo "☆";}?></dt>
					<dd name="description">
							<?php echo $das['comment'];?>
							<div name="posted">
								（<span name="posted_at"><?php echo $das['posted_at'];?></span><span name="reviewer"><?php echo $das['reviewer'];?></span>さん）
							</div>
					</dd>
				</dl>
				<?php } ?>
			</section>
		</article>
		<article class="entry">
			<h2>レビュを書き込む</h2>
			<section>
				<form action="detail.php?id=<?php echo $id; ?>" method="post">
					<table class="entry">
						<tr>
							<th>お名前</th>
							<td>
								<input type="text" name="name" />
							</td>
						</tr>
						<tr>
							<th>ポイント</th>
							<td>
								<input type="radio" name="point" value="1">1
								<input type="radio" name="point" value="2">2
								<input type="radio" name="point" value="3" checked>3
								<input type="radio" name="point" value="4">4
								<input type="radio" name="point" value="5">5
							</td>
						</tr>
						<tr>
							<th>レビュ</th>
							<td>
								<textarea name="comments"></textarea>
							</td>
						</tr>
					</table>
					<div class="buttons">
						<input type="submit" value="投稿" />
						<input type="reset" value="クリア" />
					</div>
				</form>
			</section>
		</article>
	</main>
	<footer>
		<div class="copyright">&copy; 2020 the applied course of web system development</div>
	</footer>
	</div>
</body>
</html>