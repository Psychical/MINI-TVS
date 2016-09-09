<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js"></script> 
<script>
jQuery(document).ready(function(){	
	$(".deleteitem").click(function(){
		var answer = confirm('Tikrai norite ištrinti šį tipą?');
		if(answer)
		{
			var parent = $(this).closest('TR');
			var id = parent.attr('id');
			$.ajax({
				type: "POST",
				url: "ajax/del_type.php",
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
	die("Eik iš čia..."); ?>
	
<table class="table">
	<tr>
		<th>#</th>
		<th>Kalbos prefix</th>
		<th>Tipo pavadinimas</th>
		<th></th>
	</tr>

<?php
	$sms_c = $mysqli->query("SELECT * FROM `unban_messages_types`"); $i = 1;
	while($row = $sms_c->fetch_object())
	{	
		echo "
		<tr id='".$row->id."'>
		<td>".$i++."</td>
		<td>".strtoupper($row->lang)." <img src='../img/flags/".$row->lang.".gif' border='0'></td>
		<td>".$row->type."</td>
		<td><a href='./admin.php?action=message_types&id=".$row->id."'><img src='../img/admin/icons/edit.png' border='0'></a> <img src='../img/x.png' border='0' class='deleteitem'></td>
		</tr>";
	} 
echo "</table>";
?>