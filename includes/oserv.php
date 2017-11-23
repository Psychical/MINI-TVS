<?php
if(!$f_page)
	die();
?>
<div style="overflow:auto; max-height: 450px;">
	<table class="table table-hover" style="margin-bottom: 0px;">
		<thead>
			<th style="text-align: center;"></th>
			<th style="text-align: center;">ADRESAS</th>
			<th style="text-align: center;">PAVADINIMAS</th>
			<th style="text-align: center;">ŽEMĖLAPIS</th>
			<th style="text-align: center;">ŽAIDĖJAI</th>
		</thead>
		<?php
		require 'includes/SourceQuery.class.php';
		while($serv_obj = $servers_lst->fetch_object()):
		
			$szInfo = array();
			$szInfo['HostName'] = "Unknown";
			$szInfo['Players'] = "0";
			$szInfo['MaxPlayers'] = "0";
			$szInfo['Map'] = "Unknown";
			
			$Query = new SourceQuery( );
			try { $Query->Connect($serv_obj->ip, $serv_obj->port, 1, 0); $szInfo = $Query->GetInfo( ); }
			catch( Exception $e ) { }

			$Query->Disconnect( );
		
			$server = $serv_obj->ip.":".$serv_obj->port;
			$players = $szInfo['Players']." / ".$szInfo['MaxPlayers'];
			
			?>
			<tr>
				<td style="text-align: center;"><?php echo $mod; ?></td>
				<td><?php echo $server; ?></td>
				<td style="text-align: center;"><?php echo $szInfo['HostName']; ?></td>
				<td style="text-align: center;"><?php echo $szInfo['Map']; ?></td>
				<td style="text-align: center;"><?php echo $players; ?></td>
			</tr>
		<?php endwhile; ?>
	</table>
</div>