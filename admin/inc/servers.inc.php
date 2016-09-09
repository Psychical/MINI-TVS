<?php
if(isset($_COOKIE["unban_loged"]))
{?>
	<h3><u>SERVERIŲ VALDYMAS</u></h3>
	<table style="width: 40%; margin: 0 auto;">
		<tbody>
			<tr>
				<td width="100%">
					<form action="ajax/server.php" method="POST" id='form2'>
						<div class="form-group">
							<label for="exampleInputEmail1">IP adresas</label>
							<input type="text" class="form-control" name="ip" value="">
						</div>
						<div class="form-group">
							<label for="exampleInputEmail1">Port'as</label>
							<input type="text" class="form-control" name="port" value="">
						</div>
						
						<div class="form-group">
							<label for="exampleInputEmail1">RCON</label>
							<input type="text" class="form-control" name="rcon" value="">
						</div>
						<input type="submit" name="submit" value="Pridėti" class="form-control" id='add'>
					</form>
					<div id='target2' style='color:red'></div>
				</td>
			</tr>
		</tbody>
	</table>
	<hr />
	<h3 style="margin-top: -20px;"><u>ESAMI SERVERIAI</u></h3>
	<div id='comments-box4'></div>
<?php } ?>