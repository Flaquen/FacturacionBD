$(function() {

    var TallerAvanzada = {};

    (function(app) {

        app.init = function() {
            $("#cerrarSesion").on('click', function(event) {
                document.location.href="../../CerrarSesion.php";
                event.preventDefault();
            });
            
            app.buscarAlumnos();
            app.bindings();

        };
        app.bindings = function() {

            $("#agregar").on('click', function(event) {
                app.borrarCampos();
                $("#id").val(0);
                $("#tituloModal").html("Nuevo Alumno");
                $("#modalAlumno").modal({show: true});
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
            $("#cLeg").on('click', function (event){//si click en el elemento del combo Legajo, muestra legajo
                $("#btnCriterio").attr("value","legajo");
                $("#btnCriterio").html("Legajo <span class=\"caret\"></span>");      

            });
            $("#cCal").on('click', function (event){//si click en el elemento del combo Calle, muestra calle
                $("#btnCriterio").attr("value","calle");
                $("#btnCriterio").html("Calle <span class=\"caret\"></span>");      

            });
            
            $("#reporte").on('click', function(event) {
                document.location.href="reporteAlumnos.php";
            });

            $("#cuerpoTablaAlumno").on('click', '.editar', function(event) {

                $("#id").val($(this).attr("data-id_alumno"));

                $("#nombre").val($(this).parent().parent().children().first().html());
                $("#apellido").val($(this).parent().parent().children().first().next().html());
                $("#legajo").val($(this).parent().parent().children().first().next().next().html());
                $("#calle").val($(this).parent().parent().children().first().next().next().next().html());
                $("#numero").val($(this).parent().parent().children().first().next().next().next().next().html());
                $("#guardar").html("Modificar");
                $("#guardar").attr("value","Modificar");
                $("#tituloModal").html("Editar Alumno");
                $("#modalAlumno").modal({show: true});
            });

            $("#cuerpoTablaAlumno").on('click', '.eliminar', function() {
                app.eliminarAlumno($(this).attr("data-id_alumno"));
            });

            $("#cancelar").on("click", function(event) {
                event.preventDefault();
                app.borrarCampos();
                $("#modalAlumno").modal('hide');
            });

            $("#guardar").on("click", function(event) {
                event.preventDefault();
                app.guardarAlumno();
            });

            $("#formAlumno").bootstrapValidator({
                excluded: []
            });
        };
        
        app.borrarCampos = function (){
            $("#nombre").val("").html();
            $("#apellido").val("").html();
            $("#legajo").val("").html();
            $("#calle").val("").html();
            $("#numero").val("").html();
            
        }; 
        
        app.buscarXcriterio = function (txtBuscar, btnCriterio){
            var valor = txtBuscar;
            var crit = btnCriterio;
            var url = "../../controlador/ruteador/Ruteador.php?accion=buscarX&nombreFormulario=Alumno&criterio=" + crit +"&valor=" + valor;
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
        
        app.guardarAlumno = function() {
            
            var url = "../../controlador/ruteador/Ruteador.php"; //cambiar url
            //data del formulario persona
            var data = $("#formAlumno").serialize();
            $.ajax({
                url: url,
                method: 'POST',
                dataType: 'json',
                data: data,
                success: function(datos) {
                    $("#modalAlumno").modal('hide');
                    app.actualizarTabla(datos, $("#id").val());
                },
                error: function(data) {
                    alert(data);
                }
            });
        };
        app.eliminarAlumno = function(id) {

            var url = "../../controlador/ruteador/Ruteador.php?accion=eliminar&nombreFormulario=Alumno&id=" + id; //cambiar url

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
            
            $.each(data, function(clave, alumno) {
                
                html += '<tr>' +
                        '<td><a class="center-block seleccionar" data-id_alumno="' + alumno.id + '"><span class="glyphicon glyphicon-eye-open"></span> </a></td>' +
                        '<td>' + alumno.nombre + '</td>' +
                        '<td>' + alumno.apellido + '</td>' +
                        '<td>' + alumno.legajo + '</td>' +
                        '<td>' + alumno.calle + '</td>' +
                        '<td>' + alumno.numero + '</td>' +
                        '<td>' +
                        '<a class="pull-left editar" data-id_alumno="' + alumno.id + '"><span class="glyphicon glyphicon-pencil"></span>Editar</a>' +
                        '<a class="pull-right eliminar" data-id_alumno="' + alumno.id + '"><span class="glyphicon glyphicon-remove"></span>Eliminar</a>' +
                        '</td>' +
                        '</tr>';
            });

            $("#cuerpoTablaAlumno").html(html);
        };
        

        app.actualizarTabla = function(alumno, id) {
            if (id == 0) {
                var html = '<tr>' +
                        '<td><a class="center-block seleccionar" data-id_alumno="' + alumno.id + '"><span class="glyphicon glyphicon-eye-open"></span> </a></td>' +
                        '<td>' + alumno.nombre + '</td>' +
                        '<td>' + alumno.apellido + '</td>' +
                        '<td>' + alumno.legajo + '</td>' +
                        '<td>' + alumno.calle + '</td>' +
                        '<td>' + alumno.numero + '</td>' +
                        '<td>' +
                        '<a class="pull-left editar" data-id_alumno="' + alumno.id + '"><span class="glyphicon glyphicon-pencil"></span>Editar</a>' +
                        '<a class="pull-right eliminar" data-id_alumno="' + alumno.id + '"><span class="glyphicon glyphicon-remove"></span>Eliminar</a>' +
                        '</td>' +
                        '</tr>';
                $("#cuerpoTablaAlumno").append(html);
                
            } else {
                //busco la fila
                var fila = $("#cuerpoTablaAlumno").find("a[data-id_alumno='" + id + "']").parent().parent();
                var html = '<td>' + 
                        '<td><a class="center-block seleccionar" data-id_alumno="' + alumno.id + '"><span class="glyphicon glyphicon-eye-open"></span> </a></td>' +
                        alumno.nombre + '</td>' +
                        '<td>' + alumno.apellido + '</td>' +
                        '<td>' + alumno.legajo + '</td>' +
                        '<td>' + alumno.calle + '</td>' +
                        '<td>' + alumno.numero + '</td>' +
                        '<td>' +
                        '<a class="pull-left editar" data-id_alumno="' + alumno.id + '"><span class="glyphicon glyphicon-pencil"></span>Editar</a>' +
                        '<a class="pull-right eliminar" data-id_alumno="' + alumno.id + '"><span class="glyphicon glyphicon-remove"></span>Eliminar</a>' +
                        '</td>';
                fila.html(html);
            }
        };

        app.borrarFila = function(id) {
            var fila = $("#cuerpoTablaAlumno").find("a[data-id_alumno='" + id + "']").parent().parent().remove();

        };
        
        
        
        
        
        
        app.buscarAlumnos = function() {

            var url = "../../controlador/ruteador/Ruteador.php?accion=buscar&nombreFormulario=Alumno";

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
                        '<td><a class="center-block seleccionar" data-id_alumno="' + persona.id + '"><span class="glyphicon glyphicon-eye-open"></span></a></td>' +
                        '<td>' + persona.nombre + '</td>' +
                        '<td>' + persona.apellido + '</td>' +
                        '<td>' + persona.legajo + '</td>' +
                        '<td>' + persona.calle + '</td>' +
                        '<td>' + persona.numero + '</td>' +
                        '<td>' +
                        '<a class="pull-left editar" data-id_alumno="' + persona.id + '"><span class="glyphicon glyphicon-pencil"></span>Editar</a>' +
                        '<a class="pull-right eliminar" data-id_alumno="' + persona.id + '"><span class="glyphicon glyphicon-remove"></span>Eliminar</a>' +
                        '</td>' +
                        '</tr>';
            });
            $("#cuerpoTablaAlumno").html(html);
        };





        app.init();

    })(TallerAvanzada);


});
