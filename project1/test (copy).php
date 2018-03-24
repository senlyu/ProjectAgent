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
  <script
  src="https://code.jquery.com/jquery-3.3.1.js"
  integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
  crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.js"></script>
  <script src="/project1/raphael.js"></script>
  <script src="/project1/jquery.usmap.js"></script>  
</head>
<body class="bg-info">
  <div class="p-0">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <ul class="nav nav-pills p-1">
            <li class="nav-item">
              <a href="#" class="active nav-link"> <i class="fa fa-home fa-home"></i>Back</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="p-5">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h1 class="bg-primary">Basic Analysis</h1>
        </div>
      </div>
      <div class="row mb-5">
        <div class="col-md-7">
          <div class="row">
            <div class="col-md-12">
              <p class="lead">Premium Total: <?php echo $c['P1']; ?></p>
            </div>
          </div>
          <div class="row"></div>
          <div class="row">
            <div class="col-md-12">
              <p class="lead">Compensation Total: <?php echo $c['C1']; ?></p>
            </div>
          </div>
          <div class="row"></div>
        </div>
        <div class="col-md-5 align-self-center">
          <canvas id="radarchart"></canvas>
        </div>
      </div>
    </div>
  </div>
  <div class="p-5">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h1 class="bg-primary">Value Analysis</h1>
          <p class="lead">Predictions</p>
          <div class="row">
            <div class="col-md-6">
              <p class=""><b>Premium Total next year: <?php echo $c['P2']; ?></b></p>
            </div>
            <div class="col-md-6">
              <p class=""><b>Premium Total next two years: <?php echo $c['P3']; ?></b></p>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <p class=""><b>Compensation Total next year: <?php echo $c['C2']; ?></b></p>
            </div>
            <div class="col-md-6">
              <p class=""><b>Compensation Total next two years: <?php echo $c['C3']; ?></b></p>
            </div>
          </div>

          <div id="map" ></div>

          <div class="row">
            <div class="col-md-6">
              <p class=""><b>This agent is in the state : <?php echo $c['StateName']; ?></b></p>
            </div>
            <div class="col-md-6">
              <p class="">In this state, the&nbsp;</p>
            </div>
          </div>
          <p class="lead">In this state,&nbsp;
            <br>the average Premium Total is: <?php echo $c['stateA'][$c['StateName']]['PA']; ?>
            <br>the average Compensation Total is: <?php echo $c['stateA'][$c['StateName']]['CA']; ?>
            <br>
            <br>This agent is in the top {} of all the agents in this area.</p>
        </div>
      </div>
    </div>
  </div>
  <div class="p-5">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h1 class="bg-primary">Company Analysis</h1>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <p class="lead">Probability of terminated next 1 year: <?php echo $c['L5']; ?>
            <br>Probability of terminated next 2 year: <?php echo $c['L4']; ?>
            <br>Probability of terminated next 3 year: <?php echo $c['L3']; ?>
            <br>
          </p>
          <p class="lead">The company is <?php echo $c['CompanyCode']; ?>
            <br>The rate of retention of the company</p>
          <div class="row">
            <div class="col-md-6">
              <canvas id="piechart"></canvas>
            </div>
            <div class="col-md-6">
              <p class="lead">This agent stays longer than 50% of all the agents in that company.&nbsp;</p>
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
        data: [
            <?php echo $c['radar']["E"]; ?>,
            <?php echo $c['radar']["C"]; ?>,
            <?php echo $c['radar']["L"]; ?>
        ]
      }]
    }
  }
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
    document.getElementById("test_name").innerHTML = <?php echo $c['company'][$c['CompanyCode']]["1"]; ?>;
  </script>


</body>

</html>


  








