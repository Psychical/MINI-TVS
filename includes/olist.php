<?php
if(!$f_page)
	die();
?>
<div style="overflow:auto; max-height: 450px;">
	<table class="table" style="margin-bottom: 0px;">
		<tr>
			<th style="text-align: center;">IP Adresas</th>
			<th style="text-align: center;">GALIOJA IKI</th>
			<th style="text-align: center;">Privilegijos</th>
			<th style="text-align: center;"></th>
		</tr>
<?php
while($lst = $list->fetch_object())
{
	$p = $mysqli->query("SELECT * FROM `unban_order_prvilegies`");
	
	$lst->timeleft = ($lst->timeleft) ? $lst->timeleft : date("Y-m-d", $lst->expired);
	
	$privilegies = "Nenustatyta";
	
	while($row = $p->fetch_object())
	{
		$get = str_split($row->priv);
		$have = str_split($lst->access);
		sort($get);
		sort($have);
		
		if(implode('', $get) == implode('', $have)) $privilegies = strtoupper($row->name);
	}
	
	echo '<tr>';
	echo '<td style="text-align: center;">'.get_user_access($lst->username).'</td>';
	echo '<td style="text-align: center;">'.$lst->timeleft.'</td>';
	echo '<td style="text-align: center;">'.$privilegies.'</td>';
	
	if($lst->timeleft)
	{ 
		$liko = (strtotime(date('Y-m-d', time()))-strtotime($lst->timeleft))*-1/86400+1;
		switch(round($liko))
		{
			case (round($liko) < 1): { $font = "blue"; break; }
			case 2: { $font = "red"; break; }
			case 3: { $font = "orange"; break; }
			case 4: { $font = "orange"; break; }
			case 5: { $font = "orange"; break; }
			default:  { $font = "green"; break; }
		}
		if(round($liko) < 30)
			echo '<td style="text-align: center;"> [ <font color="'.$font.'">Liko '.round($liko).'d.</font> ]</td>';
		else
			echo '<td style="text-align: center;"></td>';
	}
} ?>
	<tr>
		<td colspan="5"><br /> <small>*Raudonu <font class="red">*</font> pažymėtas Jūsų IP adresas!</small> </td>
	</tr>
<?php
echo "</table></div>";

function get_user_access($username)
{
	if($username == $_SERVER['REMOTE_ADDR'])
		$username .= '<font class="red">*</font>';
	else
	{
		if(filter_var($username, FILTER_VALIDATE_IP))
			$username = substr($username, 0, strrpos($username, ".")).".***";
		elseif(preg_match("/^STEAM_0:[01]:[0-9]{6,10}$/", $username))
			$username = substr($username, 0, strlen($username)-4)."****";
	}
	
	return $username;
}
?>