<?php
if(isset($_COOKIE["unban_loged"]))
{?>
	<h3><u>ŠALIŲ VALDYMAS</u></h3>
	<table class="table">
		<tbody>
			<tr>
				<td width="100%">
					<div class="unterline"></div>
					<table style='width: 700px; height: 100px;' align='center'>
						<tr>
							<td style='border-right: 1px solid grey; width: 30%; padding-right: 40px;'>
								<form action="ajax/flag.php" method="POST" id='form1'>
									<div class="form-group">
										<label for="exampleInputEmail1">Pridėti šalį [<a href = 'http://lt.wikipedia.org/wiki/S%C4%85ra%C5%A1as:%C5%A0ali%C5%B3_s%C4%85ra%C5%A1as' target='_blank'>ISO Kodai</a>]</label>
										<input class="form-control" type="text" name="prefix" placeholder="Šalies ISO kodas"><br />
										<input type="submit" name="submit" value="Pridėti" class="form-control" id='add'>
									</div>
								</form>
								<div id='target1' style='color:red'></div>
							</td>
							<td style='padding-left: 40px; padding-right: 40px;' valign="top">
								Esamos šalys (Norint ištrinti, spausti ant vėliavėlės):
								<div id='comments-box1'></div>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</tbody>
	</table>
<?php } ?>