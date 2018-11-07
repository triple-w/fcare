$(function(){

    $('.datetimepicker').daterangepicker({
        singleDatePicker: true,
        locale: {
            format: 'Y-MM-DD HH:mm',
        },
        minDate: moment().subtract(3, 'days').startOf('day'),
        maxDate: moment(),
        startDate: moment(),
        timePicker: true,
    });

    $('.datetimepagos').daterangepicker({
        singleDatePicker: true,
        locale: {
            format: 'Y-MM-DD HH:mm:ss',
        },
        maxDate: moment(),
        startDate: moment(),
        timePicker: true,
    });

    $('.datepicker').daterangepicker({
        singleDatePicker: true,
        locale: {
            format: 'Y-MM-DD',
        },
        startDate: moment(),
        parentEl:  $('.datepicker').data('parent')
    });

    $.extend( $.fn.dataTable.defaults, {
        autoWidth: false,
        columnDefs: [{
            orderable: false,
            width: '100px',
        }],
        dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
        language: {
            search: '<span>Filter:</span> _INPUT_',
            lengthMenu: '<span>Show:</span> _MENU_',
            paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
        },
        drawCallback: function () {
            $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
        },
        preDrawCallback: function() {
            $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
        }
    });

    $('[datatable]').DataTable({
        "language": {
            "sProcessing":    "Procesando...",
            "sLengthMenu":    "Mostrar _MENU_ registros",
            "sZeroRecords":   "No se encontraron resultados",
            "sEmptyTable":    "Ningún dato disponible en esta tabla",
            "sInfo":          "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty":     "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered":  "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":   "",
            "sSearch":        "Buscar:",
            "sUrl":           "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":    "Último",
                "sNext":    "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            },
        },
        "bStateSave": true,
    });

})