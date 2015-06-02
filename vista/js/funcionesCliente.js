$(function() {

    var TallerAvanzada = {};

    (function(app) {

        app.init = function() {
            $("#cerrarSesion").on('click', function(event) {
                document.location.href="../../CerrarSesion.php";
                event.preventDefault();
            });
            app.buscarClientes();
            app.bindings();

        };
        app.bindings = function() {

            $("#agregar").on('click', function(event) {
                event.preventDefault();
                app.borrarCampos();
                $("#id_cliente").val(0);
                $("#tituloModal").html("Nuevo Cliente");
                $("#modalCliente").modal({show: true});
                $("#guardar").attr("value","Guardar");
                $("#guardar").html("Guardar");
            });
            
            $("#buscar").on('click', function(event) {
                if ($("#txtBuscar").val()==="") {
                    alert("Debe completar el campo búsqueda.");
                    $("#btnCriterio").attr("value","Criterio");
                    $("#btnCriterio").html("Criterio <span class=\"caret\"></span>");
                    app.buscarClientes();
                }else if($("#btnCriterio").val()==="Criterio"){
                    alert("Debe seleccionar un criterio de búsqueda.");
                    app.buscarClientes();
                }else{
                    var valor = $("#btnCriterio").html().replace(" <span class=\"caret\"></span>","_cliente");
                    app.buscarXcriterio($("#txtBuscar").val(), valor);
                }
                
            });
            
            $("#cNom").on('click', function (event){//si click en el elemento del combo Nombre, muestra nombre
                $("#btnCriterio").attr("value","nombre_cliente");
                $("#btnCriterio").html("Nombre <span class=\"caret\"></span>");      

            });
            $("#cApe").on('click', function (event){//si click en el elemento del combo Apellido, muestra Apellido
                $("#btnCriterio").attr("value","apellido_cliente");
                $("#btnCriterio").html("Apellido <span class=\"caret\"></span>");      

            });
            $("#cCUIL").on('click', function (event){//si click en el elemento del combo CUIL, muestra CUIL
                $("#btnCriterio").attr("value","cuil_cliente");
                $("#btnCriterio").html("CUIL <span class=\"caret\"></span>");      

            });
                     
            $("#reporte").on('click', function(event) {
                document.location.href="reporteClientes.php";
            });

            $("#cuerpoTablaCliente").on('click', '.editar', function(event) {

                $("#id_cliente").val($(this).attr("data-id_clientes"));
                $("#nombre_cliente").val($(this).parent().parent().children().first().next().html());
                $("#apellido_cliente").val($(this).parent().parent().children().first().next().next().html());
                $("#CUIL_cliente").val($(this).parent().parent().children().first().next().next().next().html());
                if ($(this).parent().parent().children().first().next().next().next().next().html() == "RI") {
                    $("#IVA_cliente").val("RI").attr("selected");
                }else if($(this).parent().parent().children().first().next().next().next().next().html() == "MO"){
                    $("#IVA_cliente").val("MO").attr("selected");
                }else{
                    $("#IVA_cliente").val("CF").attr("selected");
                }
                $("#guardar").html("Modificar");
                $("#guardar").attr("value","Modificar");
                $("#tituloModal").html("Editar Cliente");
                $("#modalCliente").modal({show: true});
            });

            $("#cuerpoTablaCliente").on('click', '.eliminar', function() {
                app.eliminarCliente($(this).attr("data-id_clientes"));
            });

            $("#cancelar").on("click", function(event) {
                event.preventDefault();
                app.borrarCampos();
                $("#modalCliente").modal('hide');
            });

            $("#guardar").on("click", function(event) {
                event.preventDefault();
                app.guardarCliente();
            });

            $("#formCliente").bootstrapValidator({
                excluded: []
            });
        };
        
        app.borrarCampos = function (){
            $("#nombre_cliente").val("").html();
            $("#apellido_cliente").val("").html();
            $("#CUIL_cliente").val("").html();
            $("#IVA_cliente").val("CF").attr("selected");
            
        }; 
        
        app.buscarXcriterio = function (txtBuscar, btnCriterio){
            var valor = txtBuscar;
            var crit = btnCriterio;
            var url = "../../controlador/ruteador/Ruteador.php?accion=buscarX&nombreFormulario=Cliente&criterio=" + crit +"&valor=" + valor;
            $.ajax({
                url: url,
                method: "GET",
                dataType: 'json',
                success: function(data) {
                    app.rellenarTabla(data);
                },
                error: function(data) {
                    alert('error');
                }
            });
        };
        
        app.guardarCliente = function() { //guarda ALTAS y MODIFICACIONES
            
            var url = "../../controlador/ruteador/Ruteador.php"; 
            //data del formulario cliente
            var data = $("#formCliente").serialize();
            $.ajax({
                url: url,
                method: 'POST',
                dataType: 'json',
                data: data,
                success: function(datos) {
                    $("#modalCliente").modal('hide');
                    app.actualizarTabla(datos, $("#id_cliente").val());
                },
                error: function(data) {
                    alert(data);
                }
            });
        };
        app.eliminarCliente = function(id) {

            var url = "../../controlador/ruteador/Ruteador.php?accion=eliminar&nombreFormulario=Cliente&id=" + id; //cambiar url

            $.ajax({
                url: url,
                method: "GET",
                dataType: 'json',
                success: function(data) {
                    app.borrarFila(id);
                },
                error: function(data) {
                    alert('error');
                }
            });

        };

        app.rellenarTabla = function(data) {

            var html = "";
            
            $.each(data, function(clave, cliente) {
                
                html += '<tr>' +
                        '<td><a class="pull-left ver" data-id_clientes="' + cliente.id_cliente + '"><span class="glyphicon glyphicon-eye-open"></span>Ver</a></td>' +
                        '<td>' + cliente.nombre_cliente + '</td>' +
                        '<td>' + cliente.apellido_cliente + '</td>' +
                        '<td>' + cliente.cuil_cliente + '</td>' +
                        '<td>' + cliente.iva_cliente + '</td>' +
                        '<td>' +
                        '<a class="pull-left editar" data-id_clientes="' + cliente.id_cliente + '"><span class="glyphicon glyphicon-pencil"></span>Editar</a>' +
                        '<a class="pull-right eliminar" data-id_clientes="' + cliente.id_cliente + '"><span class="glyphicon glyphicon-remove"></span>Eliminar</a>' +
                        '</td>' +
                        '</tr>';
            });

            $("#cuerpoTablaCliente").html(html);
        };
        

        app.actualizarTabla = function(clientes, id) {
            var html = "";
            if (id == 0) {
                html = '<tr><td>' + 
                    '<a class="pull-left ver" data-id_clientes="' + clientes.id_cliente + '"><span class="glyphicon glyphicon-eye-open"></span>Ver</a></td>' +
                    '<td>' + clientes.nombre_cliente + '</td>' +
                    '<td>' + clientes.apellido_cliente + '</td>' +
                    '<td>' + clientes.cuil_cliente + '</td>' +
                    '<td>' + clientes.iva_cliente + '</td>' +
                    '<td>' +
                    '<a class="pull-left editar" data-id_clientes="' + clientes.id_cliente + '"><span class="glyphicon glyphicon-pencil"></span>Editar</a>' +
                    '<a class="pull-right eliminar" data-id_clientes="' + clientes.id_cliente + '"><span class="glyphicon glyphicon-remove"></span>Eliminar</a>' +
                    '</td></tr>';
                $("#cuerpoTablaCliente").append(html);
                
            } else {
                //busco la fila
                var fila = $("#cuerpoTablaCliente").find("a[data-id_clientes='" + id + "']").parent().parent();
                html = '<td>' + 
                    '<a class="pull-left ver" data-id_clientes="' + clientes.id_cliente + '"><span class="glyphicon glyphicon-eye-open"></span>Ver</a></td>' +
                    '<td>' + clientes.nombre_cliente + '</td>' +
                    '<td>' + clientes.apellido_cliente + '</td>' +
                    '<td>' + clientes.cuil_cliente + '</td>' +
                    '<td>' + clientes.iva_cliente + '</td>' +
                    '<td>' +
                    '<a class="pull-left editar" data-id_clientes="' + clientes.id_cliente + '"><span class="glyphicon glyphicon-pencil"></span>Editar</a>' +
                    '<a class="pull-right eliminar" data-id_clientes="' + clientes.id_cliente + '"><span class="glyphicon glyphicon-remove"></span>Eliminar</a>' +
                    '</td>';
                fila.html(html);
            }
        };

        app.borrarFila = function(id) {
            var fila = $("#cuerpoTablaCliente").find("a[data-id_clientes='" + id + "']").parent().parent().remove();
        };
        
        
        
        
        
        
        app.buscarClientes = function() {

            var url = "../../controlador/ruteador/Ruteador.php?accion=buscar&nombreFormulario=Cliente";

            $.ajax({
                url: url,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    app.rellenarTabla(data);
                },
                error: function() {
                    alert('error al buscar cliente');
                }

            });
        };

        app.rellenarTabla = function(data) {

            var html = "";

            $.each(data, function(clave, cliente) {
                html += '<tr>' +
                        '<td><a class="pull-left ver" data-id_clientes="' + cliente.id_cliente + '"><span class="glyphicon glyphicon-eye-open"></span>Ver</a></td>' +
                        '<td>' + cliente.nombre_cliente + '</td>' +
                        '<td>' + cliente.apellido_cliente + '</td>' +
                        '<td>' + cliente.cuil_cliente + '</td>' +
                        '<td>' + cliente.iva_cliente + '</td>' +
                        '<td>' +
                        '<a class="pull-left editar" data-id_clientes="' + cliente.id_cliente + '"><span class="glyphicon glyphicon-pencil"></span>Editar</a>' +
                        '<a class="pull-right eliminar" data-id_clientes="' + cliente.id_cliente + '"><span class="glyphicon glyphicon-remove"></span>Eliminar</a>' +
                        '</td>' +
                        '</tr>';
            });
            $("#cuerpoTablaCliente").html(html);
        };

        app.init();

    })(TallerAvanzada);


});
