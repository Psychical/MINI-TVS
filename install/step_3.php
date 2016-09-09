<?php
/*
	Copyright (C) 2013 REZ.LT
	
    This program is free software; you can redistribute it and/or
    modify it under the terms of the GNU General Public License
    as published by the Free Software Foundation; either version 2
    of the License, or (at your option) any later version.
	
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
	
    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
*/

if($install_page)
{ ?>
	<form action="index.php" method="POST">
		<table style="width: 100%;">
			<tr><td><b>Sistemos duomenų bazė</b></td></tr>
			<tr><td><input type="text" class="form-control input-sm" name="host" autocomplete="off" placeholder="DB Adresas. PVZ.: localhost" value="<?php echo $_POST['host']; ?>"></td></tr>
			<tr><td><input type="text" class="form-control input-sm" name="user" autocomplete="off" placeholder="DB Vartotojas. PVZ.: root" value="<?php echo $_POST['user']; ?>"></td></tr>
			<tr><td><input type="password" class="form-control input-sm" name="pass" autocomplete="off" placeholder="DB vartotojo slaptažodis" value="<?php echo $_POST['pass']; ?>"></td></tr>
			<tr><td><input type="text" class="form-control input-sm" name="data" autocomplete="off" placeholder="DB pavadinimas. PVZ.: unban" value="<?php echo $_POST['data']; ?>"></td></tr>
		</table>
		<br />
		<table style="width: 100%;">
			<tr><td><b>AMXBANS duomenų bazė</b><br><small>Jei sistema įrašoma ten pat kur jau yra AMXBANS, žemiau užpildyti TIK <b>prefix</b> langelį!</small></td></tr>
			<tr><td><input type="text" class="form-control input-sm" name="host_amx" autocomplete="off" placeholder="AMX DB Adresas. PVZ.: localhost" value="<?php echo $_POST['host_amx']; ?>"></td></tr>
			<tr><td><input type="text" class="form-control input-sm" name="user_amx" autocomplete="off" placeholder="AMX DB Vartotojas. PVZ.: root" value="<?php echo $_POST['user_amx']; ?>"></td></tr>
			<tr><td><input type="password" class="form-control input-sm" name="pass_amx" autocomplete="off" placeholder="AMX DB vartotojo slaptažodis" value="<?php echo $_POST['pass_amx']; ?>"></td></tr>
			<tr><td><input type="text" class="form-control input-sm" name="data_amx" autocomplete="off" placeholder="AMX DB pavadinimas. PVZ.: amxbans" value="<?php echo $_POST['data_amx']; ?>"></td></tr>
			<tr><td><input type="text" class="form-control input-sm" name="prefix" autocomplete="off" placeholder="Amxbans prefix. PVZ.: amx" value="<?php echo $_POST['prefix']; ?>"></td></tr>
		</table>
		<table style="width: 100%;">
			<tr><td><input type="hidden" name="step" value="3"></td></tr>
			<tr><td align="center"><input type="submit" class="btn btn-default" name="submit" value="Įrašyti"></td></tr>
		</table>
	</form>
	
	<?php if(isset($_POST['host']))
	{
		foreach($_POST as $key => $value) {
			$_POST[$key] = addslashes($value);
		}
		
		if($_POST['host'])
		{
			if($_POST['user'])
			{
				if($_POST['data'])
				{
					if($_POST['prefix'])
					{
						$mysqli = new mysqli($_POST['host'], $_POST['user'], $_POST['pass'], $_POST['data']);
						$mysqli_amx = $mysqli;
						
						if($mysqli->connect_error)
						{
							echo '<br /><div class="alert alert-danger"><b>Prisijungimo klaida:</b><br /> '.$mysqli->connect_error.'</div>';
						}
						else
						{
							echo '<br /><div class="alert alert-success"><b>Sėkmingai</b> prisijungta prie duomenų bazės!</div>';
							
							if(!empty($_POST['host_amx']) && !empty($_POST['user_amx']) && !empty($_POST['data_amx']))
							{
								$mysqli_amx = new mysqli($_POST['host_amx'], $_POST['user_amx'], $_POST['pass_amx'], $_POST['data_amx']);
								
								if($mysqli_amx->connect_error) {
									echo '<br /><div class="alert alert-danger"><b>AMXBANS Prisijungimo klaida:</b><br /> '.$mysqli_amx->connect_error.'</div>';
								}
								else {
									echo '<br /><div class="alert alert-success"><b>Sėkmingai</b> prisijungta prie AMXBANS duomenų bazės!</div>';
								}
							}
							
							$result = $mysqli_amx->query("SELECT * FROM ".$_POST['prefix']."_bans");
							$result1 = $mysqli_amx->query("SELECT * FROM ".$_POST['prefix']."_amxadmins");
							if($result && $result1)
							{
								echo '<div class="alert alert-success"><b>AMXBANS</b> sėkmingai rastas Jūsų duomenų bazėje!</div>';
								
								create_file($_POST['host'], $_POST['user'], $_POST['pass'], $_POST['data'], $_POST['host_amx'], $_POST['user_amx'], $_POST['pass_amx'], $_POST['data_amx']);
								
								$back = install_db($mysqli, $mysqli_amx, $_POST['prefix']);
								echo $back;
								
								if($back)
								{
									echo '<input type="hidden" name="step" value="4">';
									echo '<form method="POST">';
									echo '<input type="hidden" name="step" value="4"><br />';
									echo '<input type="submit" name="next" style="float: right;" class="btn btn-success btn-large" value="Kitas žingsnis">';
									echo '</form>';
								}
							}
							else
							{
								echo '<div class="alert alert-danger"><b>Klaida:</b> Jūsų duomenų bazėje neradome AMXBANS sistemos, be šios sistemos mūsų sistema veikti negali, prašome pirmiausia įrašyti AMXBANS, o tik paskui mūsų sistemą!</div>';
							}
						}
					}
					else
					{
						echo '<br /><br /><br /><div class="alert alert-danger"><b>Klaida!</b><br /> Neįvestas įdiegto AMXBANS prefix\'as!</div>';
					}
				}
				else
				{
					echo '<br /><br /><br /><div class="alert alert-danger"><b>Klaida!</b><br /> Neįvestas duomenų bazės pavadinimas!</div>';
				}
			}
			else
			{
				echo '<br /><br /><br /><div class="alert alert-danger"><b>Klaida!</b><br /> Neįvestas duomenų vartotojo vardas!</div>';
			}
		}
		else
		{
			echo '<br /><br /><br /><div class="alert alert-danger"><b>Klaida!</b><br /> Neįvestas duomenų bazės adresas!</div>';
		}
	}
}
?>