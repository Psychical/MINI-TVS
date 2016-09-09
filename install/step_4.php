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
{
	?>
	<form action="index.php" method="POST">
		<table style="width: 100%;">
			<tr><td><input type="text" class="form-control input-sm" name="http_addr" value="<?php echo "http://".$_SERVER['HTTP_HOST'].limitString($_SERVER['SCRIPT_NAME'], strlen($_SERVER['SCRIPT_NAME'])-17); ?>"></td></tr>
			<tr>
				<td>
					<center>AMXBans versija</center>
					<select class="form-control" name="amxbans_version">
						<option value="1">AMXBans 6.x.x/GM</option>
					</select>
				</td>
			</tr>
			<tr><td><input type="hidden" name="step" value="5"></td></tr>
			<tr><td align="center"><input type="submit" class="btn btn-default" name="submit" value="Įrašyti"></td></tr>
		</table>
	</form>
	
	<?php
}
?>