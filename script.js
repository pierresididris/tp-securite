$(document).ready(function(){
    $("#btn-dnx").hide();
    $("#form-register-error-email").hide();
    $("#form-register-error-pwd").hide();
    $("#form-register-error-profil").hide();
    $("#success-connection").hide();
    $("#success-inscription").hide();
    
    $("#submit").click(function(){
        $("#form-register-error-email").hide();
        $("#form-register-error-pwd").hide();
        $("#form-register-error-profil").hide();

        var email = $("#email").val();

        var pwd = $("#password").val();
        var pwdCheck = $("#passwordCheck").val()
        
        var profil = $("#profil").val();

        const baseUrl = "http://localhost/dev/a3/tp-securite/index.php?"

        if(checkMail(email) && checkPwd(pwd, pwdCheck) && checkProfil(profil)){
            $.ajax({
                url: `${baseUrl}add-user`,
                type: 'POST',
                dataType: 'json',
                data: {
                    'email' : email,
                    'pwd' : pwd,
                    'profil': profil
                },
                success: function(data, statut){
                    console.log(data)
                    if(!data.result){
                        if(data.memberAlreadyExists){
                            $("#form-register-error-email").show();
                        }
                    }else{
                        $.get("./form-connection.html", function(data){
                            $("#container").html(null);
                            $("#container").html(data);
                        });
                    }
                },
                error: function(data, statut, error){
                    console.log(data);
                }
            });
        }else {
            if(!checkPwd(pwd, pwdCheck)){
                $("#form-register-error-pwd").show();
            }
            if(!checkProfil(profil)){
                $("#form-register-error-profil").show();
            }
        }
    });

    function checkMail(email){
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    }

    function checkPwd(pwd, pwdCheck){
        var result = false;
        if (pwd === pwdCheck){
            result = true;
        }
        return result;
    }

    function checkProfil(profil){
        var result = false;
        if (profil != "" && profil != 0 ){
            result = true;
        }
        return result;
    }

    $("#btn-iscpt").click(function(){
        $.get('./form-register.html', function(data){
            var temp = data;
            $("#container").html(null);
            $("#container").append(temp);
        });
    });

    $("#btn-cnx").click(function(){
        $.get('./form-connection.html', function(data){
            var temp = data;
            $("#container").html(null);
            $("#container").append(temp);
        });
    });

    $("#btn-connection").click(function(){
        const baseUrl = "http://localhost/dev/a3/tp-securite/index.php?"
        
        var email = $("#connection-email").val();
        var pwd = $("#connection-pwd").val();
        if(checkMail(email)){
            $.ajax({
                url: `${baseUrl}connect-user`,
                type: 'POST',
                dataType: 'json',
                data: {
                    'email' : email,
                    'pwd' : pwd,
                },
                success: function(data, statut){
                    console.log(data)
                    if(data.userId != "error"){
                        $("#btn-cnx").hide();
                        $("#btn-dnx").show();
                        $("#success-connection").show();
                        $.get('./home.html', function(data){
                            $("#container").html(null);
                            $("#container").append(data);
                        });
                        $("#btn-iscpt").hide();
                    }
                },
                error: function(data, statut, error){
                    console.log(data);
                }
            });
        }
    });
    
    $("#btn-dnx").click(function(){
        const baseUrl = "http://localhost/dev/a3/tp-securite/index.php?"

        $.ajax({
            url: `${baseUrl}deconnect-user`,
            type: 'POST',
            dataType: 'json',
            data: {
            },
            success: function(data, statut){
                console.log(data);
                if(data.sessionDestroy){
                    $("#btn-cnx").show();
                    $("#btn-dnx").hide();
                    $("#btn-iscpt").show();
                    $("#container").html(null);
                }
            },
            error: function(data, statut, error){
                console.log(data);
            }
        });
    });
});