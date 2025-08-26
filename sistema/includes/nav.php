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
					    <a href="#">Clientes</a>
					    <ul>
						    <li><a href="registro_cliente.php">Nuevo Cliente</a></li>
						    <li><a href="lista_clientes.php">Lista de Clientes</a></li>
					    </ul>
				    </li>
				    <li class="principal">
					    <a href="#">Proveedores</a>
					    <ul>
						    <li><a href="#">Nuevo Proveedor</a></li>
						    <li><a href="#">Lista de Proveedores</a></li>
					</ul>
				    </li>
				    <li class="principal">
					    <a href="#">Productos</a>
					    <ul>
						    <li><a href="#">Nuevo Producto</a></li>
						    <li><a href="#">Lista de Productos</a></li>
					    </ul>
				    </li>
				    <li class="principal">
					    <a href="#">Facturas</a>
					    <ul>
						    <li><a href="#">Nuevo Factura</a></li>
						    <li><a href="#">Facturas</a></li>
					    </ul>
				    </li>
			</ul>
		</nav>