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
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
            <tr>
                <td>1</td>
                <td>Jorge</td>
                <td>jorge@gmail.com</td>
                <td>Administrador</td>
                <td>
                    <a href="#" class="link_edit">Editar</a>
                    |
                    <a href="#" class="link_delete">Eliminar</a>
                </td>
            </tr>
            <tr>
                <td>1</td>
                <td>Jorge</td>
                <td>jorge@gmail.com</td>
                <td>Administrador</td>
                <td>
                    <a href="#" class="link_edit">Editar</a>
                    <a href="#" class="link_delete">Eliminar</a>
                </td>
            </tr>
            <tr>
                <td>1</td>
                <td>Jorge</td>
                <td>jorge@gmail.com</td>
                <td>Administrador</td>
                <td>
                    <a href="#" class="link_edit">Editar</a>
                    <a href="#" class="link_delete">Eliminar</a>
                </td>
            </tr>
            <tr>
                <td>1</td>
                <td>Jorge</td>
                <td>jorge@gmail.com</td>
                <td>Administrador</td>
                <td>
                    <a href="#" class="link_edit">Editar</a>
                    <a href="#" class="link_delete">Eliminar</a>
                </td>
            </tr>  
        </table>

	</section>

	<?php include "includes/footer.php"; ?>
</body>
</html>