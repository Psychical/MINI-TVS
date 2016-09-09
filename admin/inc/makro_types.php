<?php
if(isset($_COOKIE["unban_loged"]))
{?>
	<script src='bbeditor/jquery.bbcode.js' type='text/javascript'></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#page_content").bbcode();
		});
	</script>
	<table width="100%">
		<tbody>
			<tr>
				<td width="4"><img src="../img/admin/skin/tl_lo.gif" width="4" height="4" border="0"></td>
				<td background="../img/admin/skin/tl_oo.gif"><img src="../img/admin/skin/tl_oo.gif" width="1" height="4" border="0"></td>
				<td width="6"><img src="../img/admin/skin/tl_ro.gif" width="6" height="4" border="0"></td>
			</tr>
			<tr>
				<td background="../img/admin/skin/tl_lb.gif"><img src="../img/admin/skin/tl_lb.gif" width="4" height="1" border="0"></td>
				<td width="100%">
					<table width="100%">
						<tbody>
							<tr>
								<td bgcolor="#EFEFEF" height="29" style="padding-left:10px;"><div class="navigation">Žinučių valdymas</div></td>
							</tr>
						</tbody>
					</table>
					<div class="unterline"></div>

								<div id='target2' style='color:red'></div>
								<center>Pridėti žinutės tipą<br /><br />
								<form action="ajax/message_types.php" method="POST" id='form2'>
									<div style='style: inline;'>Tipas (pvz.: vip, admin)<br /><input type="text" class="window" name="type" value="<?php echo $type; ?>"></div><br />
									<div style='style: inline;'>Pauslaugos tipas<br />
										<textarea id="page_content" name="page_content" style="width:500px; height: 200px;"><?php echo $page_content; ?></textarea>
									</div>
									<br />
									<font color='red'>PVZ.:</font> <font size='1'>Siuskite zinute su tekstu %key% %ip% numeriu %nr%. Kaina %time%d/%price% %price_type%<br /> Kai nusiusite SMS zinute iskart po atsakymo VIP bus automatiskai aktivuotas!</font>
									<br />									
									<br />									
									<input type="hidden" name="id" value="<?php echo $id; ?>">
									<input type="submit" name="submit" class="window" value="Pridėti" id='add'>
								</form></center><br /><br />
								<center>Svetainės pulapio turinys</center><br />
								<table border='0' style='border:1px #A198B8 solid; width: 400px;' align='center'>
									<tbody id='comments-box3'>
										<tr class='row progress'>
											<td style='background-color:transparent; border-width:0;'>&nbsp;</td>
										</tr>
									</tbody>
								</table><br />
				</td>
				<td background="../img/admin/skin/tl_rb.gif"><img src="../img/admin/skin/tl_rb.gif" width="6" height="1" border="0"></td>
			</tr>
			<tr>
				<td><img src="../img/admin/skin/tl_lu.gif" width="4" height="6" border="0"></td>
				<td background="../img/admin/skin/tl_ub.gif"><img src="../img/admin/skin/tl_ub.gif" width="1" height="6" border="0"></td>
				<td><img src="../img/admin/skin/tl_ru.gif" width="6" height="6" border="0"></td>
			</tr>
		</tbody>
	</table>
<?php } ?>