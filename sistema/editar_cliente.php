<?php 

    session_start();
    include "../conexion.php";

    //--------- POST ------------.
    if(!empty($_POST))
    {
        $alert='';
        if (empty($_POST['nombre']) || empty($_POST['telefono']) || empty($_POST['direccion'])) 
        {
            $alert='<p class="msg_error">Todo los campos son obligatorios.</p>';
        }else{

            $idcliente = $_POST['id'];
            $nit       = $_POST['nit'];
            $nombre    = $_POST['nombre'];
            $telefono  = $_POST['telefono'];
            $direccion = $_POST['direccion'];
            
            $result = 0;
            //Condicion para NIT
            if(is_numeric($nit) && $nit != 0)
            {
                $query = mysqli_query($conection,"SELECT * FROM cliente
                                                    WHERE (nit = '$nit' AND idcliente != $idcliente)
                                                    ");
                
                $result = mysqli_fetch_array($query);
            }
            
            //Condicion para validar el formulario.
            if ($result > 0) {
                $alert = '<p class="msg_error">El nit ya existe, ingrese otro.</p>';
            } else {

                //Validar a nit a 0.
                if($nit == '')
                {
                    $nit = 0;
                }

                //Sql para actualizar datos.
                $sql_update = mysqli_query($conection, "UPDATE cliente
                                                        SET nit = $nit, nombre = '$nombre', telefono = '$telefono'
                                                            , direccion = '$direccion'
                                                        WHERE idcliente = $idcliente ");
            
                if ($sql_update) {
                    $alert = '<p class="msg_save">Cliente actualizado correctamente.</p>';
                } else {
                    $alert = '<p class="msg_error">Error al actualizar el cliente.</p>';
                }
            
            }
        
        } 
    }

    //---------- GET ------------//
    //-------Mostrar Datos-------.
    if(empty($_REQUEST['id']))
    {
        header('Location: lista_clientes.php');
        mysqli_close($conection);
    }
    $idcliente = $_REQUEST['id'];

    $sql = mysqli_query($conection, "SELECT * FROM cliente WHERE idcliente = $idcliente");
    mysqli_close($conection);
    $result_sql = mysqli_num_rows($sql);

    if($result_sql == 0){
        header('Location: lista_clientes.php');
    }else{
        
        while ($data = mysqli_fetch_array($sql)) {

            $idcliente = $data['idcliente'];
            $nit       = $data['nit'];
            $nombre    = $data['nombre'];
            $telefono  = $data['telefono'];
            $direccion = $data['direccion'];

        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Actualizar Cliente</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	
	<section id="container">

		<div class="form_register">
            <h1>Actualizar cliente</h1>
            <hr>
            <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

            <form action="" method="post">
                <input type="hidden" name="id" value="<?php echo $idcliente ?>">
                <label for="nit">NIT</label>
                <input type="number" name="nit" id="nit" placeholder="Número de NIT" value="<?php echo $nit ?>">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" placeholder="Nombre completo" value="<?php echo $nombre ?>">
                <label for="telefono">Teléfono</label>
                <input type="number" name="telefono" id="telefono" placeholder="Teléfono" value="<?php echo $telefono ?>">
                <label for="direccion">Dirección</label>
                <input type="text" name="direccion" id="direccion" placeholder="Dirección completa" value="<?php echo $direccion ?>">

                <input type="submit" value="Actualizar Cliente" class="btn_save">
                
            </form>

        </div>

	</section>

	<?php include "includes/footer.php"; ?>
</body>
</html>