$(document).ready(function() {

    $(':checkbox').checkboxpicker();
    $(activar);
    $("#opcao").change(activar);
    equipamentos();
    patchpanel();
    novo();



});




function patchpanel() {


    $.getJSON('http://relatorioh.com/patchpanel/listaPatch', {
    }).done(function(data) {
        $.each(data, function(id, valor) {
            $("#patch").append('<option value="' + valor.id + '">' + valor.nome + '</option>');

        });
    });
}



function equipamentos() {

    $.getJSON('http://relatorioh.com/equipamentos/listaEquipamento', {
    }).done(function(data) {
        console.log(data);
        $.each(data, function(id, valor) {
            $("#equipamento").append('<option value="' + valor.id + '">' + valor.nome + '</option>');

        });
    });
}


function novo() {

    $(document).on('submit', '#interface', function() {

        var url = $(this).attr('action');
        var data = $(this).serialize();
        $.post(url, data)
                .done(function(data) {
                    var json = $.parseJSON(data);
                    //alert(json.mensagem);
                    notificacao(json.mensagem);
                    if (json.status == "ok") {
                        redirecionar(url);
                    }
                    else {
                        return false;
                    }

                });

        return false;
    });
}


function notificacao(mensagem) {
    $.amaran({
        content: {
            bgcolor: '#8e44ad',
            color: '#fff',
            message: mensagem
        },
        theme: 'colorful',
        position: 'top right',
        closeButton: true,
        cssanimationIn: 'rubberBand',
        cssanimationOut: 'bounceOutUp'

    });

}

function redirecionar(url) {

    setTimeout(function() {
        window.location.href = url;
    }, 2000);
}


var activar = function() {


    if ($("#opcao").is(":checked")) {
        $('#equipamento').prop('disabled', 'disabled');
        $('#patch').prop('disabled', false);

    }
    else {
        $('#equipamento').prop('disabled', false);
        $('#patch').prop('disabled', 'disabled');
    }

}






