<?php
//getting all the countries in the database in order to validate the user's input
include "getDB.php";// gets the connection to the database

$sql = "SELECT ISO_id FROM Country"; //sql to get all available countries
$res = $db->query($sql);
//execute query

//JSON
$results= json_encode($res ->fetchAll()); //all availabe countries used to validate data

?>

<html>
<!--This page allows the user to enter up to four different country ISO_id, depending on how many the user wants to enter. Before 
submiting the result and setting a connection with the databse, the page validates the data by checking if the entered ISO_ids exist.
If the countries exist then this page generates an sql statement containing the countries entered by the user and then 
uses the ajax ethod .get, passing the sql statement to the dbAccess php file which echos a json format data structure containg all the results.
The page appends the given results into tables (one per country).  -->

<head>
    <title> View </title>
    <link href="https://fonts.googleapis.com/css?family=Bree+Serif|Luckiest+Guy" rel="stylesheet">
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js' type='text/javascript'></script>
    <!-- adding jquery UI -->
    <link rel="stylesheet" href="Jquery-UI/jquery-ui.min.css">
    <script src="Jquery-UI/external/jquery/jquery.js"></script>
    <script src="Jquery-UI/jquery-ui.min.js"></script>
    <style>
        
        body{
            margin:0;
        }

        /* titles */
        h1{
            text-align:center;
            font-family: 'Bree Serif', serif;
            font-size: 5em;
            margin:20px;
        }
        .sub,.sub2{
            text-align:center;
            font-family: 'Bree Serif', serif;
            font-size: 3.5em;
            margin:0;
            padding:.3em;

        }
        .sub2{
            text-align:left;
            font-size: 2.5em;
        }
        .sub{
            background-color:#EE5D5D;
        }
        
        /* tables */
        
        .twoTables, .threeTables, .fourTables{
            border:1px solid black;
            display: inline-block;
            float:left;
            text-align: center;
            font-family: 'Bree Serif', serif;
            margin-top:1em;

        }
        
        .twoTables{
            width:35%;
            margin-left:7%;
            font-size: 1.5em;

        }

        .threeTables{
            width:29%;
            margin-left:3%;
            font-size: 1.5em;
        }

        .fourTables{
            width:23%;
            margin-left:1%;
            font-size: 1.5em;
        }

        /* tables data */
        .data{
            padding-left:4em;
            text-align:left;
        }

        .countryName{
            background-color:#EE5D5D;
            height: 50px;
            width:40%;
            color:white;
            font-family: 'Luckiest Guy', cursive;
            font-size: 2.3em;
            text-align:center;
        }

        .innerHeadings{
            text-align:left;
            font-size:1.4em;
        }

        .rank{
            float:right;
            color:gold;
            margin-right:10px;
            font-size: 1.2em;
            transform: rotate(20deg);
        }

        .names{
            border-bottom: 1px solid #ddd;
            text-align:left;
            padding-left:4em;
        }
        
        .namesRows:nth-child(even) {
            background-color: #f2f2f2;
            }

        /* form */
        form{
            padding: 2%;
            background-color: #C2EDCB;
        }
       
        fieldset{
            background-color: #026890;
        }

        legend{
            background-color: #6eac2c;
            padding:2%;
        }

        #fieldCountries{
            display:inline-block;
            float:left;
            width:20%;
            margin-left: 21%;
        }

        #fieldConfiguation{
            display:inline-block;
            float:right;
            width: 30%;
            margin-right: 22%;
        }

        /* form text */
        .inputText {
            font-family: Arial;
            font-size: 1.3em;
            font-weight: bold;
            color:white;
        }

        p.inputText{
            margin-top:.5em;
            margin-bottom:.5em;
        }

        .spanCountries{
            margin-left:1em;
        }

        #submit{
            margin-top:.5em;
            margin-left:30em;
            margin-bottom:.5em;
        }

        .error{
            width:30%;
            text-align:center;
            font-size: 1.5em;
            /* margin-left: 8em; */
            margin:auto;
        }

        p{
            margin:0;
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
    <script type="text/javascript" >
        
        var availableCountries = '<?php echo $results?>'; //all avaible countries from database

        function validateCountry(availableCountries){
            /*
            This function is called when the user clicks on the submit button. It gets the number of countries 
            to be entered by the user and then checks if the countries ID's are correct, if they are this function
            returns true, if they are not correct it returns false and it displays a message saying there's an error.
            PARAMETERS: availableCountries are all the countries in the database
            RETURNS: true if no error and false if error
            */

            //getting number of countries the user wants to input  
            var numberOfCountries = $("#numberOfCountries").val();

            //getting true or false values for every country entered. If the country name entered is included in the list of available countries it returns true.
            if (numberOfCountries ==2){
                if ($("#country_id1").val()=="" || $("#country_id2").val()==""){ // if values are not entered
                    var country1=false;
                    var country2=false;
                } else{
                    var country1 =availableCountries.includes($("#country_id1").val().toUpperCase());
                    var country2 = availableCountries.includes($("#country_id2").val().toUpperCase());
                }
                var country3 = true;
                var country4 = true;
            } else if (numberOfCountries == 3 ){
                if ($("#country_id1").val()=="" || $("#country_id2").val()=="" || $("#country_id3").val()==""){ // if values are not entered
                    var country1=false;
                    var country2=false;
                    var country3 = false;
                } else{
                    var country1 =availableCountries.includes($("#country_id1").val().toUpperCase());
                    var country2 = availableCountries.includes($("#country_id2").val().toUpperCase());
                    var country3 =availableCountries.includes($("#country_id3").val().toUpperCase());
                }
                var country4 = true;
            } else if (numberOfCountries == 4){
                if ($("#country_id1").val()=="" || $("#country_id2").val()=="" || $("#country_id3").val()=="" || $("#country_id3").val()==""){ // if values are not entered
                    var country1=false;
                    var country2=false;
                    var country3 = false;
                    var country4 = false;
                } else{
                    var country1 =availableCountries.includes($("#country_id1").val().toUpperCase());
                    var country2 = availableCountries.includes($("#country_id2").val().toUpperCase());
                    var country3 =availableCountries.includes($("#country_id3").val().toUpperCase());
                    var country4 =availableCountries.includes($("#country_id4").val().toUpperCase());
                } 
            }

            //if one of the countries enteres is false i.e does not exist then it display an error message and the function returns false.
            if (country1 && country2 && country3 && country4){ //no errors
                if ($(".error").is(":visible")) $(".error").toggle();
                return true;
            } else { //at least one country entered does not exist
                if ($(".error").is(":hidden")) $(".error").toggle();
                return false;
            }
        }

        function submitCountries(availableCountries){

            /*
            This function is called when the user clicks on the submit button. First it validates that the countries entered exist,
            then it deletes all data from previous results from the tables and removes classes from tables to restart the display options.
            It adds the corresponding classes to the tables depending on how many countries the user enters and finally, 
            it calls the getResults method which appends the data to the tables.
            PARAMETERS: availableCountries is the list existing countries in the database used to validate countries
             */

            var elem = document.getElementById("div_Country1");
            elem.scrollIntoView();

            var numberOfCountries = $("#numberOfCountries").val();

            var validation = validateCountry(availableCountries); //true or false

            if (validation){ //true if no error validating the data
                //removes html of all country tables to delete previous results
                $("#countryTable1").html(""); 
                $("#countryTable2").html(""); 
                $("#countryTable3").html(""); 
                $("#countryTable4").html(""); 
                
                //removes all classes for display purposes
                $("#countryTable1").removeClass();
                $("#countryTable2").removeClass();
                $("#countryTable3").removeClass();
                $("#countryTable4").removeClass();

                //adds classes to tables for display purposes depending on how many countries are being compared
                if (numberOfCountries ==2){
                    $("#countryTable1").addClass("twoTables");
                    $("#countryTable2").addClass("twoTables");
                } else if (numberOfCountries == 3){
                    $("#countryTable1").addClass("threeTables");
                    $("#countryTable2").addClass("threeTables");
                    $("#countryTable3").addClass("threeTables");
                } else if (numberOfCountries ==4){
                    $("#countryTable1").addClass("fourTables");
                    $("#countryTable2").addClass("fourTables");
                    $("#countryTable3").addClass("fourTables");
                    $("#countryTable4").addClass("fourTables");  
                }
                getResults(); //this function appends the results to the tables
            }
            
        }

        function getResults(){
            /* 
            This function appends the country information and athletes to different tables (one table per country).
            It first generates an sql statement from the user's input, then uses ajax and the get method passing the sql to 
            the the php file dbAccess.php which access the database and echos the result in json format and the result is used
            to append the information to the tables. 
            */

                var numberOfCountries = $("#numberOfCountries").val();

                //generating SQL statement from users input
                var rank = $("#rankBy").val();
                var country1 = $("#country_id1").val().toUpperCase();
                var country2 = $("#country_id2").val().toUpperCase();
                var country3 = $("#country_id3").val().toUpperCase();
                var country4 = $("#country_id4").val().toUpperCase();

                
                var sqlFromUser="SELECT population/total AS average, population, gdp,total, name,country_name, gold, silver,bronze FROM Country LEFT JOIN Cyclist ON Country.ISO_id = Cyclist.ISO_id WHERE Country.ISO_id IN ";
                
                // adding countries to sql statement
                if (numberOfCountries ==2){
                    sqlFromUser+="(" + "'"+country1+"' ," + "'"+country2+"' )";
                } else if (numberOfCountries ==3){
                    sqlFromUser+="(" + "'"+country1+"' ,"+ "'"+country2+"' ,"+ "'"+country3+"' )";
                } else if (numberOfCountries ==4)  {
                    sqlFromUser+="(" + "'"+country1+"' ,"+ "'"+country2+"' ,"+ "'"+country3+"' ," + "'"+country4+"' )";
                }
                
                //adding ORDER BY to rank the countries to SQL statement
                sqlFromUser+=" ORDER BY "+ rank +" , Country.ISO_id DESC";
                
                //USING AJAX TO GET VALUES FROM DATABASE INTO JSON AND THEN PUTTING THEM IN TABLES
                $.get('dbAccess.php',{sql:sqlFromUser}, function(result){

                    //getting the countries in order and the index of their first occurance in the json array
                    var indexArray = [];
                    var countryArray=[];
                    for (var row in result){
                        if (!(countryArray.includes(result[row].country_name))) { //true if current country is not in array
                            countryArray.push(result[row].country_name);
                            indexArray.push(row);
                        }
                    }

                    var country1= countryArray[0];
                    var country2= countryArray[1];
                    var country3= countryArray[2];
                    var country4= countryArray[3];

                    //appending the general information (medals and general information )
                    var currentTable=1;
                    for (var i=0; i<numberOfCountries; i++){ //loops the number of times as number of countries
                        var index = indexArray[i];//index of country occurrance
                        //getting the medal-population average
                        var total = parseInt(result[index].total);
                        var population= parseInt(result[index].population);
                        var average = (total/population).toPrecision(2);

                        //table heading (country name and rank)
                        $("#countryTable"+currentTable).append("<tr><th class='countryName'>"+result[index].country_name+"<span class='rank'>#"+currentTable+"</span></th></tr>");
                        
                        //to display extra general information in case user wants to display it
                        if($("#populationCheck").prop("checked") || $("#gdpCheck").prop("checked") || $("#averageCheck").prop("checked")){
                            $("#countryTable"+currentTable).append("<tr><td class='innerHeadings'> GENERAL INFORMATION</td></tr>");
                            if ($("#averageCheck").prop("checked")) $("#countryTable"+currentTable).append("<tr><td class='data'>"+"- Medal-Population Average:  "+average+"</td></tr>");
                            if ($("#populationCheck").prop("checked")) $("#countryTable"+currentTable).append("<tr><td class='data'>"+"- Population:  "+result[index].population+"</td></tr>");
                            if ($("#gdpCheck").prop("checked")) $("#countryTable"+currentTable).append("<tr><td class='data'>"+"- GDP:  "+result[index].gdp+"</td></tr>");
                        }

                        //medals information
                        $("#countryTable"+currentTable).append("<tr><td class='innerHeadings'>MEDALS</td></tr>");
                        $("#countryTable"+currentTable).append("<tr><td class='data'>"+"Total  "+result[index].total+"</td></tr>");
                        $("#countryTable"+currentTable).append("<tr><td class='data'>"+"Gold &#129351  "+result[index].gold+"</td></tr>");
                        $("#countryTable"+currentTable).append("<tr><td class='data'>"+"Silver &#129352  "+result[index].silver+"</td></tr>");
                        $("#countryTable"+currentTable).append("<tr><td class='data'>"+"Bronze &#129353  "+result[index].bronze+"</td></tr>");
                        $("#countryTable"+currentTable).append("<tr><td class='innerHeadings'>ATHLETES </td></tr>");
                        currentTable+=1;
                    }

                    //appending athletes
                    for (var field in result){
                        if (result[field].name ==null) result[field].name= "No Athletes";
                        if (result[field].country_name ==country1){//if row is for country1
                            $("#countryTable1").append("<tr class='namesRows'><td class='names'>"+result[field].name+ "</td></tr>");
                        } else if (result[field].country_name == country2) { //if row is for country2
                            $("#countryTable2").append("<tr class='namesRows'><td class='names'>"+result[field].name+ "</td></tr>");
                        } else if (result[field].country_name == country3){//if row is for country3
                            $("#countryTable3").append("<tr class='namesRows'><td class='names'>"+result[field].name+ "</td></tr>");
                        } else { //if row is for country 4
                            $("#countryTable4").append("<tr class='namesRows'><td class='names'>"+result[field].name+ "</td></tr>");
                        }
                    }
                },'json');
        }
            

        $(document).ready(function(){
            //toggles input fields for country 3 and 4 when page is first loaded
            $("#div_Country3").toggle();
            $("#div_Country4").toggle();
            //toggles the error message when page is first loaded
            $(".error").toggle();

            //JQUERY UI
            //enable autocomplete for countries text fields 
            $.get('dbAccess.php',{sql:"SELECT ISO_id FROM Country"}, function(result){
                var availableTags = [];
                for (var field in result){
                    availableTags.push(result[field].iso_id);
                }
                    $( "#country_id1" ).autocomplete({
                        source: availableTags
                    });
                    $( "#country_id2" ).autocomplete({
                        source: availableTags
                    });
                    $( "#country_id3" ).autocomplete({
                        source: availableTags
                    });
                    $( "#country_id4" ).autocomplete({
                        source: availableTags
                    });
            },'json');
                 
            $("#numberOfCountries").selectmenu({
                 //on change, it shows the neccesary input boxes to enter countries depending on how many the user specifies
                change: function(){
                    var numberOfCountries = $("#numberOfCountries").val();
                    
                    if (numberOfCountries ==2){
                        if ($("#div_Country4").is(":visible")) $("#div_Country4").toggle();
                        if ($("#div_Country3").is(":visible")) $("#div_Country3").toggle();
                    } else if (numberOfCountries == 3){
                        if ($("#div_Country4").is(":visible")) $("#div_Country4").toggle();
                        if ($("#div_Country3").is(":hidden")) $("#div_Country3").toggle();
                    } else if (numberOfCountries ==4){
                        if ($("#div_Country4").is(":hidden")) $("#div_Country4").toggle();
                        if ($("#div_Country3").is(":hidden")) $("#div_Country3").toggle(); 
                    }
                }
            });
            $("#numberOfCountries").selectmenu( "option", "width", 85);
            $(".controlgroup").controlgroup();
        }); 
    </script>
</head>
<body>
    <h1>LONDON OLYMPICS 2012</h1>
    <center><a class ="link" href="bmi.htm">BMI CALCULATOR</a><a class ="link" href="athletes.htm">ATHLETE FINDER</a><a class ="linkCurrent">COUNTRY COMPARISON</a> </center>
    <p class='sub'> COUNTRY COMPARISON </p>
    <form>
        <fieldset id="fieldCountries"> 
            <legend class="inputText"> Enter Countries </legend>

            <!-- slecting number of countries  -->
            <p for="numberOfCountries" class="inputText"><span class='spanCountries'>Number of Countries</span>
                <select id="numberOfCountries">
                    <option value='2'>2</option>
                    <option value='3'>3</option>
                    <option value='4'>4</option>
                </select>
            </p>
            
            <!-- input boxes for countries -->
            <div id="div_Country1">    
                <span class='inputText'>Enter Country</span>
                <input id="country_id1" value="MEX"><br>
            </div>
            <div id="div_Country2">    
                <span class='inputText'>Enter Country</span>
                <input id="country_id2" value="CHN"><br>
            </div>
            <div id="div_Country3">    
                <span class='inputText'>Enter Country</span>
                <input id="country_id3" value="USA"><br>
            </div>
            <div id="div_Country4">    
                <span class='inputText'>Enter Country</span>
                <input id="country_id4" value="FRA"><br>
            </div>
        </fieldset>

        <fieldset id="fieldConfiguation">
            <legend class="inputText">Configure Display</legend>

            <!-- rank by dropdown menu -->
            <div class="controlgroup">
                <p class="inputText"><span class='spanConf' > Rank By </span></p>
                <select  id="rankBy">
                    <option value='total DESC, gold DESC, silver DESC, bronze DESC'>Total of medals</option>
                    <option value='gold DESC, silver DESC, bronze DESC'>Gold medals</option>
                    <option value='country_name ASC'>Country Name</option>
                    <option value='population DESC'>Population</option>
                    <option value='gdp DESC'>GDP</option>
                    <option value='average ASC'>Medals-Population Average</option>
                </select>        
            </div>

            <!-- checkboxes to select what extra information to display -->
            <div class="controlgroup">
                <p class="inputText"><span class='spanConf' >Select additional information to display </span></p>
                <label for="populationCheck">Population</label>
                <input type="Checkbox" value='population' id="populationCheck"> 
                <label for="gdpCheck">GDP</label>
                <input type="Checkbox" value='gdp' id="gdpCheck">
                <label for="averageCheck">Medals/population</label>
                <input type="Checkbox" value='average' id="averageCheck">
            </div>
        </fieldset>

        <!-- submit button -->
        <div class="controlgroup">
            <input type="button" name="submit" id="submit" value="Submit" class="larger controlgroup" onclick='submitCountries(availableCountries);'/>
        </div>

    </form>
    <div id="resultsBackground">   
    <!-- error message (it is toggled at the start) -->
    <div class="ui-widget error">
            <div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;">
                <p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
                <strong>Hey!</strong> The country you entered is not valid</p>
            </div>
    </div>
     
    <!-- tables to append the information to     -->
    <div id="tables">
        <table id='countryTable1' >
        </table>
        <table id='countryTable2'  >
        </table>
        <table id='countryTable3' >
        </table>
        <table id='countryTable4' >
        </table>
    </div>
    </div>
    
</body>
</html>