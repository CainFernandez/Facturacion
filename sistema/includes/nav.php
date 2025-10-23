<nav>
			<ul>
				<li><a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> Inicio</a></li>
				<?php 
				    if ($_SESSION['rol'] == 1) {
				?>
				    <li class="principal">
					    <a href="#"><i class="fa fa-users" aria-hidden="true"></i> Usuarios</a>
					    <ul>
						    <li><a href="registro_usuario.php"><i class="fa fa-user-plus" aria-hidden="true"></i> Nuevo Usuario</a></li>
						    <li><a href="lista_usuarios.php"><i class="fa fa-users" aria-hidden="true"></i> Lista de Usuarios</a></li>
					    </ul>
				    </li>
				<?php } ?>
				    <li class="principal">
					    <a href="#"><i class="fa fa-user" aria-hidden="true"></i> Clientes</a>
					    <ul>
						    <li><a href="registro_cliente.php"><i class="fa fa-user-plus" aria-hidden="true"></i> Nuevo Cliente</a></li>
						    <li><a href="lista_clientes.php"><i class="fa fa-list-ul" aria-hidden="true"></i> Lista de Clientes</a></li>
					    </ul>
				    </li>
					<?php 
				        if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2) {
					?>
				        <li class="principal">
					        <a href="#"><i class="fa fa-building" aria-hidden="true"></i> Proveedores</a>
					        <ul>
						        <li><a href="registro_proveedor.php"><i class="fa fa-plus-square" aria-hidden="true"></i> Nuevo Proveedor</a></li>
						        <li><a href="lista_proveedor.php"><i class="fa fa-th-list" aria-hidden="true"></i> Lista de Proveedores</a></li>
					        </ul>
				        </li>
					<?php } ?>
				    <li class="principal">
					    <a href="#"><i class="fa fa-cubes" aria-hidden="true"></i> Productos</a>
					    <ul>
							<?php 
				                if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2) {
					        ?>
						        <li><a href="registro_producto.php"><i class="fa fa-plus-circle" aria-hidden="true"></i> Nuevo Producto</a></li>
						    <?php } ?>

						    <li><a href="lista_producto.php"><i class="fa fa-cubes" aria-hidden="true"></i> Lista de Productos</a></li>
					    </ul>
				    </li>
				    <li class="principal">
					    <a href="#"><i class="fa fa-calculator" aria-hidden="true"></i> Ventas</a>
					    <ul>
						    <li><a href="nueva_venta.php"><i class="fa fa-calendar-plus" aria-hidden="true"></i> Nuevo Venta</a></li>
						    <li><a href="ventas.php"><i class="fa fa-calculator" aria-hidden="true"></i> Ventas</a></li>
					    </ul>
				    </li>
			</ul>
		</nav>