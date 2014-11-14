function displayDroits()
{
		var codeProf = $('#profs :selected').val();

		event.preventDefault();

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
			// TODO
		})
		.fail(function(elem)
		{
			alert("Appel AJAX impossible");
		});
}