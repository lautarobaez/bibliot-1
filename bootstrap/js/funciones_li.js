$(document).ready(function(){
    var consulta;
    $("#txt_b_li").focus();

    $("#btn_b_li").click(function(){
        consulta = $("#txt_b_li").val();
        buscarImpresos(consulta);
    });

    $("#txt_b_li").keyup(function(e){
        if (e.which != 13){
            return;
        }
        consulta = $("#txt_b_li").val();
        buscarImpresos(consulta);
    });
    buscarImpresos('');
});

function buscarImpresos(consulta){
    $.ajax({
        type: "POST",
        url: "busqueda_li.php",
        data: "b="+consulta,
        dataType: "html",
        beforeSend: function(){
            $("#capa_lista_impreso").html("<p align='center'><img src='images/ajax-loader.gif' /></p>");
        },
        error: function(){
            alert("Error en la petición");
        },
        success: function(data){
            $("#capa_lista_impreso").empty();
            $("#capa_lista_impreso").append(data);
        }
    });
}

function editar_impreso(id){
    $.ajax({
        type: "POST",
        url: "edit_li.php",
        data: {operacion: 'edicion', id_imp: id}
    }).done(function (html) {
        $('#capa_impreso').html(html);
    });
}

function ver_impreso(id){
    $.ajax({
        type: "POST",
        url: "edit_li.php",
        data: {operacion: 'ver', id_imp: id}
    }).done(function (html) {
        $('#capa_impreso').html(html);
    });
}

function borrar_impreso(id){
    $.ajax({
        type: "POST",
        url: "edit_li.php",
        data: {operacion: 'baja', id_imp: id}
    }).done(function (html) {
        $('#capa_impreso').html(html);
    });
}

