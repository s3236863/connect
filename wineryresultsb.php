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
	<?php
	
	function showerror()
	{
	die("An error has occurred: " . mysql_errno() . " - " . mysql_error());
	}
	
	//may use the db.php file to retrieve extra info
	
	function displayWines($connection, $query, $regionName)
	{
	
	//Run query on server
	if(!($result = @ mysql_query ($query, $connection)))
	{
		showerror();
	}
	
	//find the number of rows
	
	$rowsFound = @ mysql_num_rows($result);
	
	//if there are results from the query
	if($rowsFound > 0)
	{
	
	print "<table id='VT' ><th>Wine Name</th><th>Grape</th><th>Year</th><th>Winery</th><th>Region</th><th>Cost</th><th>Total bottles</th><th>Total stock sold</th><th>Total Revenue</th>";
	
	while($row = @ mysql_fetch_array($result))
			{
			//verify names
				print "<tr><td>" .$row['wine_name']."</td>
				<td>".$row['variety']."</td>
				<td>".$row['year']."</td>
				<td>".$row['winery_name']."</td>
				<td>".$row['region_name']."</td>
				<td>".$row['cost']."</td>
				<td>".$row['on_hand']."</td>
				<td>".$row['qty']."</td>
				<td>".$row['Total_Revenue']."</td>
				</tr>";
			//adds one to the counter each time a row is found and written
			$counter = $counter + 1;
			}//while
			print "</table>";
			
			print "{$rowsFound} records found.<br />";
			print "Total returned: $counter <br />";
	}//if
}//function

//Connect to MySQL server

if(!($connection = @ mysql_connect('localhost', 'root', '')))
{
	die("Could not connect");
	
	//get the user data
$regionName = $_GET['regionName'];

if(!mysql_select_db(DB_NAME, $connection))
{
	showerror();
}

	$query = "select wine_name, variety, year,  winery_name, region_name, cost, on_hand, qty, sum(cost*qty) as Total_Revenue from wine, grape_variety, winery, region, inventory, wine_variety, items where winery.region_id = region.region_id and wine.winery_id = winery.winery_id and wine.wine_id = inventory.wine_id and wine_variety.variety_id = grape_variety.variety_id and wine_variety.wine_id = wine.wine_id and items.wine_id = wine.wine_id";
	
	if($grape != 'All'){
	$query.= "and variety like '%$grape%'";
	}
	if($winename != ''){
	$query.= "and wine_name like '%$winename%'";
	}
	if($region !='All'){
	$query.= "and region_name like '%$region%'";
	}
	if($YearMin !='All' && $YearMax !='All'){
	$query.= "and year between '$YearMin'and '$YearMax'";
	}
	if($minDollar !='' && $maxDollar !=''){
	$query.="and cost between'$minDollar' and '$maxDollar'";
	}
	if($wineryname !='All'){
	$query.="and winery_name like '%$wineryname%'";
	}
	if($minStock !='' && $minOrdered != ''){
	$query.="and qty between '$minStock' and '$minordered'";
	}
	
	$query.="group by wine.wine_id order by wine.wine_name";
	
	displayWine($connection, $query, $regionName);
	?>
	
	</div>
	</body>
	</html>
