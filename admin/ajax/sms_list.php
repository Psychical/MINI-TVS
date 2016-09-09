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
				url: "ajax/del_key.php",
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
<table class="table">
	<tr>
		<th>#</th>
		<th>Kalba</th>
		<th>Raktažodis</th>
		<th>Numeris</th>
		<th>Kaina</th>
		<th>Tipas</th>
		<th>Valiuta</th>
		<th>Žinutės tipas</th>
		<th></th>
	</tr>

<?php
	$sms_c = $mysqli->query("SELECT * FROM `unban_sms_config`"); $i = 1;
	while($row = $sms_c->fetch_object())
	{
		switch($row->sms_type)
		{
			case 0: $row->sms_type = "PaySera"; break;
			case 1: $row->sms_type = "VPSNet"; break;
		}
	
		echo "
		<tr id='".$row->id."'>
		<td>".$i++."</td>
		<td>".strtoupper($row->lang)." <img src='../img/flags/".$row->lang.".gif' border='0'></td>
		<td>".$row->key."</td>
		<td>".$row->number."</td>
		<td>".$row->price."</td>
		<td>".$row->sms_type."</td>
		<td>".$row->price_type."</td>
		<td>".strtoupper($row->message_type)."</td>
		<td><img src='../img/x.png' border='0' class='deleteitem'></td>
		</tr>";
	}
echo "</table>";
?>