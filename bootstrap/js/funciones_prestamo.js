$(document).ready(function(){
    $("#btn_b_prestamo").click(function(){
        buscarPrestamos($("#txt_b_prestamo").val());
    });

    $("#txt_b_prestamo").keyup(function(e){
        if (e.which != 13){
            return;
        }
        buscarPrestamos($("#txt_b_prestamo").val());
    });

    buscarPrestamos('');
});

function buscarPrestamos(consulta){
    $.ajax({
        type: "POST",
        url: "busqueda_prestamos.php",
        data: "b="+consulta,
        dataType: "html",
        beforeSend: function(){
            $("#capa_lista_prestamos").html("<p align='center'><img src='images/ajax-loader.gif' /></p>");
        },
        error: function(){
            alert("Error al buscar préstamos");
        },
        success: function(data){
            $("#capa_lista_prestamos").empty();
            $("#capa_lista_prestamos").append(data);
        }
    });
}

function devolver_prestamo(id){
    $.ajax({
        type: "POST",
        url: "edit_prestamo.php",
        data: {operacion: 'devolver', id_prestamo: id},
        error: function(){
            alert("No se pudo registrar la devolución");
        },
        success: function(html){
            $('#mensaje_prestamo_ajax').html(html);
            buscarPrestamos($("#txt_b_prestamo").val());
        }
    });
}


