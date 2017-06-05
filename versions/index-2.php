<?php

  error_reporting(0);

  if(!empty($_GET['city'])) {

    $town = htmlspecialchars($_GET["city"]);
    $town = strtolower($town);
    $town = str_replace(" ", "", $town);

    //print_r($town);

    $page = file_get_contents("http://www.weather-forecast.com/locations/$town/forecasts/latest");

    if($page !== false) {

      $needle = '3 Day Weather Forecast Summary:</b><span class="read-more-small"><span class="read-more-content"> <span class="phrase">';

      $pageArray = explode($needle, $page);

      $weather = explode("</span></span></span>", $pageArray[1]);

      $weather[0] = "<strong>Weather Report Summary: </strong>" . $weather[0];

      $type = "warning";
    } else {

      $weather[0] = "<strong>Failed to load weather report!</strong> Type again or try later.";

      $type = "danger";
    }

  }

?>
<!DOCTYPE html>
<html>
<head>
  <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Smart Watch Dashboard</title>
  <!-- Bootstrap 4 CSS -->
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <!-- Latest compiled and minified jQuery -->
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

  <!-- Amcharts Libraries -->
  <script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
  <script src="https://www.amcharts.com/lib/3/serial.js"></script>
  <script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
  <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
  <script src="https://www.amcharts.com/lib/3/themes/light.js"></script>

  <style type="text/css">
  html, body {
    height: 100%;
  }
  html {
    overflow-y: hidden;
  }
  body {
    overflow-y: scroll;
  }
  body {
    background: url(background.jpg) no-repeat center fixed;
    background-size: cover;
  }
  .dl-horizontal dt, .dl-horizontal dd {
    width:auto;
      margin-left:auto;
      margin-right: 10px;
  }
  #bpm_vitals, #temp_vitals, #pressure_vitals {
  width : 100%;
  height  : 500px;
  }
  a:hover {
    filter: brightness(50%);
    text-decoration: none;
  }
  .well {
    height: 255px !important;
  }
  .well-weather {
    height: auto !important;
  }
  @media only screen and (max-device-width: 480px) {
    #bpm_vitals, #temp_vitals, #pressure_vitals {
      width : 100%;
      height  : 400px;
    }
    .well {
      height: auto !important;
    }
  }
  </style>
</head>
<body>

<div class="container-fluid">
  
  <h1>Tu/e smart watch dashboard !</h1>

  <div class="btn-group" role="group" aria-label="buttons">
      <button id="home_click" type="button" class="btn btn-default"><span class="glyphicon glyphicon-home"></span> Home</button>
      <button id="settings_click" type="button" class="btn btn-default"><span class="glyphicon glyphicon-cog"></span> Settings</button>
      <button id="about_click" type="button" class="btn btn-default"><span class="glyphicon glyphicon-info-sign"></span> About</button>
  </div>

  <!-- Single button -->
  <div class="btn-group">
    <button id="plus" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <span class="glyphicon glyphicon-th-list"></span>
    </button>
    <ul class="dropdown-menu">
      <li><a href="#">Hide / Show elements</a></li>
      <li role="separator" class="divider"></li>
      <li><a href="#" class="small" data-value="option1" tabIndex="-1"><input id="home_check" type="checkbox" checked/>&nbsp;Home</a></li>
      <li><a href="#" class="small" data-value="option2" tabIndex="-1"><input id="vital_check" type="checkbox" checked/>&nbsp;Vital Signs</a></li>
      <li><a href="#" class="small" data-value="option3" tabIndex="-1"><input id="condition_check" type="checkbox" checked/>&nbsp;Atmospheric Conditions</a></li>
      <li><a href="#" class="small" data-value="option4" tabIndex="-1"><input id="warning_check" type="checkbox" checked/>&nbsp;Warnings</a></li>
  </ul>
  </div>

  <div id="content_home">
  <div class="row">

    <div class="col-md-3">
      <h3>Home <a role="button"><small id="home_hide">hide</small></a></h3>
      <div id="home_us" class="well">
        <p>This <code>section</code> displays general information received from the watch.</p>
        <dl class="dl-horizontal">
          <dt>Date</dt><dd id="date">19/05/2017</dd>
          <dt>Time</dt><dd id="time">21:37</dd>
          <dt>GPS Coordinates</dt><dd id="gps">latitude / longitute</dd>
        </dl>
      </div>
    </div>

    <div class="col-md-3">
      <h3>Vital Signs <a role="button"><small id="vital_hide">hide</small></a></h3>
      <div id="vital_us" class="well">
        <p>This <code>section</code> displays the vital signs received from the watch.</p>
        <dl class="dl-horizontal">
          <dt>Heart rate</dt><dd id="rate">60 bpm</dd>
          <dt>Blood pressure</dt><dd>(120/80)</dd>
          <dt>Body temperature</dt><dd>20&deg;C</dd>
          <dt>Skin temperature</dt><dd>24&deg;C</dd>
          <dt>Skin conductivity</dt><dd>5.586</dd>
        </dl>

          <button id="bpm_graph" type="button" class="btn btn-default">Avg. bpm</button>
          <button id="pressure_graph" type="button" class="btn btn-default">Blood pressure</button>
          <button id="temp_graph" type="button" class="btn btn-default">Body temp.</button>

      </div>
    </div>

    <div class="col-md-3">
      <h3>Atmospheric Conditions <a role="button"><small id="condition_hide">hide</small></a></h3>
      <div id="condition_us" class="well">

        <p>This <code>section</code> displays the atmospheric conditions as recorded by the watch.</p>
        <dl class="dl-horizontal">
          <dt>Ambient temperature</dt><dd>20&deg;C</dd>
          <dt>Ambient humidity</dt><dd>92%</dd>
        </dl>

        <form>
          <div class="form-group">
            <p>Enter the name of a city to get a weather report.</p>
            <input type="text" class="form-control" id="city" name="city" placeholder="Eg. London, Tokyo">
            <small id="cityHelp" class="form-text text-muted">We'll never share your location with anyone else.</small>
            <button id="weather-submit" type="submit" class="btn btn-default">Get weather</button>
          </div>
        </form>

      </div>
    </div>

    <div class="col-md-3">
      <h3>Warnings <a role="button"><small id="warning_hide">hide</small></a></h3>
      <div id="warning_us" class="well">
        <p>This <code>section</code> displays various warnings received from the watch.</p>
        <div class="alert alert-danger" role="alert">
        <a type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </a>
            <strong>Warning!</strong> Better check yourself, you're <a href="#" class="alert-link">not looking too good</a>.
        </div>
      </div>
    </div>

    <!--
    <div class="alert alert-warning" role="alert">
    <a type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </a>
        <strong>Heads up!</strong> This <a href="#" class="alert-link">alert needs your attention</a>, but it's not super important.
    </div>
    -->
  </div>
  <!-- The following <div> represents the second row on the home page -->
  <div class="row">

    <div id="bpm_graph" class="col-md-6">
      <div>
        <h3>Average heart rate by day</h3>
      </div>
      <div id="bpm_vitals"></div>
    </div>
    
    <div id="pressure_graph" class="col-md-6">
      <div>
        <h3>Average blood pressure by day</h3>
      </div>
      <div id="pressure_vitals"></div>
    </div>

    <div id="temp_graph" class="col-md-6">
      <div>
        <h3>Average body temperature by day</h3>
      </div>
      <div id="temp_vitals"></div>
    </div>

    <div id="weather_report" class="col-md-3">
      <h3 id="weather-title">Weather Report</h3>
      <?php

      if(!empty($weather[0])) {

        echo '<div class="well well-weather">' . $weather[0] . '</div>';
      }

    ?>
    </div>

  </div>
  </div>

  <div id="content_settings">
    <h3>Settings</h3>
    <p>Settings <code>page</code> gives the customization options.</p>
  </div>

  <div id="content_about">
    <h3>About</h3>
    <p>About <code>page</code> displays information about the application.</p>
  </div>
</div>

<script type="text/javascript">
  
  $("document").ready(function() {

    $("div[id^='content']").hide();

    $("#content_home").show();

    var date = new Date();
    var time = date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds();

    var dateFormat = date.getFullYear()+"-"+("0"+(date.getMonth()+1)).slice(-2)+"-"+("0" + date.getDate()).slice(-2);
    var year = date.getFullYear();
    var month = (date.getMonth()+1);
    var day = (date.getDate());

    var rate = getRandomInt(50,70) + " bpm";
    $("#rate").text(rate);

    $("#date").text(date);
    $("#time").text(time);

    $("button[id*=_click]").click(function() {

      if(this.id == "plus") return;

      $("div[id^='content']").hide();

      var value = $(this).text().toLowerCase();
      value = value.trim()

      $("#content_" + value).show();
    });

    $("button[id*=_graph]").click(function() {

      $("div[id*=graph]").hide();

      $("div[id="+this.id+"]").show();
    });

    var $_GET = {};

    document.location.search.replace(/\??(?:([^=]+)=([^&]*)&?)/g, function () {
      function decode(s) {
          return decodeURIComponent(s.split("+").join(" "));
      }

      $_GET[decode(arguments[1])] = decode(arguments[2]);
    });

    if($_GET["city"] != undefined) {
      $("#weather-title").show();
      console.log($_GET["city"]);
    } else {
      $("#weather-title").hide();
      console.log($_GET["city"]);
    }

    //vitalsArray is used to store random generated values for the bpm (beats per minute)
    //this is further used in the .makeChart method used by the amcharts plugin
    var bpmArray = [];
    var pressureArray = [];
    var tempArray = [];

    while(year < 2018) {
      while(month < 12) {
        while (day < 30) {
          
          if(month < 10) {
            var newDate = year + "-0" + month + "-" + day;
          }
          else {
            var newDate = year + "-" + month + "-" + day;
          }

          //generate random values for the bpms / pressures / temperatures
          var bpm = getRandomInt(40,70);
          var pressure = getRandomInt(80,150);
          var temperature = getRandomArbitrary(35,37);

          //populate the dictionaries bpmArray / pressureArray / tempArray with the random values generated
          //later to be used in generating the graphs for each section
          bpmArray.push({
          "date": newDate,
          "value": bpm
          });

          pressureArray.push({
            "date": newDate,
            "value": pressure
          });

          tempArray.push({
            "date": newDate,
            "value": temperature
          });

          day += 1;
        }
        month += 1;
        day = 1;
      }
      year += 1;
      month = 12;
    }

    var bpmSettings = {
      "type": "serial",
      "theme": "light",
      "marginRight": 20,
      "marginLeft": 20,
      "autoMarginOffset": 20,
      "mouseWheelZoomEnabled":true,
      "dataDateFormat": "YYYY-MM-DD",
      "valueAxes": [{
          "id": "v1",
          "axisAlpha": 0,
          "position": "left",
          "ignoreAxisWidth":true
      }],
      "balloon": {
          "borderThickness": 1,
          "shadowAlpha": 0
      },
      "graphs": [{
          "id": "g1",
          "balloon":{
            "drop":true,
            "adjustBorderColor":false,
            "color":"#ffffff"
          },
          "bullet": "round",
          "bulletBorderAlpha": 1,
          "bulletColor": "#FFFFFF",
          "bulletSize": 5,
          "hideBulletsCount": 50,
          "lineThickness": 2,
          "title": "red line",
          "useLineColorForBulletBorder": true,
          "valueField": "value",
          "balloonText": "<span style='font-size:18px;'>[[value]]</span>"
      }],
      "chartScrollbar": {
          "graph": "g1",
          "oppositeAxis":false,
          "offset":30,
          "scrollbarHeight": 80,
          "backgroundAlpha": 0,
          "selectedBackgroundAlpha": 0.1,
          "selectedBackgroundColor": "#888888",
          "graphFillAlpha": 0,
          "graphLineAlpha": 0.5,
          "selectedGraphFillAlpha": 0,
          "selectedGraphLineAlpha": 1,
          "autoGridCount":true,
          "color":"#AAAAAA"
      },
      "chartCursor": {
          "pan": true,
          "valueLineEnabled": true,
          "valueLineBalloonEnabled": true,
          "cursorAlpha":1,
          "cursorColor":"#258cbb",
          "limitToGraph":"g1",
          "valueLineAlpha":0.2,
          "valueZoomable":true
      },
      "valueScrollbar":{
        "oppositeAxis":false,
        "offset":50,
        "scrollbarHeight":10
      },
      "categoryField": "date",
      "categoryAxis": {
          "parseDates": true,
          "dashLength": 1,
          "minorGridEnabled": true
      },
      "export": {
          "enabled": true
      },
      "dataProvider": bpmArray
  };

     var pressureSettings = {
      "type": "serial",
      "theme": "light",
      "marginRight": 20,
      "marginLeft": 20,
      "autoMarginOffset": 20,
      "mouseWheelZoomEnabled":true,
      "dataDateFormat": "YYYY-MM-DD",
      "valueAxes": [{
          "id": "v1",
          "axisAlpha": 0,
          "position": "left",
          "ignoreAxisWidth":true
      }],
      "balloon": {
          "borderThickness": 1,
          "shadowAlpha": 0
      },
      "graphs": [{
          "id": "g1",
          "balloon":{
            "drop":true,
            "adjustBorderColor":false,
            "color":"#ffffff"
          },
          "bullet": "round",
          "bulletBorderAlpha": 1,
          "bulletColor": "#FFFFFF",
          "bulletSize": 5,
          "hideBulletsCount": 50,
          "lineThickness": 2,
          "title": "red line",
          "useLineColorForBulletBorder": true,
          "valueField": "value",
          "balloonText": "<span style='font-size:18px;'>[[value]]</span>"
      }],
      "chartScrollbar": {
          "graph": "g1",
          "oppositeAxis":false,
          "offset":30,
          "scrollbarHeight": 80,
          "backgroundAlpha": 0,
          "selectedBackgroundAlpha": 0.1,
          "selectedBackgroundColor": "#888888",
          "graphFillAlpha": 0,
          "graphLineAlpha": 0.5,
          "selectedGraphFillAlpha": 0,
          "selectedGraphLineAlpha": 1,
          "autoGridCount":true,
          "color":"#AAAAAA"
      },
      "chartCursor": {
          "pan": true,
          "valueLineEnabled": true,
          "valueLineBalloonEnabled": true,
          "cursorAlpha":1,
          "cursorColor":"#258cbb",
          "limitToGraph":"g1",
          "valueLineAlpha":0.2,
          "valueZoomable":true
      },
      "valueScrollbar":{
        "oppositeAxis":false,
        "offset":50,
        "scrollbarHeight":10
      },
      "categoryField": "date",
      "categoryAxis": {
          "parseDates": true,
          "dashLength": 1,
          "minorGridEnabled": true
      },
      "export": {
          "enabled": true
      },
      "dataProvider": pressureArray
  };

     var tempSettings = {
      "type": "serial",
      "theme": "light",
      "marginRight": 20,
      "marginLeft": 20,
      "autoMarginOffset": 20,
      "mouseWheelZoomEnabled":true,
      "dataDateFormat": "YYYY-MM-DD",
      "valueAxes": [{
          "id": "v1",
          "axisAlpha": 0,
          "position": "left",
          "ignoreAxisWidth":true
      }],
      "balloon": {
          "borderThickness": 1,
          "shadowAlpha": 0
      },
      "graphs": [{
          "id": "g1",
          "balloon":{
            "drop":true,
            "adjustBorderColor":false,
            "color":"#ffffff"
          },
          "bullet": "round",
          "bulletBorderAlpha": 1,
          "bulletColor": "#FFFFFF",
          "bulletSize": 5,
          "hideBulletsCount": 50,
          "lineThickness": 2,
          "title": "red line",
          "useLineColorForBulletBorder": true,
          "valueField": "value",
          "balloonText": "<span style='font-size:18px;'>[[value]]</span>"
      }],
      "chartScrollbar": {
          "graph": "g1",
          "oppositeAxis":false,
          "offset":30,
          "scrollbarHeight": 80,
          "backgroundAlpha": 0,
          "selectedBackgroundAlpha": 0.1,
          "selectedBackgroundColor": "#888888",
          "graphFillAlpha": 0,
          "graphLineAlpha": 0.5,
          "selectedGraphFillAlpha": 0,
          "selectedGraphLineAlpha": 1,
          "autoGridCount":true,
          "color":"#AAAAAA"
      },
      "chartCursor": {
          "pan": true,
          "valueLineEnabled": true,
          "valueLineBalloonEnabled": true,
          "cursorAlpha":1,
          "cursorColor":"#258cbb",
          "limitToGraph":"g1",
          "valueLineAlpha":0.2,
          "valueZoomable":true
      },
      "valueScrollbar":{
        "oppositeAxis":false,
        "offset":50,
        "scrollbarHeight":10
      },
      "categoryField": "date",
      "categoryAxis": {
          "parseDates": true,
          "dashLength": 1,
          "minorGridEnabled": true
      },
      "export": {
          "enabled": true
      },
      "dataProvider": tempArray
  };

    var bpmChart = AmCharts.makeChart("bpm_vitals", bpmSettings);

    var pressureChart = AmCharts.makeChart("pressure_vitals", pressureSettings);

    var tempChart = AmCharts.makeChart("temp_vitals", tempSettings);

    bpmChart.addListener("rendered", zoomChartBpm);
    pressureChart.addListener("rendered", zoomChartPressure);
    tempChart.addListener("rendered", zoomChartTemp);

    zoomChartBpm();
    zoomChartPressure();
    zoomChartTemp();

    function zoomChartBpm() {
        bpmChart.zoomToIndexes(bpmChart.dataProvider.length - 40, bpmChart.dataProvider.length - 1);
    }

    function zoomChartPressure() {
      pressureChart.zoomToIndexes(pressureChart.dataProvider.length - 40, pressureChart.dataProvider.length - 1);
    }

    function zoomChartTemp() {
      tempChart.zoomToIndexes(tempChart.dataProvider.length - 40, tempChart.dataProvider.length - 1);
    }

    /**
    * Returns a random number between min (inclusive) and max (exclusive)
    */
    function getRandomArbitrary(min, max) {
        return Math.round((Math.random() * (max - min) + min) * 100) / 100;
    }

    /**
     * Returns a random integer between min (inclusive) and max (inclusive)
     * Using Math.round() will give you a non-uniform distribution!
     */
    function getRandomInt(min, max) {
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }

    // GPS Coordinates function, works but asks for permision, so commented for testing
    /*
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function(position) {
        $("#gps").text("latitude: " + position.coords.latitude + " / longitude: " + position.coords.longitude);
      });
    } else {
      $("#gps").text("GPS coordinates could not be displayed.");
    }
    */

    //user has clicked on the hide/show <small> text tag
    //the action will be to hide the respective <div>
    //<div> that can be toggled are home / vital / condition / warning
    $("small[id*=_hide]").click(function() {

      var id = this.id;
      $(this).html($(this).html() == "hide" ? "show" : "hide");

      id = id.split("_hide");

      var check = id[0] + "_check";
      var hide = id[0] + "_us";

      //toggle the checkmark from the dropdown menu
      var marked = $("#"+check).prop("checked");
      if(marked == true) {
        $("#"+check).prop("checked", false);
      } else {
        $("#"+check).prop("checked", true);
      }

      $("#"+hide).fadeToggle(300);      
    });

    //user has clicked on the checkbox from the dropdown menu
    //the action will be to hide the respective <dive>
    $("input").click(function() {

      var id = this.id;

      id = id.split("_check");

      var check = id[0] + "_hide";
      var hide = id[0] + "_us";

      $("#"+check).html($("#"+check).html() == "hide" ? "show" : "hide");
      $("#"+hide).fadeToggle(300);
    });

    $("div[id*=_graph]").hide();

    $("div[id=bpm_graph]").show();

  });
</script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>                                         