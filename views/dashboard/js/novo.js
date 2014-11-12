


$(document).ready(function() {
    novo();

    $('#tabela').dataTable({
        "pagingType": "full_numbers",
    }
    );

    // notificacao();


});



function notificacao(nome, mensagem, url) {
    $.amaran({
        content: {
            img: url + "views/layout/default/images/gravatar.jpg",
            user: nome,
            message: mensagem
        },
        theme: 'user green',
//        inEffect: 'slideBottom',
        position: 'top right',
        closeButton: true,
        cssanimationIn: 'rubberBand',
        cssanimationOut: 'bounceOutUp'
    });

//    $.amaran({
//        content: {
//            title: 'Your Download is Ready!',
//            message: '1.4 GB',
//            info: 'my_birthday.mp4',
//            icon: 'fa fa-download'
//        },
//        theme: 'awesome ok',
//        closeButton: true
//    });
}

function saudacao() {
    $.getJSON('http://relatorioh.com/dashboard/listarUsuario', function(data) {
        console.log(data.url);
        notificacao(data.nome, data.mensagem, data.url);

    });

}


// READ USERS
function autoload() {
    setTimeout("$('#pageContent').load('http://relatorioh.com/dashboard/dados/', function(){ $('#loaderImage').hide(); });", 1000);

}


function pesquisa() {
    $('#tabela').dataTable({
        "pagingType": "full_numbers"
    }
    );

}

