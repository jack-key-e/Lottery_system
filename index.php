<?php 
	include "database.inc";
	mysql_select_db("lottery");
	$sql_query="SELECT * FROM `idform` ";
	$result= mysql_query($sql_query);
	$textleft="SELECT * FROM `textarea` WHERE `area`='textleft'";
	$textleft=mysql_query($textleft);
	$rowleft = mysql_fetch_array($textleft, MYSQL_NUM);
	$textright="SELECT * FROM `textarea` WHERE `area`='textright'";
	$textright=mysql_query($textright);
	$rowright = mysql_fetch_array($textright, MYSQL_NUM);
?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type"content="text/html; charset=utf8"/>
	<title>公會樂透登記系統</title></head>
<link rel=stylesheet type="text/css" href="./css.css">
<body>
	<h1>公會樂透登記系統</h1>
	<h2 class="left"><?php
		echo $rowleft[0];
	?></h2>
	<h2 class="right"><?php
		echo $rowright[0];
	?></h2>
		<table>
		<tr><th>GameID</th> <th>Real NameId</th> <th>第一號碼</th> <th>第二號碼</th> <th>第三號碼</th> 
			<th>第四號碼</th> <th>第五號碼</th> <th>第六號碼</th> <th>是否完成登記</th></tr>
		
	<?php
		while ($row =mysql_fetch_array($result))
		{
			echo"<tr>";
			for($i=0;$i<=8;$i++){
				echo "<td>".$row[$i]."</td>";
			}
			echo"<tr>";
		}
	?>
</table>
<form action="bet.php" method="post">
<table class="table">
<tr> <td><input name="check" class="button"type="submit" value="投注"></td></tr>
</table>
</form>
</body>
</html>
