<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js"></script> 
<script src="http://malsup.github.com/jquery.form.js"></script>
<script>
jQuery(document).ready(function(){	
	$(".deleteitem").click(function(){
		var answer = confirm('Tikrai norite ištrinti šią šalį?');
		if(answer)
		{
			var parent = $(this).closest('TD');
			var id = parent.attr('id');
			$.ajax({
				type: "POST",
				url: "ajax/del_flag.php",
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

$i = 0; ?>
<table class="table">
	<tr>
		<?php while($row = $fl->fetch_object()): ?>
		
		<td id='<?php echo $row->id; ?>' style='width: 70px;'>
			<img src='../img/flags/<?php echo $row->prefix; ?>.gif' class='deleteitem' border='0'> - <?php echo strtoupper($row->prefix); ?>
		</td>
		<?php if(!(++$i % 5)): ?>
			</tr> <tr>
		<?php endif; 
		endwhile; ?>
</tr>
</table>