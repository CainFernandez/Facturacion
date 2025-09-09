<?php

    session_start();
    if ($_SESSION['rol'] != 1 && $_SESSION['rol'] != 2) 
    {
	    header("location: ./");
    }
    
	include "../conexion.php";

    if(!empty($_POST))
	{
        if(empty($_POST['idcliente']))
        {
            header("location: lista_clientes.php");
            mysqli_close($conection);
        }

		$idcliente = $_POST['idcliente'];

		$query_delete = mysqli_query($conection, "UPDATE cliente SET estatus = 0 WHERE idcliente = $idcliente");
		mysqli_close($conection);

		if($query_delete){
			header("location: lista_clientes.php");
		}else{
			echo "Error al eliminar";
		}
	}


    //Consultar a BD y mostrar datos.
    if(empty($_REQUEST['id'])) 
	{
		header("location: lista_clientes.php");
		mysqli_close($conection);

	} else {

		$idcliente = $_REQUEST['id'];

		$query = mysqli_query($conection, "SELECT * FROM cliente WHERE idcliente = $idcliente ");
		mysqli_close($conection);

		$result = mysqli_num_rows($query);

		if ($result > 0 ) {
			while($data = mysqli_fetch_array($query)){
				$nit  = $data['nit'];
				$nombre = $data['nombre'];
			}
		} else {
			header("location: lista_clientes.php");
		}
		
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Eliminar Cliente</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	
	<section id="container">
		<div class="data_delete">
			<i class="fa fa-user-times fa-7x" aria-hidden="true"></i>
			<br>
			<br>
			<h2>¿Está seguro de eliminar el siguiente registro?</h2>
			<p>Nombre del cliente: <span><?php echo $nombre; ?></span></p>
			<p>Nit: <span><?php echo $nit; ?></span></p>
			
			<form method="post" action="" >
                <input type="hidden" name="idcliente" value="<?php echo $idcliente; ?>">
				<a href="lista_clientes.php" class="btn_cancel"><i class="fa fa-ban" aria-hidden="true"></i> Cancelar</a>
				<button type="submit" class="btn_ok"><i class="fa fa-trash-alt" aria-hidden="true"></i> Eliminar</button>
			</form>
		</div>
	</section>

	<?php include "includes/footer.php"; ?>
</body>
</html>