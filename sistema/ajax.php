<?php
    include "../conexion.php";
    session_start();

    //print_r($_POST);exit;

    if(!empty($_POST)){

        //Extraer datos del producto
        if($_POST['action'] == 'infoProducto')
        {
            $producto_id = $_POST['producto'];
            $query = mysqli_query($conection, "SELECT codproducto,descripcion,existencia,precio FROM producto
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

                        $data['producto_id'] = $producto_id;
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

        //ELIMINAR PRODUCTO
         if($_POST['action'] == 'delProduct')
        {
            if(empty($_POST['producto_id']) || !is_numeric($_POST['producto_id'])){
                echo 'Error';
            }else{

                $idproducto = $_POST['producto_id'];
		        $query_delete = mysqli_query($conection, "UPDATE producto SET estatus = 0 WHERE codproducto = $idproducto");
		        mysqli_close($conection);

		        if($query_delete){
                    echo 'OK';
                }else{
			        echo 'Error';
                }
            }
            echo 'Error';
            exit;
        }

        //-------------- NUEVA VENTA LLAMANDO A 'BD' ------------------//
            //Buscar cliente.
            if($_POST['action'] == 'searchCliente')
            {
                if(!empty($_POST['cliente'])){

                    $nit = $_POST['cliente'];
                    $query = mysqli_query($conection,"SELECT * FROM cliente WHERE nit LIKE '$nit' AND estatus = 1");
                    mysqli_close($conection);
                    $result = mysqli_num_rows($query);

                    $data = '';
                    if($result > 0){
                        $data = mysqli_fetch_assoc($query);
                    }else{
                        $data = 0;
                    }
                    echo json_encode($data, JSON_UNESCAPED_UNICODE);
                }
                exit;
            }

            //Boton guardar nuevo cliente.
            if($_POST['action'] == 'addCliente')
            {
                $nit         = $_POST['nit_cliente'];
                $nombre      = $_POST['nom_cliente'];
                $telefono    = $_POST['tel_cliente'];
                $direccion   = $_POST['dir_cliente'];
                $usuario_id  = $_SESSION['idUser'];

                $query_insert = mysqli_query($conection, "INSERT INTO cliente(nit,nombre,telefono,direccion,usuario_id)
                                                          VALUES('$nit','$nombre','$telefono','$direccion','$usuario_id')");

                if($query_insert){
                    $codCliente = mysqli_insert_id($conection);
                    $msg = $codCliente;
                }else{
                    $msg = 'error';
                }
                mysqli_close($conection);
                echo $msg;
                exit; 
            }

            //Agregar producto al detalle temporal.
            if($_POST['action'] == 'addProductoDetalle'){

                if(empty($_POST['producto']) || empty($_POST['cantidad']))
                {
                    echo 'error';
                }else{
                    $codproducto = $_POST['producto'];
                    $cantidad    = $_POST['cantidad'];
                    $token       = md5($_SESSION['idUser']);

                    $query_iva = mysqli_query($conection, "SELECT iva from configuracion");
                    $result_iva = mysqli_num_rows($query_iva);

                    //Llamar al procedimiento almacenado.
                    $query_detalle_temp = mysqli_query($conection, "CALL add_detalle_temp($codproducto,$cantidad,'$token')");
                    $result = mysqli_num_rows($query_detalle_temp);

                    $detalleTabla = '';
                    $sub_total    = 0;
                    $iva          = 0;
                    $total        = 0;
                    $arrayData    = array();

                    if($result > 0){
                        if($result_iva > 0){
                            $info_iva = mysqli_fetch_assoc($query_iva);
                            $iva = $info_iva['iva'];
                        }

                        while($data = mysqli_fetch_assoc($query_detalle_temp)){
                            $precioTotal = round($data['cantidad'] * $data['precio_venta'], 2);
                            $sub_total   = round($sub_total + $precioTotal, 2);
                            $total       = round($total + $precioTotal, 2);

                            $detalleTabla .= '<tr>
                                                <td>'.$data['codproducto'].'</td>
                                                <td colspan="2">'.$data['descripcion'].'</td>
                                                <td class="textcenter">'.$data['cantidad'].'</td>
                                                <td class="textright">'.$data['precio_venta'].'</td>
                                                <td class="textright">'.$precioTotal.'</td>
                                                <td class="">
                                                <a href="#" class="link_delete" onclick="event.preventDefault(); del_product_detalle('.$data['codproducto'].');">
                                                <i class="fa fa-trash-alt" aria-hidden="true"></i></a>
                                                </td>
                                            </tr>
                            ';
                        }

                        $impuesto = round($sub_total * ($iva / 100), 2);
                        $tl_sniva = round($sub_total - $impuesto, 2);
                        $total    = round($tl_sniva + $impuesto, 2);

                        $detalleTotales = '<tr>
                                                <td colspan="5" class="textright">SUBTOTAL Q.</td>
                                                <td class="textright">'.$tl_sniva.'</td>
                                            </tr>
                                            <tr>
                                                <td colspan="5" class="textright">IVA ('.$iva.'%)</td>
                                                <td class="textright">'.$impuesto.'</td>
                                            </tr>
                                            <tr>
                                                <td colspan="5" class="textright">TOTAL Q.</td>
                                                <td class="textright">'.$total.'</td>
                                            </tr>

                        ';
                        $arrayData['detalle'] = $detalleTabla;
                        $arrayData['totales'] = $detalleTotales;

                        echo json_encode($arrayData,JSON_UNESCAPED_UNICODE);
                    }else{
                        echo 'error';
                    }
                    mysqli_close($conection);
                }
                exit;
            }

            //Extrae datos del detalle_temp sin recargar la pagina.
            if($_POST['action'] == 'serchForDetalle'){

                if(empty($_POST['user']))
                {
                    echo 'error';

                }else{

                    $token = md5($_SESSION['idUser']);
                    $query = mysqli_query($conection,"SELECT tmp.correlativo,
                                                             tmp.token_user,
                                                             tmp.cantidad,
                                                             tmp.precio_venta,
                                                             p.codproducto,
                                                             p.descripcion
                                                        FROM detalle_temp tmp
                                                        INNER JOIN producto p
                                                        ON tmp.codproducto = p.codproducto
                                                        WHERE token_user = '$token' ");

                    $result = mysqli_num_rows($query);

                    $query_iva = mysqli_query($conection, "SELECT iva from configuracion");
                    $result_iva = mysqli_num_rows($query_iva);

                    $detalleTabla = '';
                    $sub_total    = 0;
                    $iva          = 0;
                    $total        = 0;
                    $arrayData    = array();

                    if($result > 0){
                        if($result_iva > 0){
                            $info_iva = mysqli_fetch_assoc($query_iva);
                            $iva = $info_iva['iva'];
                        }

                        while($data = mysqli_fetch_assoc($query)){
                            $precioTotal = round($data['cantidad'] * $data['precio_venta'], 2);
                            $sub_total   = round($sub_total + $precioTotal, 2);
                            $total       = round($total + $precioTotal, 2);

                            $detalleTabla .= '<tr>
                                                <td>'.$data['codproducto'].'</td>
                                                <td colspan="2">'.$data['descripcion'].'</td>
                                                <td class="textcenter">'.$data['cantidad'].'</td>
                                                <td class="textright">'.$data['precio_venta'].'</td>
                                                <td class="textright">'.$precioTotal.'</td>
                                                <td class="">
                                                <a href="#" class="link_delete" onclick="event.preventDefault(); del_product_detalle('.$data['codproducto'].');">
                                                <i class="fa fa-trash-alt" aria-hidden="true"></i></a>
                                                </td>
                                            </tr>
                            ';
                        }

                        $impuesto = round($sub_total * ($iva / 100), 2);
                        $tl_sniva = round($sub_total - $impuesto, 2);
                        $total    = round($tl_sniva + $impuesto, 2);

                        $detalleTotales = '<tr>
                                                <td colspan="5" class="textright">SUBTOTAL Q.</td>
                                                <td class="textright">'.$tl_sniva.'</td>
                                            </tr>
                                            <tr>
                                                <td colspan="5" class="textright">IVA ('.$iva.'%)</td>
                                                <td class="textright">'.$impuesto.'</td>
                                            </tr>
                                            <tr>
                                                <td colspan="5" class="textright">TOTAL Q.</td>
                                                <td class="textright">'.$total.'</td>
                                            </tr>

                        ';
                        $arrayData['detalle'] = $detalleTabla;
                        $arrayData['totales'] = $detalleTotales;

                        echo json_encode($arrayData,JSON_UNESCAPED_UNICODE);
                    }else{
                        echo 'error';
                    }
                    mysqli_close($conection);
                }
                exit;
            }
        //---------END NUEVA VENTA.

    }
    exit;
?>