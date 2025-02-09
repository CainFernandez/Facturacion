<?php 

    session_start();
    if ($_SESSION['rol'] != 1) 
    {
        header("location: ./");
    }
    
    include "../conexion.php";

    //--------- POST ------------.
    if(!empty($_POST))
    {
        $alert='';
        if (empty($_POST['nombre']) || empty($_POST['correo']) || empty($_POST['usuario']) || empty($_POST['rol'])) 
        {
            $alert='<p class="msg_error">Todo los campos son obligatorios.</p>';
        }else{

            $idUsuario = $_POST['id'];
            $nombre = $_POST['nombre'];
            $email = $_POST['correo'];
            $user = $_POST['usuario'];
            $clave = md5($_POST['clave']);
            $rol = $_POST['rol'];

                                                       
            $query = mysqli_query($conection,"SELECT * FROM usuario 
                                                        WHERE (usuario = '$user' AND idUsuario != $idUsuario)
                                                        OR (correo = '$email' AND idUsuario != $idUsuario)");
            $result = mysqli_fetch_array($query);
            
            if ($result > 0) {
                $alert = '<p class="msg_error">El correo o el usuario ya existe.</p>';
            } else {

                if (empty($_POST['clave']))
                {
                    $sql_update = mysqli_query($conection, "UPDATE usuario
                                                            SET    nombre = '$nombre', correo = '$email', usuario ='$user', rol='$rol'
                                                            WHERE idusuario= $idUsuario");
                } else {
                    $sql_update = mysqli_query($conection, "UPDATE usuario
                                                            SET    nombre = '$nombre', correo = '$email', usuario ='$user',clave='$clave', rol='$rol'
                                                            WHERE idusuario= $idUsuario");                        
                }
            
                if ($sql_update) {
                    $alert = '<p class="msg_save">Usuario actualizado correctamente.</p>';
                } else {
                    $alert = '<p class="msg_error">Error al actualizar el usuario.</p>';
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