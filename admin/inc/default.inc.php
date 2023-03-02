<?php if(MAIN_ADMIN): ?>

<div class="container">
	<?php if($version < file_get_contents('http://rez.lt/unban/version.txt', false, stream_context_create(array('http'=> array( 'timeout' => 1 ) )))): ?>
		<div class="alert alert-danger"><b>DĖMESIO!</b> Aptiktas sistemos naujinys! Informacija <a href="https://github.com/Psychical/MINI-TVS">GitHub</a>.</div>
	<?php endif;  ?>
	<div class="panel panel-primary">
		<div class="panel-body">
		<?php
			switch($_GET['action'])
			{
				case 'flags': { include('inc/flags.inc.php'); break; }
				case 'keys': { include('inc/keys.inc.php'); break; }
				case 'settings': { include('inc/settings.inc.php'); break; }
				case 'links': { include('inc/links.inc.php'); break; }
				case 'message_types': { include('inc/message_types.inc.php'); break; }
				case 'priv_types': { include('inc/priv_types.inc.php'); break; }
				case 'servers': { include('inc/servers.inc.php'); break; }
				case 'makro_types': { include('inc/makro_types.inc.php'); break; }
				default: { include('inc/action.default.inc.php'); break; }
			}					
		?>
		</div>
		<div class="panel-footer text-center">
			<small>2011-<?php echo date("Y"); ?> &copy; <a href="http://www.amxmodx.lt/viewtopic.php?f=34&t=1035" target="_blank">Mini TVS</a></small>
		</div>
	</div>
</div>

<?php endif; ?>