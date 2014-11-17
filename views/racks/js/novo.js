
$(document).ready(function() {
    novo();
    tabela();
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


function tabela() {


    $('#tabela').dataTable({
        "pagingType": "full_numbers",
        "sDom": '<"H"Tlfr>t<"F"ip>',
        "oTableTools": {
            "sSwfPath": "https://datatables.net/release-datatables/extras/TableTools/media/swf/copy_csv_xls_pdf.swf",
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
        "oLanguage": {"sLengthMenu": "Mostrar _MENU_ registros por página", "sZeroRecords": "Nenhum registro encontrado", "sInfo": "Mostrando _START_ / _END_ de _TOTAL_ registro(s)", "sInfoEmpty": "Mostrando 0 / 0 de 0 registros", "sInfoFiltered": "(filtrado de _MAX_ registros)", "sSearch": "Pesquisar: ", "oPaginate": {"sFirst": "Início", "sPrevious": "Anterior", "sNext": "Próximo", "sLast": "Último"}}, "aaSorting": [[0, 'desc']], "aoColumnDefs": [{"sType": "num-html", "aTargets": [0]}]
    });
}


