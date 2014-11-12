


$(document).ready(function() {
    dados();
    novo();
//    campos();

});

function novo() {

    $(document).on('submit', '#equipamento', function() {

        var url = $(this).attr('action');
        var data = $(this).serialize();
        $.post(url, data)
                .done(function(data) {
                    var json = $.parseJSON(data);
                    notificacao(json.mensagem);
                    console.log(json);
                    setTimeout(function() {
                        window.location.href = url;
                    }, 2000);
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



function dados() {
    $.getJSON('http://relatorioh.com/patchpanel/listaSelect', function(data) {
        var html = '';
        var len = data.length;
        for (i = 0; i < len; i++) {
            html += '<option value="' + data[i].id + '">' + data[i].nome + '</option>';
        }
        $('#patch').html(html);

    });

}




function campos() {
        var sheepItForm = $('#sheepItForm').sheepIt({
        separator: '',
        allowRemoveLast: true,
        allowRemoveCurrent: true,
        allowRemoveAll: true,
        allowAdd: true,
        allowAddN: true,
        maxFormsCount: 10,
        minFormsCount: 0,
        iniFormsCount: 2
    });

}




