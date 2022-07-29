<?php 

?>
<!DOCTYPE html>
<html lang="es">
<head>
	<style type="text/css">
		body {
		    padding: 20px 10%;
		}
		section {
		    margin: 10px 0px;
		    padding: 30px 0px;
		}
		section div {
		    border: 1px solid gray;
		    padding: 20px 40px;
		}
		a {
			color: lightblue;
		}
		hr {
			width: 40px;
			float: left;
		}
	</style>
</head>
<body>
	<header>
		<h1>Hola <?=$full_name?></h1>
	</header>
	<hr>
	<section>
		<h3>ID de Orden: <?=$order_id?> - En Transito</h3>
		<div>
			<p>Tu orden con el numero de referencia <b><?=$reference_issuance?></b> esta en camino.</p>
			<p>You can track package using the following link: <a href="<?=$link_tracking?>">[Link]</a></p>
		</div>
	</section>
</body>
</html>