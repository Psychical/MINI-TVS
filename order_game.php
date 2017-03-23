<!DOCTYPE html>
<html>
	<head>
		<title>Privilegijų pirkimas žaidime</title>
	</head>
	<body>
		<?php
		error_reporting(E_ALL);
		include('config/db_connect.php');

		$order = substr($_GET['p'], 1);
		$lang = substr($_GET['lang'], 0, 5);

		echo "Choose country: ";
		while($row = $fl->fetch_object())
			echo "<a href='./order_game.php?p=o".$order."&lang=".$row->prefix."'>".strtoupper($row->prefix)." <img src='img/flags/".$row->prefix.".gif' border='0'></a> ";

		echo "<br/><br/>";

		if($game_order_result = $mysqli->prepare("SELECT `key`, `number`, `price`, `price_type`, `priv_time` FROM `unban_sms_config` WHERE `message_type` = ? AND `lang` = ?")):
			$game_order_result->bind_param('ss', $order, $lang); $game_order_result->execute(); $game_order_result->store_result();
			
			if($game_order_result->num_rows):
				$game_order_result->bind_result($key, $number, $price, $price_type, $priv_time); $game_order_result->fetch();
				if($game_privileg_result = $mysqli->prepare("SELECT `page_content` FROM `unban_messages_types` WHERE `type` = ? AND `lang` = ?")):
					$game_privileg_result->bind_param('ss', $order, $lang); $game_privileg_result->execute(); $game_privileg_result->store_result();
					
					if($game_privileg_result->num_rows):
						$game_privileg_result->bind_result($page_content); $game_privileg_result->fetch();
						
						echo content_text($page_content, $key, $number, $price, $price_type, $priv_time);
					else:
						echo 'Šios paslaugos laikinai neteikiamos.';
					endif;
				else:
					echo 'Šios paslaugos laikinai neteikiamos.';
				endif;
			else:
				echo 'Šios paslaugos laikinai neteikiamos.';
			endif;
		else:
			echo 'Šios paslaugos laikinai neteikiamos.';
		endif;
		?>
	</body>
</html>

<?php
function content_text($text, $key, $nr, $price, $price_type, $priv_time)
{
	$ip = $_SERVER['REMOTE_ADDR'];
	
	$text = str_replace("%key%", $key, $text);
	$text = str_replace("%nr%", $nr, $text);
	$text = str_replace("%price%", $price/100, $text);
	$text = str_replace("%price_type%", $price_type, $text);
	$text = str_replace("%ip%", $ip, $text);
	$text = str_replace("%time%", $priv_time, $text);
	
	return $text;
}

$result->close();
$mysqli->close();
?>