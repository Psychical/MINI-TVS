<html>
	<head>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js"></script> 
		<script src="../jquery.cookie.js"></script>
		<script>
		$(function(){ 
			$.cookie('unban_loged', null, { expires: false, path: '/' });
			$.cookie('unban_loged_ids', null, { expires: false, path: '/' });
		});
		</script>
	</head>
	<body>
		<meta http-equiv="refresh" content="0;url=admin.php">
	</body>
</html>
