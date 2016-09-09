<html> 
	<head>
	</head>
<body> 
<?php 
if(!isset($_POST['submit']))
{	
	$ip = $_SERVER['REMOTE_ADDR']; ?>

	<form method="post"> 
	<div> 
		<input type="hidden" name="ip" value="<?php echo $ip; ?>"/> 
	</div> 
	<div> 
		Kiti mokejimo budai: <input type="submit" name="submit" value="Moketi" /> 
	</div> 
	</form>
	<?php
}
else
{	
	$kada = date("Y-m-d"); //cia irgi
	$ipas = $_POST['ip'];

	require_once('WebToPay.php');

	function get_self_url() 
	{
		$s = substr(strtolower($_SERVER['SERVER_PROTOCOL']), 0, strpos($_SERVER['SERVER_PROTOCOL'], '/'));

		if (!empty($_SERVER["HTTPS"])) 
		{
			$s .= ($_SERVER["HTTPS"] == "on") ? "s" : "";
		}
		$s .= '://'.$_SERVER['HTTP_HOST'];

		if (!empty($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] != '80') 
		{
			$s .= ':'.$_SERVER['SERVER_PORT'];
		}
		$s .= dirname($_SERVER['SCRIPT_NAME']);
		return $s;
	}

	try 
	{
		$self_url = get_self_url();
		$request = WebToPay::buildRequest(
			array
			(
				'projectid'     => $paysera_projectid,
				'orderid'       => $ipas,
				'amount'        => $paysera_makro_price,
				'currency'      => 'EUR',
				'country'       => 'LT',
				'accepturl'     => $self_url.'/makro_pay/accept.php',
				'cancelurl'     => $self_url.'/makro_pay/cancel.php',
				'callbackurl'   => $self_url.'/makro_pay/call.php',
				'test'          => 0,
				'sign_password' => $paysera_sign
			)
		);
	}
	catch (WebToPayException $e) 
	{
		echo $e->getMessage();
	}
?>
	<form name="form" id="form" action="https://www.paysera.lt/pay/" method="post"> 
		<?php foreach ($request as $key => $val): ?>
			<input type="hidden" name="<?php echo $key ?>" value="<?php echo htmlspecialchars($val); ?>" />
		<?php endforeach; ?>
		<div>Nukreipiama...</div> 
	</form> 
    <script>document.getElementById("form").submit();</script>
<?php } ?>
</body> 
</html>