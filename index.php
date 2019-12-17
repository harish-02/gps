<!DOCTYPE html>
<html lang="en">
<head>
  <title>Location Search</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <script src="https://maps.google.com/maps/api/js?sensor=false"></script>

<?php

if (isset($_POST['formSubmit'])) {

$servername = "localhost";
$username = "root";
$password = "";
$mysql_database = "location";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
mysqli_select_db($conn,$mysql_database);
  $loc = $_POST['search'];

  $sql = "SELECT * FROM locationinfo";
  $result = $conn->query($sql);
  // print_r($result) ;

  if ($result->num_rows > 0) {
    // output data of each row
    $value = 0;
    $latitude = '';
    $longitude = '';
    while($row = $result->fetch_assoc()) {
      if($row['location'] == $loc) {
        $latitude = $row['latitude'];
        $longitude = $row['longitude'];
        $value = 1;
      }
    }
    } else {
        $value = 0;
    }
    $conn->close();
  }
?>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type='text/javascript'>
    $(document).ready(function() {
        var value = <?php echo(json_encode($value)); ?>;
        if(value == 1) {
            var lat = <?php echo(json_encode($latitude)); ?>;
            var long = <?php echo(json_encode($longitude)); ?>;

            var latlong = new google.maps.LatLng(lat, long);
    
            var myOptions = {
                center: latlong,
                zoom: 16,
                mapTypeControl: true,
                navigationControlOptions: {
                    style:google.maps.NavigationControlStyle.SMALL
                }
            }
            var map = new google.maps.Map(document.getElementById("embedMap"), myOptions);
            var marker = new google.maps.Marker({ position:latlong, map:map, title:"You are here!" });
        }
        else {
            alert('Unknown Location, Map Cannot Be Loaded!');
            // window.location.href = 'index.php';         
        }
        
    });

// Define callback function for failed attempt
function showError(error) {
    if(error.code == 1) {
        result.innerHTML = "You've decided not to share your position, but it's OK. We won't ask you again.";
    } else if(error.code == 2) {
        result.innerHTML = "The network is down or the positioning service can't be reached.";
    } else if(error.code == 3) {
        result.innerHTML = "The attempt timed out before it could get the location data.";
    } else {
        result.innerHTML = "Geolocation failed due to unknown error.";
    }
}
</script>

</head>
<body>


<div class="jumbotron text-center">
  <h1>Location Search</h1>
</div>
<div class="container">
  <div class="row mt-5">
    <div class="col-sm-6">
    	<form action="" method="POST">
  			<div class="form-group">
    			<input type="text" name="search" class="form-control" placeholder="Search" required>
 			</div>
  			<input type="submit" name="formSubmit" value="Submit" class="btn btn-primary">
        <button type="button" class="btn btn-secondary" onclick="document.location.href='addlocation.php'">Add New Location</button>
		</form> 
    </div>
  </div>
  <div class="row mt-5">
  <div class="col-sm-6">

    <div id="embedMap" style="width: 1000px; height: 600px;"></div>
  </div>
</div>

</div>
</body>
</html>