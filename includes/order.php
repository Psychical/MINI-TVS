<?php
if(!$f_page) die();

$order = addslashes($_GET['p']);

if($sms_status)
{
	$result = $mysqli->query("SELECT * FROM `unban_sms_config` WHERE `message_type` = '".substr($order, 1)."' AND `lang` = '".$sLang."'");

	$in_o_c = $mysqli_amx->query("SELECT `access` FROM `amx_amxadmins` WHERE `username` = '".$_SERVER['REMOTE_ADDR']."'");
		
	if($in_o_c->num_rows):
		?> <div class="alert alert-info" style="padding: 5px;"> <?php echo $unban['have_priv']; ?> </div> <?php
	endif;
	
	echo $unban['30'];
	if($result->num_rows && $order != "ounban")
	{
		$msg_info = $result->fetch_object();
		
		$get_content = $mysqli->query("SELECT * FROM `unban_messages_types` WHERE `type` = '".substr($order, 1)."' AND `lang` = '".$sLang."'");
		$fetch_get_content = $get_content->fetch_object();
	
		echo content_text($fetch_get_content->page_content, $msg_info->key, $msg_info->number, $msg_info->price, $msg_info->price_type, $msg_info->priv_time);
		
		$get_content->close();
	}
	else
		echo $unban['31'];
	
	echo "<br /><br />";
	$result->close();
}

if($makro_type == 1)
{
	$result = $mysqli->query("SELECT * FROM `unban_makro_types` WHERE `priv_type` = '".substr($order, 1)."' ORDER BY `price`");
	
	if(!$result->num_rows)
		echo $unban['32'];
		
	if($result->num_rows > 0): ?>
		<form action="./pay/makro/index.php" method="POST">
		<?php echo $unban['32']; ?>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Nickname/IP Address or SteamID<br /> (<small>Your IP (maybe): <?php echo $_SERVER['REMOTE_ADDR']; ?></small>)</label>
						<input type="text" name="nick" onkeyup="keyupFunction(this.id, this.value)" onfocus="keyupFunction(this.id, this.value)" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>" class="form-control" autocomplete="off" required> 
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group" style="display: none;" id="pid">
						<label>Password<br /> (<small>only FOR nickname</small>)</label>
						<input type="text" id="pass" name="password" value="<?php echo isset($_POST['password']) ? "".$_POST['password']."" : ""; ?>" class="form-control" autocomplete="off" disabled> 
					</div>
				</div>
			</div>
			
		
		<?php echo $unban['33']; ?>
		<select name='buy' class='form-control' style='width: 130px;'>
		
		<?php while($row = $result->fetch_object()): 
			$row->price /= 100; ?>
			<option value='<?php echo $row->id; ?>'><?php echo $row->lenght; ?>d. - <?php echo $row->price.$unban['35']; ?></option>
		<?php endwhile; ?>
		
		</select>
		<br />
		<input type='submit' class='btn btn-default' name='submit' value='<?php echo $unban['34']; ?>' />
		</form>

		<script>
		function keyupFunction(id, value) {
			document.getElementById("pass").disabled = (ValidateIPaddress(value)) ? true : false;
			document.getElementById("pass").required = (ValidateIPaddress(value)) ? false : true;
			document.getElementById("pid").style.display = (ValidateIPaddress(value)) ? "none" : "block";
		}
		function ValidateIPaddress(ipaddress) 
		{
			if(/^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/.test(ipaddress))
				return true;
			
			return false;
		}
		</script>
		
		<?php
	else:
		echo $unban['31'];
	endif;
	
	$result->close();
}
	
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
?>