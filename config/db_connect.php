<?php
include('config.php');

if(is_dir('install'))
{
	?>
	<meta http-equiv="refresh" content="5; url=./install">
    <div class="alert alert-danger" style="width: 80%; margin: 0 auto; margin-top: 25px;">
		Aptikta <a href='./install'>install</a> direktorija, jei sistema neįrašyta paspauskite ant prieš tai buvusios nuorodos, jei sistema įrašyta, ištrinkite <b>/install</b> direktoriją!
	</div>
	<?php
	exit;
}

$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbdata);
$mysqli->query("SET NAMES utf8");
if(empty($dbhost_amx) && empty($dbuser_amx) && empty($dbpass_amx) && empty($dbdata_amx)) { $mysqli_amx = $mysqli; }
else { $mysqli_amx = new mysqli($dbhost_amx, $dbuser_amx, $dbpass_amx, $dbdata_amx); }

if($mysqli->connect_error) { die('Connect Error: '.$mysqli->connect_error); }
if($mysqli_amx->connect_error) { die('Connect Error: '.$mysqli_amx->connect_error); }

$ip = $_SERVER['REMOTE_ADDR'];
$i = 1;
$ok = "OK ";
$kada = date("Y-m-d");

error_reporting(0);

/*==================NELYSTI==================*/
$config = $mysqli->query("SELECT * FROM `unban_config`");

if($config->num_rows > 0)
{
	$objs = array();
	while($obj = $config->fetch_object()) { $objs[$obj->id] = $obj->value; }
	extract($objs, EXTR_OVERWRITE);

	$version = "5.4.1";
	/*==================NELYSTI==================*/

	//WEB admin name/pass
	$web_admin_name = "admin"; //CHANGE
	$web_admin_pass = "admin"; //CHANGE

	//SMS Answers
	$unbanned = "Jus sekmingai atbanintas!";
	$no_ban_exist = "IP kuri issiuntete neegzistuoja musu ban liste!";

	$unbans = $mysqli_amx->query("SELECT * FROM `".$amxbans_prefix."_bans` WHERE `expired` = '-1'");
	$bans = $mysqli_amx->query("SELECT * FROM `".$amxbans_prefix."_bans` WHERE `expired` = '0'");
	$banned = $mysqli_amx->query("SELECT * FROM `".$amxbans_prefix."_bans` WHERE `player_ip` = '".$ip."' AND `expired` = '0'");

	$bans1 = $bans->num_rows < 1 ? "0" : $bans->num_rows;
	$unbans1 = $unbans->num_rows < 1 ? "0" : $unbans->num_rows;
	$banned1 = $banned->num_rows;

	$fl = $mysqli->query("SELECT * FROM `unban_flags`");
	$mp = $mysqli->query("SELECT * FROM `unban_messages_types`");
	$priv = $mysqli->query("SELECT * FROM `unban_order_prvilegies`");
	$list = $mysqli_amx->query("SELECT * FROM `".$amxbans_prefix."_amxadmins` WHERE `expired` >= '".time()."' ORDER BY `expired` ASC");
	$servers_lst = $mysqli->query("SELECT * FROM `unban_servers`");
	$makro_l = $mysqli->query("SELECT * FROM `unban_makro_types`");
}

function dExpired($mysqli)
{
	$mysqli->query("DELETE FROM `amx_amxadmins` WHERE `expired` < '".time()."'");	
}

function limitString($string, $limit = 100)
{
    if(strlen($string) < $limit)
		return $string;

    $regex = "/(.{1,$limit})\b/";
    preg_match($regex, $string, $matches);
    return $matches[1];
}

function reload_admins($mysqli)
{
	$server_list = $mysqli->query("SELECT * FROM `unban_servers`");

	$server = new Rcon();
	
	while($row = $server_list->fetch_object())
	{
		$server->Connect("".$row->ip."", "".$row->port."", "".$row->rcon."");
		$server->RconCommand("amx_reloadadmins");
	}
	$server->disconnect();
	
	$server_list->close();
}

function get_acces_makro($mysqli, $name)
{
	$result = $mysqli->query("SELECT * FROM `unban_order_prvilegies` WHERE `name` = '".$name."'")->fetch_object();
	
	return $result->priv;
}

function randomPassword($lenght = 8)
{
    $pass = array(); //remember to declare $pass as an array
	
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
	
    for ($i = 0; $i < $lenght; $i++)
	{
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
	
    return implode($pass); //turn the array into a string
}
?>