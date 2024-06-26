<?php

    include "../conexion.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Lista de usuarios</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	
	<section id="container">

		<h1>Lista de usuarios</h1>
        <a href="registro_usuario.php" class="btn_new">Crear usuario</a>

        <table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Usuario</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
            <?php
                $query = mysqli_query($conection, "SELECT u.idusuario, u.nombre, u.correo, u.usuario, r.rol FROM
                usuario u INNER JOIN rol r ON u.rol = r.idrol");

                $result = mysqli_num_rows($query);
                if ($result > 0) {
                    while ($data = mysqli_fetch_array($query)){

            ?>
                <tr>
                    <td><?php echo $data["idusuario"]; ?></td>
                    <td><?php echo $data["nombre"]; ?></td>
                    <td><?php echo $data["correo"]; ?></td>
                    <td><?php echo $data["usuario"]; ?></td>
                    <td><?php echo $data["rol"]; ?></td>
                    <td>
                        <a href="#" class="link_edit">Editar</a>
                        |
                        <a href="#" class="link_delete">Eliminar</a>
                    </td>
                </tr>
            <?php
                    }
                }
            ?>
        </table>

	</section>

	<?php include "includes/footer.php"; ?>
</body>
</html>