<?php
if(isset($_COOKIE["unban_loged"]))
{
	?>
	<h3><u>PRIVILEGIJŲ VALDYMAS</u></h3>
	<script src='bbeditor/jquery.bbcode.js' type='text/javascript'></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#page_content").bbcode();
		});
	</script>
	<table style="width:40%; margin: 0 auto;">
		<tbody>
			<tr>
				<td width="100%">
					<form action="ajax/priv.php" method="POST" id='form2'>
						<div class="form-group">
							<label for="exampleInputEmail1">Privilegijų pavadinimas (pvz.: vip, admin)</label>
							<input type="text" class="form-control" name="name" value="">
						</div>
						
						<div class="form-group">
							<label for="exampleInputEmail1">Privilegijos (pvz.: bt, bit)</label>
							<input type="text" class="form-control" name="priv" value="">
						</div>
						
						<input type="submit" name="submit" class="form-control" value="Pridėti" id='add'>
						<br />
						<div id='target2' style='color: red; text-align: center;'></div>
					</form>
				</td>
			</tr>
		</tbody>
	</table>
	<hr />
	<h3 style="margin-top: -20px;"><u>ESAMOS PRIVILEGIJOS</u></h3>
	<div id='comments-box6'></div>
<?php } ?>