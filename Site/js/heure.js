function loadSeanceList() {
    console.log("test");

    var annee_scolaire = $("#annee_scolaire").val();
    var composante = $("#composante").val();
    var prof = $("#prof").val();
    var url = "index.php?page=heure&annee_scolaire=" + annee_scolaire + "&composante=" + composante + "&prof=" + prof + "&ajax&" + Math.random();

    $.ajax({
        type: "GET",
        url: url,
        cache: false,
        dateType: 'html',
        success: function(data) {
            $("#tableContent").html(data);
			drawChart();
        },
        error: function(data) {
            console.log(data);
        }
    });

    return false;
}

$(document).ready(function() {
    $("#prof").change(loadSeanceList);
});

// Load the Visualization API and the piechart package.
google.load('visualization', '1', {
    'packages': ['corechart']
});

// Set a callback to run when the Google Visualization API is loaded.
google.setOnLoadCallback(drawChart);

function drawChart() {
	var annee_scolaire = $("#annee_scolaire").val();
    var composante = $("#composante").val();
    var prof = $("#prof").val();
    var url = "index.php?page=heure&annee_scolaire=" + annee_scolaire + "&composante=" + composante + "&prof=" + prof + "&json&" + Math.random();

    var jsonData = $.ajax({
        url: url,
        dataType: "json",
        async: false
    }).responseText;

    // Create our data table out of JSON data loaded from server.
    var data = new google.visualization.DataTable(jsonData);

    var options = {
        title: "Répartition des heures sur l'année ( en Heure )",
    };

    // Instantiate and draw our chart, passing in some options.
    var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
    chart.draw(data, options);
}
