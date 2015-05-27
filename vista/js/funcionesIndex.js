$(function() {

    var TallerAvanzada = {};

    (function(app) {
        
        app.init = function() {
            $("#btnLogin").on('click', function(event) {
                app.validar();
                event.preventDefault();
            });
            $("#user").on('click', function(event) {
                $("#user").css("background-color","white").val('');
                $("#pass").css("background-color","white").val('');
                event.preventDefault();
            });
            $("#pass").on('click', function(event) {
                $("#user").css("background-color","white").val('');
                $("#pass").css("background-color","white").val('');
                event.preventDefault();
            });
        };


        app.validar = function() {
            var url = "controlador/ruteador/Seguridad.php";
            var data = $("#frmLogin").serialize();
            $.ajax({
                url: url,
                method: 'POST',
                dataType: 'json',
                data: data,
                success: function(data) {
                    app.rellenardiv(data);
                },
                error: function() {
                    alert('ERROR');
                    
                }

            });
        };
        app.rellenardiv = function(data) {
            var html = "";
            if(data.hasOwnProperty("user")) {
                document.location.href ="admin.html";
            }else{
                html += "<div class='alert alert-danger' role='alert'><p>" + "USUARIO Y/O CONTRASEÑA INVALIDOS" + "</p></div>";
                $("#loginError").html(html);
                $("#user").css("background-color","red");
                $("#pass").css("background-color","red");
            }
        };
        app.init();

    })(TallerAvanzada);


});
