<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js"></script> 
<script>
jQuery(document).ready(function(){	
	$(".deleteitem").click(function(){
		var answer = confirm('Tikrai norite ištrinti šį raktažodį?');
		if(answer)
		{
			var parent = $(this).closest('TR');
			var id = parent.attr('id');
			$.ajax({
				type: "POST",
				url: "ajax/del_link.php",
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

if((md5($web_admin_name.$web_admin_pass.$_SERVER["HTTP_REMOTE"]) != addslashes($_COOKIE["unban_loged_ids"])))
	die("Eik iš čia...");
?>
<table class="table table-striped">
	<tr>
		<th>#</th>
		<th>Kalba</th>
		<th>Pavadinimas</th>
		<th>Adresas</th>
		<th>Statusas</th>
		<th>Vieta</th>
		<th></th>
	</tr>
	
	<?php
	while($row = $fl->fetch_object()):
		$mysqli->query("SET NAMES 'utf8'");
		$sms_c = $mysqli->query("SELECT * FROM `unban_links` WHERE `lang` = '".$row->prefix."' ORDER BY `sort_place`");
		while($row = $sms_c->fetch_object()):
		
			$row->show = $row->show ? "Rodomas" : "Nerodomas";
		
			echo "
			<tr id='".$row->id."'>
			<td>".$i++."</td>
			<td><img src='../img/flags/".$row->lang.".gif' border='0'> ".$row->lang."</td>
			<td>".$row->name."</td>
			<td>".$row->url."</td>
			<td>".$row->show."</td>
			<td>".$row->sort_place."</td>
			<td><img src='../img/x.png' border='0' class='deleteitem'></td>
			</tr>";
		endwhile;
		if($sms_c->num_rows): $i = 1; ?>
		<tr class="info"><td colspan="7"></td></tr>
	<?php endif; endwhile; ?>
		<tr class="info"><td colspan="7"><b>VISOMS KALBOMS</b></td></tr>
	<?php 
	$sms_c = $mysqli->query("SELECT * FROM `unban_links` WHERE `lang` = '*'");
	while($row = $sms_c->fetch_object()):
		$row->show = $row->show ? "Rodomas" : "Nerodomas";
		
			echo "
			<tr id='".$row->id."'>
			<td>".$i++."</td>
			<td>".$row->lang."</td>
			<td>".$row->name."</td>
			<td>".$row->url."</td>
			<td>".$row->show."</td>
			<td>".$row->sort_place."</td>
			<td><img src='../img/x.png' border='0' class='deleteitem'></td>
			</tr>";
	endwhile;?>
	
</table>