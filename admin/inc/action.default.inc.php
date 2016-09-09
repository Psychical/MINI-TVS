<?php
if(isset($_COOKIE["unban_loged"]))
{
	?>
	<h3><u>BENDRI NUSTATYMAI</u></h3>
	<a href="./admin.php?action=settings">
		<div class="panel admin text-center">
			<img src="../img/admin/icons/settings.png" border="0" /><br />
			<small>Svetainės valdymas</small>
		</div>
	</a>
	<a href="./admin.php?action=flags">
		<div class="panel admin text-center">
			<img src="../img/admin/icons/countrys.png" border="0" /><br />
			<small>Šalių valdymas</small>
		</div>
	</a>
	<a href="./admin.php?action=links">
		<div class="panel admin text-center">
			<img src="../img/admin/icons/links.png" border="0" /><br />
			<small>Nuorodų valdymas</small>
		</div>
	</a>
	<div style="clear: both; height: 40px;"></div>
	<h3 style="margin-top: -20px;"><u>COUNTER-STRIKE NUSTATYMAI</u></h3>
	<a href="./admin.php?action=keys">
		<div class="panel admin text-center">
			<img src="../img/admin/icons/keywords.png" border="0" /><br />
			<small>Raktažodžių valdymas</small>
		</div>
	</a>
	<a href="./admin.php?action=servers">
		<div class="panel admin text-center">
			<img src="../img/admin/icons/servers.png" border="0" /><br />
			<small>Serverių nustatymai</small>
		</div>
	</a>
	<a href="./admin.php?action=priv_types">
		<div class="panel admin text-center">
			<img src="../img/admin/icons/privilegies.png" border="0" /><br />
			<small>Privilegijų nustatymas</small>
		</div>
	</a>
	<a href="./admin.php?action=message_types">
		<div class="panel admin text-center">
			<img src="../img/admin/icons/etc.png" border="0" /><br />
			<small>Žinučių tipai</small>
		</div>
	</a>
	<a href="./admin.php?action=makro_types">
		<div class="panel admin text-center">
			<img src="../img/admin/icons/etc.png" border="0" /><br />
			<small>Makro nustatymas</small>
		</div>
	</a>
	<div style="clear: both;"></div>
	<hr />
	<table class="table">
		<tr><th>Prisijungimų istorija (paskutiniai 5 prisijungimai)</th></tr>
		<tr>
			<td>
				<?php include('ajax/log_login.php'); ?>
			</td>
		</tr>
	</table>
	<?php $vn = file_get_contents('http://rez.lt/unban/version.txt');
	if($version < $vn): ?>
	<hr />
	<table width="100%">
		<tr>
			<td width="100%">
			<table width="100%">
				<tbody>
					<tr>
						<td bgcolor="#EFEFEF" height="29" style="padding-left:10px;">Sistemos naujinimas</td>
					</tr>
				</tbody>
			</table>
			<table width="100%">
				<tbody>
					<tr>
						<td width="50%" style="padding-left: 10px;">
							<table width="100%">
								<tbody>
									<tr>
										<td width="70" style="padding-top:5px;padding-bottom:5px;">
											<?php
											if($version < $vn)
												$version = '<font color="red">'.$version.'</font> (<a href="http://rez.lt/unban/unban.rar" target="_blank">http://rez.lt/unban/unban.rar</a>)';
											else if($version > $vn)
												$version = "<font color='green'><b>".$version."</font> <font color='red'>BETA!!!</b></font>";
											else
												$version = "<font color='green'><b>".$version."</b></font>";
											?>
											
											Sistemos versija: <?php echo $version; ?>									
										</td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
			</td>
		</tr>
	</table>
<?php endif;
} ?>