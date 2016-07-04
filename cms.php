<?php 
	include "database.inc";
	include"sqlin.php";
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
<head><meta http-equiv="Content-Type"content="text/html; charset=utf8"/>
	<title>cms</title></head>
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
			if(isset($_GET["user"])){
				$del='DELETE FROM `idform` WHERE `count`='.$_GET["user"].";";
				mysql_query($del);
				header('Location: cms.php');
			}
			if(isset($_POST["submit"])){
				if($_POST["submit"]=="修改登記"){	
					while ($ID =mysql_fetch_array($result)){
						if(isset($_POST["$ID[9]"])){
							if($_POST["$ID[9]"]=="Y"){
								$update="UPDATE  `lottery`.`idform` SET  `ADM_check` =  'Y' WHERE  `idform`.`count` =".$ID[9].";";
							}else{
								$update="UPDATE  `lottery`.`idform` SET  `ADM_check` =  'N' WHERE  `idform`.`count` =".$ID[9].";";
							}
							mysql_query($update);
						}
					}
					header('Location: cms.php');
				}
				if($_POST["submit"]=="自動兌獎"){
					header('Location: result.php');
				}
			}
			if(isset($_POST["textareaset"])){
				if(isset($_POST["txtArealeft"])){
					$textArealeft=nl2br($_POST["txtArealeft"]);
					$textupdate="UPDATE  `lottery`.`textarea` SET  `textarea` =  '".$textArealeft."' WHERE  `textarea`.`area` =  'textleft';";
					mysql_query($textupdate);
				}
				if(isset($_POST["txtArearight"])){
					$textArearight=nl2br($_POST["txtArearight"]);
					$textupdate="UPDATE  `lottery`.`textarea` SET  `textarea` =  '".$textArearight."' WHERE  `textarea`.`area` =  'textright';";
					mysql_query($textupdate);
				}
				header('Location: cms.php');
			}
			echo'
			<form action="cms.php" method="post">
			<h1>公會樂透登記系統(後台)</h1>
			<h2 class="left">​<textarea name="txtArealeft" rows="10" cols="30">';
			echo $rowleft[0];
			echo'</textarea>
			<input  class="button" name="textareaset" type="submit" value="輸入">
			</h2>
			<h2 class="right"><textarea name="txtArearight" rows="10" cols="30">';
			echo $rowright[0];
			echo'</textarea>
			<input  class="button" name="textareaset" type="submit" value="輸入">
			</h2>
			<table>
			<tr><th>GameID</th> <th>Real NameId</th> <th>第一號碼</th> <th>第二號碼</th> <th>第三號碼</th> 
			<th>第四號碼</th> <th>第五號碼</th> 
			<th>第六號碼</th> 
			<th>是否完成登記</th></tr>';
			while ($row =mysql_fetch_array($result))
				{
					echo"<tr>";
					for($i=0;$i<=8;$i++){
						echo "<td>";
						if($i==8){
							echo"
							Y<input type=\"radio\"";if($row[8]=="Y")echo"checked";echo" name=\"$row[9]\" value=\"Y\">
							N<input type=\"radio\"";if($row[8]=="N")echo"checked";echo" name=\"$row[9]\" value=\"N\">
							";
						}else{
							echo $row[$i] ;
						}
						echo "</td>";
					}
					echo "<td>"."<a  class=\"button\"href=\"cms.php?user=$row[9]\">刪除</a>"."</td>";
					echo"<tr>";
				}
			echo "</table>";
			echo'
			<table class="table">
			<tr> <td>
			<input  class="button" name="submit" type="submit" value="修改登記">
			</td>
			<td>
			<input  class="button" name="submit" type="submit" value="自動兌獎"></td></tr>
			</table>
			</form>';
		}else{
			echo "Wrong ID or PW.";
			setcookie("ID","",time()-0);
			setcookie("PW","",time()-0);
		}
	}
?>

