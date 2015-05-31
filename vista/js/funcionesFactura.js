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
                $("#tituloModal").html("Nuevo Profesor");
                $("#modalProfesor").modal({show: true});
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

            $("#cuerpoTablaProfesor").on('click', '.editar', function(event) {

                $("#id").val($(this).attr("data-id_profesor"));

                $("#nombre").val($(this).parent().parent().children().first().html());
                $("#apellido").val($(this).parent().parent().children().first().next().html());
                $("#titulo").val($(this).parent().parent().children().first().next().next().html());
                $("#calle").val($(this).parent().parent().children().first().next().next().next().html());
                $("#numero").val($(this).parent().parent().children().first().next().next().next().next().html());
                $("#guardar").html("Modificar");
                $("#guardar").attr("value","Modificar");
                $("#tituloModal").html("Editar Profesor");
                $("#modalProfesor").modal({show: true});
            });
            
            app.buscarXcriterio = function (txtBuscar, btnCriterio){
            var valor = txtBuscar;
            var crit = btnCriterio;
            var url = "../../controlador/ruteador/Ruteador.php?accion=buscarX&nombreFormulario=Profesor&criterio=" + crit +"&valor=" + valor;
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

            $("#cuerpoTablaProfesor").on('click', '.eliminar', function() {
                app.eliminarProfesor($(this).attr("data-id_profesor"));
            });

            $("#cancelar").on("click", function(event) {
                event.preventDefault();
                app.borrarCampos();
                $("#modalProfesor").modal('hide');
            });

            $("#guardar").on("click", function(event) {
                event.preventDefault();
                app.guardarProfesor();
            });

            $("#formProfesor").bootstrapValidator({
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
        
        app.guardarProfesor = function() {
            
            var url = "../../controlador/ruteador/Ruteador.php"; //cambiar url
            //data del formulario persona
            var data = $("#formProfesor").serialize();
            $.ajax({
                url: url,
                method: 'POST',
                dataType: 'json',
                data: data,
                success: function(datos) {
                    $("#modalProfesor").modal('hide');
                    app.actualizarTabla(datos, $("#id").val());
                },
                error: function(data) {
                    alert(data);
                }
            });
        };
        app.eliminarProfesor = function(id) {

            var url = "../../controlador/ruteador/Ruteador.php?accion=eliminar&nombreFormulario=Profesor&id=" + id; 

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

            $.each(data, function(clave, profesor) {
                html += '<tr>' +
                        '<td><a class="center-block seleccionar" data-id_profesor="' + profesor.id + '"><span class="glyphicon glyphicon-eye-open"></span></a>' +
                        '<td>' + profesor.nombre + '</td>' +
                        '<td>' + profesor.apellido + '</td>' +
                        '<td>' + profesor.titulo + '</td>' +
                        '<td>' + profesor.calle + '</td>' +
                        '<td>' + profesor.numero + '</td>' +
                        '<td>' +
                        '<a class="pull-left editar" data-id_profesor="' + profesor.id + '"><span class="glyphicon glyphicon-pencil"></span>Editar</a>' +
                        '<a class="pull-right eliminar" data-id_profesor="' + profesor.id + '"><span class="glyphicon glyphicon-remove"></span>Eliminar</a>' +
                        '</td>' +
                        '</tr>';
            });

            $("#cuerpoTablaProfesor").html(html);
        };

        app.actualizarTabla = function(profesor, id) {
            if (id == 0) {
                var html = '<tr>' +
                        '<td><a class="center-block seleccionar" data-id_profesor="' + profesor.id + '"><span class="glyphicon glyphicon-eye-open"></span></a></td>' +
                        '<td>' + profesor.nombre + '</td>' +
                        '<td>' + profesor.apellido + '</td>' +
                        '<td>' + profesor.titulo + '</td>' +
                        '<td>' + profesor.calle + '</td>' +
                        '<td>' + profesor.numero + '</td>' +
                        '<td>' +
                        '<a class="pull-left editar" data-id_profesor="' + profesor.id + '"><span class="glyphicon glyphicon-pencil"></span>Editar</a>' +
                        '<a class="pull-right eliminar" data-id_profesor="' + profesor.id + '"><span class="glyphicon glyphicon-remove"></span>Eliminar</a>' +
                        '</td>' +
                        '</tr>';
                $("#cuerpoTablaProfesor").append(html);
                
            } else {
                //busco la fila
                var fila = $("#cuerpoTablaProfesor").find("a[data-id_profesor='" + id + "']").parent().parent();
                var html = '<td>' + 
                        '<td><a class="center-block seleccionar" data-id_profesor="' + profesor.id + '"><span class="glyphicon glyphicon-eye-open"></span></a></td>' +
                        '<td>' + profesor.nombre + '</td>' +
                        '<td>' + profesor.apellido + '</td>' +
                        '<td>' + profesor.titulo + '</td>' +
                        '<td>' + profesor.calle + '</td>' +
                        '<td>' + profesor.numero + '</td>' +
                        '<td>' +
                        '<a class="pull-left editar" data-id_profesor="' + profesor.id + '"><span class="glyphicon glyphicon-pencil"></span>Editar</a>' +
                        '<a class="pull-right eliminar" data-id_profesor="' + profesor.id + '"><span class="glyphicon glyphicon-remove"></span>Eliminar</a>' +
                        '</td>';
                fila.html(html);
            }
        };

        app.borrarFila = function(id) {
            var fila = $("#cuerpoTablaProfesor").find("a[data-id_profesor='" + id + "']").parent().parent().remove();

        };
        
        
        
        
        
        
        
        app.buscarProfesores = function() {

            var url = "../../controlador/ruteador/Ruteador.php?accion=buscar&nombreFormulario=Profesor";

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
                        '<td><a class="center-block seleccionar" data-id_profesor="' + persona.id + '"><span class="glyphicon glyphicon-eye-open"></span></a></td>' +
                        '<td>' + persona.nombre + '</td>' +
                        '<td>' + persona.apellido + '</td>' +
                        '<td>' + persona.titulo + '</td>' +
                        '<td>' + persona.calle + '</td>' +
                        '<td>' + persona.numero + '</td>' +
                        '<td>' +
                        '<a class="pull-left editar" data-id_profesor="' + persona.id + '"><span class="glyphicon glyphicon-pencil"></span>Editar</a>' +
                        '<a class="pull-right eliminar" data-id_profesor="' + persona.id + '"><span class="glyphicon glyphicon-remove"></span>Eliminar</a>' +
                        '</td>' +
                        '</tr>';
            });
            $("#cuerpoTablaProfesor").html(html);
        };





        app.init();

    })(TallerAvanzada);


});
