$(document).ready(function()
{

    // connexion teacher
    $('#teachConnect').submit(function(event)
	{

        event.preventDefault();

        $.ajax({
                type: "POST",
                url: "script/teachConnectScript.php",
                data: {
                    teachLogin: $("#inputLoginEnseignement").val(),
                    teachPwd: $("#inputPasswordEnseignement").val()
                },
                dataType: "json"
            })
            .done(function(elem)
			{
                if (elem.connexion === true)
				{
                    // connexion réussie
                    window.location.replace('index.php');
                } 
				else
				{
                    // connexion échouée
                    $("#retourLoginJs")
                        .html(elem.message)
                        .addClass('alert alert-danger col-md-4 col-centered alert-dismissible')
                        .show();
                }
            })
            .fail(function(elem)
			{
                alert("Appel AJAX impossible");
            });
    });

    // connexion student
    $('#studyConnect').submit(function(event)
	{

        event.preventDefault();

        $.ajax({
                type: "POST",
                url: "script/studyConnectScript.php",
                data:
				{
                    studyLogin: $("#inputLoginEtudiant").val(),
                },
                dataType: "json"
            })
            .done(function(elem)
			{
                if (elem.connexion === true)
				{
                    // connexion réussie
                    window.location.replace('index.php');
                }
				else
				{
                    // connexion échouée
                    $("#retourLoginJs")
                        .html(elem.message)
                        .addClass('alert alert-danger col-md-4 col-centered alert-dismissible')
                        .show();
                }
            })
            .fail(function(elem)
			{
                alert("Appel AJAX impossible");
            });
    });

    $('.btn-success').click(function()
	{

        $("#retourLoginJs").hide();

    });
});
