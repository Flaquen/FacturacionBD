$(function() {

    var TallerAvanzada = {};

    (function(app) {

        app.init = function() {
            $("#cerrarSesion").on('click', function(event) {
                document.location.href="../../CerrarSesion.php";
                event.preventDefault();
            });
            app.buscarProfesores();
            app.bindings();

        };
        app.bindings = function() {

            $("#agregar").on('click', function(event) {
                app.borrarCampos();
                $("#id").val(0);
                $("#tituloModal").html("Nueva Factura");
                $("#modalFactura").modal({show: true});
                $("#guardar").attr("value","Agregar");
                $("#guardar").html("Agregar");
            });
            
            $("#buscar").on('click', function(event) {
                if ($("#txtBuscar").val()==="") {
                    alert("Debe completar el campo búsqueda.");
                    $("#btnCriterio").attr("value","Criterio");
                    $("#btnCriterio").html("Criterio <span class=\"caret\"></span>");
                    app.buscarAlumnos();
                }else if($("#btnCriterio").val()==="Criterio"){
                    alert("Debe seleccionar un criterio de búsqueda.");
                    app.buscarAlumnos();
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
            $("#cTit").on('click', function (event){//si click en el elemento del combo Legajo, muestra legajo
                $("#btnCriterio").attr("value","titulo");
                $("#btnCriterio").html("Título <span class=\"caret\"></span>");      

            });
            $("#cCal").on('click', function (event){//si click en el elemento del combo Calle, muestra calle
                $("#btnCriterio").attr("value","calle");
                $("#btnCriterio").html("Calle <span class=\"caret\"></span>");      

            });
            
            $("#reporte").on('click', function(event) {
                document.location.href="reporteProfesores.php";
            });

            $("#cuerpoTablaFactura").on('click', '.editar', function(event) {

                $("#id").val($(this).attr("data-id_factura"));

                $("#nombre").val($(this).parent().parent().children().first().html());
                $("#apellido").val($(this).parent().parent().children().first().next().html());
                $("#titulo").val($(this).parent().parent().children().first().next().next().html());
                $("#calle").val($(this).parent().parent().children().first().next().next().next().html());
                $("#numero").val($(this).parent().parent().children().first().next().next().next().next().html());
                $("#guardar").html("Modificar");
                $("#guardar").attr("value","Modificar");
                $("#tituloModal").html("Editar Factura");
                $("#modalFactura").modal({show: true});
            });
            
            app.buscarXcriterio = function (txtBuscar, btnCriterio){
            var valor = txtBuscar;
            var crit = btnCriterio;
            var url = "../../controlador/ruteador/Ruteador.php?accion=buscarX&nombreFormulario=Factura&criterio=" + crit +"&valor=" + valor;
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

            $("#cuerpoTablaFactura").on('click', '.eliminar', function() {
                app.eliminarFactura($(this).attr("data-id_factura"));
            });

            $("#cancelar").on("click", function(event) {
                event.preventDefault();
                app.borrarCampos();
                $("#modalFactura").modal('hide');
            });

            $("#guardar").on("click", function(event) {
                event.preventDefault();
                app.guardarFactura();
            });

            $("#formFactura").bootstrapValidator({
                excluded: []
            });
        };
        
        app.borrarCampos = function (){
            $("#nombre").val("").html();
            $("#apellido").val("").html();
            $("#titulo").val("").html();
            $("#calle").val("").html();
            $("#numero").val("").html();
            
        };
        
        app.guardarFactura = function() {
            
            var url = "../../controlador/ruteador/Ruteador.php"; //cambiar url
            //data del formulario persona
            var data = $("#formFactura").serialize();
            $.ajax({
                url: url,
                method: 'POST',
                dataType: 'json',
                data: data,
                success: function(datos) {
                    $("#modalFactura").modal('hide');
                    app.actualizarTabla(datos, $("#id").val());
                },
                error: function(data) {
                    alert(data);
                }
            });
        };
        app.eliminarFactura = function(id) {

            var url = "../../controlador/ruteador/Ruteador.php?accion=eliminar&nombreFormulario=Factura&id=" + id; 

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

            $.each(data, function(clave, factura) {
                html += '<tr>' +
                        '<td><a class="center-block seleccionar" data-id_factura="' + factura.id_factura + '"><span class="glyphicon glyphicon-eye-open"></span></a>' +
                        '<td>' + factura.nombre + '</td>' +
                        '<td>' + factura.apellido + '</td>' +
                        '<td>' + factura.titulo + '</td>' +
                        '<td>' + factura.calle + '</td>' +
                        '<td>' + factura.numero + '</td>' +
                        '<td>' +
                        '<a class="pull-left editar" data-id_factura="' + factura.id_factura + '"><span class="glyphicon glyphicon-pencil"></span>Editar</a>' +
                        '<a class="pull-right eliminar" data-id_factura="' + factura.id_factura + '"><span class="glyphicon glyphicon-remove"></span>Eliminar</a>' +
                        '</td>' +
                        '</tr>';
            });

            $("#cuerpoTablaFactura").html(html);
        };

        app.actualizarTabla = function(factura, id) {
            if (id == 0) {
                var html = '<tr>' +
                        '<td><a class="center-block seleccionar" data-id_factura="' + factura.id_factura + '"><span class="glyphicon glyphicon-eye-open"></span></a></td>' +
                        '<td>' + factura.nombre + '</td>' +
                        '<td>' + factura.apellido + '</td>' +
                        '<td>' + factura.titulo + '</td>' +
                        '<td>' + factura.calle + '</td>' +
                        '<td>' + factura.numero + '</td>' +
                        '<td>' +
                        '<a class="pull-left editar" data-id_factura="' + factura.id_factura + '"><span class="glyphicon glyphicon-pencil"></span>Editar</a>' +
                        '<a class="pull-right eliminar" data-id_factura="' + factura.id_factura + '"><span class="glyphicon glyphicon-remove"></span>Eliminar</a>' +
                        '</td>' +
                        '</tr>';
                $("#cuerpoTablaFactura").append(html);
                
            } else {
                //busco la fila
                var fila = $("#cuerpoTablaFactura").find("a[data-id_factura='" + id + "']").parent().parent();
                var html = '<td>' + 
                        '<td><a class="center-block seleccionar" data-id_factura="' + factura.id_factura + '"><span class="glyphicon glyphicon-eye-open"></span></a></td>' +
                        '<td>' + factura.nombre + '</td>' +
                        '<td>' + factura.apellido + '</td>' +
                        '<td>' + factura.titulo + '</td>' +
                        '<td>' + factura.calle + '</td>' +
                        '<td>' + factura.numero + '</td>' +
                        '<td>' +
                        '<a class="pull-left editar" data-id_factura="' + factura.id_factura + '"><span class="glyphicon glyphicon-pencil"></span>Editar</a>' +
                        '<a class="pull-right eliminar" data-id_factura="' + factura.id_factura + '"><span class="glyphicon glyphicon-remove"></span>Eliminar</a>' +
                        '</td>';
                fila.html(html);
            }
        };

        app.borrarFila = function(id) {
            var fila = $("#cuerpoTablaFactura").find("a[data-id_factura='" + id + "']").parent().parent().remove();

        };
        
        
        
        
        
        
        
        app.buscarProfesores = function() {

            var url = "../../controlador/ruteador/Ruteador.php?accion=buscar&nombreFormulario=factura";

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

            $.each(data, function(clave, persona) {
                html += '<tr>' +
                        '<td><a class="center-block seleccionar" data-id_factura="' + persona.id + '"><span class="glyphicon glyphicon-eye-open"></span></a></td>' +
                        '<td>' + persona.nombre + '</td>' +
                        '<td>' + persona.apellido + '</td>' +
                        '<td>' + persona.titulo + '</td>' +
                        '<td>' + persona.calle + '</td>' +
                        '<td>' + persona.numero + '</td>' +
                        '<td>' +
                        '<a class="pull-left editar" data-id_factura="' + persona.id + '"><span class="glyphicon glyphicon-pencil"></span>Editar</a>' +
                        '<a class="pull-right eliminar" data-id_factura="' + persona.id + '"><span class="glyphicon glyphicon-remove"></span>Eliminar</a>' +
                        '</td>' +
                        '</tr>';
            });
            $("#cuerpoTablaFactura").html(html);
        };





        app.init();

    })(TallerAvanzada);


});
