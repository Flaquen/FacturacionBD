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
                app.borrarCampos();
                $("#id").val(0);
                $("#tituloModal").html("Nuevo Cliente");
                $("#modalCliente").modal({show: true});
                $("#guardar").attr("value","Agregar");
                $("#guardar").html("Agregar");
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
                    var valor = $("#btnCriterio").html().replace(" <span class=\"caret\"></span>","");
                    app.buscarXcriterio($("#txtBuscar").val(), valor);
                }
                
            });
            
            $("#cNom").on('click', function (event){//si click en el elemento del combo Nombre, muestra nombre
                $("#btnCriterio").attr("value","nombre");
                $("#btnCriterio").html("Nombre <span class=\"caret\"></span>");      

            });
            $("#cApe").on('click', function (event){//si click en el elemento del combo Apellido, muestra Apellido
                $("#btnCriterio").attr("value","apellido");
                $("#btnCriterio").html("Apellido <span class=\"caret\"></span>");      

            });
            $("#cCUIL").on('click', function (event){//si click en el elemento del combo CUIL, muestra CUIL
                $("#btnCriterio").attr("value","CUIL");
                $("#btnCriterio").html("CUIL <span class=\"caret\"></span>");      

            });
            $("#cIVA").on('click', function (event){//si click en el elemento del combo IVA, muestra IVA
                $("#btnCriterio").attr("value","IVA");
                $("#btnCriterio").html("IVA <span class=\"caret\"></span>");      

            });
            
            $("#reporte").on('click', function(event) {
                document.location.href="reporteClientes.php";
            });

            $("#cuerpoTablaCliente").on('click', '.editar', function(event) {

                $("#id").val($(this).attr("data-id_cliente"));

                $("#nombre").val($(this).parent().parent().children().first().next().html());
                $("#apellido").val($(this).parent().parent().children().first().next().next().html());
                $("#CUIL").val($(this).parent().parent().children().first().next().next().next().html());
                $("#IVA").val($(this).parent().parent().children().first().next().next().next().next().html());
                $("#guardar").html("Modificar");
                $("#guardar").attr("value","Modificar");
                $("#tituloModal").html("Editar Cliente");
                $("#modalCliente").modal({show: true});
            });

            $("#cuerpoTablaCliente").on('click', '.eliminar', function() {
                app.eliminarCliente($(this).attr("data-id_cliente"));
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
            $("#nombre").val("").html();
            $("#apellido").val("").html();
            $("#CUIL").val("").html();
            $("#IVA").val("").html();
            
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
        
        app.guardarCliente = function() {
            
            var url = "../../controlador/ruteador/Ruteador.php"; //cambiar url
            //data del formulario persona
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
                        '<td><a class="pull-left ver" data-id_cliente="' + cliente.id_cliente + '"><span class="glyphicon glyphicon-eye-open"></span>Ver</a></td>' +
                        '<td>' + cliente.nombre_cliente + '</td>' +
                        '<td>' + cliente.apellido_cliente + '</td>' +
                        '<td>' + cliente.cuil_cliente + '</td>' +
                        '<td>' + cliente.iva_cliente + '</td>' +
                        '<td>' +
                        '<a class="pull-left editar" data-id_cliente="' + cliente.id_cliente + '"><span class="glyphicon glyphicon-pencil"></span>Editar</a>' +
                        '<a class="pull-right eliminar" data-id_cliente="' + cliente.id_cliente + '"><span class="glyphicon glyphicon-remove"></span>Eliminar</a>' +
                        '</td>' +
                        '</tr>';
            });

            $("#cuerpoTablaCliente").html(html);
        };
        

        app.actualizarTabla = function(cliente, id) {
            if (id == 0) {
                var html = '<tr>' +
                        '<td><a class="pull-left ver" data-id_cliente="' + cliente.id_cliente + '"><span class="glyphicon glyphicon-eye-open"></span>Ver</a></td>' +
                        '<td>' + cliente.nombre_cliente + '</td>' +
                        '<td>' + cliente.apellido_cliente + '</td>' +
                        '<td>' + cliente.cuil_cliente + '</td>' +
                        '<td>' + cliente.iva_cliente + '</td>' +
                        '<td>' +
                        '<a class="pull-left editar" data-id_cliente="' + cliente.id_cliente + '"><span class="glyphicon glyphicon-pencil"></span>Editar</a>' +
                        '<a class="pull-right eliminar" data-id_cliente="' + cliente.id_cliente + '"><span class="glyphicon glyphicon-remove"></span>Eliminar</a>' +
                        '</td>' +
                        '</tr>';
                $("#cuerpoTablaCliente").append(html);
                
            } else {
                //busco la fila
                var fila = $("#cuerpoTablaCliente").find("a[data-id_cliente='" + id + "']").parent().parent();
                var html = '<td>' + 
                        '<td><a class="pull-left ver" data-id_cliente="' + cliente.id_cliente + '"><span class="glyphicon glyphicon-eye-open"></span>Ver</a></td>' +
                        cliente.nombre_cliente + '</td>' +
                        '<td>' + cliente.apellido_cliente + '</td>' +
                        '<td>' + cliente.cuil_cliente + '</td>' +
                        '<td>' + cliente.iva_cliente + '</td>' +
                        '<td>' +
                        '<a class="pull-left editar" data-id_cliente="' + cliente.id_cliente + '"><span class="glyphicon glyphicon-pencil"></span>Editar</a>' +
                        '<a class="pull-right eliminar" data-id_cliente="' + cliente.id_cliente + '"><span class="glyphicon glyphicon-remove"></span>Eliminar</a>' +
                        '</td>';
                fila.html(html);
            }
        };

        app.borrarFila = function(id) {
            var fila = $("#cuerpoTablaCliente").find("a[data-id_cliente='" + id + "']").parent().parent().remove();

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
                    alert('error');
                }

            });
        };

        app.rellenarTabla = function(data) {

            var html = "";

            $.each(data, function(clave, cliente) {
                html += '<tr>' +
                        '<td><a class="pull-left ver" data-id_cliente="' + cliente.id_cliente + '"><span class="glyphicon glyphicon-eye-open"></span>Ver</a></td>' +
                        '<td>' + cliente.nombre_cliente + '</td>' +
                        '<td>' + cliente.apellido_cliente + '</td>' +
                        '<td>' + cliente.cuil_cliente + '</td>' +
                        '<td>' + cliente.iva_cliente + '</td>' +
                        '<td>' +
                        '<a class="pull-left editar" data-id_cliente="' + cliente.id + '"><span class="glyphicon glyphicon-pencil"></span>Editar</a>' +
                        '<a class="pull-right eliminar" data-id_cliente="' + cliente.id + '"><span class="glyphicon glyphicon-remove"></span>Eliminar</a>' +
                        '</td>' +
                        '</tr>';
            });
            $("#cuerpoTablaCliente").html(html);
        };





        app.init();

    })(TallerAvanzada);


});
