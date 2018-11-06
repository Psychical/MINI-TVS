<nav class="navbar navbar-default">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#">TVS</a>
		</div>
		
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<li><a href="./"><b>PRADINIS</b></a></li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><b>KEITIMAI</b> <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="./?action=flags">ŠALIŲ</a></li>
						<li><a href="./?action=links">NUORODŲ</a></li>
						<li><a href="./?action=keys">RAKTAŽODŽIŲ</a></li>
						<li><a href="./?action=servers">SERVERIŲ</a></li>
						<li><a href="./?action=priv_types">PRIVILEGIJŲ</a></li>
						<li><a href="./?action=message_types">ŽINUČIŲ TIPAI</a></li>
						<li><a href="./?action=makro_types">MAKRO</a></li>
					</ul>
				</li>
				<li><a href="./?action=settings"><b>NUSTATYMAI</b></a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Sveiki, <b><?php echo $web_admin_name; ?></b> <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="../">PERŽIŪRĖTI SVETAINĘ</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="./logout.php">ATSIJUNGTI</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</nav>