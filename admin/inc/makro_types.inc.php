<?php
if(isset($_COOKIE["unban_loged"]))
{
	$id = (int) addslashes($_GET['id']);
	
	$result_type = $mysqli->query("SELECT * FROM `unban_messages_types` WHERE `id` = '".$id."'");
	
	$typeFtc = $result_type->fetch_object();
	
	$id = $typeFtc->id ? $typeFtc->id : 0;
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
	<h3><u>MAKRO VALDYMAS</u></h3>
	<table style="width:40%; margin: 0 auto;">
		<tbody>
			<tr>
				<td>
					<form action="ajax/makro_types.php" method="POST" id='form2'>
					
						<div class="form-group">
							<label for="exampleInputEmail1">Privilegijos</label>
							<select class="form-control" name="priv">
								<?php
								while($rfl = $priv->fetch_object())
									echo '<option value="'.$rfl->name.'">'.strtoupper($rfl->name).' ('.$rfl->priv.')</option>';
								?>
							</select>
						</div>
						
						<div class="form-group">
							<label for="exampleInputEmail1">SMS Kaina (centais)</label>
							<input type="number" class="form-control" name="price" value="100" min="100">
						</div>
						
						<div class="form-group">
							<label for="exampleInputEmail1">Privilegijų trukmė (dienomis)</label>
							<input type="number" class="form-control" name="time" value="1" min="1">
						</div>
						
						<input type="hidden" name="id" value="<?php echo $id; ?>">
						<input type="submit" name="submit" class="form-control" value="Pridėti" id='add'>
					</form>
					<div id='target2' style='color: red; text-align: center;'></div>
				</td>
			</tr>
		</tbody>
	</table>
	<hr />
	<h3 style="margin-top: -20px;"><u>ESAMI MAKRO</u></h3>
	<div id='comments-box7'></div>
<?php } ?>