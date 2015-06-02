$(function() {

    var TallerAvanzada = {};

    (function(app) {

        app.init = function() {
            $("#cerrarSesion").on('click', function(event) {
                document.location.href="../../CerrarSesion.php";
                event.preventDefault();
            });
            app.buscarProductos();
            app.bindings();

        };
        app.bindings = function() {

            $("#agregar").on('click', function(event) {
                event.preventDefault();
                app.borrarCampos();
                $("#id_producto").val(0);
                $("#tituloModal").html("Nuevo Producto");
                $("#modalProducto").modal({show: true});
                $("#guardar").attr("value","Guardar");
                $("#guardar").html("Guardar");
            });
            
            $("#buscar").on('click', function(event) {
                if ($("#txtBuscar").val()==="") {
                    alert("Debe completar el campo búsqueda.");
                    $("#btnCriterio").attr("value","Criterio");
                    $("#btnCriterio").html("Criterio <span class=\"caret\"></span>");
                    app.buscarProductos();
                }else if($("#btnCriterio").val()==="Criterio"){
                    alert("Debe seleccionar un criterio de búsqueda.");
                    app.buscarProductos();
                }else{
                    var valor = $("#btnCriterio").html().replace(" <span class=\"caret\"></span>","_producto");
                    app.buscarXcriterio($("#txtBuscar").val(), valor);
                }
                
            });
            
            $("#cDesc").on('click', function (event){//si click en el elemento del combo Nombre, muestra nombre
                $("#btnCriterio").attr("value","descripcion_producto");
                $("#btnCriterio").html("Descripcion <span class=\"caret\"></span>");      

            });
                     
            $("#reporte").on('click', function(event) {
                document.location.href="reporteProductos.php";
            });

            $("#cuerpoTablaProducto").on('click', '.editar', function(event) {

                $("#id_producto").val($(this).attr("data-id_productos"));
                $("#descripcion_producto").val($(this).parent().parent().children().first().next().html());
                $("#guardar").html("Modificar");
                $("#guardar").attr("value","Modificar");
                $("#tituloModal").html("Editar Producto");
                $("#modalProducto").modal({show: true});
            });

            $("#cuerpoTablaProducto").on('click', '.eliminar', function() {
                app.eliminarProducto($(this).attr("data-id_productos"));
            });

            $("#cancelar").on("click", function(event) {
                event.preventDefault();
                app.borrarCampos();
                $("#modalProducto").modal('hide');
            });

            $("#guardar").on("click", function(event) {
                event.preventDefault();
                app.guardarProducto();
            });

            $("#formProducto").bootstrapValidator({
                excluded: []
            });
        };
        
        app.borrarCampos = function (){
            $("#descripcion_producto").val("").html();
        }; 
        
        app.buscarXcriterio = function (txtBuscar, btnCriterio){
            var valor = txtBuscar;
            var crit = btnCriterio;
            var url = "../../controlador/ruteador/Ruteador.php?accion=buscarX&nombreFormulario=Producto&criterio=" + crit +"&valor=" + valor;
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
        
        app.guardarProducto = function() { //guarda ALTAS y MODIFICACIONES
            
            var url = "../../controlador/ruteador/Ruteador.php"; 
            //data del formulario producto
            var data = $("#formProducto").serialize();
            $.ajax({
                url: url,
                method: 'POST',
                dataType: 'json',
                data: data,
                success: function(datos) {
                    $("#modalProducto").modal('hide');
                    app.actualizarTabla(datos, $("#id_producto").val());
                },
                error: function(data) {
                    alert(data);
                }
            });
        };
        app.eliminarProducto = function(id) {

            var url = "../../controlador/ruteador/Ruteador.php?accion=eliminar&nombreFormulario=Producto&id=" + id; //cambiar url

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
            
            $.each(data, function(clave, producto) {
                
                html += '<tr>' +
                        '<td><a class="pull-left ver" data-id_productos="' + producto.id_producto + '"><span class="glyphicon glyphicon-eye-open"></span>Ver</a></td>' +
                        '<td>' + producto.descripcion_producto + '</td>' +
                        '<td>' +
                        '<a class="pull-left editar" data-id_productos="' + producto.id_producto + '"><span class="glyphicon glyphicon-pencil"></span>Editar</a>' +
                        '<a class="pull-right eliminar" data-id_productos="' + producto.id_producto + '"><span class="glyphicon glyphicon-remove"></span>Eliminar</a>' +
                        '</td>' +
                        '</tr>';
            });

            $("#cuerpoTablaProducto").html(html);
        };
        

        app.actualizarTabla = function(productos, id) {
            var html = "";
            if (id == 0) {
                html = '<tr><td>' + 
                    '<a class="pull-left ver" data-id_productos="' + productos.id_producto + '"><span class="glyphicon glyphicon-eye-open"></span>Ver</a></td>' +
                    '<td>' + productos.descripcion_producto + '</td>' +
                    '<td>' +
                    '<a class="pull-left editar" data-id_productos="' + productos.id_producto + '"><span class="glyphicon glyphicon-pencil"></span>Editar</a>' +
                    '<a class="pull-right eliminar" data-id_productos="' + productos.id_producto + '"><span class="glyphicon glyphicon-remove"></span>Eliminar</a>' +
                    '</td></tr>';
                $("#cuerpoTablaProducto").append(html);
                
            } else {
                //busco la fila
                var fila = $("#cuerpoTablaProducto").find("a[data-id_productos='" + id + "']").parent().parent();
                html = '<td>' + 
                    '<a class="pull-left ver" data-id_productos="' + productos.id_producto + '"><span class="glyphicon glyphicon-eye-open"></span>Ver</a></td>' +
                    '<td>' + productos.descripcion_producto + '</td>' +
                    '<td>' +
                    '<a class="pull-left editar" data-id_productos="' + productos.id_producto + '"><span class="glyphicon glyphicon-pencil"></span>Editar</a>' +
                    '<a class="pull-right eliminar" data-id_productos="' + productos.id_producto + '"><span class="glyphicon glyphicon-remove"></span>Eliminar</a>' +
                    '</td>';
                fila.html(html);
            }
        };

        app.borrarFila = function(id) {
            var fila = $("#cuerpoTablaProducto").find("a[data-id_productos='" + id + "']").parent().parent().remove();
        };
        
        
        
        
        
        
        app.buscarProductos = function() {

            var url = "../../controlador/ruteador/Ruteador.php?accion=buscar&nombreFormulario=Producto";

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

            $.each(data, function(clave, producto) {
                html += '<tr>' +
                        '<td><a class="pull-left ver" data-id_productos="' + producto.id_producto + '"><span class="glyphicon glyphicon-eye-open"></span>Ver</a></td>' +
                        '<td>' + producto.descripcion_producto + '</td>' +
                        '<td>' +
                        '<a class="pull-left editar" data-id_productos="' + producto.id_producto + '"><span class="glyphicon glyphicon-pencil"></span>Editar</a>' +
                        '<a class="pull-right eliminar" data-id_productos="' + producto.id_producto + '"><span class="glyphicon glyphicon-remove"></span>Eliminar</a>' +
                        '</td>' +
                        '</tr>';
            });
            $("#cuerpoTablaProducto").html(html);
        };

        app.init();

    })(TallerAvanzada);


});
