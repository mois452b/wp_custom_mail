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
			<p>Tu orden esta en camino.</p>
			<?php if($issuance_id == 0): ?>
				<p>Puede conocer el estado del envio usando el siguiente enlace: <a href="<?=get_permalink( get_option('woocommerce_myaccount_page_id') ).'view-order/'.$order_id?>" >[Link]</a></p>
			<?php else:?>
				<p>Puede conocer el estado del envio usando el siguiente enlace: <a href="https://starken.cl/seguimiento?codigo=<?=$issuance_id?>" ><?=$issuance_id?></a></p>
			<?php endif; ?>
		</div>		
	</section>
</body>
</html>