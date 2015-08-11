<?php
//queries the database for a quick search based on the fulltext indexes
require_once "accessdatabase.php";
$db_server = mysql_connect($db_hostname, $db_username, $db_password);

if(!$db_server) die("Unable to connect to MySQL: " . mysql_error());

mysql_select_db($db_database, $db_server)
or die("Unable to select database : " . mysql_error());

if(isset($_POST['searchterm']))
$searchterm = mysql_real_escape_string($_POST['searchterm']);
//queries a search through the specified columns
$searchquery = mysql_query("SELECT * FROM Books WHERE MATCH (isbn, title, author, class) AGAINST ('$searchterm')");
if(!$searchquery) die ("Can't do the search " .mysql_error());


session_start();
if(!isset($_SESSION['email']))
{
	echo "<!DOCTYPE HTML>
<html>
<head>
<title>U Sale | Search Results</title>
<meta http-equiv='content-type' content='text/html; charset=utf-8' />
<meta name='description' content='' />
<meta name='keywords' content='' />
<noscript>
<link rel='stylesheet' href='css/5grid/core.css' />
<link rel='stylesheet' href='css/5grid/core-desktop.css' />
<link rel='stylesheet' href='css/5grid/core-1200px.css' />
<link rel='stylesheet' href='css/5grid/core-noscript.css' />
<link rel='stylesheet' href='css/style.css' />
<link rel='stylesheet' href='css/style-desktop.css' />
</noscript>
<script src='css/5grid/jquery.js'></script>
<script src='css/5grid/init.js?use=mobile,desktop,1000px&amp;mobileUI=1&amp;mobileUI.theme=none&amp;mobileUI.openerWidth=52'></script>
<!--[if IE 9]><link rel='stylesheet' href='css/style-ie9.css' /><![endif]-->
</head><body class='twocolumn2'>
<div id='wrapper'>
	<div id='header-wrapper'>
		<header id='header'>
			<div class='5grid-layout'>
				<div class='row'>
					<div class='12u' id='logo'> <!-- Logo -->
						<h1><a href='.'><img src = 'images/logo.png'></a></h1>
						<p><a href='login'>Login</a> / <a href='signup'>Sign Up</a></p>
					</div>
				</div>
			</div>
			<div class='5grid-layout'>
				<div class='row'>
					<div class='12u' id='menu'>
						<div id='menu-wrapper'>
							<nav class='mobileUI-site-nav'>
								<ul>
								 	
									<li class='current_page_item'><a href='search'>Search</a></li>
									<li><a href='browse'>Browse</a></li>
									<li><a href='sell'>Sell</a></li>
									<li><a href='account'>Account</a></li>
								</ul>
							</nav>
						</div>
					</div>
				</div>
			</div>
		</header>
	</div>";

}else{
	$sessionemail = $_SESSION['email'];
	$sessionpassword = $_SESSION['password'];
echo "<!DOCTYPE HTML>
<html>
<head>
<title>U Sale | Search Results</title>
<meta http-equiv='content-type' content='text/html; charset=utf-8' />
<meta name='description' content='' />
<meta name='keywords' content='' />
<noscript>
<link rel='stylesheet' href='css/5grid/core.css' />
<link rel='stylesheet' href='css/5grid/core-desktop.css' />
<link rel='stylesheet' href='css/5grid/core-1200px.css' />
<link rel='stylesheet' href='css/5grid/core-noscript.css' />
<link rel='stylesheet' href='css/style.css' />
<link rel='stylesheet' href='css/style-desktop.css' />
</noscript>
<script src='css/5grid/jquery.js'></script>
<script src='css/5grid/init.js?use=mobile,desktop,1000px&amp;mobileUI=1&amp;mobileUI.theme=none&amp;mobileUI.openerWidth=52'></script>
<!--[if IE 9]><link rel='stylesheet' href='css/style-ie9.css' /><![endif]-->
</head><body class='onecolumn'>
<div id='wrapper'>
	<div id='header-wrapper'>
		<header id='header'>
			<div class='5grid-layout'>
				<div class='row'>
					<div class='12u' id='logo'> <!-- Logo -->
						<h1><a href='.'><img src = 'images/logo.png'></a></h1>
						<p><a href='logout'>Log Out</a>
					</div>
				</div>
			</div>
			<div class='5grid-layout'>
				<div class='row'>
					<div class='12u' id='menu'>
						<div id='menu-wrapper'>
							<nav class='mobileUI-site-nav'>
								<ul>
								 	
									<li class='current_page_item'><a href='search'>Search</a></li>
									<li><a href='browse'>Browse</a></li>
									<li><a href='sell'>Sell</a></li>
									<li><a href='account'>Account</a></li>
								</ul>
							</nav>
						</div>
					</div>
				</div>
			</div>
		</header>
	</div>";
}
?>
	
	<div id="footer-content-wrapper">
		<div class="5grid-layout">
			<div class="row" id="search-content">
				<div class="6u" id="box1">
					<section>
						
						
						<form method="post" action="quicksearch.php"> 
<table cellpadding="10px" cellspacing="10px"> 
<tr> 
<td style="border-style:solid none solid solid;border-color:#4B7B9F;border-width:0px;">
<input type="text" name="searchterm" style="width:1070px; border:0px solid; height: 60px; padding:0px 3px; position:relative; font-family: 'Abel', sans-serif; font-size: 27pt;"> 

<td>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</td>

</td>
<td style="border-style:solid;border-width:0px;"> 
<h2 align = "left"><input type = "submit" value = "" name = "quicksearch"  style="border-style: solid; border-color:#4B7B9F;border-width:1px; background: url('images/searchbutton2.png') no-repeat; width: 100px; height: 40px;"/></h2></td>
</tr>
</table>
</form>
						
						
						
					</section>
				</div>
			</div>
		</div>
	</div>
	
	
	
	
	
	<div id="page-wrapper" class="5grid-layout">
		<div class="row">
			<div class="9u">
				<div class="titlebg">
					<h2>Results</h2>
				</div><br>
				
				
				
				
<?php				
while($searchqueryarray = mysql_fetch_array($searchquery))
{
$postnumber = $searchqueryarray['PostNumber'];			
echo "<table
style='text-align: left; width: 1012px; background-color: white; height: 127px;'
border='0' cellpadding='2' cellspacing='2'>
<tbody>
<tr>
<td style='vertical-align: top; height: 47px;'>
<table style='text-align: left; width: 997px; height: 47px;'
border='0' cellpadding='0' cellspacing='0'>
<tbody>
<tr>


<td
style='vertical-align: top; width: 733px; height: 49px; background-color: white; font-size: 20pt; text-transform: uppercase;'>
	<div class='post' style='color: #000000;'><h2>
	".$searchqueryarray['Title']."
	</h2></div>
	</td>
<td
style='text-align: center; vertical-align: top; width: 257px; height: 49px; background-color: white; text-transform: uppercase;'>
	<div class='post' style='font-size: 20pt; color: #000000;'><h2>
	$".$searchqueryarray['Price']."
	</h2></div>
	<br>
</td>


</tr>
</tbody>
</table>
</td>
</tr>
<tr>
<td
style='vertical-align: top; height: 103px; background-color: white;'>
<table style='text-align: left; width: 1000px; height: 93px;'
border='0' cellpadding='0' cellspacing='0'>
<tbody>
<tr>
<td style='vertical-align: top; height: 30px; width: 496px;'>Author: ".$searchqueryarray['Author']."<br>
</td>
<td style='vertical-align: top; height: 24px; width: 498px;'>Year: ".$searchqueryarray['YEAR']."<br>
</td>
</tr>
<tr>
<td style='vertical-align: top; height: 30px; width: 496px;'>Course: ".$searchqueryarray['Class']."<br>
</td>
<td style='vertical-align: top; height: 27px; width: 498px;'>Condition: ".$searchqueryarray['bookcondition']."<br>
</td>
</tr>
<tr>
<td style='vertical-align: top; height: 30px; width: 496px;'>ISBN: ".$searchqueryarray['isbn']."<br>
</td>
<td style='vertical-align: top; height: 30px; width: 498px;'><br>
</td>
</tr>
</tbody>
</table>
<br>
</td>
</tr>
<tr>
<td
style='vertical-align: top; height: 34px; background-color: white;'>
<table style='text-align: left; width: 1000px; height: 39px;'
border='0' cellpadding='0' cellspacing='0'>
<tbody>
<tr>
<td style='vertical-align: top; width: 495px;'><a href='add.php'><img src='images/wishlist.jpg'></a>
<br>
</td>
<td style='vertical-align: top; width: 499px;'><form method = 'post' action = 'buy.php'><input type = 'hidden' name = 'postnumber' value = '$postnumber'> <button type = 'submit' name = 'buy'><img src='images/buy2.jpg'></button></form>
<br>
</td>
</tr>
</tbody>
</table>
<br>
</td>
</tr>
</tbody>
</table>



<div class='divider'></div>";
}

?>
Don't see the book your looking for? <a href = 'add' class='darker'>Add a book to your wishlist</a> to get notified when someone posts it.				
				
				
				
				
				
				
				
			</div>
			
		</div>
	</div>
</div>
<div id="copyright" class="5grid-layout">
	<section>
		<p>&copy; 2013 U Sale   |   <a href="about">About Us</a>   |   <a href="privacy">Privacy Policy</a>   |   <a href="terms">Terms of Use</a></p>
	</section>
</div>
</body>
</html>