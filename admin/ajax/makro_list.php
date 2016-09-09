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
				url: "ajax/del_makro.php",
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
		<th>Privilegijos</th>
		<th>Kaina</th>
		<th>Trukmė</th>
		<th></th>
	</tr>

	<?php
	while($row = $makro_l->fetch_object())
	{	
		echo "
		<tr id='".$row->id."'>
		<td>".$i++."</td>
		<td>".strtoupper($row->priv_type)."</td>
		<td>".$row->price." ct</td>
		<td>".$row->lenght." d.</td>
		<td><img src='../img/x.png' border='0' class='deleteitem'></td>
		</tr>";
	} 
echo "</table>";
?>