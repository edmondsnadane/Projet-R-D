function loadGroupesListFilter()
{
    var codeGroupe = $('#groupesFilter :selected').val();

    addGroupesToOptions = function(groupes)
	{
        $('#groupesFormationsFilter').empty();
        if (groupes.length) {
            for (i = 0; i < groupes.length; i++)
	    {
                groupesInfos = groupes[i].split("#");
                $('#groupesFormationsFilter').append("<option value=" + groupesInfos[0] + ">" + groupesInfos[1] + "</option>");
            }
        }
    };

    $.ajax({
        type: "POST",
        url: "./script/getGroupesByFormation.php",
        data: {
            code: codeGroupe
        },
        cache: false,
        dateType: 'text',
        success: function(data)
		{
            addGroupesToOptions(data.split("~"));
        },
        error: function(data)
		{
            alert(data);
        }
    });
}


function loadProfsListFilter()
{
    var codeComposante = $('#profsComposantesFilter :selected').val();

    addProfsToOptions = function(profs)
	{
        $('#profsFilter').empty();
        if (profs.length) {
            for (i = 0; i < profs.length; i++)
	    {
                profInfos = profs[i].split("#");
                $('#profsFilter').append("<option value=" + profInfos[0] + ">" + profInfos[1] + " " + profInfos[2] + "</option>");
            }
        }
    };

    $.ajax({
        type: "POST",
        url: "./script/getTeacherByComposante.php",
        data: {
            code: codeComposante
        },
        cache: false,
        dateType: 'text',
        success: function(data)
		{
            addProfsToOptions(data.split("~"));
        },
        error: function(data)
		{
            alert(data);
        }
    });
}

function loadSallesListFilter()
{
    var codeSalle = $('#departementFilter :selected').val();

    addSallesToOptions = function(salles)
	{
        $('#salleFilter').empty();
        if (salles.length) {
            for (i = 0; i < salles.length; i++)
	    {
                sallesInfos = salles[i].split("#");
                $('#salleFilter').append("<option value=" + sallesInfos[0] + ">" + sallesInfos[1] + "</option>");
            }
        }
    };

    $.ajax({
        type: "POST",
        url: "./script/getSallesByDepartements.php",
        data: {
            code: codeSalle
        },
        cache: false,
        dateType: 'text',
        success: function(data)
		{
            addSallesToOptions(data.split("~"));
        },
        error: function(data)
		{
            alert(data);
        }
    });
}