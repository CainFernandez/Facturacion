$(document).ready(function(){

    //--------------------- SELECCIONAR FOTO PRODUCTO ---------------------
    $("#foto").on("change",function(){
    	var uploadFoto = document.getElementById("foto").value;
        var foto       = document.getElementById("foto").files;
        var nav = window.URL || window.webkitURL;
        var contactAlert = document.getElementById('form_alert');
        
            if(uploadFoto !='')
            {
                var type = foto[0].type;
                var name = foto[0].name;
                if(type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png')
                {
                    contactAlert.innerHTML = '<p class="errorArchivo">El archivo no es valido.</p>';                        
                    $("#img").remove();
                    $(".delPhoto").addClass('notBlock');
                    $('#foto').val('');
                    return false;
                }else{  
                        contactAlert.innerHTML='';
                        $("#img").remove();
                        $(".delPhoto").removeClass('notBlock');
                        var objeto_url = nav.createObjectURL(this.files[0]);
                        $(".prevPhoto").append("<img id='img' src="+objeto_url+">");
                        $(".upimg label").remove();
                        
                    }
              }else{
              	alert("No selecciono foto");
                $("#img").remove();
              }              
    });

    //REMOVER LA FOTO.
    $('.delPhoto').click(function(){
    	$('#foto').val('');
    	$(".delPhoto").addClass('notBlock');
    	$("#img").remove();

        //Remover foto para editar producto.
        if($("#foto_actual") && $("#foto_remove")){
            $("#foto_remove").val('img_producto.png');
        }

    });

    //--------------- MODAL FORMULARIO AGREGAR PRODUCTO ---------------//
    $('.add_product').click(function(e){
        e.preventDefault();
        var producto = $(this).attr('product');
        var action = 'infoProducto';

        //Extraer datos con AJAX
        $.ajax({
            url: 'ajax.php',
            type: 'POST',
            async: true,
            data: {action:action, producto:producto},

            success: function(response){

                //Conversion de JSON a objeto.
                if(response != 'error'){
                    var info = JSON.parse(response);

                    //$('#producto_id').val(info.codproducto);
                    //$('.nameProducto').html(info.descripcion);

                    $('.bodyModal').html('<form action="" method="post" name="form_add_product" id="form_add_product" onsubmit="event.preventDefault(); sendDataProduct();">'+
		                                  '<h1><i class="fa fa-cubes" aria-hidden="true" style="font-size:45pt;"></i><br> Agregar Producto</h1>'+
			                              '<h2 class="nameProducto">'+info.descripcion+'</h2><br>'+
			                              '<input type="number" name="cantidad" id="txtCantidad" placeholder="Cantidad del Producto" required><br>'+
			                              '<input type="text" name="precio" id="txtPrecio" placeholder="Precio del Producto" required>'+
			                              '<input type="hidden" name="producto_id" id="producto_id" value="'+info.codproducto+'" required>'+
			                              '<input type="hidden" name="action" value="addProduct" required>'+
			                              '<div class="alert alertAddProduct"></div>'+
			                              '<button type="submit" class="btn_new"><i class="fas fa-plus"></i> Agregar</button>'+
			                              '<a href="#" class="btn_ok closeModal" onclick="coloseModal();"><i class="fas fa-ban"></i> Cerrar</a>'+
		                                '</form>');
                }
            },

            error: function(error){
                console.log(error);
            },	
        });

        //Abrir modal
        $('.modal').fadeIn();
    });


     //--------------- MODAL FORMULARIO ELIMINAR PRODUCTO ---------------//
    $('.del_product').click(function(e){
        e.preventDefault();
        var producto = $(this).attr('product');
        var action = 'infoProducto';

        //Extraer datos con AJAX
        $.ajax({
            url: 'ajax.php',
            type: 'POST',
            async: true,
            data: {action:action, producto:producto},

            success: function(response){

                //Conversion de JSON a objeto.
                if(response != 'error'){
                    var info = JSON.parse(response);

                    //$('#producto_id').val(info.codproducto);
                    //$('.nameProducto').html(info.descripcion);

                    $('.bodyModal').html('<form action="" method="post" name="form_del_product" id="form_del_product" onsubmit="event.preventDefault(); delProduct();">'+
		                                  '<h1><i class="fa fa-cubes" aria-hidden="true" style="font-size:45pt;"></i><br> Eliminar Producto</h1>'+
			                              '<p>¿Està seguro de eliminar el siguiente registro?</p>'+
                                          '<h2 class="nameProducto">'+info.descripcion+'</h2><br>'+
			                              '<input type="hidden" name="producto_id" id="producto_id" value="'+info.codproducto+'" required>'+
			                              '<input type="hidden" name="action" value="delProduct" required>'+
			                              '<div class="alert alertAddProduct"></div>'+
                                          '<a href="#" class="btn_cancel"  onclick="coloseModal();"><i class="fa fa-ban" aria-hidden="true"></i> Cerrar</a>'+
				                          '<button type="submit" class="btn_ok"><i class="fa fa-trash-alt" aria-hidden="true"></i> Eliminar</button>'+
		                                '</form>');
                }
            },

            error: function(error){
                console.log(error);
            },	
        });

        //Abrir modal
        $('.modal').fadeIn();
    });

    //---------------- BUSCAR PRODUCTO POR PROVEEDOR ------------------//
    $('#search_proveedor').change(function(e){
        e.preventDefault();
        var sistema = getUrl();
        location.href = sistema+'buscar_productos.php?proveedor='+$(this).val();
    })
    
    
}); //End Ready

//Funcion buscar producto.
function getUrl(){
    var loc = window.location;
    var pathName = loc.pathname.substring(0, loc.pathname.lastIndexOf('/') + 1);
    return loc.href.substring(0, loc.href.length - ((loc.pathname + loc.search + loc.hash).length - pathName.length));
}

//Agregar producto a entradas con ajax
function sendDataProduct() {
    
    $('.alertAddProduct').html('');

    $.ajax({
        url: 'ajax.php',
        type: 'POST',
        async: true,
        data: $('#form_add_product').serialize(),

        //Mostra cantidad,precio sin necesidad recargar la  pagina.
        success: function(response){
            if(response == 'error')
            {
                $('.alertAddProduct').html('<p style="color:red;">Error al agregar el producto.</p>');
            }else{
                var info = JSON.parse(response);
                $('.row'+info.producto_id+' .celPrecio').html(info.nuevo_precio);
                $('.row'+info.producto_id+' .celExistencia').html(info.nueva_existencia);
                $('#txtCantidad').val('');
                $('#txtPrecio').val('');
                $('.alertAddProduct').html('<p>Producto guardado correctamente.</p>');
            }
        },

            error: function(error){
            console.log(error);
        },	
    });

}


//FUNCION ELIMINAR PRODUCTO
function delProduct() {
    
    var pr = $('#producto_id').val();
    $('.alertAddProduct').html('');

    $.ajax({
        url: 'ajax.php',
        type: 'POST',
        async: true,
        data: $('#form_del_product').serialize(),

        success: function(response){
            console.log(response);

            if(response == 'error')
            {
                $('.alertAddProduct').html('<p style="color:red;">Error al agregar el producto.</p>');

            }else{
                $('.row'+pr).remove();
                $('#form_del_product .btn_ok').remove();
                $('.alertAddProduct').html('<p>Producto eliminado correctamente.</p>');
            }
        },

            error: function(error){
            console.log(error);
        },	
    });

}

//Cerrar modal
function coloseModal(){

    $('#txtCantidad').val('');
    $('#txtPrecio').val('');
    $('.alertAddProduct').html('');
    $('.modal').fadeOut();
}

