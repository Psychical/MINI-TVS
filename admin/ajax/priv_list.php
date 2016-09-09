<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js"></script> 
<script>
jQuery(document).ready(function(){	
	$(".deleteitem").click(function(){
		var answer = confirm('Tikrai norite ištrinti šias privilegijas?');
		if(answer)
		{
			var parent = $(this).closest('TR');
			var id = parent.attr('id');
			$.ajax({
				type: "POST",
				url: "ajax/del_priv.php",
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
	
<table class="table table-striped">
	<tr>
		<th>#</th>
		<th>Privilegijų pavadinimas</th>
		<th>Privilegijos</th>
		<th></th>
	</tr>

<?php
	$sms_c = $mysqli->query("SELECT * FROM `unban_order_prvilegies`"); $i = 1;
	while($row = $sms_c->fetch_object())
	{	
		echo "
		<tr id='".$row->id."'>
		<td>".$i++."</td>
		<td>".$row->name."</td>
		<td>".$row->priv."</td>
		<td><img src='../img/x.png' border='0' class='deleteitem'></td>
		</tr>";
	} 
echo "</table>";
?>