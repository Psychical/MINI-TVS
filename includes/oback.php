<?php
if(!$f_page)
	die();
?>
<div style="overflow:auto; max-height: 450px;">
	<div class="alert alert-info">Paslaugos susigrazinimo forma pagal savo sena: <li><b>IP adresą</b> <li><b>Telefono numerį</b> - kuris darė apmokejimą <li><b>Pirkimo datą</b> - paslaugos pirkimo laikas</div>
	<form method="POST" action>
		<label>Senas IP:</label><input type="text" class="form-control" placeholder="00.00.00.00" name="old_ip" value="<?php echo isset($_POST['old_ip']) ? $_POST['old_ip'] : ""; ?>">
		<label>Telefono nr.:</label><input type="text" class="form-control" placeholder="+370 000 00000" name="phone" value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : ""; ?>">
		<label>Naujas IP:</label><input type="text" class="form-control" placeholder="11.11.11.11" name="new_ip" value="<?php echo isset($_POST['new_ip']) ? $_POST['new_ip'] : ""; ?>">
		<label>Pirkimo data:</label><input type="date" class="form-control" placeholder="<?php echo date("Y-m-d"); ?>" name="bdate" value="<?php echo isset($_POST['bdate']) ? $_POST['bdate'] : ""; ?>">
		<br />
		<input type='submit' class='btn btn-success' name='submit' value='Informacija užpildyta teisingai' />
	</form>
</table>
</div>

<?php 
if(isset($_POST['submit'], $_POST['old_ip'], $_POST['phone'], $_POST['new_ip'], $_POST['bdate'])):
	if(filter_var($_POST['old_ip'], FILTER_VALIDATE_IP)):
		if(filter_var($_POST['new_ip'], FILTER_VALIDATE_IP)):
			if($result = $mysqli->prepare("SELECT `created` FROM `amx_amxadmins` WHERE `username` = ? AND `nr` = ?")):
				$result->bind_param("ss", $_POST['old_ip'], $_POST['phone']); $result->execute(); $result->store_result();

				if($result->num_rows):
					$result->bind_result($created); $result->fetch();
					if(date("Y-m-d", $created) == $_POST['bdate']):
						$mysqli->query("UPDATE `amx_amxadmins` SET `username` = '".$_POST['new_ip']."' WHERE `username` = '".$_POST['old_ip']."'");
							
						?>
						<br />
						<div class="alert alert-success">
							Privilegijos buvo <b>sėkmingai</b> perkeltos ant <?php echo $_POST['new_ip']; ?> adreso.
						</div>
						<?php
					else:
						?>
						<br />
						<div class="alert alert-danger">
							<b>KLAIDA!</b> Neteisingai įvesta data!
						</div>
						<?php
					endif;
				else:
					?>
					<br />
					<div class="alert alert-danger">
						<b>KLAIDA!</b> Neteisingai įvestas senas IP ir/arba telefono numeris!
					</div>
					<?php
				endif;
			else:
				?>
				<br />
				<div class="alert alert-danger">
					<b>KLAIDA!</b> Neteisingai įvestas senas IP ir/arba telefono numeris!
				</div>
				<?php
			endif;
		else:
			?>
			<br />
			<div class="alert alert-danger">
				<b>KLAIDA!</b> Neteisingai įvestas naujas IP!
			</div>
			<?php
		endif;
	else:
		?>
		<br />
		<div class="alert alert-danger">
			<b>KLAIDA!</b> Neteisingai įvestas senas IP!
		</div>
		<?php
	endif;
endif;
?>