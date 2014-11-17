


$(document).ready(function() {
    tabela();
    busca();
    saudacao();

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
        notificacao(data.nome, data.mensagem, data.url);
    });
}


// READ USERS
function autoload() {
    setTimeout("$('#pageContent').load('http://relatorioh.com/dashboard/dados/', function(){ $('#loaderImage').hide(); });", 1000);
}

function tabela() {


    $('#tabela').dataTable({
        "pagingType": "full_numbers",
        "sDom": '<"H"Tlfr>t<"F"ip>',
        "oTableTools": {
            "sRowSelect": "multi",
            "aButtons": ["copy", "csv", "xls", "pdf", "print"]
        },
        "bDestroy": true,
       
        "aoColumnDefs": [{
                'bSortable': false,
                'aTargets': [0, 1]
            }],
        "aLengthMenu": [[5, 10, 25, 50, 75, -1], [5, 10, 25, 50, 75, "All"]],
        "iDisplayLength": 5,
        "bJQueryUI": true,
        "oLanguage": {"sLengthMenu":
                    "Mostrar _MENU_ registros por página",
            "sZeroRecords": "Nenhum registro encontrado",
            "sInfo": "Mostrando _START_ / _END_ de _TOTAL_ registro(s)",
            "sInfoEmpty": "Mostrando 0 / 0 de 0 registros",
            "sInfoFiltered": "(filtrado de _MAX_ registros)",
            "sSearch": "Pesquisar: ",
            "oPaginate": {"sFirst": "Início",
                "sPrevious": "Anterior",
                "sNext": "Próximo",
                "sLast": "Último"},
            "oFilterSelectedOptions": {
                AllText: "All Widgets",
                SelectedText: "Selected Widgets"
            }

        },
        "aaSorting": [[0, 'desc']],
        "aoColumnDefs": [{"sType": "num-html", "aTargets": [0]},
        ]

    });
}

function busca() {
    $("#pesquisa").keyup(function() {
        var index = $(this).parent().index();
        var nth = "#tabela td:nth-child(" + (index + 0).toString() + ")";
        var valor = $(this).val().toUpperCase();
        $("#tabela tbody tr").show();
        $(nth).each(function() {
            if ($(this).text().toUpperCase().indexOf(valor) < 0) {
                $(this).parent().hide();
            }
        });
    });

    $("#pesquisa").blur(function() {
        $(this).val("");
    });

}


