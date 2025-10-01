<?php
    if (empty($_SESSION['active'])) 
    {
	    header('location: ../');
    }
?>

<header>
		<div class="header">
			
			<h1>Sistema Facturación</h1>
			<div class="optionsBar">
				<p>Panamá, <?php echo fechaC(); ?></p>
				<span>|</span>
				<span class="user"><?php echo $_SESSION['user'].' -'.$_SESSION['rol']; ?></span>
				<img class="photouser" src="img/user.png" alt="Usuario">
				<a href="salir.php"><img class="close" src="img/salir.png" alt="Salir del sistema" title="Salir"></a>
			</div>
		</div>
        <?php include "nav.php" ?>
</header>
<div class="modal">
	<div class="bodyModal">
		<form action="" method="post" name="form_add_product" id="form_add_product" onsubmit="event.preventDefault(); sendDataProduct();">
		    <h1><i class="fa fa-cubes" aria-hidden="true" style="font-size:45pt;"></i><br> Agregar Producto</h1>
			<h2 class="nameProducto"></h2><br>
			<input type="number" name="cantidad" id="txtCantidad" placeholder="Cantidad del Producto" required><br>
			<input type="text" name="precio" id="txtPrecio" placeholder="Precio del Producto" required>
			<input type="hidden" name="producto_id" id="producto_id" required>
			<input type="hidden" name="action" value="addProduct" required>
			<div class="alert alertAddProduct"></div>
			<button type="submit" class="btn_new"><i class="fas fa-plus"></i> Agregar</button>
			<a href="#" class="btn_ok closeModal" onclick="coloseModal();"><i class="fas fa-ban"></i> Cerrar</a>
		</form>
	</div>
</div>
	 