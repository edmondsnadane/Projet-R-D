function modifyConfig()
{
    var weekend = $('#weekend :selected').val();
	var beginTime = $('#beginTime :selected').val();
	var endTime = $('#endTime :selected').val();

    $.ajax({
        type: "POST",
        url: "./script/modifyConfig.php",
        data: {
            weekend: weekend,
			beginTime: benginTime,
			endTime : endTime
        },
        cache: false,
        dateType: 'text',
        success: function(data)
		{
            $("#retourLoginJs")
                .html(data)
                .addClass('alert alert-success col-md-4 col-centered alert-dismissible');
        },
        error: function(data)
		{
            alert(data);
        }
    });
}