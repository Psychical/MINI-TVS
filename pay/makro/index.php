<?php 
	foreach ($_POST as $key => $value) {
		$_POST[$key] = addslashes($_POST[$key]);
	}
	
	if(isset($_POST['submit']))
	{
		include('../../config/db_connect.php');
		require_once('WebToPay.php');
		
		$id = (int) $_POST['buy'];
		$orderid = $_POST['username'];
		
		$result = $mysqli->query("SELECT * FROM `unban_makro_types` WHERE `id` = '".$id."'");
		
		if($result->num_rows)
		{
			$ftc = $result->fetch_object();
			
			try 
			{
				$self_url = get_self_url();
				$request = WebToPay::buildRequest(
					array
					(
						'projectid'     => $paysera_projectid,
						'orderid'       => $orderid,
						'amount'        => $ftc->price,
						'currency'      => 'EUR',
						'country'       => 'LT',
						'accepturl'     => $self_url.'/accept.php',
						'cancelurl'     => $self_url.'/cancel.php',
						'callbackurl'   => $self_url.'/call.php',
						'test'          => 0,
						'sign_password' => $paysera_sign,
						'privileges' 	=> $ftc->priv_type,
						'password' 		=> $_POST['pass'],
					)
				);
			}
			catch (WebToPayException $e) {
				echo $e->getMessage();
			} ?>
			<form name="form" id="form" action="https://www.paysera.lt/pay/" method="post">
				<?php foreach ($request as $key => $val): ?>
				<input type="hidden" name="<?php echo $key ?>" value="<?php echo htmlspecialchars($val); ?>" />
				<?php endforeach; ?>
				<div>Nukreipiama...</div> 
			</form> 
			<script>document.getElementById("form").submit();</script>
		<?php }
	} ?>
</body> 
</html>

<?php
	function get_self_url() 
	{
		$s = substr(strtolower($_SERVER['SERVER_PROTOCOL']), 0, strpos($_SERVER['SERVER_PROTOCOL'], '/'));
		
		if (!empty($_SERVER["HTTPS"])) {
			$s .= ($_SERVER["HTTPS"] == "on") ? "s" : "";
		}
		$s .= '://'.$_SERVER['HTTP_HOST'];
		
		if (!empty($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] != '80') {
			$s .= ':'.$_SERVER['SERVER_PORT'];
		}
		$s .= dirname($_SERVER['SCRIPT_NAME']);
		return $s;
	}
?>