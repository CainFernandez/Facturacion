<?php

    session_start();

    //Condicion solamente para Admi y Supervisor.
    if($_SESSION['rol'] != 1 and $_SESSION['rol'] != 2)
    {
        header("location: ./");
    }

    include "../conexion.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Lista de Proveedores</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	
	<section id="container">
        <?php 
            $busqueda = strtolower($_REQUEST['busqueda']);

            //Condicion para saber si existe lo que busca.
            if (empty($busqueda)) 
            {
                header("location: lista_proveedor.php");
                mysqli_close($conection);
            }
        
        ?>
		<h1><i class="fa fa-building" aria-hidden="true"></i> Lista de proveedores</h1>
        <a href="registro_proveedor.php" class="btn_new"><i class="fa fa-user-plus" aria-hidden="true"></i> Crear proveedor</a>

        <form action="buscar_proveedor.php" method="get" class="form_search">
            <input type="text" name="busqueda" id="busqueda" placeholder="Buscar" value="<?php  echo $busqueda;?> ">
            <button type="submit" class="btn_search"><i class="fa fa-search" aria-hidden="true"></i></button>
        </form>

        <table>
            <tr>
                <th>ID</th>
                <th>Proveedor</th>
                <th>Contacto</th>
                <th>Teléfono</th>
                <th>Dirección</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
            <?php
                
                //Paginador
                $sql_registe = mysqli_query($conection, "SELECT COUNT(*) as total_registro FROM proveedor 
                                                                    WHERE(  codproveedor LIKE '%$busqueda%' OR
                                                                            proveedor LIKE '%$busqueda%' OR
                                                                            contacto LIKE '%$busqueda%' OR
                                                                            telefono LIKE '%$busqueda%'
                                                                        ) 
                                                                    AND estatus = 1");

                $result_register = mysqli_fetch_array($sql_registe);
                $total_registro = $result_register['total_registro'];

                $por_pagina = 5;

                if(empty($_GET['pagina']))
                {
                    $pagina = 1;
                }else{
                    $pagina = $_GET['pagina'];
                }

                $desde = ($pagina-1) * $por_pagina;
                $total_paginas = ceil($total_registro / $por_pagina);

                $query = mysqli_query($conection,"SELECT * FROM proveedor WHERE
                                                    (  codproveedor  LIKE '%$busqueda%' OR
                                                        proveedor    LIKE '%$busqueda%' OR
                                                        contacto     LIKE '%$busqueda%' OR
                                                        telefono     LIKE '%$busqueda%' ) 
                                                    AND
                                                    estatus = 1 ORDER BY codproveedor ASC LIMIT $desde,$por_pagina
                ");
                mysqli_close($conection);

                $result = mysqli_num_rows($query);
                if ($result > 0) {
                    while ($data = mysqli_fetch_array($query)){
                    //Formato de Fecha
                    $formato = 'Y-m-d H:i:s';
                    $fecha   = DateTime::createFromFormat($formato,$data['date_add']);
            ?>
                <tr>
                    <td><?php echo $data["codproveedor"]; ?></td>
                    <td><?php echo $data["proveedor"]; ?></td>
                    <td><?php echo $data["contacto"]; ?></td>
                    <td><?php echo $data["telefono"]; ?></td>
                    <td><?php echo $data["direccion"]; ?></td>
                    <td><?php echo $fecha->format('d-m-Y'); ?></td>

                    <td>
                        <a class="link_edit" href="editar_proveedor.php?id=<?php echo $data["codproveedor"];?>"><i class="far fa-edit" aria-hidden="true"></i> Editar</a>
                        |
                        <a class="link_delete" href="eliminar_confirmar_proveedor.php?id=<?php echo $data["codproveedor"];?>"><i class="fa fa-trash-alt" aria-hidden="true"></i> Eliminar</a>
                        
                    </td>
                </tr>
            <?php
                    }
                }
            ?>
        </table>
        <?php
            if ($total_registro != 0) 
            {
        ?>
             <div class="paginador">
                <ul>
                    <?php
                        if($pagina != 1)
                        { 
                    ?>
                            <li><a href="?pagina=<?php echo 1; ?>&busqueda=<?php echo $busqueda; ?>"><i class="fa fa-step-backward" aria-hidden="true"></i></a></li>
                            <li><a href="?pagina=<?php echo $pagina-1; ?>&busqueda=<?php echo $busqueda; ?>"><i class="fa fa-caret-left" aria-hidden="true"></i></a></li>

                    <?php
                        }
                        for ($i=1; $i <= $total_paginas; $i++) { 
                            if($i == $pagina) {
                                echo '<li class="pageSelected">'.$i.'</li>';
                            } else {
                                echo '<li><a href="?pagina='.$i.'&busqueda='.$busqueda.'">'.$i.'</a></li>';
                            }
                        }
                        if($pagina != $total_paginas)
                            {
                    ?>
                            <li><a href="?pagina=<?php echo $pagina + 1; ?>&busqueda=<?php echo $busqueda; ?>"><i class="fa fa-caret-right" aria-hidden="true"></i></a></li>
                            <li><a href="?pagina=<?php echo $total_paginas; ?>&busqueda=<?php echo $busqueda; ?>"><i class="fa fa-step-forward" aria-hidden="true"></i></a></li>
                    <?php   } ?>
                </ul>
            </div>
        <?php } ?>

	</section>

	<?php include "includes/footer.php"; ?>
</body>
</html>