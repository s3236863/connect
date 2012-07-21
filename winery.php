<html>
	<head>
		<title>Winery Database</title>
	</head>

	<body>
	<div id="wrapper">
	
	<h1>Search wines and wineries</h1>
	
	<form>
	Wine Name: <input type="text" name="winename" 
id="winename" />
	Winery Name: <input type="text" name="wineryname" 
id="wineryname" />
	Region: 
	<select>
	<!--dynamically added select options-->
		<option></option>
	</select>
	
	Grape variety:
	<select>
	<!--dynamically added select options-->
		<option></option>
	</select>
	
	Year Range:
	<select>
	<!--dynamically added select options-->
		<option></option>
	</select>
	 to 
	 <select>
	 <!--dynamically added select options-->
		<option></option>
	 </select>
	 
	 Minimum number of wines in stock, per wine: <input 
type="text" name="minstock" id="minstock" />
	 Minimum number of wines ordered, per wine: <input 
type="text" name="minordered" id="minordered" />
	 Dollar Cost Range:
	 Minimum: <input type="text" name="minDollar" 
id="minDollar" />
	 Maximum: <input type="text" name="maxDollar" 
id="maxDollar" />
	 
	 <input type="submit" value="Search" name="search" 
id="search" />
	
	</form>
	
	<?php
	
	$winename = POST['winename'];
	$wineryname = POST['wineryname'];
	$region = POST['region'];
	$grape = POST['grape'];
	$YearMin = POST['yearMin'];
	$YearMax = POST['yearMax'];
	$minstock = POST['minstock'];
	$minordered = POST['minordered'];
	$minDollar = POST['minDollar'];
	$maxDollar = POST['maxDollar'];
	$counter = 0;
	
	//enter the database and query it
	
	//query names
	$query = "select wine, grape, year, winery, region, 
(cost), (totalbottles), (totalstock sold), (total revenue) 
from wine";
	
	//display the table
	
	//adds one to the counter each time a row is found 
and written
	counter = counter + 1;
	
	//after the query is executed, return an error if 
the counter is still at 0.
	if (counter == 0){print "No records match your 
search criteria.";}
	
	
	?>
	
	</div> <!--wrapper-->
	</body>

</html>
