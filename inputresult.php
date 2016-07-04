<?php 
	include "database.inc";
	mysql_select_db("lottery");
	$bounty = "SELECT * FROM `bountyid`";
	mysql_query($bounty);
	$end = mysql_affected_rows();
	$sql_query="SELECT * FROM `idform` ";
	$result= mysql_query($sql_query);
	if(!isset($_POST["submit"])){
		header('Location: cms.php');
	}
	if(isset($_POST["submit"])){
		if($_POST["submit"]=="確認"){
			$winer="SELECT * FROM `idform` WHERE `lottery_num1`=".$_COOKIE["num1"]."&&`lottery_num2`=".$_COOKIE["num2"].
			"&&`lottery_num3`=".$_COOKIE["num3"]."&&`lottery_num4`=".$_COOKIE["num4"]."&&`lottery_num5`=".$_COOKIE["num5"].
			"&&`lottery_num6`=".$_COOKIE["num6"]."&&`ADM_check`='Y';";
			$winer_result=mysql_query($winer);
		}
		if($_POST["submit"]=="下一期開始"){
			$del="truncate table `idform`";;
			mysql_query($del);
			header('Location: cms.php');
		}
	}
?>
<head><meta http-equiv="Content-Type"content="text/html; charset=utf8"/>
	<title> </title></head>
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
		}
		if($checkpw==$admform[1]){
			$check=0;
			for($i=1;$i<$end;$i++){
				$bounty_id = "SELECT * FROM `bountyid`WHERE `bounty_id` =$i";
				$getbounty_id=mysql_query($bounty_id);
				$row = mysql_fetch_array($getbounty_id, MYSQL_NUM);
				if(isset($_POST[$row[0]])){
					$check++;
				}
			}
			if($check==6){
				echo"<h1>確認選單</h1>";
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
			echo"<input type=\"submit\"class=\"button\" name=\"submit\" value=\"確認\">";
			echo"<input class=\"button\"type=\"submit\"  value=\"返回\">";
			echo"</form>";
			echo"</footer>";
			}else{
				if(isset($winer_result)){
					echo"<h1>中獎名單 </h1>";
					echo "<table>";
					echo "<tr><th>GameID</th> <th>Real NameId</th> <th>第一號碼</th> <th>第二號碼</th> 
					<th>第三號碼</th> <th>第四號碼</th> <th>第五號碼</th> <th>第六號碼</th> <th>是否完成登記</th></tr>";
					if(mysql_fetch_array($winer_result)==false){
						echo"<h1>無人中獎</h1>";
					}
					while ($row =mysql_fetch_array($winer_result)){
						echo"<tr>";
						for($i=0;$i<=8;$i++){
							echo "<td>".$row[$i]."</td>";
						}
						echo"</tr></table>";
					}
					echo"<footer>";
					echo"*當按下下一期開始後所有投票資料都會刪掉請確定後再刪";
					echo"<form action=\"\" method=\"post\">";
					echo"<input type=\"submit\"class=\"button\" name=\"submit\" value=\"下一期開始\">";
					echo"<input class=\"button\"type=\"submit\"  value=\"返回\">";
					echo"</form>";
					echo"</footer>";
				}else{
					echo"<div class=\"err\">";
					echo"請確認選滿六個";
					echo"<form action=\"result.php\">";
					echo"<input class=\"button\"type=\"submit\" value=\"返回\">";
					echo"</form>";
					echo "</div>";
				}
			}

		}else{
			echo $winer."xxx";
			echo "Wrong ID or PW or times out.";
			setcookie("ID","",time()-0);
			setcookie("PW","",time()-0);
		}
	}
?>