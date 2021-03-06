<?php include("header.inc");?>

	<?php
			$dbc = mysql_connect("yallara.cs.rmit.edu.au:56586", "winestore", "bmRVQy5E") or 
		print("can't connect to server");
		mysql_select_db("winestore") or print("can't connect to 
database");
	?>
	<h1>Search wines and wineries</h1>
<!--display the form-->	
	<form action="wineryresults.php" method="get" onsubmit="return 
checkWine()" >
	<table id="winetable">
	<tr><td>Wine Name: </td><td><input type="text" name="winename" 
id="winename" /></td></tr>
	<tr><td>Winery Name: </td><td><input type="text" name="wineryname" 
id="wineryname" /></td></tr>
	<tr><td>Region: </td><td>
	<select name="region" id = "region">
	<!--dynamically added select options-->
		<option>All</option>
		<?php	
	$regionquery = mysql_query("select region_name from region group by region_name");
	while($row = mysql_fetch_array($regionquery))
	{
		print "<option>".$row['region_name']."</option>";
	}
		?>
	</select>
	</td></tr>
	
	<tr><td>Grape variety:</td><td>
	<select name="grape" id="grape">
	<!--dynamically added select options-->
		<option>All</option>
		<?php	
	$grapequery = mysql_query("select variety from grape_variety group by variety");
	while($row = mysql_fetch_array($grapequery))
	{
		print "<option>".$row['variety']."</option>";
	}
		?>
	</select>
	</td></tr>
	
	<tr><td>Year Range:</td><td>
	<select name="YearMin" id="YearMin">
	<!--dynamically added select options-->
		<option>All</option>
		<?php	
	$year1query = mysql_query("select year from wine group by year");
	while($row = mysql_fetch_array($year1query))
	{
		print "<option>".$row['year']."</option>";
	}
		?>
	</select>
	 to 
	 <select name="YearMax" id="YearMax">
	 <!--dynamically added select options-->
		<option>All</option>
		<?php	
	$year2query = mysql_query("select year from wine group by year");
	while($row = mysql_fetch_array($year2query))
	{
		print "<option>".$row['year']."</option>";
	}
		?>
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
//get commands
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
	
	print "<span id='dieerrors'>";

	//php validation before entering the database

		print "<table id='errortable'>";
		print "<td>";
		//individual validation for each variable s3236863
		if(($YearMin < '1000' || $YearMin > '2030') && $YearMin != 'All')
		{
			die("Minimum year must be between 1000 and 2030.");
		}
		else if(($YearMax < '1000' || $YearMax > '2030') && $YearMin != 'All')
		{
			die("Maximum year must be between 1000 and 2030.");
		}
		else if($YearMax < $YearMin)
		{
			die("Maximum year is smaller than minimum year!!!");
		}
		else if(ctype_digit($minstock) != TRUE)
		{
			die("Minimum stock must be a number.");
		}
		else if(ctype_digit($minordered) != TRUE)
		{
			die("Minimum ordered must be a number.");
		}
		else if(ctype_digit($minDollar) != TRUE)
		{
			die("Minimum dollar must be a number.");
		}
		else if(ctype_digit($maxDollar) != TRUE)
		{
			die("Maximum dollar must be a number.");
		}
		else if($maxDollar < $minDollar)
		{
			die("Maximum dollar range is smaller than minimum dollar range!!!");
		}
	
		print "</td></table>";
//	}
	

//this is the (very long) sql command as a variable name
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

	print "</span>";

	if ($error == '')
	{
	//enter the database and query it
		$dbc = mysql_connect("yallara.cs.rmit.edu.au:56586", "winestore", "bmRVQy5E") or 
		die("can't connect to server");
		mysql_select_db("winestore") or die("can't connect to 
database");
		$result = mysql_query("$query");
//Nathan Dalby s3236863
	}//if statement if there are required statements
	else{
	die("There is a blank field. Please try again.");
	}
	
	echo '<div id="error">';

	echo "$error</div>";
	?>
	
	<?php include("footer.inc"); ?>
