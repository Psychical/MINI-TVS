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
	switch(addslashes($_POST['step']))
	{
		case 0: $f = 'class="text-successs"'; break;
		case 1: $si = 'class="text-successs"'; break;
		case 2: $s = 'class="text-successs"'; break;
		case 3: $t = 'class="text-successs"'; break;
		case 4: $fo = 'class="text-successs"'; break;
		case 5: $ff = 'class="text-successs"'; break;
		default: $f = 'class="text-successs"'; break;
	}

	echo '
	<div class="well well-sm">
		<div '.$f.'><font style="color: grey;">Žingsnis 1:</font> Sutikimas su taisyklėmis</div>
		<br />
		<div '.$si.'><font style="color: grey;">Žingsnis 2:</font> Informacija</div>
		<br />
		<div '.$s.'><font style="color: grey;">Žingsnis 3:</font> Failų leidžiamumo patvirtinimas</div>
		<br />
		<div '.$t.'><font style="color: grey;">Žingsnis 4:</font> MySQL duomenų surašymas</div>
		<br />
		<div '.$fo.'><font style="color: grey;">Žingsnis 5:</font> Nustatymų surašymas</div>
		<br />
		<div '.$ff.'><font style="color: grey;">Žingsnis 6:</font> Instaliacijos pabaiga</div>
	</div>';
}
?>