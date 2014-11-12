
$(document).ready(function() {
    novo();

    $('#tabela').dataTable({
        "pagingType": "full_numbers",
    }
    );

    // notificacao();


});

function novo() {
    $(document).on('submit', '#rack', function() {

        var url = $(this).attr('action');
        var data = $(this).serialize();
        $.post(url, data)
                .done(function(data) {
                    var json = $.parseJSON(data);
                    notificacao(json.mensagem);
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


