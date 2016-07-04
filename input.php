<?php 
	include"sqlin.php";
	include "database.inc";
	mysql_select_db("lottery");
	$bounty = "SELECT * FROM `bountyid`";
	mysql_query($bounty);
	$end = mysql_affected_rows();
	if(isset($_POST["back"])){
		if($_POST["back"]=="返回"){
				header('Location: index.php');
			}
	}
	if(isset($_POST["submit"])){
		if($_POST["submit"]=="返回"){
				header('Location: index.php');
			}
	}
	if(isset($_POST["submit"])&&isset($_COOKIE["id"])){
		if($_POST["submit"]=="確認投注"){
			$sql = "INSERT INTO `lottery`.`idform` (`id`, `real_id`, `lottery_num1`, `lottery_num2`, `lottery_num3`, `lottery_num4`, `lottery_num5`, `lottery_num6`, `ADM_check`, `count`) 
			VALUES ('".$_COOKIE["id"]."', '".$_COOKIE["realid"]."', '".$_COOKIE["num1"]."', '".$_COOKIE["num2"]."', '".$_COOKIE["num3"]."', '".$_COOKIE["num4"]."', '".$_COOKIE["num5"]."', '".$_COOKIE["num6"]."', 'N', NULL);";
			mysql_query($sql);
			header('Location: index.php');
			}
	}
?>
<html>
<head><meta http-equiv="Content-Type"content="text/html; charset=utf8"/>
<title>確認系統</title></head>
<link rel=stylesheet type="text/css" href="./css.css">
<body>
<h1>確認選單</h1>
<?php
	$check=0;
	for($i=1;$i<$end;$i++){
		$bounty_id = "SELECT * FROM `bountyid`WHERE `bounty_id` =$i";
		$getbounty_id=mysql_query($bounty_id);
		$row = mysql_fetch_array($getbounty_id, MYSQL_NUM);
		if(isset($_POST[$row[0]])){
			$check++;
		}
	}
	if($check==6&&$_POST["id"]!=""&&$_POST["realid"]!=""){
		for($j=1,$i=1;$i<$end;$i++){
			$bounty_id = "SELECT * FROM `bountyid`WHERE `bounty_id` =$i";
			$getbounty_id=mysql_query($bounty_id);
			$row = mysql_fetch_array($getbounty_id, MYSQL_NUM);
			if(isset($_POST[$row[0]])){
				setcookie("num$j","$row[0]",time()+600);
				$j++;
				echo"<div class=\"ppl\">";
				echo "<img src='".$row[2]."'";
				echo "width=\"280\" height=\"180\">";
				echo"$row[0].$row[1]";
				echo "</div>";
			}
		}
	echo"<footer>";
	echo"<form action=\"\" method=\"post\">";
	setcookie("id","$_POST[id]",time()+600);
	setcookie("realid","$_POST[realid]",time()+600);
	echo"ID:$_POST[id]"."&nbsp;REAL ID:$_POST[realid]&nbsp;";
	echo"<input type=\"submit\"class=\"button\" name=\"submit\" value=\"確認投注\">";
	echo"<input class=\"button\"type=\"submit\" name=\"submit\" value=\"返回\">";
	echo"</form>";
	echo"</footer>";
	}else{
		echo"<div class=\"err\">";
		echo"請確認ID和REALID是否填寫或選滿六個";
		echo"<form action=\"bet.php\">";
		echo"<input class=\"button\"type=\"submit\" value=\"返回\">";
		echo"</form>";
		echo "</div>";
	}
?>
</body>
</html>