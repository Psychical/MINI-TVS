<?php
error_reporting(0);

/*
Copyright (C) 2013 REZ.LT

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
*/

$install_page = true;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Sistemos įrašymas</title>
	<link rel="stylesheet" type="text/css" href="../css/install.css">
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
</head>

<body style="padding: 15px;">
	<div style="width: 800px; margin: 0 auto;">
		<h4>Sistemos įrašymas</h4>
		<div style="border: 1px solid grey; padding: 5px;">
			<table style="width: 100%;">
				<tr>
					<td style="width: 50%; padding: 25px; font-size: 12px;" valign="top">
						<?php include('steps.inc.php'); ?>
					</td>
					<td style="width: 50%; padding: 25px; font-size: 12px;" valign="top">
						<?php
						switch (addslashes($_POST['step'])) {
							case 1:
								include('step_1.php');
								break;
							case 2:
								include('step_2.php');
								break;
							case 3:
								include('step_3.php');
								break;
							case 4:
								include('step_4.php');
								break;
							case 5:
								include('step_5.php');
								break;
							default:
								include('step_0.php');
								break;
						}
						?>
					</td>
				</tr>
			</table>
		</div>
	</div>
</body>

</html>

<?php
function limitString($string, $limit = 100)
{
	if (strlen($string) < $limit)
		return $string;

	$regex = "/(.{1,$limit})\b/";
	preg_match($regex, $string, $matches);
	return $matches[1];
}

function create_file($host, $user, $pass, $data, $host_amx, $user_amx, $pass_amx, $data_amx)
{
	$dbconfig = <<<HTML
<?php
\$dbhost = "{$host}";
\$dbuser = "{$user}";
\$dbpass = "{$pass}";
\$dbdata = "{$data}";

\$dbhost_amx = "{$host_amx}";
\$dbuser_amx = "{$user_amx}";
\$dbpass_amx = "{$pass_amx}";
\$dbdata_amx = "{$data_amx}"; 
?>
HTML;

	$con_file = fopen("../config/config.php", "w+") or die("Atsiprašome, tačiau nepavyko sukurti failo <b>../config/config.php</b>.<br />Prašome patikrinti rašymo teises, CHMOD!<br> CHMOD turi būti 777");

	fwrite($con_file, $dbconfig);
	fclose($con_file);
	@chmod("../config/config.php", 0666);

	return "Failas sėkmingai sukurtas!";
}

function checkTableExists($mysqli,$table)
{
	$queryTemplate = "SELECT TABLE_NAME FROM  information_schema.TABLES WHERE TABLE_SCHEMA LIKE '" . $_POST["data"] . "' AND TABLE_TYPE LIKE 'BASE TABLE' AND TABLE_NAME = '%s'";
	return $mysqli->query(sprintf($queryTemplate, $table))->num_rows > 0;
}

function install_db($mysqli, $mysqli_amx, $prefix)
{
	$return = '<table class="table">';
	$return .= "<thead><tr><th>Lentelė</th><th>Statusas</th></tr></thead>";
	$return .= "<tr>";
	if(!checkTableExists($mysqli, "unban_flags")) {
	// if (!$result) {
		$mysqli->multi_query(file_get_contents("sql/unban_flags.sql"));
		$return .= "<td>unban_flags</td><td>Sukurtas</td>";
		while ($mysqli->next_result()) {
			;
		}
	} else {
		$return .= "<td>unban_flags</td><td>Egzistuoja</td>";
	}
	$return .= "</tr><tr>";
	if(!checkTableExists($mysqli, "unban_sms_config")) {
		$mysqli->multi_query(file_get_contents("sql/unban_sms_config.sql"));
		$return .= "<td>unban_sms_config</td><td>Sukurtas</td>";
		while ($mysqli->next_result()) {
			;
		}
	} else {
		$return .= "<td>unban_sms_config</td><td>Egzistuoja</td>";
	}
	$return .= "</tr><tr>";
	if(!checkTableExists($mysqli, "unban_config")) {
		$mysqli->multi_query(file_get_contents("sql/unban_config.sql"));
		$return .= "<td>unban_config</td><td>Sukurtas</td>";
		while ($mysqli->next_result()) {
			;
		}
		$mysqli->query("UPDATE `unban_config` SET `value` = '" . $prefix . "' WHERE `id` = 'amxbans_prefix'");
	} else {
		$mysqli->query("UPDATE `unban_config` SET `value` = '" . $prefix . "' WHERE `id` = 'amxbans_prefix'");
		$return .= "<td>unban_config</td><td>Egzistuoja</td>";
	}
	$return .= "</tr><tr>";
	if(!checkTableExists($mysqli, "unban_makro_types")) {
		$mysqli->multi_query(file_get_contents("sql/unban_makro_types.sql"));
		$return .= "<td>unban_makro_types</td><td>Sukurtas</td>";
		while ($mysqli->next_result()) {
			;
		}
	} else {
		$return .= "<td>unban_log_login</td><td>Egzistuoja</td>";
	}
	$return .= "</tr><tr>";
	if(!checkTableExists($mysqli, "unban_log_login")) {
		$mysqli->multi_query(file_get_contents("sql/unban_log_login.sql"));
		$return .= "<td>unban_log_login</td><td>Sukurtas</td>";
		while ($mysqli->next_result()) {
			;
		}
	} else {
		$return .= "<td>unban_log_login</td><td>Egzistuoja</td>";
	}
	$return .= "</tr><tr>";
	if(!checkTableExists($mysqli, "unban_links")) {
		$mysqli->multi_query(file_get_contents("sql/unban_links.sql"));
		$return .= "<td>unban_links</td><td>Sukurtas</td>";
		while ($mysqli->next_result()) {
			;
		}
	} else {
		$return .= "<td>unban_links</td><td>Egzistuoja</td>";
	}
	$return .= "</tr><tr>";
	if(!checkTableExists($mysqli, "unban_order_prvilegies")) {
		$mysqli->multi_query(file_get_contents("sql/unban_order_prvilegies.sql"));
		$return .= "<td>unban_order_prvilegies</td><td>Sukurtas</td>";
		while ($mysqli->next_result()) {
			;
		}
	} else {
		$return .= "<td>unban_order_prvilegies</td><td>Egzistuoja</td>";
	}
	$return .= "</tr><tr>";
	if(!checkTableExists($mysqli, "unban_messages_types")) {
		$mysqli->multi_query(file_get_contents("sql/unban_messages_types.sql"));
		$return .= "<td>unban_messages_types</td><td>Sukurtas</td>";
		while ($mysqli->next_result()) {
			;
		}
	} else {
		$return .= "<td>unban_messages_types</td><td>Egzistuoja</td>";
	}
	$return .= "</tr><tr>";
	if(!checkTableExists($mysqli, "unban_servers")) {
		$mysqli->multi_query(file_get_contents("sql/unban_servers.sql"));
		$return .= "<td>unban_servers</td><td>Sukurtas</td>";
		while ($mysqli->next_result()) {
			;
		}
	} else {
		$return .= "<td>unban_servers</td><td>Egzistuoja</td>";
	}
	$return .= "</tr><tr>";

	if(checkTableExists($mysqli_amx, $prefix."_amxadmins")) {
		$result2 = $mysqli_amx->query("SELECT `nr` FROM " . $prefix . "_amxadmins");
		if (!$result2) {
			$mysqli_amx->query("ALTER TABLE " . $prefix . "_amxadmins ADD `nr` VARCHAR( 15 ) NOT NULL;");
			$return .= "<td>" . $prefix . "_amxadmins</td><td>Pakoreguotas</td>";
		} else {
			$return .= "<td>" . $prefix . "_amxadmins</td><td>Jau buvo pakoreguotas</td>";
		}
	} else
		$return .= "<td>" . $prefix . "_amxadmins</td><td>NERASTA</td>";
	$return .= "</tr>";
	$return .= "</table>";

	return $return;
}
?>