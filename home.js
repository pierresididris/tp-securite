$(document).ready(function(){
    baseUrl = "http://localhost/dev/a3/tp-securite/index.php?"
    $.ajax({
        url: `${baseUrl}connected-user`,
        type: 'GET',
        dataType: 'json',
        data: {
        },
        success: function(data, statut){
            console.log(data);
            displayList(data);
            if(!data.userConnected){
                $("#message").append("Vous n'êtes pas connecté");
            }
        },
        error: function(data, statut, error){
            console.log(data);
        }
    });

    function displayList(data){
        for(var i = 0 ; i < data.length ; i++){
            $("#list-user").append("<div class=\"col-3\">"+data[i].email+"</div>");
        }
    }
});