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
			$dbc = mysql_connect("localhost", "root", "") or 
		print("can't connect to server");
		mysql_select_db("winestore") or print("can't connect to 
database");
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
		$dbc = mysql_connect("localhost", "root", "") or 
		die("can't connect to server");
		mysql_select_db("winestore") or die("can't connect to 
database");
		$result = mysql_query("$query");
	
	//display the table
	//after the query is executed, return an error if 
	//the counter is still at 0.
//		if (counter == 0){print "No records match your 
//search criteria.";}
//		else{
			print "<table id='VT' ><th>Wine 
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
				<td>".$row['on_hand']."</td>
				<td>".$row['qty']."</td>
				<td>".$row['Total_Revenue']."</td>
				</tr>";
			//adds one to the counter each time a row is found and written
			$counter = $counter + 1;
			}//while
			print "</table>";
			print "Total returned: $counter";
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

