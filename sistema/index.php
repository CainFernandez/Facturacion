<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Sisteme Ventas</title>
</head>
<body>
	<?php 

	    include "includes/header.php"; 
		include "../conexion.php";

		$query_dash = mysqli_query($conection,"CALL dataDashboard();");
		$result_das = mysqli_num_rows($query_dash);
		if($result_das > 0){
			$data_dash = mysqli_fetch_assoc($query_dash);
			mysqli_close($conection);
		}
	?>
	
	<section id="container">
		<div class="divContainer">
			<div>
				<h1 class="titlePanelControl">Panel de control</h1>
			</div>
			<div class="dashboard">
				<?php
				    if($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2)
				    {
				?>
				<a href="lista_usuarios.php">
					<i class="fas fa-users"></i>
					<p>
						<strong>Usuarios</strong><br>
						<span><?= $data_dash['usuarios'];  ?></span>
					</p>
				</a>
				<?php 
				    } 
				?>
				<a href="lista_clientes.php">
					<i class="fas fa-user"></i>
					<p>
						<strong>Clientes</strong><br>
						<span><?= $data_dash['clientes'];  ?></span>
					</p>
				</a>
				<?php
				    if($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2)
				    {
				?>
				<a href="lista_proveedor.php">
					<i class="fa fa-building" aria-hidden="true"></i>
					<p>
						<strong>Proveedores</strong><br>
						<span><?= $data_dash['proveedores'];  ?></span>
					</p>
				</a>
				<?php
					}
				?>
				<a href="lista_producto.php">
					<i class="fa fa-cubes" aria-hidden="true"></i>
					<p>
						<strong>Productos</strong><br>
						<span><?= $data_dash['productos'];  ?></span>
					</p>
				</a>
				<a href="ventas.php">
					<i class="fa fa-calculator" aria-hidden="true"></i>				
					<p>
						<strong>Ventas</strong><br>
						<span><?= $data_dash['ventas'];  ?></span>
					</p>
				</a>
			</div>
		</div>
		<div class="divInfoSistema">
			<div>
				<h1 class="titlePanelControl">Configuración</h1>
			</div>
			<div class="containerPerfil">
				<div class="containerDataUser">
					<div class="logoUser">
						<img src="img/logoUser.png" alt="">
					</div>
					<div class="divDataUser">
						<h4>Informaciòn Personal</h4>

						<div>
							<label>Nombre:</label><span><?= $_SESSION['nombre']; ?></span>
						</div>
						<div>
							<label>Correo:</label><span><?= $_SESSION['email']; ?></span>
						</div>

						<h4>Datos Usuario</h4>
						<div>
							<label>Rol:</label><span><?= $_SESSION['rol_name']; ?></span>
						</div>
						<div>
							<label>Usuario:</label><span><?= $_SESSION['user']; ?></span>
						</div>

						<h4>Cambiar contraseña</h4>
						<form action="" method="post" name="frmChangePass" id="frmChangePass">
							<div>
								<input type="password" name="txtPassUser" id="txtPassUser" placeholder="Contraseña actual" required>
							</div>
							<div>
								<input type="password" class="newPass" name="txtNewPassUser" id="txtNewPassUser" placeholder="Nueva contraseña" required>
							</div>
							<div>
								<input type="password" class="newPass" name="txtPassConfirm" id="txtPassConfirm" placeholder="Confirmar contraseña" required>
							</div>
							<div class="alertChangePass" style="display: none;">

							</div>
							<div>
								<button type="submit" class="btn_save btnChangePass"><i class="fas fa-key"></i> Cambiar contraseña</button>
							</div>
						</form>
					</div>
				</div>
				<div class="containerDataEmpresa">
					<div class="logoEmpresa">
						<img src="img/logoEmpresa.png" alt="">
					</div>
					<h4>Datos de la empresa</h4>

					<form action="" method="post" name="frmEmpresa" id="frmEmpresa">

						<input type="hidden" name="action" value="updateDataEmpresa">

						<div>
							<label>Nit:</label><input type="text" name="txtNit" id="txtNit" placeholder="Nit de la empresa" value="" required>
						</div>
						<div>
							<label>Nombre:</label><input type="text" name="txtNombre" id="txtNombre" placeholder="Nombre de la empresa" value="" required>
						</div>
						<div>
							<label>Razon social:</label><input type="text" name="txtRSocial" id="txtRSocial" placeholder="Razon social" value="">
						</div>
						<div>
							<label>Telèfono:</label><input type="text" name="txtTelEmpresa" id="txtTelEmpresa" placeholder="Nùmero de telèfono" value="" required>
						</div>
						<div>
							<label>Correo electrònico:</label><input type="email" name="txtEmailEmpresa" id="txtEmailEmpresa" placeholder="Correo electrònico" value="" required>
						</div>
						<div>
							<label>Direcciòn:</label><input type="text" name="txtDirEmpresa" id="txtDirEmpresa" placeholder="Direcciòn de la empresa" value="" required>
						</div>
						<div>
							<label>IVA (%):</label><input type="text" name="txtIva" id="txtIva" placeholder="Impuesto al valor agregado (IVA)" value="" required>
						</div>
						<div class="alertFormEmpresa" style="display: none;"></div>
						<div>
							<button type="submit" class="btn_save btnChangePass"><i class="fa fa-save" aria-hidden="true"></i> Guardar datos</button>
						</div>
					</form>

				</div>
			</div>
		</div>
	</section>

	<?php include "includes/footer.php"; ?>
</body>
</html>