<!DOCTYPE html>
<html>
<head>
	<title>Add Location Data</title>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body>
	<?php 
		if (isset($_POST['submit'])) {
			
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
			$location = $_POST['location'];
			$latitude = $_POST['latitude'];
			$longitude = $_POST['longitude'];
			$sql = "INSERT INTO locationinfo (location, latitude, longitude) VALUES ('".$location."', '".$latitude."', '".$longitude."')";

			if ($conn->query($sql) === TRUE) {
				// echo "New Location Added Successfully";
				echo "<script>alert('New Location Added Successfully');</script>";
			} else {
    			echo "Error: " . $sql . "<br>" . $conn->error;
			}
			$conn->close();

		}

	?>
	<div class="jumbotron text-center">
  		<h1>Add New Location</h1>
	</div>
	<div class="container">
  		<div class="row">
    	<div class="col-sm-6">
    		<form action="" method="POST">
  				<div class="form-group">
    				<label for="email">Location:</label>
    				<input type="text" class="form-control" placeholder="Location" id="" name="location" required>
  				</div>
  				<div class="form-group">
    				<label for="pwd">Latitude:</label>
    				<input type="text" class="form-control" placeholder="Latitude" id="latitude" name="latitude" required>
  				</div>
  				<div class="form-group">
    				<label for="pwd">Longitude:</label>
    				<input type="text" class="form-control" placeholder="Longitude" id="longitude" name="longitude" required>
  				</div>
  				<input type="submit" name="submit" value="Save" class="btn btn-primary">
  				<button type="button" class="btn btn-secondary" onclick="document.location.href='index.php'">Cancel</button>

			</form>
    	</div>
  	</div>
	</div>
</body>
</html>