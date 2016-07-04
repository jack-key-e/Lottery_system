<?php 
	include "database.inc";
	mysql_select_db("lottery");
	$sql_query="SELECT * FROM `idform` ";
	$result= mysql_query($sql_query);
?>
<head><meta http-equiv="Content-Type"content="text/html; charset=utf8"/>
	<title>自動開獎</title></head>
<link rel=stylesheet type="text/css" href="./css.css">
<?php
	if(!isset($_POST["enter"])&&!isset($_COOKIE["ID"])){
		echo"<form action=\"cms.php\" method=\"post\">";
		echo "<div class=\"err\">";
		echo "login<br>";
		echo '<font size="5" color="white">ID:</font>';
		echo "<input type=\"text\" name=\"admid\" value=\"\">";
		echo '<font size="5" color="white">PW:</font>';
		echo "<input type=\"password\" name=\"admpw\" value=\"\">";
		echo "<input class=\"button\"name=\"enter\" type=\"submit\" value=\"確認\">";
		echo"</form>";
		echo "</div>";

	}else{
		if(!isset($_COOKIE["ID"])){
			setcookie("ID",$_POST["admid"],time()+60*30);
			setcookie("PW",md5($_POST["admpw"]),time()+60*30);
			$admlogin="SELECT * FROM `admform` WHERE  `ID` LIKE "."'".$_POST["admid"]."'";
			$getid= mysql_query($admlogin);
			$admform =mysql_fetch_array($getid);
			$checkpw=md5($_POST["admpw"]);
		}else{
			$admlogin="SELECT * FROM `admform` WHERE  `ID` LIKE "."'".$_COOKIE["ID"]."'";
			$getid= mysql_query($admlogin);
			$admform =mysql_fetch_array($getid);
			$checkpw=$_COOKIE["PW"];
		}if($checkpw==$admform[1]){
			echo'<h1>請選擇開獎號碼</h1>';
			$bounty = "SELECT * FROM `bountyid`";
			mysql_query($bounty);
			$end = mysql_affected_rows();
			echo '<form action="inputresult.php" method="post">';
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
			echo'<footer><input class="button"name="submit"type="submit" value="確定">
			<input class="button"type="submit" name="back" value="返回"></footer>';
		}else{
			echo "Wrong ID or PW.";
			setcookie("ID","",time()-0);
			setcookie("PW","",time()-0);
		}
	}
?>