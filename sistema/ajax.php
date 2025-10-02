<?php
    include "../conexion.php";
    session_start();
    //print_r($_POST);exit;

    if(!empty($_POST)){

        //Extraer datos del producto
        if($_POST['action'] == 'infoProducto')
        {
            $producto_id = $_POST['producto'];
            $query = mysqli_query($conection, "SELECT codproducto,descripcion FROM producto
                                               WHERE  codproducto = $producto_id AND estatus = 1");

            mysqli_close($conection);

            $result = mysqli_num_rows($query);
            if($result > 0){
                $data = mysqli_fetch_assoc($query);
                echo json_encode($data,JSON_UNESCAPED_UNICODE);
                exit;
            }
            
            echo 'error';
            exit; 
        }

        //Agregar productos a entrada
        if($_POST['action'] == 'addProduct')
        {
            if(!empty($_POST['cantidad']) || !empty($_POST['precio']) || !empty($_POST['producto_id']))
            {
                $cantidad    = $_POST['cantidad'];
                $precio      = $_POST['precio'];
                $producto_id = $_POST['producto_id'];
                $usuario_id  = $_SESSION['idUser'];
                
                $query_insert = mysqli_query($conection, "INSERT INTO entradas(codproducto,cantidad,precio,usuario_id) 
                                                          VALUES($producto_id,$cantidad,$precio,$usuario_id)");
                                        
                if($query_insert){
                    //Ejecutar procedimiento almacenado.
                    $query_upd = mysqli_query($conection,"CALL actualizar_precio_producto($cantidad,$precio,$producto_id)");
                    $result_pro = mysqli_num_rows($query_upd);
                    if($result_pro > 0){

                        $data = mysqli_fetch_assoc($query_upd);
                        echo json_encode($data,JSON_UNESCAPED_UNICODE);
                        exit;
                    }
                }else{
                    echo 'Error';
                }
                mysqli_close($conection);
            }else{
                echo 'Erro';
            }
            exit;
        }
    }

    exit;
?>