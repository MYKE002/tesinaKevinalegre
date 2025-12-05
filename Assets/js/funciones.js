let tblUsuarios, tblClientes, tblCajas, tblCategorias, tblProductos, t_h_c, t_h_v,
    t_arqueo, tblProductosLista, t_auditoria, tblProveedores;
//USUARIOS
document.addEventListener("DOMContentLoaded", function () {
    $('#cliente').select2();
    $('#proveedor').select2();

    //USUARIOS
    tblUsuarios = $('#tblUsuarios').DataTable({
        responsive: true,
        ajax: {
            url: base_url + "Usuarios/listar",
            dataSrc: '',
            error: function (xhr, error, code) {
                console.log('Error en AJAX:', error);
                console.log('Código:', code);
                console.log('Respuesta:', xhr.responseText);
                alert('Error al cargar usuarios. Ver consola para detalles.');
            }
        },
        columns: [
            {
                'data': 'id'
            },
            {
                'data': 'usuario'
            },
            {
                'data': 'nombre'
            },
            {
                'data': 'telefono'
            },
            {
                'data': 'correo'
            },
            {
                'data': 'caja'
            },
            {
                'data': 'rol'
            },
            {
                'data': 'estado'
            },
            {
                'data': 'acciones'
            }
        ],
        dom: "<'row d-flex align-items-center '<'col-sm-4'l><'col-sm-4 text-center 'B><'col-sm-4' f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons: [{
            //Botón para Excel
            extend: 'excelHtml5',
            footer: true,
            title: 'Reporte de Usuarios',
            titleAttr: 'Exportar a Excel',
            filename: 'Reporte de Usuarios',
            text: '<span class="badge badge-success p-2"><i class="fas fa-file-excel fa-2x"></i></span>'
        },
        //Botón para PDF
        {
            extend: 'pdfHtml5',
            download: 'open',
            footer: true,
            title: 'Reporte de Usuarios',
            filename: 'Reporte de Usuarios',
            text: '<span class="badge badge-danger p-2"><i class="fas fa-file-pdf fa-2x"></i></span>',
            exportOptions: {
                columns: [0, ':visible']
            }
        },
        //Botón para copiar
        {
            extend: 'copyHtml5',
            footer: true,
            title: 'Reporte de Usuarios',
            filename: 'Reporte de Usuarios',
            text: '<span class="badge  badge-primary p-2"><i class="fas fa-copy fa-2x"></i></span>',
            exportOptions: {
                columns: [0, ':visible']
            }
        },
        //Botón para print
        {
            extend: 'print',
            footer: true,
            title: 'Reporte de Usuarios',
            filename: 'Reporte de Usuarios',
            text: '<span class="badge badge-light p-2"><i class="fas fa-print fa-2x"></i></span>'
        },
        //Botón para cvs
        {
            extend: 'csvHtml5',
            footer: true,
            filename: 'Reporte de Usuarios',
            text: '<span class="badge badge-success p-2"><i class="fas fa-file-csv fa-2x"></i></span>'
        },
        {
            extend: 'colvis',
            text: '<span class="badge badge-info p-2"><i class="fas fa-columns fa-2x"></i></span>',
            postfixButtons: ['colvisRestore']
        }
        ]
    });
    //FIN DE LA TABLA USUARIOS
    //FIN DE LA TABLA USUARIOS

    //CLIENTES
    tblClientes = $('#tblClientes').DataTable({
        ajax: {
            url: base_url + "Clientes/listar",
            dataSrc: ''
        },
        columns: [
            {
                'data': 'id'
            },
            {
                'data': 'cedula'
            },
            {
                'data': 'nombre'
            },
            {
                'data': 'telefono'
            },
            {
                'data': 'correo'
            },
            {
                'data': 'direccion'
            },
            {
                'data': 'estado'
            },
            {
                'data': 'acciones'
            }
        ],
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json"
        },
        dom: "<'row d-flex align-items-center '<'col-sm-4'l><'col-sm-4 text-center 'B><'col-sm-4' f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons: [{
            //Botón para Excel
            extend: 'excelHtml5',
            footer: true,
            title: 'Reporte de Clientes',
            titleAttr: 'Exportar a Excel',
            filename: 'Reporte de Clientes',

            //Aquí es donde generas el botón personalizado
            text: '<span class="badge badge-success p-2"><i class="fas fa-file-excel fa-2x"></i></span>'
        },
        //Botón para PDF
        {
            extend: 'pdfHtml5',
            download: 'open',
            footer: true,
            title: 'Reporte de Clientes',
            filename: 'Reporte de Clientes',
            text: '<span class="badge badge-danger p-2"><i class="fas fa-file-pdf fa-2x"></i></span>',
            exportOptions: {
                columns: [0, ':visible']
            }
        },
        //Botón para copiar
        {
            extend: 'copyHtml5',
            footer: true,
            title: 'Reporte de Clientes',
            filename: 'Reporte de Clientes',
            text: '<span class="badge  badge-primary p-2"><i class="fas fa-copy fa-2x"></i></span>',
            exportOptions: {
                columns: [0, ':visible']
            }
        },
        //Botón para print
        {
            extend: 'print',
            footer: true,
            title: 'Reporte de Clientes',
            filename: 'Reporte de Clientes',
            text: '<span class="badge badge-light p-2"><i class="fas fa-print fa-2x"></i></span>'
        },
        //Botón para cvs
        {
            extend: 'csvHtml5',
            footer: true,
            filename: 'Reporte de Clientes',
            text: '<span class="badge badge-success p-2"><i class="fas fa-file-csv fa-2x"></i></span>'
        },
        {
            extend: 'colvis',
            text: '<span class="badge badge-info p-2"><i class="fas fa-columns fa-2x"></i></span>',
            postfixButtons: ['colvisRestore']
        }
        ]
    });
    //FIN DE LA TABLA CLIENTES

    //PROVEEDORES
    tblProveedores = $('#tblProveedores').DataTable({
        ajax: {
            url: base_url + "Proveedores/listar",
            dataSrc: ''
        },
        columns: [
            {
                'data': 'id'
            },
            {
                'data': 'ruc'
            },
            {
                'data': 'nombre'
            },
            {
                'data': 'telefono'
            },
            {
                'data': 'correo'
            },
            {
                'data': 'direccion'
            },
            {
                'data': 'estado'
            },
            {
                'data': 'acciones'
            }
        ],
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json"
        },
        dom: "<'row d-flex align-items-center '<'col-sm-4'l><'col-sm-4 text-center 'B><'col-sm-4' f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons: [{
            //Botón para Excel
            extend: 'excelHtml5',
            footer: true,
            title: 'Reporte de Proveedores',
            titleAttr: 'Exportar a Excel',
            filename: 'Reporte de Proveedores',

            //Aquí es donde generas el botón personalizado
            text: '<span class="badge badge-success p-2"><i class="fas fa-file-excel fa-2x"></i></span>'
        },
        //Botón para PDF
        {
            extend: 'pdfHtml5',
            download: 'open',
            footer: true,
            title: 'Reporte de Proveedores',
            filename: 'Reporte de Proveedores',
            text: '<span class="badge badge-danger p-2"><i class="fas fa-file-pdf fa-2x"></i></span>',
            exportOptions: {
                columns: [0, ':visible']
            }
        },
        //Botón para copiar
        {
            extend: 'copyHtml5',
            footer: true,
            title: 'Reporte de Proveedores',
            filename: 'Reporte de Proveedores',
            text: '<span class="badge  badge-primary p-2"><i class="fas fa-copy fa-2x"></i></span>',
            exportOptions: {
                columns: [0, ':visible']
            }
        },
        //Botón para print
        {
            extend: 'print',
            footer: true,
            title: 'Reporte de Proveedores',
            filename: 'Reporte de Proveedores',
            text: '<span class="badge badge-light p-2"><i class="fas fa-print fa-2x"></i></span>'
        },
        //Botón para cvs
        {
            extend: 'csvHtml5',
            footer: true,
            filename: 'Reporte de Proveedores',
            text: '<span class="badge badge-success p-2"><i class="fas fa-file-csv fa-2x"></i></span>'
        },
        {
            extend: 'colvis',
            text: '<span class="badge badge-info p-2"><i class="fas fa-columns fa-2x"></i></span>',
            postfixButtons: ['colvisRestore']
        }
        ]
    });
    //FIN PROVEEDORES

    //CAJAS
    tblCajas = $('#tblCajas').DataTable({
        ajax: {
            url: base_url + "Cajas/listar",
            dataSrc: ''
        },
        columns: [
            {
                'data': 'id'
            },
            {
                'data': 'caja'
            },
            {
                'data': 'estado'
            },
            {
                'data': 'acciones'
            }
        ],
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json"
        },
        dom: "<'row d-flex align-items-center '<'col-sm-4'l><'col-sm-4 text-center 'B><'col-sm-4' f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons: [{
            //Botón para Excel
            extend: 'excelHtml5',
            footer: true,
            title: 'Reporte de Cajas',
            titleAttr: 'Exportar a Excel',
            filename: 'Reporte de Cajas',

            //Aquí es donde generas el botón personalizado
            text: '<span class="badge badge-success p-2"><i class="fas fa-file-excel fa-2x"></i></span>'
        },
        //Botón para PDF
        {
            extend: 'pdfHtml5',
            download: 'open',
            footer: true,
            title: 'Reporte de Cajas',
            filename: 'Reporte de Cajas',
            text: '<span class="badge badge-danger p-2"><i class="fas fa-file-pdf fa-2x"></i></span>',
            exportOptions: {
                columns: [0, ':visible']
            }
        },
        //Botón para copiar
        {
            extend: 'copyHtml5',
            footer: true,
            title: 'Reporte de Cajas',
            filename: 'Reporte de Cajas',
            text: '<span class="badge  badge-primary p-2"><i class="fas fa-copy fa-2x"></i></span>',
            exportOptions: {
                columns: [0, ':visible']
            }
        },
        //Botón para print
        {
            extend: 'print',
            footer: true,
            title: 'Reporte de Cajas',
            filename: 'Reporte de Cajas',
            text: '<span class="badge badge-light p-2"><i class="fas fa-print fa-2x"></i></span>'
        },
        //Botón para cvs
        {
            extend: 'csvHtml5',
            footer: true,
            filename: 'Reporte de Cajas',
            text: '<span class="badge badge-success p-2"><i class="fas fa-file-csv fa-2x"></i></span>'
        },
        {
            extend: 'colvis',
            text: '<span class="badge badge-info p-2"><i class="fas fa-columns fa-2x"></i></span>',
            postfixButtons: ['colvisRestore']
        }
        ]
    });
    //FIN DE LA TABLA CAJAS

    //CATEGORÍAS
    tblCategorias = $('#tblCategorias').DataTable({
        ajax: {
            url: base_url + "Categorias/listar",
            dataSrc: ''
        },
        columns: [
            {
                'data': 'id'
            },
            {
                'data': 'nombre'
            },
            {
                'data': 'estado'
            },
            {
                'data': 'acciones'
            }
        ],
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json"
        },
        dom: "<'row d-flex align-items-center '<'col-sm-4'l><'col-sm-4 text-center 'B><'col-sm-4' f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons: [{
            //Botón para Excel
            extend: 'excelHtml5',
            footer: true,
            title: 'Reporte de Categorías',
            titleAttr: 'Exportar a Excel',
            filename: 'Reporte de Categorías',

            //Aquí es donde generas el botón personalizado
            text: '<span class="badge badge-success p-2"><i class="fas fa-file-excel fa-2x"></i></span>'
        },
        //Botón para PDF
        {
            extend: 'pdfHtml5',
            download: 'open',
            footer: true,
            title: 'Reporte de Categorías',
            filename: 'Reporte de Categorías',
            text: '<span class="badge badge-danger p-2"><i class="fas fa-file-pdf fa-2x"></i></span>',
            exportOptions: {
                columns: [0, ':visible']
            }
        },
        //Botón para copiar
        {
            extend: 'copyHtml5',
            footer: true,
            title: 'Reporte de Categorías',
            filename: 'Reporte de Categorías',
            text: '<span class="badge  badge-primary p-2"><i class="fas fa-copy fa-2x"></i></span>',
            exportOptions: {
                columns: [0, ':visible']
            }
        },
        //Botón para print
        {
            extend: 'print',
            footer: true,
            title: 'Reporte de Categorías',
            filename: 'Reporte de Categorías',
            text: '<span class="badge badge-light p-2"><i class="fas fa-print fa-2x"></i></span>'
        },
        //Botón para cvs
        {
            extend: 'csvHtml5',
            footer: true,
            filename: 'Reporte de Categorías',
            text: '<span class="badge badge-success p-2"><i class="fas fa-file-csv fa-2x"></i></span>'
        },
        {
            extend: 'colvis',
            text: '<span class="badge badge-info p-2"><i class="fas fa-columns fa-2x"></i></span>',
            postfixButtons: ['colvisRestore']
        }
        ]
    });
    //FIN DE LA TABLA CATEGORÍAS

    //PRODUCTOS
    tblProductos = $('#tblProductos').DataTable({
        responsive: true,
        ajax: {
            url: base_url + "Productos/listar",
            dataSrc: ''
        },
        columns: [
            {
                'data': 'id'
            },
            {
                'data': 'imagen'
            },
            {
                'data': 'codigo'
            },
            {
                'data': 'descripcion'
            },
            {
                'data': 'categoria'
            },
            {
                'data': 'precio_venta'
            },
            {
                'data': 'cantidad'
            },
            {
                'data': 'estado'
            },
            {
                'data': 'acciones'

            }
        ],
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json"
        },
        dom: "<'row d-flex align-items-center '<'col-sm-4'l><'col-sm-4 text-center 'B><'col-sm-4' f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons: [{
            //Botón para Excel
            extend: 'excelHtml5',
            footer: true,
            title: 'Reporte de Productos',
            titleAttr: 'Exportar a Excel',
            filename: 'Reporte de Productos',

            //Aquí es donde generas el botón personalizado
            text: '<span class="badge badge-success p-2"><i class="fas fa-file-excel fa-2x"></i></span>'
        },
        //Botón para PDF
        {
            extend: 'pdfHtml5',
            download: 'open',
            footer: true,
            title: 'Reporte de Productos',
            filename: 'Reporte de Productos',
            text: '<span class="badge badge-danger p-2"><i class="fas fa-file-pdf fa-2x"></i></span>',
            exportOptions: {
                columns: [0, ':visible']
            }
        },
        //Botón para copiar
        {
            extend: 'copyHtml5',
            footer: true,
            title: 'Reporte de Productos',
            filename: 'Reporte de Productos',
            text: '<span class="badge  badge-primary p-2"><i class="fas fa-copy fa-2x"></i></span>',
            exportOptions: {
                columns: [0, ':visible']
            }
        },
        //Botón para print
        {
            extend: 'print',
            footer: true,
            title: 'Reporte de Productos',
            filename: 'Reporte de Productos',
            text: '<span class="badge badge-light p-2"><i class="fas fa-print fa-2x"></i></span>'
        },
        //Botón para cvs
        {
            extend: 'csvHtml5',
            footer: true,
            filename: 'Reporte de Productos',
            text: '<span class="badge badge-success p-2"><i class="fas fa-file-csv fa-2x"></i></span>'
        },
        {
            extend: 'colvis',
            text: '<span class="badge badge-info p-2"><i class="fas fa-columns fa-2x"></i></span>',
            postfixButtons: ['colvisRestore']
        }
        ]

    });
    //FIN DE LA TABLA PRODUCTO

    //PRODUCTOS LISTA
    tblProductosLista = $('#tblProductosLista').DataTable({
        responsive: true,
        ajax: {
            url: base_url + "Productos/listar",
            dataSrc: ''
        },
        columns: [
            {
                'data': 'imagen'
            },
            {
                'data': 'codigo'
            },
            {
                'data': 'descripcion'
            },
            {
                'data': 'cantidad'
            }
        ],
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json"
        },
        dom: "<'row d-flex align-items-center text-center '<'col-12' f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons: [{
            //Botón para Excel
            extend: 'excelHtml5',
            footer: true,
            title: 'Reporte de Productos',
            titleAttr: 'Exportar a Excel',
            filename: 'Reporte de Productos',

            //Aquí es donde generas el botón personalizado
            text: '<span class="badge badge-success p-2"><i class="fas fa-file-excel fa-2x"></i></span>'
        },
        //Botón para PDF
        {
            extend: 'pdfHtml5',
            download: 'open',
            footer: true,
            title: 'Reporte de Productos',
            filename: 'Reporte de Productos',
            text: '<span class="badge badge-danger p-2"><i class="fas fa-file-pdf fa-2x"></i></span>',
            exportOptions: {
                columns: [0, ':visible']
            }
        },
        //Botón para copiar
        {
            extend: 'copyHtml5',
            footer: true,
            title: 'Reporte de Productos',
            filename: 'Reporte de Productos',
            text: '<span class="badge  badge-primary p-2"><i class="fas fa-copy fa-2x"></i></span>',
            exportOptions: {
                columns: [0, ':visible']
            }
        },
        //Botón para print
        {
            extend: 'print',
            footer: true,
            title: 'Reporte de Productos',
            filename: 'Reporte de Productos',
            text: '<span class="badge badge-light p-2"><i class="fas fa-print fa-2x"></i></span>'
        },
        //Botón para cvs
        {
            extend: 'csvHtml5',
            footer: true,
            filename: 'Reporte de Productos',
            text: '<span class="badge badge-success p-2"><i class="fas fa-file-csv fa-2x"></i></span>'
        },
        {
            extend: 'colvis',
            text: '<span class="badge badge-info p-2"><i class="fas fa-columns fa-2x"></i></span>',
            postfixButtons: ['colvisRestore']
        }
        ]

    });
    //FIN DE LA TABLA PRODUCTO

    //COMPRAS
    t_h_c = $('#t_historial_c').DataTable({
        ajax: {
            url: base_url + "Compras/listar_historial",
            dataSrc: ''
        },
        columns: [
            {
                'data': 'id'
            },
            {
                'data': 'proveedor'
            },
            {
                'data': 'total'
            },
            {
                'data': 'fecha'
            },

            {
                'data': 'estado'
            },
            {
                'data': 'acciones'
            },
        ],
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json"
        },
        dom: "<'row d-flex align-items-center '<'col-sm-4'l><'col-sm-4 text-center 'B><'col-sm-4' f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons: [{
            //Botón para Excel
            extend: 'excelHtml5',
            footer: true,
            title: 'Reporte Historial de Compras',
            titleAttr: 'Exportar a Excel',
            filename: 'Reporte de Cajas',

            //Aquí es donde generas el botón personalizado
            text: '<span class="badge badge-success p-2"><i class="fas fa-file-excel fa-2x"></i></span>'
        },
        //Botón para PDF
        {
            extend: 'pdfHtml5',
            download: 'open',
            footer: true,
            title: 'Reporte Historial de Compras',
            filename: 'Reporte Historial de Compras',
            text: '<span class="badge badge-danger p-2"><i class="fas fa-file-pdf fa-2x"></i></span>',
            exportOptions: {
                columns: [0, ':visible']
            }
        },
        //Botón para copiar
        {
            extend: 'copyHtml5',
            footer: true,
            title: 'Reporte Historial de Compras',
            filename: 'Reporte Historial de Compras',
            text: '<span class="badge  badge-primary p-2"><i class="fas fa-copy fa-2x"></i></span>',
            exportOptions: {
                columns: [0, ':visible']
            }
        },
        //Botón para print
        {
            extend: 'print',
            footer: true,
            title: 'Reporte Historial de Compras',
            filename: 'Reporte Historial de Compras',
            text: '<span class="badge badge-light p-2"><i class="fas fa-print fa-2x"></i></span>'
        },
        //Botón para cvs
        {
            extend: 'csvHtml5',
            footer: true,
            filename: 'Reporte Historial de Compras',
            text: '<span class="badge badge-success p-2"><i class="fas fa-file-csv fa-2x"></i></span>'
        },
        {
            extend: 'colvis',
            text: '<span class="badge badge-info p-2"><i class="fas fa-columns fa-2x"></i></span>',
            postfixButtons: ['colvisRestore']
        }
        ]
    });
    //FIN DE LA TABLA COMPRAS

    //VENTAS
    t_h_v = $('#t_historial_v').DataTable({
        ajax: {
            url: base_url + "Compras/listar_historial_venta",
            dataSrc: ''
        },
        columns: [
            { 'data': 'id' },
            { 'data': 'nombre' },
            { 'data': 'total' },
            { 'data': 'fecha' },
            { 'data': 'estado' },
            { 'data': 'acciones' }
        ],
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json"
        },
        dom: "<'row d-flex align-items-center '<'col-sm-4'l><'col-sm-4 text-center 'B><'col-sm-4' f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons: [{
            //Botón para Excel
            extend: 'excelHtml5',
            footer: true,
            title: 'Reporte Historial de Ventas',
            titleAttr: 'Exportar a Excel',
            filename: 'Reporte de Cajas',

            //Aquí es donde generas el botón personalizado
            text: '<span class="badge badge-success p-2"><i class="fas fa-file-excel fa-2x"></i></span>'
        },
        //Botón para PDF
        {
            extend: 'pdfHtml5',
            download: 'open',
            footer: true,
            title: 'Reporte Historial de Ventas',
            filename: 'Reporte Historial de Ventas',
            text: '<span class="badge badge-danger p-2"><i class="fas fa-file-pdf fa-2x"></i></span>',
            exportOptions: {
                columns: [0, ':visible']
            }
        },
        //Botón para copiar
        {
            extend: 'copyHtml5',
            footer: true,
            title: 'Reporte Historial de Ventas',
            filename: 'Reporte Historial de Ventas',
            text: '<span class="badge  badge-primary p-2"><i class="fas fa-copy fa-2x"></i></span>',
            exportOptions: {
                columns: [0, ':visible']
            }
        },
        //Botón para print
        {
            extend: 'print',
            footer: true,
            title: 'Reporte Historial de Ventas',
            filename: 'Reporte Historial de Ventas',
            text: '<span class="badge badge-light p-2"><i class="fas fa-print fa-2x"></i></span>'
        },
        //Botón para cvs
        {
            extend: 'csvHtml5',
            footer: true,
            filename: 'Reporte Historial de Ventas',
            text: '<span class="badge badge-success p-2"><i class="fas fa-file-csv fa-2x"></i></span>'
        },
        {
            extend: 'colvis',
            text: '<span class="badge badge-info p-2"><i class="fas fa-columns fa-2x"></i></span>',
            postfixButtons: ['colvisRestore']
        }
        ]
    });
    //FIN DE LA TABLA VENTAS

    //ARQUEO DE CAJA
    t_arqueo = $('#tArqueo').DataTable({
        ajax: {
            url: base_url + "Cajas/listar_arqueo",
            dataSrc: ''
        },
        columns: [
            {
                'data': 'id'
            },
            {
                'data': 'monto_inicial'
            },
            {
                'data': 'monto_final'
            },
            {
                'data': 'fecha_apertura'
            },
            {
                'data': 'fecha_cierre'
            },
            {
                'data': 'total_ventas'
            },
            {
                'data': 'monto_total'
            },
            {
                'data': 'estado'
            }
        ],
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json"
        },
        dom: "<'row d-flex align-items-center '<'col-sm-4'l><'col-sm-4 text-center 'B><'col-sm-4' f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons: [{
            //Botón para Excel
            extend: 'excelHtml5',
            footer: true,
            title: 'Reporte Arqueo de Caja',
            titleAttr: 'Exportar a Excel',
            filename: 'Reporte de Cajas',

            //Aquí es donde generas el botón personalizado
            text: '<span class="badge badge-success p-2"><i class="fas fa-file-excel fa-2x"></i></span>'
        },
        //Botón para PDF
        {
            extend: 'pdfHtml5',
            download: 'open',
            footer: true,
            title: 'Reporte Arqueo de Caja',
            filename: 'Reporte Arqueo de Caja',
            text: '<span class="badge badge-danger p-2"><i class="fas fa-file-pdf fa-2x"></i></span>',
            exportOptions: {
                columns: [0, ':visible']
            }
        },
        //Botón para copiar
        {
            extend: 'copyHtml5',
            footer: true,
            title: 'Reporte Arqueo de Caja',
            filename: 'Reporte Arqueo de Caja',
            text: '<span class="badge  badge-primary p-2"><i class="fas fa-copy fa-2x"></i></span>',
            exportOptions: {
                columns: [0, ':visible']
            }
        },
        //Botón para print
        {
            extend: 'print',
            footer: true,
            title: 'Reporte Arqueo de Caja',
            filename: 'Reporte Arqueo de Caja',
            text: '<span class="badge badge-light p-2"><i class="fas fa-print fa-2x"></i></span>'
        },
        //Botón para cvs
        {
            extend: 'csvHtml5',
            footer: true,
            filename: 'Reporte Arqueo de Caja',
            text: '<span class="badge badge-success p-2"><i class="fas fa-file-csv fa-2x"></i></span>'
        },
        {
            extend: 'colvis',
            text: '<span class="badge badge-info p-2"><i class="fas fa-columns fa-2x"></i></span>',
            postfixButtons: ['colvisRestore']
        }
        ]
    });
    //FIN DE LA TABLA ARQUEO DE CAJA

    //AUDITORIA
    t_auditoria = $('#tAuditoria').DataTable({
        ajax: {
            url: base_url + "Administracion/listar_auditoria",
            dataSrc: ''
        },
        columns: [
            {
                'data': 'id'
            },
            {
                'data': 'usuario'
            },
            {
                'data': 'movimiento'
            },
            {
                'data': 'fecha'
            }
        ],
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json"
        },
        dom: "<'row d-flex align-items-center '<'col-sm-4'l><'col-sm-4 text-center 'B><'col-sm-4' f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons: [{
            //Botón para Excel
            extend: 'excelHtml5',
            footer: true,
            title: 'Reporte Arqueo de Caja',
            titleAttr: 'Exportar a Excel',
            filename: 'Reporte de Cajas',

            //Aquí es donde generas el botón personalizado
            text: '<span class="badge badge-success p-2"><i class="fas fa-file-excel fa-2x"></i></span>'
        },
        //Botón para PDF
        {
            extend: 'pdfHtml5',
            download: 'open',
            footer: true,
            title: 'Reporte Arqueo de Caja',
            filename: 'Reporte Arqueo de Caja',
            text: '<span class="badge badge-danger p-2"><i class="fas fa-file-pdf fa-2x"></i></span>',
            exportOptions: {
                columns: [0, ':visible']
            }
        },
        //Botón para copiar
        {
            extend: 'copyHtml5',
            footer: true,
            title: 'Reporte Arqueo de Caja',
            filename: 'Reporte Arqueo de Caja',
            text: '<span class="badge  badge-primary p-2"><i class="fas fa-copy fa-2x"></i></span>',
            exportOptions: {
                columns: [0, ':visible']
            }
        },
        //Botón para print
        {
            extend: 'print',
            footer: true,
            title: 'Reporte Arqueo de Caja',
            filename: 'Reporte Arqueo de Caja',
            text: '<span class="badge badge-light p-2"><i class="fas fa-print fa-2x"></i></span>'
        },
        //Botón para cvs
        {
            extend: 'csvHtml5',
            footer: true,
            filename: 'Reporte Arqueo de Caja',
            text: '<span class="badge badge-success p-2"><i class="fas fa-file-csv fa-2x"></i></span>'
        },
        {
            extend: 'colvis',
            text: '<span class="badge badge-info p-2"><i class="fas fa-columns fa-2x"></i></span>',
            postfixButtons: ['colvisRestore']
        }
        ]
    });
    //FIN AUDITORIA
})

//incio para usuarios
// Función para abrir el modal de nuevo usuario
function frmUsuario() {
    document.getElementById("title").innerHTML = "AGREGAR USUARIO";
    document.getElementById("btnAccion").innerHTML = "Registrar";
    document.getElementById("claves").classList.remove("d-none");
    document.getElementById("frmUsuario").reset();
    $("#nuevo_usuario").modal("show");
    document.getElementById("id").value = "";
}

// Función para registrar o modificar usuario
function registrarUser(e) {
    e.preventDefault();

    const usuario = document.getElementById("usuario");
    const nombre = document.getElementById("nombre");
    const telefono = document.getElementById("telefono");
    const correo = document.getElementById("correo");
    const clave = document.getElementById("clave");
    const confirmar = document.getElementById("confirmar");
    const caja = document.getElementById("caja");
    const rol = document.getElementById("rol");

    // Expresiones regulares
    const expUsuario = /^[a-zA-Z0-9_-]{3,20}$/;
    const expNombre = /^[a-zA-ZÀ-ÿ\s]{3,100}$/;
    const expTelefono = /^[0-9\+\-\s]{10,16}$/;
    const expCorreo = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    // Limpiar clases previas
    usuario.classList.remove("is-invalid");
    nombre.classList.remove("is-invalid");
    telefono.classList.remove("is-invalid");
    correo.classList.remove("is-invalid");
    clave.classList.remove("is-invalid");
    confirmar.classList.remove("is-invalid");

    // Validaciones
    if (usuario.value == '' || nombre.value == '' || telefono.value == '' ||
        correo.value == '' || caja.value == '' || rol.value == '') {
        alertas('TODOS LOS CAMPOS SON OBLIGATORIOS', 'error');
        return false;
    }

    if (!expUsuario.test(usuario.value)) {
        usuario.classList.add("is-invalid");
        alertas('El usuario no es válido', 'error');
        return false;
    }

    if (!expNombre.test(nombre.value)) {
        nombre.classList.add("is-invalid");
        alertas('El nombre no es válido', 'error');
        return false;
    }

    if (!expTelefono.test(telefono.value)) {
        telefono.classList.add("is-invalid");
        alertas('El teléfono no es válido', 'error');
        return false;
    }

    if (!expCorreo.test(correo.value)) {
        correo.classList.add("is-invalid");
        alertas('El correo no es válido', 'error');
        return false;
    }

    // Si es un nuevo usuario, validar contraseñas
    const id = document.getElementById("id").value;
    if (id == "") {
        if (clave.value == '' || confirmar.value == '') {
            alertas('LA CONTRASEÑA ES OBLIGATORIA', 'error');
            return false;
        }

        if (clave.value.length < 6) {
            clave.classList.add("is-invalid");
            alertas('La contraseña debe tener al menos 6 caracteres', 'error');
            return false;
        }

        if (clave.value != confirmar.value) {
            confirmar.classList.add("is-invalid");
            alertas('LAS CONTRASEÑAS NO COINCIDEN', 'error');
            return false;
        }
    }

    // Enviar formulario
    const url = base_url + "Usuarios/registrar";
    const frm = document.getElementById("frmUsuario");
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);

            if (res.icono == 'success') {
                $("#nuevo_usuario").modal("hide");
                tblUsuarios.ajax.reload();
            }

            alertas(res.msg, res.icono);
        }
    }
}

// Función para editar usuario
function btnEditarUser(id) {
    document.getElementById("title").innerHTML = "MODIFICAR USUARIO";
    document.getElementById("btnAccion").innerHTML = "Actualizar";

    const url = base_url + "Usuarios/editar/" + id;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);

            document.getElementById("id").value = res.id;
            document.getElementById("usuario").value = res.usuario;
            document.getElementById("nombre").value = res.nombre;
            document.getElementById("telefono").value = res.telefono;
            document.getElementById("correo").value = res.correo;
            document.getElementById("caja").value = res.id_caja;
            document.getElementById("rol").value = res.id_rol;

            // Ocultar campos de contraseña al editar
            document.getElementById("claves").classList.add("d-none");

            $("#nuevo_usuario").modal("show");
        }
    }
}

// Función para eliminar (desactivar) usuario
function btnEliminarUser(id) {
    Swal.fire({
        title: '¿Está seguro de desactivar este usuario?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, desactivar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Usuarios/eliminar/" + id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    alertas(res.msg, res.icono);
                    tblUsuarios.ajax.reload();
                }
            }
        }
    });
}

// Función para reactivar usuario
function btnReingresarUser(id) {
    Swal.fire({
        title: '¿Está seguro de activar este usuario?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, activar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Usuarios/reingresar/" + id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    alertas(res.msg, res.icono);
                    tblUsuarios.ajax.reload();
                }
            }
        }
    });
}

// Función para cambiar contraseña desde el perfil
function frmCambiarPass(e) {
    e.preventDefault();

    const actual = document.getElementById("clave_actual");
    const nueva = document.getElementById("clave_nueva");
    const confirmar = document.getElementById("confirmar_clave");

    if (actual.value == '' || nueva.value == '' || confirmar.value == '') {
        alertas('TODOS LOS CAMPOS SON OBLIGATORIOS', 'error');
        return false;
    }

    if (nueva.value.length < 6) {
        alertas('La nueva contraseña debe tener al menos 6 caracteres', 'error');
        return false;
    }

    if (nueva.value != confirmar.value) {
        alertas('LAS CONTRASEÑAS NO COINCIDEN', 'error');
        return false;
    }

    const url = base_url + "Usuarios/cambiarPass";
    const frm = document.getElementById("frmCambiarPass");
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);

            if (res.icono == 'success') {
                $("#cambiarPass").modal("hide");
                frm.reset();
            }

            alertas(res.msg, res.icono);
        }
    }
}

//FIN USUARIOS

//CLIENTES
function frmCliente() {
    document.getElementById("title").innerHTML = "Agregar Cliente";
    document.getElementById("btnAccion").innerHTML = "Registrar";
    document.getElementById("frmCliente").reset();
    $("#nuevo_cliente").modal();
    document.getElementById("id").value = "";
}

function registrarCli(e) {
    e.preventDefault();
    const cedula = document.getElementById("cedula");
    const nombre = document.getElementById("nombre");
    const telefono = document.getElementById("telefono");
    const correo = document.getElementById("correo");
    const direccion = document.getElementById("direccion");
    const expCedulaRuc = /^[0-9a-zA-Z\-\s]{5,20}$/;
    const expNombre = /^[a-zA-ZÀ-ÿ\s]{3,100}$/; //Letras y espacios, pueden llevar acentos
    const expTelefono = /^[0-9\+\-\(\)\s]{10,16}$/;
    const expCorreo = /^[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/;
    const expDireccion = /^.{5,200}$/;


    if (cedula.value == "" || nombre.value == "" || telefono.value == "" || direccion.value == "") {
        alertas("TODOS LOS CAMPOS SON OBLIGATORIOS!", 'warning');
    } else if (!(expCedulaRuc.test(cedula.value))) {
        cedula.classList.add("is-invalid");
    } else if (!(expNombre.test(nombre.value))) {
        cedula.classList.remove("is-invalid");
        nombre.classList.add("is-invalid");
    } else if (!(expTelefono.test(telefono.value))) {
        nombre.classList.remove("is-invalid");
        telefono.classList.add("is-invalid");
    } else if (!(expDireccion.test(direccion.value))) {
        telefono.classList.remove("is-invalid");
        direccion.classList.add("is-invalid");
    } else if (correo.value != '') {
        if (!(expCorreo.test(correo.value))) {
            direccion.classList.remove("is-invalid");
            correo.classList.add("is-invalid");
        } else {
            cedula.classList.remove("is-invalid");
            nombre.classList.remove("is-invalid");
            telefono.classList.remove("is-invalid");
            direccion.classList.remove("is-invalid");
            correo.classList.remove("is-invalid");
            const url = base_url + "Clientes/registrar";
            const frm = document.getElementById("frmCliente");
            const http = new XMLHttpRequest();
            http.open("POST", url, true);
            http.send(new FormData(frm));
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    alertas(res.msg, res.icono);

                    if (res.icono == 'success') {
                        frm.reset();
                        $("#nuevo_cliente").modal("hide");
                        tblClientes.ajax.reload();
                    }
                }
            }
        }
    } else {
        cedula.classList.remove("is-invalid");
        nombre.classList.remove("is-invalid");
        telefono.classList.remove("is-invalid");
        direccion.classList.remove("is-invalid");
        correo.classList.remove("is-invalid");
        const url = base_url + "Clientes/registrar";
        const frm = document.getElementById("frmCliente");
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(new FormData(frm));
        http.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                console.log(this.responseText);
                const res = JSON.parse(this.responseText);
                alertas(res.msg, res.icono);

                if (res.icono == 'success') {
                    frm.reset();
                    $("#nuevo_cliente").modal("hide");
                    tblClientes.ajax.reload();
                }
            }
        }
    }
}

function btnEditarCli(id) {
    document.getElementById("title").innerHTML = "Actualizar Cliente";
    document.getElementById("btnAccion").innerHTML = "Actualizar";
    const url = base_url + "Clientes/editar/" + id;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            document.getElementById("id").value = res.id;
            document.getElementById("cedula").value = res.cedula;
            document.getElementById("nombre").value = res.nombre;
            document.getElementById("telefono").value = res.telefono;
            document.getElementById("correo").value = res.correo;
            document.getElementById("direccion").value = res.direccion;
            cedula.classList.remove("is-invalid");
            nombre.classList.remove("is-invalid");
            telefono.classList.remove("is-invalid");
            direccion.classList.remove("is-invalid");
            correo.classList.remove("is-invalid");
            $("#nuevo_cliente").modal("show");
        }
    }

}

function btnEliminarCli(id) {
    Swal.fire({
        title: 'Está seguro de eliminar?',
        text: "El cliente no se eliminará de forma permanente, solo estará inactivo!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Clientes/eliminar/" + id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    alertas(res.msg, res.icono);
                    tblClientes.ajax.reload();
                }
            }

        }
    })
}

function btnReactivarCli(id) {
    Swal.fire({
        title: 'Está seguro de reingresar?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Clientes/reactivar/" + id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    alertas(res.msg, res.icono);
                    tblClientes.ajax.reload();
                }
            }

        }
    })
}
//FIN CLIENTES



//PROVEEDORES
function frmProveedor() {
    document.getElementById("title").innerHTML = "Agregar Proveedor";
    document.getElementById("btnAccion").innerHTML = "Registrar";
    document.getElementById("frmProveedor").reset();
    $("#nuevo_proveedor").modal();
    document.getElementById("id").value = "";
}


function registrarProv(e) {
    e.preventDefault();
    const ruc = document.getElementById("ruc");
    const nombre = document.getElementById("nombre");
    const telefono = document.getElementById("telefono");
    const correo = document.getElementById("correo");
    const direccion = document.getElementById("direccion");
    const exprucRuc = /^[0-9a-zA-Z\-\s]{5,20}$/;
    const expNombre = /^[a-zA-ZÀ-ÿ\s]{3,100}$/; //Letras y espacios, pueden llevar acentos
    const expTelefono = /^[0-9\+\-\(\)\s]{10,30}$/;
    const expCorreo = /^[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/;
    const expDireccion = /^.{5,200}$/;


    if (ruc.value == "" || nombre.value == "" || telefono.value == "" || direccion.value == "") {
        alertas("TODOS LOS CAMPOS SON OBLIGATORIOS!", 'warning');
    } else if (!(exprucRuc.test(ruc.value))) {
        ruc.classList.add("is-invalid");
    } else if (!(expNombre.test(nombre.value))) {
        ruc.classList.remove("is-invalid");
        nombre.classList.add("is-invalid");
    } else if (!(expTelefono.test(telefono.value))) {
        nombre.classList.remove("is-invalid");
        telefono.classList.add("is-invalid");
    } else if (!(expDireccion.test(direccion.value))) {
        telefono.classList.remove("is-invalid");
        direccion.classList.add("is-invalid");
    } else if (correo.value != '') {
        if (!(expCorreo.test(correo.value))) {
            direccion.classList.remove("is-invalid");
            correo.classList.add("is-invalid");
        } else {
            ruc.classList.remove("is-invalid");
            nombre.classList.remove("is-invalid");
            telefono.classList.remove("is-invalid");
            direccion.classList.remove("is-invalid");
            correo.classList.remove("is-invalid");
            const url = base_url + "Proveedores/registrar";
            const frm = document.getElementById("frmProveedor");
            const http = new XMLHttpRequest();
            http.open("POST", url, true);
            http.send(new FormData(frm));
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    alertas(res.msg, res.icono);

                    if (res.icono == 'success') {
                        frm.reset();
                        $("#nuevo_proveedor").modal("hide");
                        tblProveedores.ajax.reload();
                    }
                }
            }
        }
    } else {
        ruc.classList.remove("is-invalid");
        nombre.classList.remove("is-invalid");
        telefono.classList.remove("is-invalid");
        direccion.classList.remove("is-invalid");
        correo.classList.remove("is-invalid");
        const url = base_url + "Proveedores/registrar";
        const frm = document.getElementById("frmProveedor");
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(new FormData(frm));
        http.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                console.log(this.responseText);
                const res = JSON.parse(this.responseText);
                alertas(res.msg, res.icono);

                if (res.icono == 'success') {
                    frm.reset();
                    $("#nuevo_proveedor").modal("hide");
                    tblProveedores.ajax.reload();
                }
            }
        }
    }
}

function btnEditarProv(id) {
    document.getElementById("title").innerHTML = "Actualizar Proveedor";
    document.getElementById("btnAccion").innerHTML = "Actualizar";
    const url = base_url + "Proveedores/editar/" + id;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            const res = JSON.parse(this.responseText);
            document.getElementById("id").value = res.id;
            document.getElementById("ruc").value = res.ruc;
            document.getElementById("nombre").value = res.nombre;
            document.getElementById("telefono").value = res.telefono;
            document.getElementById("correo").value = res.correo;
            document.getElementById("direccion").value = res.direccion;
            ruc.classList.remove("is-invalid");
            nombre.classList.remove("is-invalid");
            telefono.classList.remove("is-invalid");
            direccion.classList.remove("is-invalid");
            correo.classList.remove("is-invalid");
            $("#nuevo_proveedor").modal("show");
        }
    }

}

function btnEliminarProv(id) {
    Swal.fire({
        title: 'Está seguro de eliminar?',
        text: "El proveedor no se eliminará de forma permanente, solo estará inactivo!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Proveedores/eliminar/" + id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    console.log(this.responseText);
                    const res = JSON.parse(this.responseText);
                    alertas(res.msg, res.icono);
                    tblProveedores.ajax.reload();
                }
            }

        }
    })
}

function btnReactivarProv(id) {
    Swal.fire({
        title: 'Está seguro de reingresar?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Proveedores/reactivar/" + id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    alertas(res.msg, res.icono);
                    tblProveedores.ajax.reload();
                }
            }

        }
    })
}
//FIN PROVEEDORES

//CAJAS
function frmCaja() {
    document.getElementById("title").innerHTML = "Agregar Caja";
    document.getElementById("btnAccion").innerHTML = "Registrar";
    document.getElementById("frmCaja").reset();
    $("#nueva_caja").modal();
    document.getElementById("id").value = "";
}

function registrarCaja(e) {
    e.preventDefault();
    const caja = document.getElementById("caja");
    const expCaja = /^[a-zA-Z0-9\_\-]{3,20}$/; //Letras, numeros, guion y guion_bajo

    if (caja.value == "") {
        Swal.fire({
            position: 'center',
            icon: 'warning',
            title: 'TODOS LOS CAMPOS SON OBLIGATORIOS',
            showConfirmButton: false,
            timer: 3000
        })
    } else if (!(expCaja.test(caja.value))) {
        caja.classList.add("is-invalid");
    } else {
        const url = base_url + "Cajas/registrar";
        const frm = document.getElementById("frmCaja");
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(new FormData(frm));
        http.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                const res = JSON.parse(this.responseText);
                alertas(res.msg, res.icono);
                if (res.icono == 'success') {
                    caja.classList.remove("is-invalid");
                    $("#nueva_caja").modal("hide");
                    tblCajas.ajax.reload();
                }
            }
        }
    }

}

function btnEditarCaja(id) {
    document.getElementById("title").innerHTML = "Actualizar Caja";
    document.getElementById("btnAccion").innerHTML = "Actualizar";
    const url = base_url + "Cajas/editar/" + id;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            document.getElementById("id").value = res.id;
            document.getElementById("caja").value = res.caja;
            $("#nueva_caja").modal("show");
        }
    }

}

function btnEliminarCaja(id) {
    Swal.fire({
        title: 'Está seguro de eliminar?',
        text: "La caja no se eliminará de forma permanente, solo estaría inactivo!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Cajas/eliminar/" + id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    alertas(res.msg, res.icono);
                    $("#nueva_caja").modal("hide");
                    tblCajas.ajax.reload();
                }

            }
        }
    });
}

function btnReactivarCaja(id) {
    Swal.fire({
        title: 'Está seguro de reingresar?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Cajas/reactivar/" + id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    alertas(res.msg, res.icono);
                    tblCajas.ajax.reload();
                }
            }

        }
    })
}
//FIN CAJAS

//CATEGORIAS
function frmCat() {
    document.getElementById("title").innerHTML = "Agregar Categoría";
    document.getElementById("btnAccion").innerHTML = "Registrar";
    document.getElementById("frmCat").reset();
    $("#nueva_categoria").modal();
    document.getElementById("id").value = "";
}

function registrarCat(e) {
    e.preventDefault();
    const nombre = document.getElementById("nombre");
    const expNombre = /^.{3,50}$/;

    if (nombre.value == "") {
        alertas('CAMPO OBLIGATORIO!', 'warning');
    } else if (!(expNombre.test(nombre.value))) {
        nombre.classList.add("is-invalid");
    } else {
        nombre.classList.remove("is-invalid");
        const url = base_url + "Categorias/registrar";
        const frm = document.getElementById("frmCat");
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(new FormData(frm));
        http.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                console.log(this.responseText);
                const res = JSON.parse(this.responseText);
                alertas(res.msg, res.icono);
                if (res.icono == 'success') {
                    frm.reset();
                    $("#nueva_categoria").modal("hide");
                    tblCategorias.ajax.reload();
                }
            }
        }
    }

}

function btnEditarCat(id) {
    document.getElementById("title").innerHTML = "Actualizar Categoría";
    document.getElementById("btnAccion").innerHTML = "Actualizar";
    const url = base_url + "Categorias/editar/" + id;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            document.getElementById("id").value = res.id;
            document.getElementById("nombre").value = res.nombre;
            $("#nueva_categoria").modal("show");
        }
    }

}

function btnEliminarCat(id) {
    Swal.fire({
        title: 'Está seguro de eliminar?',
        text: "La categoría no se eliminará de forma permanente, solo estaría inactivo!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Categorias/eliminar/" + id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    alertas(res.msg, res.icono);
                    tblCategorias.ajax.reload();
                }
            }

        }
    })
}

function btnReactivarCat(id) {
    Swal.fire({
        title: 'Está seguro de reingresar?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Categorias/reactivar/" + id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    alertas(res.msg, res.icono);
                    tblCategorias.ajax.reload();
                }
            }

        }
    })
}
//FIN CATEGORIAS

//PRODUCTOS
function frmProducto() {
    document.getElementById("title").innerHTML = "Agregar Producto";
    document.getElementById("btnAccion").innerHTML = "Registrar";
    document.getElementById("frmProducto").reset();
    $("#nuevo_producto").modal();
    document.getElementById("idP").value = "";
    deleteImg();
}

function registrarPro(e) {
    e.preventDefault();
    const codigo = document.getElementById("codigoP");
    const nombre = document.getElementById("nombreP");
    const precio_compra = document.getElementById("precio_compraP");
    const precio_venta = document.getElementById("precio_ventaP");
    const id_categoria = document.getElementById("categoria");
    const expCod = /^[a-zA-Z0-9]{1,20}$/; //Letras y números
    const expNum = /^[0-9]{1,10}$/; //Numeros
    const expNombre = /^.{3,150}$/; //Cualquier caracter desde 3 hasta 50

    if (codigo.value == "" || nombre.value == "" || precio_compra.value == "" || precio_venta.value == "") {
        alertas('TODOS LOS CAMPOS SON OBLIGATORIOS!', 'warning');
    } else if (!(expCod.test(codigo.value))) {
        codigo.classList.add("is-invalid");
    } else if (!(expNombre.test(nombre.value))) {
        nombre.classList.add("is-invalid");
    } else if (!(expNum.test(precio_compra.value))) {
        precio_compra.classList.add("is-invalid");
    } else if (!(expNum.test(precio_venta.value))) {
        precio_venta.classList.add("is-invalid");
    } else {
        codigo.classList.remove("is-invalid");
        nombre.classList.remove("is-invalid");
        precio_compra.classList.remove("is-invalid");
        precio_venta.classList.remove("is-invalid");

        const url = base_url + "Productos/registrar";
        const frm = document.getElementById("frmProducto");
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(new FormData(frm));
        http.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                console.log(this.responseText);
                const res = JSON.parse(this.responseText);
                alertas(res.msg, res.icono);
                if (res.icono == 'success') {
                    frm.reset();
                    $("#nuevo_producto").modal("hide");
                    tblProductos.ajax.reload();
                }
            }
        }

    }
}

function btnEditarPro(id) {
    document.getElementById("title").innerHTML = "Actualizar Producto";
    document.getElementById("btnAccion").innerHTML = "Actualizar";
    const url = base_url + "Productos/editar/" + id;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            document.getElementById("idP").value = res.id;
            document.getElementById("codigoP").value = res.codigo;
            document.getElementById("nombreP").value = res.descripcion;
            document.getElementById("precio_compraP").value = res.precio_compra;
            document.getElementById("precio_ventaP").value = res.precio_venta;
            document.getElementById("categoria").value = res.id_categoria;
            document.getElementById("img-preview").src = base_url + 'Assets/img/' + res.foto;
            document.getElementById("icon-cerrar").innerHTML = `
            <button class="btn btn-danger" onclick = "deleteImg()" ><i class = "fas fa-times"></i></button>`;
            document.getElementById("icon-image").classList.add("d-none");
            document.getElementById("foto-actual").value = res.foto;
            codigoP.classList.remove("is-invalid");
            nombreP.classList.remove("is-invalid");
            precio_compraP.classList.remove("is-invalid");
            precio_ventaP.classList.remove("is-invalid");

            $("#nuevo_producto").modal("show");
        }
    }

}

function btnEliminarPro(id) {
    Swal.fire({
        title: 'Está seguro de eliminar?',
        text: "El producto no se eliminará de forma permanente, solo estaría inactivo!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Productos/eliminar/" + id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    alertas(res.msg, res.icono);
                    tblProductos.ajax.reload();
                }
            }

        }
    })
}

function btnReactivarPro(id) {
    Swal.fire({
        title: 'Está seguro de reingresar?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Productos/reactivar/" + id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    alertas(res.msg, res.icono);
                    tblProductos.ajax.reload();
                }
            }

        }
    })
}
//FIN PRODUCTOS

//PREVIEW IMAGEN
function preview(e) {
    const url = e.target.files[0];
    const urlTmp = URL.createObjectURL(url);
    document.getElementById("img-preview").src = urlTmp;
    document.getElementById("icon-image").classList.add("d-none");
    document.getElementById("icon-cerrar").innerHTML = `
    <button class="btn btn-danger" onclick = "deleteImg()" ><i class = "fas fa-times"></i></button>
    ${url['name']}`;

}
//FIN PREVIEW IMAGEN

//ELIMINAR IMAGEN SELECCIONADA
function deleteImg() {
    document.getElementById("icon-cerrar").innerHTML = "";
    document.getElementById("icon-image").classList.remove("d-none");
    document.getElementById("img-preview").src = "";
    document.getElementById("imagen").value = '';
    document.getElementById("foto-actual").value = '';
}
//FIN ELIMINAR IMAGEN SELECCIONADA

//BUSCAR CÓDIGO DE BARRAS DEL PRODUCTO PARA REALIZAR UNA COMPRA
function buscarCodigo(e) {
    e.preventDefault();
    const cod = document.getElementById("codigo").value;
    if (cod != '') {
        if (e.which == 13) {
            const url = base_url + "Compras/buscarCodigo/" + cod;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    if (res) {
                        document.getElementById("nombre").value = res.descripcion;
                        document.getElementById("precio").value = res.precio_compra;
                        document.getElementById("id").value = res.id;
                        document.getElementById("cantidad").removeAttribute('disabled');
                        document.getElementById("cantidad").focus();
                    } else {
                        alertas('EL PRODUCTO NO EXISTE!', 'warning');
                        document.getElementById("codigo").value = '';
                        document.getElementById('codigo').focus;
                    }
                }
            }
        }
    } else {
        alertas('INGRESE EL CÓDIGO DEL PRODUCTO!', 'warning');
    }
}
//FIN BUSCAR CÓDIGO DE BARRAS DEL PRODUCTO PARA REALIZAR UNA COMPRA


//BUSCAR CÓDIGO DE BARRAS DEL PRODUCTO PARA REALIZAR UNA VENTA
function buscarCodigoVenta(e) {
    e.preventDefault();
    const cod = document.getElementById("codigo").value;
    if (cod != '') {
        if (e.which == 13) {
            const url = base_url + "Compras/buscarCodigo/" + cod;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    if (res) {
                        document.getElementById("nombre").value = res.descripcion;
                        document.getElementById("precio").value = res.precio_venta;
                        document.getElementById("id").value = res.id;
                        document.getElementById("cantidad").removeAttribute('disabled');
                        document.getElementById("cantidad").focus();
                    } else {
                        alertas('EL PRODUCTO NO EXISTE!', 'warning');
                        document.getElementById("codigo").value = '';
                        document.getElementById('codigo').focus;
                    }
                }
            }
        }
    } else {
        alertas('INGRESE EL CÓDIGO DEL PRODUCTO!', 'warning');
    }
}
//FIN BUSCAR CÓDIGO DE BARRAS DEL PRODUCTO PARA REALIZAR UNA VENTA


//CALCULAR EL PRECIO TOTAL DEL PRODUCTO
function calcularPrecio(e) {
    e.preventDefault();
    const cant = document.getElementById("cantidad").value;
    const precio = document.getElementById("precio").value;
    document.getElementById("sub-total").value = precio * cant;

    if (e.which == 13) {
        if (cant > 0) {
            const url = base_url + "Compras/ingresar";
            const frm = document.getElementById("frmCompra")
            const http = new XMLHttpRequest();
            http.open("POST", url, true);
            http.send(new FormData(frm));
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {

                    const res = JSON.parse(this.responseText);
                    alertas(res.msg, res.icono);
                    frm.reset();
                    cargarDetalles();
                    document.getElementById('cantidad').setAttribute('disabled', 'disabled');
                    document.getElementById('codigo').focus();
                }
            }
        }
    }
}

//CALCULAR EL PRECIO TOTAL DEL PRODUCTO DE LA VENTA
function calcularPrecioVenta(e) {
    e.preventDefault();
    const cant = document.getElementById("cantidad").value;
    const precio = document.getElementById("precio").value;
    document.getElementById("sub-total").value = precio * cant;

    if (e.which == 13) {
        if (cant > 0) {
            const url = base_url + "Compras/ingresarVenta";
            const frm = document.getElementById("frmVenta")
            const http = new XMLHttpRequest();
            http.open("POST", url, true);
            http.send(new FormData(frm));
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    alertas(res.msg, res.icono);
                    frm.reset();
                    cargarDetallesVenta();
                    document.getElementById('cantidad').setAttribute('disabled', 'disabled');
                    document.getElementById('codigo').focus();
                }
            }
        }
    }
}

//OBTENER EL DETALLE
if (document.getElementById('tblDetalle')) {
    cargarDetalles();
}
//FIN CALCULAR EL PRECIO TOTAL DEL PRODUCTO

if (document.getElementById('tblDetalleVenta')) {
    cargarDetallesVenta();
}

function cargarDetalles() {
    const url = base_url + "Compras/listar/detalles";
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            let html = '';
            res.detalle.forEach(row => {
                html += `
                <tr>
                    <td>${row['id']}</td>
                    <td>${row['descripcion']}</td>
                    <td>${row['cantidad']}</td>
                    <td>${row['precio']}</td>
                    <td>${row['sub_total']}</td>
                    <td>
                        <button class="btn btn-danger" type="button" onclick="deleteDetalle(${row['id']}, 1)"><i class="fas fa-trash-alt"></i></button>
                    </td>
                </tr>`;
            });
            document.getElementById('tblDetalle').innerHTML = html;
            document.getElementById('total').value = res.total_pagar.total;
        }
    }
}

function cargarDetallesVenta() {
    const url = base_url + "Compras/listar/detalle_temp";
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            let html = '';
            res.detalle.forEach(row => {
                html += `
                <tr>
                    <td>${row['id']}</td>
                    <td>${row['descripcion']}</td>
                    <td>${row['cantidad']}</td>
                    <td><input type="text" class="form-control" placeholder="Desc" onkeyup="calcularDescuento(event, ${row['id']})"></td>
                    <td>${row['descuento']}</td>
                    <td>${row['precio']}</td>
                    <td>${row['sub_total']}</td>
                    <td>
                        <button class="btn btn-danger" type="button" onclick="deleteDetalle(${row['id']}, 2)"><i class="fas fa-trash-alt"></i></button>
                    </td>
                </tr>`;
            });
            document.getElementById('tblDetalleVenta').innerHTML = html;
            document.getElementById('total').value = res.total_pagar.total;
        }
    }
}

function calcularDescuento(e, id) {
    e.preventDefault();
    if (e.target.value == '') {
        alertas('INGRESE EL DESCUENTO!', 'warning');
    } else {
        if (e.which == 13) {
            const url = base_url + "Compras/calcularDescuento/" + id + "/" + e.target.value;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    alertas(res.msg, res.icono);
                    cargarDetallesVenta();
                }
            }
        }
    }
}

function deleteDetalle(id, accion) {
    let url;
    if (accion == 1) {
        url = base_url + "Compras/delete/" + id;
    } else {
        url = base_url + "Compras/deleteVenta/" + id;
    }
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            alertas(res.msg, res.icono);
            if (accion == 1) {
                cargarDetalles();
            } else {
                cargarDetallesVenta();
            }
        }
    }
}

function procesar(accion) {
    Swal.fire({
        title: 'ESTÁ SEGURO DE REALIZAR LA COMPRA?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            let url;
            if (accion == 1) {
                const id_proveedor = document.getElementById('proveedor').value;
                url = base_url + "Compras/registrarCompra/" + id_proveedor;
            } else {
                const id_cliente = document.getElementById('cliente').value;
                url = base_url + "Compras/registrarVenta/" + id_cliente;
            }
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    if (res.msg == "ok") {
                        alertas(res.msg, res.icono);
                        let ruta;
                        if (accion == 1) {
                            ruta = base_url + 'Compras/generarPdf/' + res.id_compra;
                        } else {
                            ruta = base_url + 'Compras/generarPdfVenta/' + res.id_venta;
                        }
                        window.open(ruta);
                        setTimeout(() => {
                            window.location.reload();
                        }, 300);

                    } else {
                        alertas(res.msg, res.icono);
                    }
                }
            }

        }
    })
}

function modificarEmpresa(e) {
    e.preventDefault();

    // Obtener elementos del DOM
    const nombre = document.getElementById("nombre");
    const telefono = document.getElementById("telefono");
    const ruc = document.getElementById("ruc");
    const direccion = document.getElementById("direccion");
    const mensaje = document.getElementById("mensaje");
    const timbrado = document.getElementById("timbrado");
    const inicio_vigencia = document.getElementById("inicio_vigencia");
    const fin_vigencia = document.getElementById("fin_vigencia");
    const numero_factura_inicial = document.getElementById("numero_factura_inicial");

    // Expresiones regulares
    const expNombre = /^[a-zA-ZÀ-ÿ0-9\s]{3,200}$/;
    const expTelefono = /^[0-9\+\-\(\)\s]{10,16}$/;
    const expRuc = /^[0-9a-zA-Z\-\s]{8,20}$/;
    const expDireccion = /^.{5,200}$/;
    const expMensaje = /^.{0,200}$/;
    const expTimbrado = /^[0-9]{8,20}$/;
    const expNumeroFactura = /^[0-9]{3}-[0-9]{3}-[0-9]{3}$/;

    // Limpiar clases de validación previas
    const campos = [nombre, telefono, ruc, direccion, mensaje, timbrado, inicio_vigencia, fin_vigencia, numero_factura_inicial];
    campos.forEach(campo => campo.classList.remove("is-invalid"));

    // Validar campos vacíos
    if (nombre.value == '' || telefono.value == '' || ruc.value == '' ||
        direccion.value == '' || mensaje.value == '' || timbrado.value == '' ||
        inicio_vigencia.value == '' || fin_vigencia.value == '' || numero_factura_inicial.value == '') {
        alertas('POR FAVOR COMPLETE TODO EL FORMULARIO!', 'error');
        return false;
    }

    // Validar nombre
    if (!(expNombre.test(nombre.value))) {
        nombre.classList.add("is-invalid");
        alertas('El nombre de la empresa no es válido!', 'error');
        return false;
    }

    // Validar teléfono
    if (!(expTelefono.test(telefono.value))) {
        telefono.classList.add("is-invalid");
        alertas('El número de teléfono no es válido!', 'error');
        return false;
    }

    // Validar RUC
    if (!(expRuc.test(ruc.value))) {
        ruc.classList.add("is-invalid");
        alertas('El RUC no es válido!', 'error');
        return false;
    }

    // Validar dirección
    if (!(expDireccion.test(direccion.value))) {
        direccion.classList.add("is-invalid");
        alertas('La dirección debe tener entre 5 y 200 caracteres!', 'error');
        return false;
    }

    // Validar mensaje
    if (!(expMensaje.test(mensaje.value))) {
        mensaje.classList.add("is-invalid");
        alertas('El mensaje no puede superar los 200 caracteres!', 'error');
        return false;
    }

    // Validar timbrado
    if (!(expTimbrado.test(timbrado.value))) {
        timbrado.classList.add("is-invalid");
        alertas('El timbrado debe contener solo números (8-20 caracteres)!', 'error');
        return false;
    }

    // Validar fechas
    const fechaInicio = new Date(inicio_vigencia.value);
    const fechaFin = new Date(fin_vigencia.value);

    if (isNaN(fechaInicio.getTime())) {
        inicio_vigencia.classList.add("is-invalid");
        alertas('Debe seleccionar una fecha de inicio válida!', 'error');
        return false;
    }

    if (isNaN(fechaFin.getTime())) {
        fin_vigencia.classList.add("is-invalid");
        alertas('Debe seleccionar una fecha de fin válida!', 'error');
        return false;
    }

    if (fechaFin <= fechaInicio) {
        fin_vigencia.classList.add("is-invalid");
        alertas('La fecha de fin debe ser posterior a la fecha de inicio!', 'error');
        return false;
    }

    // Validar número de factura inicial
    if (!(expNumeroFactura.test(numero_factura_inicial.value))) {
        numero_factura_inicial.classList.add("is-invalid");
        alertas('El número de factura debe tener el formato: 001-001-0000001!', 'error');
        return false;
    }

    // Si todo está correcto, enviar el formulario
    const frm = document.getElementById('frmEmpresa');
    const url = base_url + "Administracion/modificar";
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            alertas(res.msg, res.icono);

            // Limpiar todas las validaciones visuales
            campos.forEach(campo => campo.classList.remove("is-invalid"));
        }
    }
}

function modificarFactura(e) {
    e.preventDefault();
    const timbrado = document.getElementById("timbrado");
    const suc_caja = document.getElementById("suc_caja");
    const numero_factura = document.getElementById("numero_factura");
    const condicion = document.getElementById("condicion");
    const iva = document.getElementById("iva");
    const exptimbrado = /^[0-9]{8}$/;
    const expsuc_caja = /^.{7}$/;
    const expnumero_factura = /^[0-9]{7}$/;
    const expcondicion = /^[A-Z]{7}$/;
    const expiva = /^[0-9]{1,2}$/;

    if (timbrado.value == '' || suc_caja.value == '' || numero_factura.value == '' || condicion.value == '' || iva.value == '') {
        alertas('POR FAVOR COMPLETE TODO EL FORMULARIO!', 'error');
    } else if (!(exptimbrado.test(timbrado.value))) {
        timbrado.classList.remove("is-invalid");
        timbrado.classList.add("is-invalid");
    } else if (!(expsuc_caja.test(suc_caja.value))) {
        timbrado.classList.remove("is-invalid");
        suc_caja.classList.add("is-invalid");
    } else if (!(expnumero_factura.test(numero_factura.value))) {
        suc_caja.classList.remove("is-invalid");
        numero_factura.classList.add("is-invalid");
    } else if (!(expcondicion.test(condicion.value))) {
        numero_factura.classList.remove("is-invalid");
        condicion.classList.add("is-invalid");
    } else if (!(expiva.test(iva.value))) {
        condicion.classList.remove("is-invalid");
        iva.classList.add("is-invalid");
    } else {
        const frm = document.getElementById('frmEmpresaFactura');
        const url = base_url + "Administracion/modificarFactura";
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(new FormData(frm));
        http.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                console.log(this.responseText);
                const res = JSON.parse(this.responseText);
                console.log(this.responseText);
                alertas(res.msg, res.icono);
                timbrado.classList.remove("is-invalid");
                suc_caja.classList.remove("is-invalid");
                numero_factura.classList.remove("is-invalid");
                condicion.classList.remove("is-invalid");
                iva.classList.remove("is-invalid");
            }
        }
    }
}

function alertas(mensaje, icono) {
    Swal.fire({
        position: 'center',
        icon: icono,
        title: mensaje,
        showConfirmButton: false,
        timer: 2000
    })
}

if (document.getElementById('stockMinimo')) {
    reporteStok();
    reporteProductosVendidos();
}

function reporteStok() {
    const url = base_url + "Administracion/reporteGrafStock";
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            let nombre = [];
            let cantidad = [];
            for (let i = 0; i < res.length; i++) {
                nombre.push(res[i]['descripcion']);
                cantidad.push(res[i]['cantidad']);
            }
            //REPORTE GRÁFICO DE STOCK MÍNIMO
            //backgroundColor: ['#922B21', '#76448A', '#1F618D', '#148F77', '#239B56', '#B7950B', '#A04000', '#909497', '#616A6B', '#2C3E50'],
            //hoverBackgroundColor: ['#7B241C ', '#633974', '#1A5276', '#117864', '#1D8348', '#9A7D0A', '#873600', '#797D7F', '#515A5A', '#212F3D'],

            var ctx = document.getElementById("stockMinimo");
            var stockMinimo = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: nombre,
                    datasets: [{
                        data: cantidad,
                        backgroundColor: ['red', 'blue', 'purple', 'lime', 'orange', 'cyan', 'olive', 'yellow', 'brown', 'magenta'],
                        hoverBackgroundColor: ['black', 'black', 'black', 'black', 'black', 'black', 'black', 'black', 'black', 'black'],
                        hoverBorderColor: "rgba(234, 236, 244, 1)",
                        hoverOffset: 20,
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    tooltips: {
                        backgroundColor: "rgb(255,255,255)",
                        bodyFontColor: "#858796",
                        borderColor: '#dddfeb',
                        borderWidth: 1,
                        xPadding: 15,
                        yPadding: 15,
                        displayColors: false,
                        caretPadding: 10,
                    },
                    legend: {
                        display: true,
                        labels: {
                            usePointStyle: true,
                            margin: 20,
                        }
                    },
                    cutoutPercentage: 0,
                }
            });
        }
    }
}

function reporteProductosVendidos() {
    const url = base_url + "Administracion/reporteGrafPVend";
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            let nombre = [];
            let cantidad = [];
            for (let i = 0; i < res.length; i++) {
                nombre.push(res[i]['descripcion']);
                cantidad.push(res[i]['total']);
            }
            //REPORTE GRÁFICO DE PRODUCTOS VENDIDOS
            var ctx = document.getElementById("productosVendidos");
            var productosVendidos = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: nombre,
                    datasets: [{
                        data: cantidad,
                        backgroundColor: ['red', 'blue', 'purple', 'lime', 'orange', 'cyan', 'olive', 'yellow', 'brown', 'magenta'],
                        hoverBackgroundColor: ['black', 'black', 'black', 'black', 'black', 'black', 'black', 'black', 'black', 'black'],
                        hoverBorderColor: "rgba(234, 236, 244, 1)",
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    tooltips: {
                        backgroundColor: "rgb(255,255,255)",
                        bodyFontColor: "#858796",
                        borderColor: '#dddfeb',
                        borderWidth: 1,
                        xPadding: 15,
                        yPadding: 15,
                        displayColors: false,
                        caretPadding: 10,
                    },
                    legend: {

                        display: true,
                        labels: {
                            usePointStyle: true,
                            margin: 20,
                        }
                    },
                    cutoutPercentage: 60,
                }
            });
        }
    }
}


function btnAnularC(id) {
    Swal.fire({
        title: 'ESTÁ SEGURO DE ANULAR LA COMPRA?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Compras/anularCompra/" + id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    alertas(res.msg, res.icono);
                    t_h_c.ajax.reload();
                }
            }
        }
    })
}


function btnAnularV(id) {
    Swal.fire({
        title: 'ESTÁ SEGURO DE ANULAR LA VENTA?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Compras/anularVenta/" + id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    alertas(res.msg, res.icono);
                    t_h_v.ajax.reload();
                }
            }
        }
    })
}



function arqueoCaja() {
    document.getElementById('ocultar_campos').classList.add('d-none');
    document.getElementById('monto_inicial').value = '';
    document.getElementById('btnAccion').textContent = 'Abrir Caja';
    $('#abrir_caja').modal('show');
}

function abrirArqueo(e) {
    e.preventDefault();
    const monto_inicial = document.getElementById('monto_inicial').value;
    const expMonto = /^[0-9]{1,10}$/; //Numeros
    if (monto_inicial == '') {
        alertas('INGRESE EL MONTO INICIAL!', 'warning');
    } else if (!(expMonto.test(monto_inicial))) {
        document.getElementById("monto_inicial").classList.add("is-invalid");
    } else {
        const frm = document.getElementById('frmAbrirCaja');
        const url = base_url + "Cajas/abrirArqueo";
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(new FormData(frm));
        http.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                console.log(this.responseText);
                const res = JSON.parse(this.responseText);
                alertas(res.msg, res.icono);
                t_arqueo.ajax.reload();
                $('#abrir_caja').modal('hide');
                if (res.icono == 'success') {
                    setTimeout(function () { window.location.href = base_url + "Cajas/arqueo"; }, 900);
                    document.getElementById("")
                }
            }
        }
    }
}

function cerrarCaja() {
    const frm = document.getElementById('frmAbrirCaja');
    const url = base_url + "Cajas/getVentas";
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            const res = JSON.parse(this.responseText);
            document.getElementById('monto_final').value = res.monto_total.total;
            document.getElementById('total_ventas').value = res.total_ventas.total;
            document.getElementById('monto_inicial').value = res.inicial.monto_inicial;
            document.getElementById('monto_general').value = res.monto_general;
            document.getElementById('id').value = res.inicial.id;
            document.getElementById('ocultar_campos').classList.remove('d-none');
            document.getElementById('btnAccion').textContent = 'Cerrar Caja';
            $('#abrir_caja').modal('show');
        }
    }

}

function registrarPermisos(e) {
    e.preventDefault();
    const url = base_url + "Usuarios/registrarPermiso";
    const frm = document.getElementById('formulario');
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            if (res != '') {
                alertas(res.msg, res.icono);
                if (res.icono == 'success') {
                    setTimeout(function () { window.location.href = base_url + "Usuarios"; }, 900);
                }
            } else {
                alertas('ERROR NO IDENTIFICADO!', 'error');
            }
        }
    }
}

function listaProductos() {
    $("#modal_productos").modal('show');
}



