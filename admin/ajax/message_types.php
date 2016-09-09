<?php 
if(!isset($_COOKIE["unban_loged"]))
	die("Eik iš čia...");

include('../../config/db_connect.php');

if((md5($web_admin_name.$web_admin_pass.$_SERVER["HTTP_REMOTE"]) != addslashes($_COOKIE["unban_loged_ids"])))
	die("Eik iš čia...");

if($_POST['submit'])
{
	foreach ($_POST as $key => $value) {
		$_POST[$key] = addslashes($_POST[$key]);
	}
	
	$id = (int) addslashes($_POST['id']);
	$prefix = $_POST['prefix'];
	$type = $_POST['type'];
	$page_content = $_POST['page_content'];
	
	if(empty($prefix)) { echo "Neįrašėte prefix!<br />"; }
	else if(empty($type)) { echo "Neįrašėte žinutės tipo!<br />"; }
	else if(empty($page_content)) { echo "Neįrašėte puslapio turinio!<br />"; }
	else
	{
		$result = $mysqli->query("SELECT * FROM `unban_messages_types` WHERE `id` = '".$id."'");
		if($result->num_rows)
		{
			$page_content = str_replace("\\n", "<br />", $page_content);
			$page_content = str_replace("\n", "<br />", $page_content);
			$mysqli->query("UPDATE `unban_messages_types` SET `lang` = '".$prefix."', `type` = '".$type."', `page_content` = '".$page_content."' WHERE `id` = '".$id."'");
			
			echo "<font color='green'>Žinutės tipas sėkmingai atnaujintas!</font><br />";
		}
		else if(!$result->num_rows)
		{
			$page_content = str_replace("\\n", "<br />", $page_content);
			$page_content = str_replace("\n", "<br />", $page_content);
			$mysqli->query("INSERT INTO `unban_messages_types` (`type`, `page_content`, `lang`) VALUES ('$type', '$page_content', '$prefix')");
			
			echo "<font color='green'>Žinutės tipas sėkmingai pridėtas!</font><br />";
		}
	}
}
?>