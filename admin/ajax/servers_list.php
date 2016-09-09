<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js"></script>
<script src="http://malsup.github.com/jquery.form.js"></script> 
<script src="admin.js"></script> 
<script>
jQuery(document).ready(function(){	
	$(".delete").click(function(){
		var answer = confirm('Tikrai norite ištrinti šį serverį?');
		if(answer)
		{
			var parent = $(this).closest('TR');
			var id = parent.attr('id');
			$.ajax({
				type: "POST",
				url: "ajax/del_server.php",
				data: {id: id},
				
				success: function(msg){
					$('#'+id).remove();
				}
			});
		}
	});
});
</script>
<?php 
if(!isset($_COOKIE["unban_loged"]))
	die("Eik iš čia...");
	
include('../../config/db_connect.php');
include "rcon_hl_net.php";

if((md5($web_admin_name.$web_admin_pass.$_SERVER["HTTP_REMOTE"]) != addslashes($_COOKIE["unban_loged_ids"])))
	die("Eik iš čia..."); ?>
	
<center><div id='target4'></div></center>

<table class="table servers-list">
	<tr>
		<th>#</th>
		<th>Serverio IP</th>
		<th>Serverio port'as</th>
		<th>RCON Slaptažodis</th>
		<th></th>
		<th></th>
	</tr>

	<?php
	$server_list = $mysqli->query("SELECT * FROM `unban_servers`");
	
	while($row = $server_list->fetch_object())
	{
		$server = new Rcon();
		$server_con = $server->Connect("".$row->ip."", "".$row->port."", "".$row->rcon."");
		
		$status = $server->RconCommand("status");
		
		if(!$status || ($status[0] === "B" && $status[1] === "a" && $status[2] === "d")) { $style1 = "style = 'background: #FFD7D7;'"; } else { $style1 = "style = 'background: #D9FFD7;'"; }
		if(!$server_con) $style2 = "style = 'background: #FFD7D7;'"; else $style2 = "style = 'background: #D9FFD7;'";
	?>
		<tr id='<?php echo $row->id; ?>'>
			<td style='vertical-align: middle;'>
				<?php echo $i++; ?>
			</td>
			<form action='ajax/upd_server.php' id='form4' method='POST'>
			<td style='vertical-align: middle;'>
				<input type='hidden' name='id' value='<?php echo $row->id; ?>'>
				<input type='text' class='form-control' name='ip' value='<?php echo $row->ip; ?>' <?php echo $style2; ?>>
			</td>
			<td style='vertical-align: middle;'>
				<input type='text' class='form-control' name='port' value='<?php echo $row->port; ?>'>
			</td>
			<td style='vertical-align: middle;'>
				<input type='text' class='form-control' name='rcon' value='(paslėptas)' <?php echo $style1; ?>>
			</td>
			<td style='vertical-align: middle;'>
				<input type='image' src='../img/v.png' title='Update' name='submit' />
				<img src='../img/x.png' border='0' title='Delete' class='delete'>
			</td>
			</form> 
		</tr>
	<?php
		$server->disconnect();
	}
	
	echo "</table>";
	echo "<br /><br /><font size='0'>* Raudona spalva pažymėtas RCON slaptažodis reiškia, jog nebuvo įmanoma prisijungit prie serverio su šiuo RCON.</font>";
	echo "<br /><font size='0'>* Raudona spalva pažymėtas IP adresas reiškia, jog nebuvo įmanoma prisijungit prie serverio.</font>";
?>