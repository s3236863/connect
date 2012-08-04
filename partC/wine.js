function checkWine(){
YearMin = document.getElementById("YearMin").value;
YearMax = document.getElementById("YearMax").value;
minDollarNumeric = isNumeric(minDollar);
maxDollarNumeric = isNumeric(maxDollar);
minstockNumeric = isNumeric(minstock);
minorderedNumeric = isNumeric(minordered);

if(minDollarNumeric == false)
{
	hideAllErrors();
	document.getElementById("minDollarerror").style.display = "inline";
	document.getElementById("minDollar".select();
	document.getElementById("minDollar".focus();
	return false;
}

if(maxDollarNumeric == false)
{
	hideAllErrors();
	document.getElementById("maxDollarerror").style.display = "inline";
	document.getElementById("maxDollar".select();
	document.getElementById("maxDollar".focus();
	return false;
}

if(minstockNumeric == false)
{
	hideAllErrors();
	document.getElementById("minstockerror").style.display = "inline";
	document.getElementById("minstock".select();
	document.getElementById("minstock".focus();
	return false;
}
if(minorderedNumeric == false)
{
	hideAllErrors();
	document.getElementById("minorderederror").style.display = "inline";
	document.getElementById("minordered".select();
	document.getElementById("minordered".focus();
	return false;
}

	function IsNumeric(num1)
	{
		mystring = num1;
		if (mystring.match(/^\d+$/ ) ) {
			return true;
			} else{
			return false;
			}
	}

		alert("minDollar: " + minDollar + "\n maxDollar:" + maxDollar + "\n minstock: " + minstock + "\n minordered: " + minordered);
	return true;
		
		function hideAllErrors()
	{
		document.getElementById("minDollarerror").style.display = "none";
		document.getElementById("maxDollarerror").style.display = "none";
		document.getElementById("minstockerror").style.display = "none";
		document.getElementById("minorderederror").style.display = "none";
	}


