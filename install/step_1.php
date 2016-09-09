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
	$php_version = phpversion();
	?>
	<div class="input-group">
		<input type="text" class="form-control" value="PHP Versija: <?php echo $php_version; ?>" disabled>
	<?php echo ($php_version[0] >= 5) ? '<span class="input-group-addon" style="color: green; font-weight: bold;"><img src="../img/v.png" border=0 /></span>' : '<span class="input-group-addon" style="color: red; font-weight: bold;"><img src="../img/x.png" border=0 /></span>'; ?>
	</div>
	<?php
	if($php_version[0] >= 5)
	{
		echo '<form method="POST">';
		echo '<input type="hidden" name="step" value="2"><br />';
		echo '<input type="submit" name="next" style="float: right;" class="btn btn-success btn-large" value="Kitas žingsnis">';
		echo '</form>';
	}
	else
	{
		echo '<br /><div class="alert alert-danger"><b>Klaida!</b> Norint naudoti šią sistema, būtina turėti PHP 5.0.0 versiją arba naujesnę!</div>';
	}
}
?>