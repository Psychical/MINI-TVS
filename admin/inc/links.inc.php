<?php
if(isset($_COOKIE["unban_loged"]))
{?>
	<h3><u>NUORODŲ VALDYMAS</u></h3>
	<table class="table" style="margin: 0 auto; width: 40%;">
		<tbody>
			<tr>
				<td>
					<form action="ajax/link.php" method="POST" id='form2'>
						<div class="form-group">
							<label for="exampleInputEmail1">Kalba</label>
							<select class="form-control" name="lang">
								<option></option>
								<option value="*">Visoms kalboms</option>
								<?php while($rfl = $fl->fetch_object()): ?>
									<option value="<?php echo $rfl->prefix; ?>"><?php echo strtoupper($rfl->prefix); ?></option>
								<?php endwhile; ?>
							</select>
						</div>
						<div class="form-group">
							<label for="exampleInputEmail1">Pavadinimas</label>
							<input type="text" class="form-control" name="name" value="">
						</div>
						<div class="form-group">
							<label for="exampleInputEmail1">Adresas</label>
							<input type="text" class="form-control" name="url" value="">
						</div>
						<div class="form-group">
							<label for="exampleInputEmail1">Rodyti skaičių</label>
							<select class="form-control" name="show_number"><option value="1">Taip</option><option value="0" >Ne</option></select>
						</div>
						<div class="form-group">
							<label for="exampleInputEmail1">Rodyti </label>
							<select class="form-control" name="show"><option value="1">Taip</option><option value="0" >Ne</option></select>
						</div>
						<div class="form-group">
							<label for="exampleInputEmail1">Vieta sąraše</label>
							<input type="number" class="form-control" name="sort_place" value="0" min=0>
						</div>
						<input type="submit" name="submit" value="Pridėti" class="form-control" id='add'>
					</form>
					<br />
					<div id='target2' style='color: red; text-align: center;'></div>
					</center>
				</td>
			</tr>
	</table>
	<small>
	<ul><b>PAPILDOMOS NUORODOS:</b>
	<li><b>./index.php?p=list</b> - Žaidėjų sąrašas
	<li><b>./index.php?p=back</b> - Privilegijų susigrąžinimas
	</ul>
	</small>
	<hr />
	<h3 style="margin-top: -20px;"><u>ESAMOS NUORODOS</u></h3>
	<table width="100%">
		<tbody id='comments-box5'>
			<tr class='row progress'>
				<td>&nbsp;</td>
			</tr>
		</tbody>
	</table>
<?php } ?>