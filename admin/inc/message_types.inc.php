<?php
if(isset($_COOKIE["unban_loged"]))
{
	$id = (int) addslashes($_GET['id']);
	
	$result_type = $mysqli->query("SELECT * FROM `unban_messages_types` WHERE `id` = '".$id."'");
	
	$typeFtc = $result_type->fetch_object();
	
	$type = $typeFtc->type ? $typeFtc->type : "";
	$page_content = $typeFtc->page_content ? $typeFtc->page_content : "";
	$lang = $typeFtc->lang ? $typeFtc->lang : "";
	
	$page_content = str_replace("<br />", "\n", $page_content);
	
	function select($f, $s)
	{
		if($f == $s)
			return "selected";
		
		return "";
	}
	
	?>
	<script src='bbeditor/jquery.bbcode.js' type='text/javascript'></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#page_content").bbcode();
		});
	</script>
	<h3><u>ŽINUČIŲ PUSLAPIŲ VALDYMAS</u></h3>
	<table style="width: 60%; margin: 0 auto;">
		<tbody>
			<tr>
				<td>
					<form action="ajax/message_types.php" method="POST" id='form2'>
					
						<div class="form-group">
							<label for="exampleInputEmail1">Šalis</label>
							<select class="form-control" name="prefix">
								<?php
								while($rfl = $fl->fetch_object())
									echo '<option value="'.$rfl->prefix.'" '.select($rfl->prefix, $lang).'>'.strtoupper($rfl->prefix).'</option>';
								?>
							</select>
						</div>
						
						<div class="form-group">
							<label for="exampleInputEmail1">Tipas (pvz.: vip, admin)</label>
							<input type="text" class="form-control" name="type" value="<?php echo $type; ?>">
						</div>
						
						<div class="form-group">
							<label for="exampleInputEmail1">Pauslaugos tipas</label>
							<textarea id="page_content" name="page_content" class="form-control" style="height: 200px;"><?php echo $page_content; ?></textarea>
						</div>
						<br />
						<font color='red'>PVZ.:</font> <font size='1'>Siuskite zinute su tekstu %key% %ip% numeriu %nr%. Kaina %time%d/%price% %price_type%<br /> Kai nusiusite SMS zinute iskart po atsakymo VIP bus automatiskai aktivuotas!</font>
						<br />
						<br />
						<input type="hidden" name="id" value="<?php echo $id; ?>">
						<input type="submit" name="submit" class="form-control" value="Pridėti" id='add'>
					</form>
					<div id='target2' style='color: red; text-align: center;'></div>
				</td>
			</tr>
		</tbody>
	</table>
<h3><u>ESAMI ŽINUČIŲ PUSLAPIAI</u></h3>
<div id='comments-box3'></div>
<?php } ?>