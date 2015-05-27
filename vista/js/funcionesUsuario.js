$(function() {

    var TallerAvanzada = {};

    (function(app) {

        app.init = function() {
            $("#cerrarSesion").on('click', function(event) {
                document.location.href="../../CerrarSesion.php";
                event.preventDefault();
            });
            app.bindings();

        };
        
        app.bindings = function() {

            $("#agregarUsuario").on('click', function(event) {
                app.borrarCampos();
                $("#tituloModal").html("Nuevo Usuario");
                $("#modalUsuario").modal({show: true});
            });
            
            $("#cancelar").on("click", function(event) {
                document.location.href= "../../index.html";
            });

            $("#guardar").on("click", function(event) {
                event.preventDefault();
                app.guardarUsuario();
            });

            $("#formUsuario").bootstrapValidator({
                excluded: []
            });
        };
        
        app.borrarCampos = function (){
            $("#user").val("").html();
            $("#pass").val("").html();
        };
        
        app.guardarUsuario = function() {

            var url = "../../controlador/ruteador/Ruteador.php";
            //data del formulario persona
            var data = $("#formUsuario").serialize();
            $.ajax({
                url: url,
                method: 'POST',
                dataType: 'json',
                data: data,
                success: function(data) {
                    $("#modalUsuario").modal('hide');
                    app.borrarCampos();
                    alert('Usuario Creado Correctamente');
                    document.location.href= "../../index.html";
                },
                error: function(data) {
                    alert(data);
                }
            });
        };

        app.init();

    })(TallerAvanzada);

});
