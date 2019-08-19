<html>
<!-- This page allows the user to enter a minimum and a maximum weight and height in order to return a table with the bmi
for the given values. The page validates the data before generating the table, it checks that the minimum values are less 
than the maximum values, it checks that the user doesn't leave any fields empty, that all values entered are numeric and positive numbers.
If no errors are found the page produces a table. By hovering on the table, the user can find more information about the health 
of a given bmi.  -->
<head>
<link href="https://fonts.googleapis.com/css?family=Bree+Serif|Luckiest+Guy" rel="stylesheet">
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title> BMI Calculator </title>
<style>
body{
    font-family: 'Bree Serif', serif;
    background-image: url("images/bmiPIC.png");
    background-size: cover;
}

h1{
    text-align:center;
    font-size: 4em;
}

table{
    border:1px solid black;
    border-collapse: collapse;
    align:center;
}

table,tr,td,th{
    border:1px solid black;
    text-align:center;
}

td{
    width:60px;
    height:50px;
    font-size:1.2em;
    background-color:#F1D8EE; 
}

.errorMessage{
    font-size: 3em;
    text-align:center;
}

.header{
    font-size: 1.7em;
    background-color: #A05BEA;
}
#tableResult td:hover{
  background-color:#ffbbff;
}
.underweight, #blue{
    background-color: #a2caf6;
}
.normalweight, #green{
    background-color: #a5f09a;
}
.overweight, #red{
    background-color: #f48f8a;
}
.obese, #darkRed{
    background-color:#ee534b;
}
h2{
    text-align:center;
}
#colours, .info{
    text-align:center;
    font-size: 1.7em;
}
#status{
    margin-left:2em;
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
<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js' type='text/javascript'></script>
<script type="text/javascript" language="javascript">
    $(document).ready(function(){
        $(".tableData").hover(function(){
            /* 
            This function is called when the user hovers over the table data, it changes the background color of the 
            table depending on the BMI that the user selects. If the BMI is underweight it sets the color to blue,
            if it is normal weight to green, overweight to red and obese to dark red. */

            //removing classes that set the background-colour
            $(".tableData").removeClass("underweight");
            $(".tableData").removeClass("normalweight");
            $(".tableData").removeClass("overweight");
            $(".tableData").removeClass("obese");

            $("#infoBMI").html("BMI: ");
            $("#status").html("Health: ");
            $("#infoBMI").append($(this).html());

            //setting classes to the table data background, this classes have css that will set background-color 
            if ($(this).html() <18.5) { //underweight
                $(".tableData").addClass("underweight");
                $("#status").append("Underweight");
            } else if ($(this).html() <24.9) { //normalweight
                $(".tableData").addClass("normalweight");
                $("#status").append("Normal weight");
            }else if ($(this).html() <29.9) { //overweight
                $(".tableData").addClass("overweight");
                $("#status").append("Overweight");
            }else{ //obese
                $(".tableData").addClass("obese");
                $("#status").append("Obese");
            }
        });

        $( ".tableData" ).mouseleave(function() {
            /* This function is called when the user takes the mouse from the table. It returns the background color 
            of the table to its original state by removing classes and sets the BMI and health to nothing. */
            $("#infoBMI").html("BMI: ");
            $("#status").html("Health: ");
            $(".tableData").removeClass("underweight");
            $(".tableData").removeClass("normalweight");
            $(".tableData").removeClass("overweight");
            $(".tableData").removeClass("obese");
        });
    });
    
</script>


<body>
<h1>BMI Calculator</h1>
<center><a class ="linkCurrent">BMI CALCULATOR</a><a class ="link" href="athletes.htm">ATHLETE FINDER</a><a class ="link" href="view.php">COUNTRY COMPARISON</a> </center>


    <h2> HOVER ON TABLE TO SEE EXTRA HEALTH INFORMATION </h2>

    <p id='colours'>
    Colour codes:        
    <span id='blue'>Underweight</span>
    <span id='green'>Normal Weight</span>
    <span id='red'>Overweight</span>
    <span id='darkRed'>Obese</span>
    </p>

    <p class ='info'>
    <span id='infoBMI'>BMI: </span>
    <span id='status'>Health:</span>
    </p>

<div id='tableResult'>
<?php 
//Getting the values from the form
$minWeight = $_GET['min_weight'];
$maxWeight = $_GET['max_weight'];
$minHeight = $_GET['min_height'];
$maxHeight = $_GET['max_height'];

//removing blank spaces
$minWeight = trim($minWeight);
$maxWeight = trim($maxWeight);
$minHeight = trim($minHeight);
$maxHeight = trim($maxHeight);

//handling errors
// checking if no value is entered
if ($minWeight == null || $maxWeight == null || $minHeight == null || $maxHeight == null ){
    echo "<p class='errorMessage'>Please fill in the blanks</p>";
//checking that no negative numbers are entered    
}else if ($minWeight <0 || $maxWeight  <0 || $minHeight <0  || $maxHeight <0 ){
    echo "<p class='errorMessage'>Values entered need to be positive numbers</p>";
//checking that values entered are numbers    
}else if (!is_numeric($minWeight) || !is_numeric($maxWeight) ||!is_numeric($minHeight) || !is_numeric($maxHeight)){
    echo "<p class='errorMessage'>Value you entered is not numeric</p>";
//checking that minimum weight is less than maximum    
} else if ($minWeight >= $maxWeight){
    echo "<p class='errorMessage'>The minimum weight needs to be less than the maximum weight</p>";
//checking that minimum height is less than maximum   
} else if ($minHeight >= $maxHeight){
    echo "<p class='errorMessage'>The minimum height needs to be less than the maximum height</p>";
} else{ // if no error is found

    echo "<table align='center'>";
    //Table heading
    echo "<th class='header'> Height &#8594; <br> Weight &#8595 </th>";
    for ($height = $minHeight; $height<=$maxHeight; $height+=5){
        echo "<th class='header'> $height </th>";
    }

    //generating table data
    for ($weight = $minWeight; $weight<=$maxWeight; $weight+=5){
        echo "<tr>";
        echo "<th class='header'> $weight </th>";
        for($height = $minHeight; $height<=$maxHeight;$height+=5){
            $heightMeters = $height/100; //convert input in cm to m
            $bmi = number_format($weight/($heightMeters*$heightMeters), 3); //using bmi formula and giving 3 decimal places
            echo "<td class='tableData'> $bmi</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
    }
 ?>
 </div>
</body>
</html>