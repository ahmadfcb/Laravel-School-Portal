@push('head')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/jszip-2.5.0/dt-1.10.16/b-1.4.2/b-colvis-1.4.2/b-flash-1.4.2/b-html5-1.4.2/b-print-1.4.2/r-2.2.0/datatables.min.css"/>
@endpush

@push('body')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs/jszip-2.5.0/dt-1.10.16/b-1.4.2/b-colvis-1.4.2/b-flash-1.4.2/b-html5-1.4.2/b-print-1.4.2/r-2.2.0/datatables.min.js"></script>

    <script type="text/javascript">
        jQuery( function ( $ ) {
            $( ".dtable" ).each( function ( i, d ) {

                var messageTop = $( d ).attr( 'data-datatable-message-top' ) || null,
                    messageBottom = $( d ).attr( 'data-datatable-message-bottom' ) || null;

                $( d ).dataTable( {
                    dom: "<'dt-toolbar'<'col-xs-12 col-sm-4'f><'col-xs-12 col-sm-5 text-center'B><'col-xs-12 col-sm-3'l>r>" +
                    "t" +
                    "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
                    pageLength: 10,
                    lengthMenu: [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "All"]],
                    buttons: [
                        {
                            extend: 'print',
                            text: '<i class="fa fa-print" aria-hidden="true"></i>',
                            titleAttr: 'Print',
                            messageTop: messageTop,
                            messageBottom: messageBottom,
                            exportOptions: {
                                columns: ':visible',
                                stripHtml: false
                            },
                            customize: function ( win ) {
                                $( win.document.body )
                                    .css( 'font-size', '10pt' );
                            },
                            'footer': true
                        },
                        {
                            extend: 'pdf',
                            text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i>',
                            titleAttr: 'PDF',
                            messageTop: messageTop,
                            exportOptions: {
                                columns: ':visible',
                                stripHtml: false
                            },
                            'footer': true
                        },
                        {
                            extend: 'excel',
                            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                            titleAttr: 'Excel',
                            exportOptions: {
                                columns: ':visible',
                                stripHtml: false
                            },
                            'footer': true
                        },
                        {
                            extend: 'copy',
                            text: '<i class="fa fa-files-o" aria-hidden="true"></i>',
                            titleAttr: 'Copy',
                            exportOptions: {
                                columns: ':visible'
                            },
                            'footer': true
                        },
                        {
                            extend: 'colvis',
                            text: '<i class="fa fa-columns" aria-hidden="true"></i>',
                            titleAttr: 'Column visibility',
                            exportOptions: {
                                columns: ':visible'
                            }
                        }
                    ],
                    asSorting: [],
                    order: [],
                    columnDefs: []
                } );
            } );
        } );
    </script>
@endpush