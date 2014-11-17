function displayDroits()
{
		var codeProf = $('#profs :selected').val();
		
		$.ajax({
			type: "POST",
			url: "./script/getDroitsByCodeProf.php",
			data: {
				code: codeProf,
			},
			dataType: "json"
		})
		.done(function(elem)
		{
			if (elem.admin == 1)
			{
				$("#admin").addClass("active");
			}
			else
			{
				$("#admin").removeClass("active");
			}
			
			if (elem.giseh == 1)
			{
				$("#giseh").addClass("active");
			}
			else
			{
				$("#giseh").removeClass("active");
			}
			
			if (elem.bilan_formation == 1)
			{
				$("#bilan_formation").addClass("active");
			}
			else
			{
				$("#bilan_formation").removeClass("active");
			}
			
			if (elem.salle == 1)
			{
				$("#bilan_salle").addClass("active");
			}
			else
			{
				$("#bilan_salle").removeClass("active");
			}
			
			if (elem.mes_droits == 1)
			{
				$("#droits").addClass("active");
			}
			else
			{
				$("#droits").removeClass("active");
			}
			
			if (elem.bilan_heure_global == 1)
			{
				$("#bilan_heure").addClass("active");
			}
			else
			{
				$("#bilan_heure").removeClass("active");
			}
			
			if (elem.pdf == 1)
			{
				$("#pdf").addClass("active");
			}
			else
			{
				$("#pdf").removeClass("active");
			}
			
			if (elem.rss == 1)
			{
				$("#rss").addClass("active");
			}
			else
			{
				$("#rss").removeClass("active");
			}
			
			if (elem.configuration == 1)
			{
				$("#config").addClass("active");
			}
			else
			{
				$("#config").removeClass("active");
			}
			
			if (elem.reservation == 1)
			{
				$("#reservation").addClass("active");
			}
			else
			{
				$("#reservation").removeClass("active");
			}
	
			if (elem.module == 1)
			{
				$("#modules").addClass("active");
			}
			else
			{
				$("#modules").removeClass("active");
			}
			
			if (elem.dialogue == 1)
			{
				$("#dialogue").addClass("active");
			}
			else
			{
				$("#dialogue").removeClass("active");
			}
			
			if (elem.bilan_heure == 1)
			{
				$("#heures").addClass("active");
			}
			else
			{
				$("#heures").removeClass("active");
			}
		})
		.fail(function(elem)
		{
			alert("Appel AJAX impossible");
		});
}

$(document).ready(function()
{
	displayDroits();
	
	$('#modifyConfigForm').submit(function(event)
	{

        event.preventDefault();

        $.ajax({
                type: "POST",
                url: "./script/updateDroits.php",
                data: {
                    code: $('#profs :selected').val(),
					admin: $('#admin :active'),
					reservation: $('#reservation :active'),
					mes_droits : $('#droits :active'),
                    modules  : $('#modules :active'),
					bilan_heure_global : $("#bilan_heure :active"),
					bilan_heure : $("#heures :active"),
					configuration : $("#config :active"),
					rss : $("#rss :active"),
					bilan_formation : $("#bilan_formation :active"),
					pdf : $("#pdf :active"),
					giseh : $("#giseh :active"),
					dialogue : $("#dialogue :active"),
					salle : $("#bilan_salle :active")
                },
                dataType: "text"
            })
            .done(function(elem)
			{
                // connexion échouée
                $("#retourLoginJs")
                    .html("<span class='glyphicon glyphicon-ok-circle'></span> "  + elem)
                    .addClass('alert alert-success col-centered alert-dismissible');
            })
            .fail(function(elem)
			{
                alert("Appel AJAX impossible");
            });
    });
});