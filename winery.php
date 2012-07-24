<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" 
"http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<title>Winery Database</title>
		<!--Nathan Dalby s3236863-->
		<link type="text/css" rel="stylesheet" href="style.css" />
	</head>

	<body>
	<div id="wrapper">
	
	<h1>Search wines and wineries</h1>
	
	<form action="winery.php" method="get" onsubmit="return 
checkWine()" >
	<table id="winetable">
	<tr><td>Wine Name: </td><td><input type="text" name="winename" 
id="winename" /></td></tr>
	<tr><td>Winery Name: </td><td><input type="text" name="wineryname" 
id="wineryname" /></td></tr>
	<tr><td>Region: </td><td>
	<select>
	<!--dynamically added select options-->
		<option>Nothing</option>	
	</select>
		<!--
		<?php
		/*
	$regionsql = "select region_name from region";
	$result = mysql_query($regionsql) or die(mysql_error());
	
	if(mysql_num_rows($result)){
	while($row = mysql_fetch_row($result))
	{
	
	print("<option value=\"$row[0]\">$row[0]</option>");
	}
	}
	else{
	print("<option value\"\">There are no regions</option>");
	}
	*/
	
	?>
	-->
	</td></tr>
	
	<tr><td>Grape variety:</td><td>
	<select>
	<!--dynamically added select options-->
		<option></option>
	</select>
	</td></tr>
	
	<tr><td>Year Range:</td><td>
	<select>
	<!--dynamically added select options-->
		<option></option>
	</select>
	 to 
	 <select>
	 <!--dynamically added select options-->
		<option></option>
	 </select>
	</td></tr>
	<!--Nathan Dalby s3236863-->
	 
	<tr><td> Minimum number of wines in stock, per wine: </td><td><input 
type="text" name="minstock" id="minstock" /></td></tr>
	<tr><td> Minimum number of wines ordered, per wine: </td><td><input 
type="text" name="minordered" id="minordered" /></td></tr>
	<tr><td> Dollar Cost Range:</td>
	<td>
	 Minimum: <input type="text" name="minDollar" 
id="minDollar" />
	 Maximum: <input type="text" name="maxDollar" 
id="maxDollar" />
	</td></tr>
	 
	</table>
	 <br /><input type="submit" value="Search" name="search" 
id="search" />
	
	</form>
	
	<?php
	//Nathan Dalby s3236863
	$error = '';
	$winename = $_GET['winename'];
	$wineryname = $_GET['wineryname'];
	$region = $_GET['region'];
	$grape = $_GET['grape'];
	$YearMin = $_GET['yearMin'];
	$YearMax = $_GET['yearMax'];
	$minstock = $_GET['minstock'];
	$minordered = $_GET['minordered'];
	$minDollar = $_GET['minDollar'];
	$maxDollar = $_GET['maxDollar'];
	$counter = 0;
	?>
	<span id="dieerrors">
	<?php

	//php validation before entering the database
	//this makes sure that all required fields are filled in.
/*no fields are required
	if($winename != '' && $wineryname != '' && $region != '' && 
$grape != '' && $YearMin != '' && $YearMax != '' && $minstock != '' && 
$minordered != '' && $minDollar != '' && $maxDollar != '')
	{
	*/

	print "<table id='errortable'>";
	print "<td>";
	//individual validation for each variable s3236863
	if($YearMin < '1000' || $YearMin > '2030'){
	$error = "Minimum year must be between 1000 and 2030.";
	print $error;
	}
	
	print "</td></table>";
	
/*
        $query = "select wine, grape, year, winery, region, (cost), 
(totalbottles), (totalstock sold), (total revenue)
from wine";
*/

//this is the (very long) sql command as a variable name
//still needed to be added to it will be querying each of the variables against it.
	$query = "select wine_name, variety, year,  winery_name, region_name, cost, on_hand, qty, sum(cost*qty) as Total_Revenue from wine, grape_variety, winery, region, inventory, wine_variety, items where winery.region_id = region.region_id and wine.winery_id = winery.winery_id and wine.wine_id = inventory.wine_id and wine_variety.variety_id = grape_variety.variety_id and wine_variety.wine_id = wine.wine_id and items.wine_id = wine.wine_id group by wine.wine_id";

	?>
	</span>
	<?php
	if ($error = '')
	{
	//enter the database and query it
		$dbc = mysql_connect("localhost", "root", "") or 
		die("can't connect to server");
		mysql_select_db("winestore") or die("can't connect to 
database");
	
	//display the table
	
	//adds one to the counter each time a row is found and written
		$counter = $counter + 1;
	
	//after the query is executed, return an error if 
	//the counter is still at 0.
		if (counter == 0){print "No records match your 
search criteria.";}
		else{
			print "<table><th>Wine 
Name</th><th>Grape</th><th>Year</th><th>Winery</th><th>Region</th><th>Cost</th><th>Total 
bottles</th><th>Total stock sold</th><th>Total Revenue</th>";

			while($row = mysql_fetch_array($result))
			{
			//verify names
				print "<tr><td>" .$row['wine_name']."</td>
				<td>".$row['variety']."</td>
				<td>".$row['year']."</td>
				<td>".$row['winery_name']."</td>
				<td>".$row['region_name']."</td>
				<td>".$row['cost']."</td>
				<td>".$row['TotalBottles']."</td>
				<td>".$row['TotalStockSold']."</td>
				<td>".$row['TotalRevenue']."</td>
				</tr>";
			}//while
			print "</table>";
//Nathan Dalby s3236863
		}//else
		} //error if
//	}//if statement if there are required statements
	
	?>
	
	</div> <!--wrapper-->
	</body>

</html>
