<?php
if(isset($_COOKIE["unban_loged"]))
{?>
	<h3><u>RAKTAŽODŽIŲ VALDYMAS</u></h3>
	<table style="width: 40%; margin: 0 auto;">
		<tbody>
			<tr>
				<td>
					<form action="ajax/sms.php" method="POST" id='form2'>
						<div class="form-group">
							<label for="exampleInputEmail1">Šalis</label>
							<select class="form-control" name="prefix">
								<?php
								while($rfl = $fl->fetch_object())
									echo '<option value="'.$rfl->prefix.'">'.strtoupper($rfl->prefix).'</option>';
								?>
							</select>
						</div>
						
						<div class="form-group">
							<label for="exampleInputEmail1">Raktažodis</label>
							<input type="text" class="form-control" name="key" value="">
						</div>
						
						<div class="form-group">
							<label for="exampleInputEmail1">SMS numeris</label>
							<input type="text" class="form-control" name="number" value="">
						</div>
						
						<div class="form-group">
							<label for="exampleInputEmail1">SMS Kaina (centais)</label>
							<input type="text" class="form-control" name="price" value="">
						</div>
						
						<div class="form-group">
							<label for="exampleInputEmail1">SMS Sistema</label>
							<select class="form-control" name="sms_type"><option value="0"<?php echo $sistema == 0 ? " selected" : ""; ?>>Mokėjimai.lt</option><option value="1"<?php echo $sistema == 1 ? " selected" : ""; ?>>Vpsnet.lt</option></select>
						</div>
						
						<div class="form-group">
							<label for="exampleInputEmail1">Kainos tipas</label>
							<input type="text" class="form-control" name="price_type" value="">
						</div>
						
						<div class="form-group">
							<label for="exampleInputEmail1">Pauslaugos tipas</label>
							<select class="form-control" name="message_type">
								<option value="unban">UNBAN</option>
								<?php
									while($rmp = $mp->fetch_object())
										if($rmp->type != "unban")
											echo '<option value="'.$rmp->type.'">'.strtoupper($rmp->type).'</option>';
								?>
							</select>
						</div>
						
						<div id='unban_no1'>
							<div class="form-group">
								<label for="exampleInputEmail1">Privilegijos</label>
								<select class="form-control" name="priv">
									<?php
										while($rpriv = $priv->fetch_object())
										{
											if($rpriv->priv != "unban")
											{
												echo '<option value="'.$rpriv->priv.'">'.strtoupper($rpriv->name).' ('.$rpriv->priv.')</option>';
											}
										}
									?>
								</select>
							</div>
						</div>
						
						<div id='unban_no2'>
							<div class="form-group">
								<label for="exampleInputEmail1">Privilegijų trukmė</label>
							
								<input type="text" class="form-control" name="priv_time" value="">
							</div>
						</div>
						
						<input type="submit" name="submit" value="Pridėti" class="form-control" id='add'>
					</form>
					<div id='target2' style='color:red; text-align: center;'></div>
				</td>
			</tr>
		</tbody>
	</table>
	<hr />
	<h3 style="margin-top: -20px;"><u>ESAMI RAKTAŽODŽIAI</u></h3>
	<div id='comments-box2'></div>
<?php } ?>