<?php 
	include"sqlin.php";
	if(!isset($_COOKIE["ck"])){
		if(!isset($_POST["check"])){
			header('Location: index.php');
		}
	}
	include "database.inc";
	mysql_select_db("lottery");
	setcookie("ck","on",time()+120);
?>
<html>
<head><meta http-equiv="Content-Type"content="text/html; charset=utf8"/>
<title>公會樂透登記系統</title></head>
<link rel=stylesheet type="text/css" href="./css.css">

<body>
<h1>人選名單18選6</h1>
<form action="input.php" method="post">
<?php
	$bounty = "SELECT * FROM `bountyid`";
	mysql_query($bounty);
	$end = mysql_affected_rows();
	for ($i=1;$i<=$end;$i++){
		$bounty_id = "SELECT * FROM `bountyid`WHERE `bounty_id` =$i";
		$getbounty_id=mysql_query($bounty_id);
		$row = mysql_fetch_array($getbounty_id, MYSQL_NUM);
		echo"<div class=\"ppl\">";
		echo "<img src='".$row[2]."'";
		echo "width=\"280\" height=\"180\">";
		echo"$row[0].$row[1]";
		echo"<input type=\"checkbox\" name=\"$row[0]\" value=\"$row[0]\">";
		echo "</div>";
	}
?>
<footer>
ID:
<input type="text" name="id" value="">
REAL ID:
<input type="text" name="realid" value="">
<input class="button"type="submit" value="投注">
<input class="button"type="submit" name="back" value="返回">
</footer>
</form>
</body>

</html>

