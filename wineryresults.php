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
			$dbc = mysql_connect("yallara.cs.rmit.edu.au:56586", "winestore", "bmRVQy5E") or 
		die("can't connect to server");
		mysql_select_db("winestore", $dbc) or die("can't connect to database");
                echo mysql_errno($dbc) . ":" . mysql_error($dbc). "\n";
	?>
	<h1>Results</h1>
	
	<?php
	//Nathan Dalby s3236863
	$error = '';
	$winename = $_GET['winename'];
	$wineryname = $_GET['wineryname'];
	$region = $_GET['region'];
	$grape = $_GET['grape'];
	$YearMin = $_GET['YearMin'];
	$YearMax = $_GET['YearMax'];
	$minstock = $_GET['minstock'];
	$minordered = $_GET['minordered'];
	$minDollar = $_GET['minDollar'];
	$maxDollar = $_GET['maxDollar'];
	$counter = 0;

	if ($error == '')
	{
	//enter the database and query it
		$dbc = mysql_connect("yallara.cs.rmit.edu.au:56586", "winestore", "bmRVQy5E") or 
		die("can't connect to server");
		mysql_select_db("winestore", $dbc) or die("can't connect to database");
                echo mysql_errno($dbc) . ":" . mysql_error($dbc) . "\n";

//this is the (very long) sql command as a variable name

//$query = "select wine_name, variety,  year, cost, on_hand, region_name, winery_name, qty, cost*qty as Total_Revenue from wine, inventory, grape_variety, region, winery, items where wine.wine_id = inventory.wine_id and wine.winery_id = winery.winery_id and winery.region_id = region.region_id and items.wine_id = wine.wine_id";
$query = "select wine_name, variety,  year, cost, on_hand, region_name, winery_name, qty, cost*qty as Total_Revenue from wine, inventory, grape_variety, region, winery, items where wine.wine_id = inventory.wine_id and wine.winery_id = winery.winery_id and winery.region_id = region.region_id and items.wine_id = wine.wine_id";


//qty multiplied the number by 7???, total revenue causes issues, 

	if($grape != 'All'){
	$query.= " and variety like '%$grape%'";
	}
	if($winename != ''){
	$query.= " and wine_name like '%$winename%'";
	}
	if($region !='All'){
	$query.= " and region_name like '%$region%'";
	}
	if($YearMin !='All' && $YearMax !='All'){
	$query.= " and year between '$YearMin'and '$YearMax'";
	}
	if($minDollar !='' && $maxDollar !=''){
	$query.=" and cost between'$minDollar' and '$maxDollar'";
	}
	if($wineryname !=''){
	$query.=" and winery_name like '%$wineryname%'";
	}
	if($minstock !=''){
	$query.=" and on_hand > '$minstock'";
	}
	if($minordered !=''){
	$query.=" and qty > '$minordered'";
	}
	
	$query.="group by wine.wine_id order by wine.wine_name limit 2000";
	$result = mysql_query("$query", $dbc);
        echo mysql_errno($dbc) . ":" . mysql_error($dbc) . "\n";
	
	//display the table
	//after the query is executed, return an error if 
	//the counter is still at 0.

			print "<table id='VT' ><th>Wine 
Name</th><th>Grape</th><th>Year</th><th>Winery</th><th>Region</th><th>Cost</th><th>Total 
bottles</th><th>Total stock sold</th><th>Total Revenue</th>";

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
			print "Total returned: $counter <br />";
//Nathan Dalby s3236863
		//}//else
		if($counter == 0)
		{print "No records match your search criteria.";}
		} //error if
//	}//if statement if there are required statements
	
	?>
	
	</div> <!--wrapper-->
	</body>

</html>

