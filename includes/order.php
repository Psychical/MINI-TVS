<?php
if(!$f_page) die();

$order = addslashes($_GET['p']);

if($sms_status)
{
	$s = addslashes($_COOKIE["lang"]) ? addslashes($_COOKIE["lang"]) : $main_lang;
	$result = $mysqli->query("SELECT * FROM `unban_sms_config` WHERE `message_type` = '".substr($order, 1)."' AND `lang` = '".$s."'");

	$in_o_c = $mysqli_amx->query("SELECT `access` FROM `amx_amxadmins` WHERE `username` = '".$_SERVER['REMOTE_ADDR']."'");
		
	if($in_o_c->num_rows):
		?> <div class="alert alert-info" style="padding: 5px;"> <?php echo $unban['have_priv']; ?> </div> <?php
	endif;
	
	echo $unban['30'];
	if($result->num_rows && $order != "ounban")
	{
		$msg_info = $result->fetch_object();
		
		$get_content = $mysqli->query("SELECT * FROM `unban_messages_types` WHERE `type` = '".substr($order, 1)."' AND `lang` = '".$s."'");
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
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js"></script>
		<script>
		$(document).ready(function()
		{
			$('input').bind("change keyup", function()
			{
				var str = $('#nick').val();
				
				if(/^[a-zA-Z0-9-]*$/.test(str) == false)
				{
					$('#nick').val("" + str.substring(0, str.length - 1) + "");
				}
				
				var str = $('#pass').val();
				if(/^[a-zA-Z0-9-#]*$/.test(str) == false)
				{
					$('#pass').val("" + str.substring(0, str.length - 1) + "");
				}
			});
			
			$("input[name=type]").change(function()
			{
				if($("input:radio[name=type]:checked").val() == 'IP')
				{
					$("#ip").css("display", "block");
					$("#nick").css("display", "none");
					$("#pass").css("display", "none");
				}
				else
				{
					$("#ip").css("display", "none");
					$("#nick").css("display", "block");
					$("#pass").css("display", "block");
				}
			});
		});
		
		</script>
		
		<form action="./pay/makro/index.php" method="POST">
		<?php echo $unban['32']; ?>
		<input type="radio" name="type" value="IP" checked>IP/NICK<input type="radio" name="type" value="NAME"><br />
		<input type="text" class="form-control" placeholder="<?php echo $ip; ?>" id="ip" style="width: 130px; display: block;" disabled>
		<input type="text" class="form-control" placeholder="Nickname" id="nick" name="nick" style="width: 130px; display: none;" max="32">
		<input type="password" class="form-control" placeholder="Password" id="pass" name="pass" style="width: 130px; display: none;" max="32">
		<?php echo $unban['33']; ?>
		<select name='buy' class='form-control' style='width: 130px;'>
		
		<?php while($row = $result->fetch_object()): 
			$row->price /= 100; ?>
			<option value='<?php echo $row->id; ?>'><?php echo $row->lenght; ?>d. - <?php echo $row->price.$unban['35']; ?></option>
		<?php endwhile; ?>
		
		</select>
		<br />
		<input type='submit' class='btn btn-default' name='submit' value='<?php echo $unban['34']; ?>' />
		</form> <?php
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