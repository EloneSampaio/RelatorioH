$(document).ready(function() {

    tabela();
    busca();
    patchpanel();
    equipamentos();
    patchpanel1();
    equipamentos1();
    novo();
    pesquisaEquipamentos();
});




function patchpanel() {

    $.getJSON('http://relatorioh.com/patchpanel/listaPatch', {
    }).done(function(data) {
        $.each(data, function(id, valor) {
            $("#patch").append('<option value="' + valor.id + '">' + valor.nome + '</option>');

        });


        //evento change   
        $('#patch').on('change', function() {
            console.log($(this).val());
            $.getJSON('http://relatorioh.com/interfaces/ pesquisaInterfacePatchs/', {id: $(this).val(), ajax: 'true'}, function(data) {
                var html = '';
                var len = data.length;
                for (i = 0; i < len; i++) {
                    html += '<option value="' + data[i].nome + '">' + data[i].nome + '</option>';
                }
                $('#patch_porta').html(html);
            });
        });
    });
}


function patchpanel1() {

    $.getJSON('http://relatorioh.com/patchpanel/listaPatch', {
    }).done(function(data) {
        $.each(data, function(id, valor) {
            $("#patch1").append('<option value="' + valor.id + '">' + valor.nome + '</option>');

        });


        //evento change   
        $('#patch1').on('change', function() {
            console.log($(this).val());
            $.getJSON('http://relatorioh.com/interfaces/ pesquisaInterfacePatchs/', {id: $(this).val(), ajax: 'true'}, function(data) {
                var html = '';
                var len = data.length;
                for (i = 0; i < len; i++) {
                    html += '<option value="' + data[i].nome + '">' + data[i].nome + '</option>';
                }
                $('#patch_porta1').html(html);
            });
        });
    });
}













function equipamentos() {

    $.getJSON('http://relatorioh.com/equipamentos/listaEquipamento', {
    }).done(function(data) {
        $.each(data, function(id, valor) {
            $("#equipamento").append('<option value="' + valor.id + '">' + valor.nome + '</option>');

        });

        //evento change   
        $('#equipamento').on('change', function() {
            console.log($(this).val());
            $.getJSON('http://relatorioh.com/interfaces/ pesquisaInterface/', {id: $(this).val(), ajax: 'true'}, function(data) {
                var html = '';
                var len = data.length;
                for (i = 0; i < len; i++) {
                    html += '<option value="' + data[i].nome + '">' + data[i].nome + '</option>';
                }
                $('#equipamento_porta').html(html);
            });
        });
    });
}



function equipamentos1() {

    $.getJSON('http://relatorioh.com/equipamentos/listaEquipamento', {
    }).done(function(data) {
        $.each(data, function(id, valor) {
            $("#equipamento1").append('<option value="' + valor.id + '">' + valor.nome + '</option>');

        });

        //evento change   
        $('#equipamento1').on('change', function() {
            console.log($(this).val());
            $.getJSON('http://relatorioh.com/interfaces/ pesquisaInterface/', {id: $(this).val(), ajax: 'true'}, function(data) {
                var html = '';
                var len = data.length;
                for (i = 0; i < len; i++) {
                    html += '<option value="' + data[i].nome + '">' + data[i].nome + '</option>';
                }
                $('#equipamento_porta1').html(html);
            });
        });
    });
}




function novo() {

    $(document).on('submit', '#cabo', function() {

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


function tabela() {


    $('#tabela').dataTable({
        "pagingType": "full_numbers",
        "sDom": '<"H"Tlfr>t<"F"ip>',
        "oTableTools": {
            "sSwfPath": "https://datatables.net/release-datatables/extras/TableTools/media/swf/copy_csv_xls_pdf.swf",
            "aButtons": ["copy", "csv", "xls", "pdf", "print"]
        },
        "bSearchable": false,
        "bDestroy": true,
        "aoColumnDefs": [{
                'bSortable': false,
                'aTargets': [0, 1]
            }],
        "aLengthMenu": [[5, 10, 25, 50, 75, -1], [5, 10, 25, 50, 75, "All"]],
        "iDisplayLength": 5,
        "bJQueryUI": true,
        "oLanguage": {"sLengthMenu": "Mostrar _MENU_ registros por página", "sZeroRecords": "Nenhum registro encontrado", "sInfo": "Mostrando _START_ / _END_ de _TOTAL_ registro(s)", "sInfoEmpty": "Mostrando 0 / 0 de 0 registros", "sInfoFiltered": "(filtrado de _MAX_ registros)", "sSearch": "Pesquisar: ", "oPaginate": {"sFirst": "Início", "sPrevious": "Anterior", "sNext": "Próximo", "sLast": "Último"}}, "aaSorting": [[0, 'desc']], "aoColumnDefs": [{"sType": "num-html", "aTargets": [0]}]
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










