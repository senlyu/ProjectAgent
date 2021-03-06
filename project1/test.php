<?php

$a = base64_encode((json_encode($_POST)));
//echo "echo" . $a;
exec("python3 main.py $a", $result);
//echo "<br>";
//echo "result" . var_dump($result);
#$resultData = json_decode($result, true);
//echo "<br>";
$b = $result["0"];
//echo "asd". $b. "<br>";
$c = json_decode($b, true);
//echo "c". $c["LV"]. "<br>";
#echo var_dump($resultData);
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
  <link rel="stylesheet" href="/project1/theme.css" type="text/css">
  <link rel="stylesheet" href="/project1/page2.css" type="text/css">
  <script
  src="https://code.jquery.com/jquery-3.3.1.js"
  integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
  crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.js"></script>
  <script src="/project1/raphael.js"></script>
  <script src="/project1/jquery.usmap.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Roboto+Slab" rel="stylesheet">  
</head>
<body class="bg-info">
  <h1 class="bg-primary">Basic Analysis</h1>
  <div class="p-5">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
        </div>
      </div>
      <div class="row mb-5">
        <div class="col-md-7">
          <div class="row">
            <div class="col-md-12">
              <p class="lead">Premium Total: <mark><?php echo $c['P1']; ?></mark></p>
            </div>
          </div>
          <div class="row"></div>
          <div class="row">
            <div class="col-md-12">
              <p class="lead">Compensation Total: <mark><?php echo $c['C1']; ?></mark></p>
            </div>
          </div>
          <div class="row"></div>
        </div>
        <div class="col-md-5 align-self-center">
          <div style="width:100%;text-align: right;">
            <div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"></div>
            <canvas id="radarchart" style="display: block; padding:0px;" class="chartjs-render-monitor"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
  <h1 class="bg-primary">Value Analysis</h1>
  <div class="p-5">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <p class="lead">Predictions</p>
          <div class="row">
            <div class="col-md-6">
              <p class=""><b>Premium Total next year: <mark><?php echo $c['P2']; ?></mark></b></p>
            </div>
            <div class="col-md-6">
              <p class=""><b>Premium Total next two years: <mark><?php echo $c['P3']; ?></mark></b></p>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <p class=""><b>Compensation Total next year: <mark><?php echo $c['C2']; ?></mark></b></p>
            </div>
            <div class="col-md-6">
              <p class=""><b>Compensation Total next two years: <mark><?php echo $c['C3']; ?></mark></b></p>
            </div>
          </div>

          <div id="map" ></div>

          <div class="row">
            <div class="col-md-12">
              <p class=""><b>This agent is in the state : <mark><?php echo $c['StateName']; ?></mark></b></p>
            </div>
          </div>
          <p class="lead">In this state,&nbsp;
            <br>the average Premium Total is: <mark><?php echo $c['stateA'][$c['StateName']]['PA']; ?></mark>
            <br>the average Compensation Total is: <mark><?php echo $c['stateA'][$c['StateName']]['CA']; ?></mark>
            <br>
            <br>This agent is in the top {} of all the agents in this area.</p>
        </div>
      </div>
    </div>
  </div>
  <h1 class="bg-primary">Company Analysis</h1>
  <div class="p-5">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <p class="lead">Probability of terminated next 1 year: <mark><?php echo $c['L5']; ?></mark>
            <br>Probability of terminated next 2 year: <mark><?php echo $c['L4']; ?></mark>
            <br>Probability of terminated next 3 year: <mark><?php echo $c['L3']; ?></mark>
            <br>
          </p>
          <p class="lead">The company is <?php echo $c['CompanyCode']; ?>
            <br>The rate of retention of the company</p>
          <div class="row">
            <div class="col-md-6">
              <canvas id="piechart"></canvas>
            </div>
            <div class="col-md-6">
              <p class="lead">This agent may stay <mark><?php echo $c['LS']; ?></mark>years.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="text-white bg-dark">
    <div class="container">
      <div class="row">
        <div class="col-md-12 mt-3">
          <p class="text-center text-white"></p>
        </div>
      </div>
    </div>
  </div>
  <p id="test_name"></p>


  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

  <!--This is the radar chart-->
  <script>
    var configRadar = {
      type: 'radar',
      data: {
        labels: ['Earning', 'Cost', 'Loyalty'],
        datasets: [{
          borderColor: 'rgb(0, 0, 255)',
          pointBackgroundColor: 'rgb(0, 0, 255)',
          data: [
              <?php echo $c['radar']["E"]; ?>,
              <?php echo $c['radar']["C"]; ?>,
              <?php echo $c['radar']["L"]; ?>
          ]
        }]
      },
      options: {
        scale: {
          ticks: {
            beginAtZero: true
          }
        },
        legend:{
          display: false
        },
        scale:{
          ticks:{
            display:false
          },
          pointLabels: {
            fontSize: 30
          }
        }
      }
    };
    var ctxRadar = document.getElementById('radarchart').getContext('2d');
    var radarchart = new Chart(ctxRadar, configRadar);
  </script>

  <!--This is the pie chart-->
  <script>
  var configPie = {
    type: 'pie',
    data: {
      datasets: [{
        data: [
            <?php echo $c['company'][$c['CompanyCode']]["1"]; ?>,
            <?php echo $c['company'][$c['CompanyCode']]["2"]; ?>,
            <?php echo $c['company'][$c['CompanyCode']]["3"]; ?>,
            <?php echo $c['company'][$c['CompanyCode']]["4"]; ?>,
            <?php echo $c['company'][$c['CompanyCode']]["5"]; ?>
        ],
        backgroundColor: [
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(255, 159, 64, 0.2)'
        ],
        label: 'Dataset 1'
      }],
      labels: [
        '1 year',
        '2 years',
        '3 years',
        '4 years',
        '5 years and above'
      ]
    }
  };

  var ctxPie = document.getElementById('piechart').getContext('2d');
  var piechart = new Chart(ctxPie, configPie);
  </script>


  <script>
  function abbrState(input, to){

    var states = [
        ['Arizona', 'AZ'],
        ['Alabama', 'AL'],
        ['Alaska', 'AK'],
        ['Arizona', 'AZ'],
        ['Arkansas', 'AR'],
        ['California', 'CA'],
        ['Colorado', 'CO'],
        ['Connecticut', 'CT'],
        ['Delaware', 'DE'],
        ['Florida', 'FL'],
        ['Georgia', 'GA'],
        ['Hawaii', 'HI'],
        ['Idaho', 'ID'],
        ['Illinois', 'IL'],
        ['Indiana', 'IN'],
        ['Iowa', 'IA'],
        ['Kansas', 'KS'],
        ['Kentucky', 'KY'],
        ['Kentucky', 'KY'],
        ['Louisiana', 'LA'],
        ['Maine', 'ME'],
        ['Maryland', 'MD'],
        ['Massachusetts', 'MA'],
        ['Michigan', 'MI'],
        ['Minnesota', 'MN'],
        ['Mississippi', 'MS'],
        ['Missouri', 'MO'],
        ['Montana', 'MT'],
        ['Nebraska', 'NE'],
        ['Nevada', 'NV'],
        ['New Hampshire', 'NH'],
        ['New Jersey', 'NJ'],
        ['New Mexico', 'NM'],
        ['New York', 'NY'],
        ['North Carolina', 'NC'],
        ['North Dakota', 'ND'],
        ['Ohio', 'OH'],
        ['Oklahoma', 'OK'],
        ['Oregon', 'OR'],
        ['Pennsylvania', 'PA'],
        ['Rhode Island', 'RI'],
        ['South Carolina', 'SC'],
        ['South Dakota', 'SD'],
        ['Tennessee', 'TN'],
        ['Texas', 'TX'],
        ['Utah', 'UT'],
        ['Vermont', 'VT'],
        ['Virginia', 'VA'],
        ['Washington', 'WA'],
        ['West Virginia', 'WV'],
        ['Wisconsin', 'WI'],
        ['Wyoming', 'WY'],
    ];

    if (to == 'abbr'){
        input = input.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
        for(i = 0; i < states.length; i++){
            if(states[i][0] == input){
                return(states[i][1]);
            }
        }    
    } else if (to == 'name'){
        input = input.toUpperCase();
        for(i = 0; i < states.length; i++){
            if(states[i][1] == input){
                return(states[i][0]);
            }
        }    
    }
  }
  </script>

  <!--This is the state chart-->
  <script>
  var statefullname = "<?php echo $c['StateName']; ?>";
  var stateshortname = abbrState(statefullname, 'abbr');

  $('#map').usmap({
    stateStyles: {fill: 'green'},
    stateSpecificStyles: {
      [stateshortname] : {fill : 'yellow'}
    }
  });
  //console.log($('#map')['stateSpecificStyles']);
  </script>

  <script type="text/javascript">
    //document.getElementById("test_name").innerHTML = <?php echo $c['company'][$c['CompanyCode']]["1"]; ?>;
  </script>


</body>

</html>






