"use strict";

require(['config'], function(config) {
    require.config({
        baseUrl: config.urlPublic + "webroot/",
        shim: {
            'jquery': {
                exports: '$'
            },
            'fnsGenerales': {
                deps: [ 'jquery' ],
                exports: 'fnsGenerales'
            },
            'jquery-ui': {
                deps: [ 'jquery' ]
            },
            'bootstrapjs': {
                deps: [ 'jquery' ]
            },
            'jquery.validate': {
                deps: [ 'jquery' ]
            },
            'datatables.net-bs': {
                deps: [ 'jquery', 'datatables.net' ]
            },
            'datatables.net-responsive-bs': {
                deps: [ 'jquery', 'datatables.net', 'datatables.net-responsive' ]
            },
            'pnotify': {
                deps: [ 'jquery' ],
                exports: 'PNotify'
            }
        },
        paths: {
            'jquery': 'libs/jquery/dist/jquery.min',
            'jquery-ui': 'libs/jquery-ui/jquery-ui.min',
            'bootstrapjs': 'libs/bootstrap/dist/js/bootstrap.min',
            'jquery.validate': 'libs/jquery.validate/dist/jquery.validate.min',
            'datatables.net': 'libs/datatables.net/js/jquery.dataTables.min',
            'datatables.net-bs': 'libs/datatables.net-bs/js/dataTables.bootstrap.min',            
            'datatables.net-responsive': 'libs/datatables.net-responsive/js/dataTables.responsive.min',
            'datatables.net-responsive-bs': 'libs/datatables.net-responsive-bs/js/responsive.bootstrap',
            'pnotify': 'libs/pnotify/dist/pnotify',

            'fnsGenerales': 'js/fnsGenerales',
        },
        // packages: [
        //     {
        //         name: 'jquery-ui',
        //         location: 'libs/jquery-ui/ui/minified'
        //     }
        // ]
    });
    require(['jquery', 'config', 'pnotify', 'bootstrapjs', 'datatables.net-bs', 'datatables.net-responsive-bs'], function($, config, PNotify){

        $('#flash-overlay-modal').modal();

        if ($('#pnotify-content').length) {
            new PNotify($.parseJSON($('#pnotify-content').val()));
        }

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
            // "dom": 'T<"clear">lfrtip',
            // "tableTools": {
            //     "sSwfPath": "//cdn.datatables.net/tabletools/2.2.4/swf/copy_csv_xls_pdf.swf",
            //     "aButtons": [ "xls", {
            //             "sExtends": "pdf",
            //             "sTitle": "Información"
            //         }],
            // },
            "responsive": true,
            "bStateSave": true,
        });

        $('[datatable-ajax]').DataTable({
            // bDestroy: true,
            // order: [],
            // aoColumnDefs: [
            //     { bSortable: false, aTargets: [ 0 ] }
            // ],
            // bLengthChange : false,
            // iDisplayLength: 10,
            bProcessing: true,
            bServerSide: true,
            sAjaxSource : 'utils/get_ajax_datatable',
            fnServerData : function(sSource, aoData, fnCallback, oSettings){
                // var valores = data.split("&");
                // var x = 0;
                // while (x<valores.length){
                //     var p = valores[x].split("=");
                //     aoData.push({"name" : p[0] , "value" : p[1]});
                //     x++;
                // }
                var datatable = $(this);
                var columns = [];
                datatable.find('thead th').each(function(key, value) {
                    columns.push($(this).data('name'));
                });
                aoData.push({"name" : "columns" , "value"  : columns});
                aoData.push({"name" : "model", "value" : datatable.data('model')});

                oSettings.jqXHR = $.ajax( {
                    dataType: 'JSON',
                    type: "POST",
                    url: sSource,
                    data: aoData,
                    success: function(data) {
                        // tableAcciones.find('div').each(function(key, value) {
                        //     var comp = $(this).data('comp');
                        //     var html = $(this).html();
                        //     $.each(data.aaData, function(key, value) {
                        //         if (data.aaData[key][0] == comp) {
                        //             data.aaData[key].push(html);
                        //         }
                        //     });
                        // });
                        console.log(data);
                        fnCallback(data);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        $("#error").html(jqXHR.responseText);
                        console.log(jqXHR.responseText);
                    }
                });
            },
            fnRowCallback: function( nRow, aData, iDisplayIndex ) {
                /* Append the grade to the default row class name */
                // var fila = $(nRow).closest('tr');
                // console.log(fila);
            },
            fnCreatedRow : function(nRow, aData, iDataIndex){
                var fila = $(nRow).closest('tr');
                console.log(fila);
                // console.log(fila.find("td.action"));
                // console.log(fila.find("td:last").html())
                // fila.append('<td>Accion</td>');
            },
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
            // "dom": 'T<"clear">lfrtip',
            // "tableTools": {
            //     "sSwfPath": "//cdn.datatables.net/tabletools/2.2.4/swf/copy_csv_xls_pdf.swf",
            //     "aButtons": [ "xls", {
            //             "sExtends": "pdf",
            //             "sTitle": "Información"
            //         }],
            // },
            "responsive": true,
            "bStateSave": true,
        });

    });
});
