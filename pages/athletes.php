<html>
<!-- This page allows the user to search for ahtletes from given countries. The user needs to give a country and the part name
of an athlete to perform the search. It returns all the athletes from the country that have the given part name in their name including their gender and bmi.
If no part name is entered, it returns all athletes from the given country. The page validates the data, it checks if the country ISO_id
is three letters, if the Iso_id has been entered and if both filds are letters. If there are no errors then the page sets a connection
with the database, performs the search and echos the data into a table -->
<head>
	<link href="https://fonts.googleapis.com/css?family=Bree+Serif|Luckiest+Guy" rel="stylesheet">
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Athletes</title>
	<style>
	body{
		margin-left:0;
		margin-right:0;
	}
	h1,h2{
		text-align:center;
		font-family: 'Bree Serif', serif;
		margin:20px;
	}
	h1{font-size:5em;}
	h2{font-size:3.5em;}

	#country{
		text-align:center;
		padding-top:40px;
		color:white;
		font-family: 'Luckiest Guy', cursive;
		font-size: 3em;
		margin:0;
	}
	#table-div{
		background: linear-gradient(
		rgba(0, 0, 0, 0.5),
		rgba(0, 0, 0, 0.5)
	  ),url("../images/cyclists.jpg");
		background-size: cover;
		margin-top:0;
		min-height:40em;
	}

	#queryName{
		text-align: center;
		color:white;
		font-family: 'Bree Serif', serif;
		font-size: 2em;
		margin-top:0;
	}

	table{
		width: 45%;
	}

	table, th,td{
		font-family: 'Bree Serif', serif;
		border-collapse: collapse;
	}

	th,td{
		text-align:left;
		padding: 10px;
		border-bottom: 1px solid #ddd;
	}

	th{
		background-color: #D7A0A0;
		font-size:2em;
	}

	td{
		font-size:1.5em;
	}

	tr:nth-child(odd) {background-color: white;}
	tr:nth-child(even) {background-color: #f2f2f2;}

	.errorMessage{
		text-align:center;
		font-family: 'Bree Serif', serif;
		font-size: 2em;
		margin-top:0;
	}

	#nullResult{
		text-align:center;
		font-family: 'Bree Serif', serif;
		font-size: 3em;
		margin-top:1.5em;

	}
	.sub{
            text-align:center;
            font-family: 'Bree Serif', serif;
            font-size: 3.5em;
            margin:0;
            padding:.3em;
            background-color:#EE5D5D;

    }
	.link{
          padding: 1em;
          background: #026890;
          color: white;
        }

	.linkCurrent{
		padding: 1em;
		background: #2fb8ee;
		color: white;
	}

</style>
</head>
<body>
<h1>LONDON OLYMPICS 2012</h1>
<center><a class ="link" href="bmi.htm">BMI CALCULATOR</a><a class ="linkCurrent">ATHLETE FINDER</a><a class ="link" href="view.php">COUNTRY COMPARISON</a> </center>

<p class='sub'> ATHLETE FINDER </p>

<?php
echo "<div id='table-div'>";

//Getting values from form
$country_id =$_GET['country_id'];
$country_id = trim($country_id);// removes white space
$country_id = strtoupper($country_id);
$part_name =$_GET['part_name'];
$part_name = trim($part_name);// removes white space
$part_name = strtoupper($part_name);

//Error handling
//The program doesn't consider an error not entering a part name, instead it will return all athletes from the country selected

if ($country_id==null){//checking if country was entered
	echo "<p id='country'> INPUT ERROR </p>";
	echo "<div id='table-div'>";
	echo "<p class='errorMessage'> Please enter a country ID in order to complete the search </p>";
	echo "</div>";
} else if (strlen($country_id) != 3){ //checking if country id is not three letters
	echo "<p id='country'> INPUT ERROR </p>";
	echo "<div id='table-div'>";
	echo "<p class='errorMessage'> The country ID must be 3 letters </p>";
	echo "</div>";
} else if (!ctype_alpha($country_id)){ //checking if country id is not letters(string)
	echo "<p id='country'> INPUT ERROR </p>";
	echo "<div id='table-div'>";
	echo "<p class='errorMessage'> The country ID must be letters </p>";
	echo "</div>";
} else if (!ctype_alpha($part_name) && $part_name!=null ) { //checking if part name is not letters (string)
	echo "<p id='country'> INPUT ERROR </p>";
	echo "<div id='table-div'>";
	echo "<p class='errorMessage'> The part name ID must be letters </p>";
	echo "</div>";
} else{ //no error found in user input
	

	echo "<p id='country'> $country_id </p>";

	

	if ($part_name==null) echo "<p id ='queryName'>Names Containing: ALL </p>";
	else echo "<p id ='queryName'>Names Containing: $part_name </p>"; //echos the part name that user inputs
	
	echo "<table align='center'>";
	echo "<tr>";
	echo "<th> Name</th>";
	echo "<th> Gender</th>";
	echo "<th> BMI</th>";
	echo "</tr>";

	include "../database/getDB.php";

	$query = "SELECT name, gender, height, weight FROM Cyclist WHERE ISO_id = '$country_id' AND upper(name) LIKE '%$part_name%'";
	$res = $db->query($query);

	while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
		$name = $row['name'];
		$gender = $row['gender'];
		$weight = $row['weight'];
		$height = $row['height'];

		echo "<tr><td> $name </td>";

		//error handling when there is no gender in database
		if($gender !=null) echo "<td> $gender </td>"; //no error
		else echo "<td> Unknown gender </td>";
		
		//error handling when there is no data in database for height and weight
		if ($weight==null || $height==null){
			echo "<td>Unkown BMI</td></tr>";
		}else{//no error
			$heightMeters = $height/100; //converts height in cm to m 
			$bmi = number_format($weight/($heightMeters*$heightMeters), 3); //calculates bmi using formula and gets the result to 3 decimal points
			echo "<td>$bmi</td></tr>";
		}
	}
	$res->closeCursor();
	echo "</table>";
	echo "</div>";
	}
?>
</body>
</html>