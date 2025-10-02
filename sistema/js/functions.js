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

    $('.delPhoto').click(function(){
    	$('#foto').val('');
    	$(".delPhoto").addClass('notBlock');
    	$("#img").remove();

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

                    $('#producto_id').val(info.codproducto);
                    $('.nameProducto').html(info.descripcion);
                }
            },

            error: function(error){
                console.log(error);
            },	
        });

        //Abrir modal
        $('.modal').fadeIn();
    });
    
});

//Agregar producto a entradas con ajax
function sendDataProduct() {
    
    $('.alertAddProduct').html('');

    $.ajax({
        url: 'ajax.php',
        type: 'POST',
        async: true,
        data: $('#form_add_product').serialize(),

        success: function(response){
            console.log(response);
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

