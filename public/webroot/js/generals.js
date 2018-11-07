$(function(){
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
		"responsive": true
	});

//     $('.datetimepicker').datetimepicker({\
//         widgetPositioning: {\
//             horizontal: 'left'\
//         },\
//         icons: {\
//             time: "fa fa-clock-o",\
//             date: "fa fa-calendar",\
//             up: "fa fa-arrow-up",\
//             down: "fa fa-arrow-down"\
//         },\
//         format: 'Y-MM-DD HH:mm',\
//         minDate: moment().subtract(3, 'days').startOf('day'),\
//         maxDate: moment(),\
//         defaultDate: moment()\
//     });\
// \
//     $('.datepicker').datetimepicker({\
//         widgetPositioning: {\
//             horizontal: 'left'\
//         },\
//         icons: {\
//             time: "fa fa-clock-o",\
//             date: "fa fa-calendar",\
//             up: "fa fa-arrow-up",\
//             down: "fa fa-arrow-down"\
//         },\
//         format: 'Y-MM-DD',\
//         defaultDate: moment()\
//     });\
})