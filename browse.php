<?php
//retunrs the complete books database for quick browsing
session_start();
if(!isset($_SESSION['email']))
{
	echo "<!DOCTYPE HTML>
<html>
<head>
<title>U Sale | Browse</title>
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
								 	
									<li><a href='search'>Search</a></li>
									<li class='current_page_item'><a href='browse'>Browse</a></li>
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
<title>U Sale | Browse</title>
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
								 	
									<li><a href='search'>Search</a></li>
									<li class = 'current_page_item'><a href='browse'>Browse</a></li>
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
<td> 
<h2 align = "left">
<input type = "submit" value = "" name = "quicksearch"  style="border-style: solid; border-color:#4B7B9F;border-width:1px; background: url('images/searchbutton2.png') no-repeat; width: 100px; height: 40px;"/></h2></td>
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
					<h2>Recent Posts</h2>
				</div><br>

<?php
    require_once "accessdatabase.php";
    $db_server = mysql_connect($db_hostname, $db_username, $db_password);
    
    if (!$db_server) die("Unable to connect to MySQL: " . mysql_error());
    
    mysql_select_db($db_database)
    or die("Unable to select database: " . mysql_error());

	// How many adjacent pages should be shown on each side?
	$adjacents = 3;
    
	$query = "SELECT COUNT(*) as num FROM Books";
	$total_pages = mysql_fetch_array(mysql_query($query));
	$total_pages = $total_pages[num];
	
	/* Setup vars for query. */
	$targetpage = "browse.php"; 	//your file name  (the name of this file)
	$limit = 5; 								//how many items to show per page
	$page = $_GET['page'];
	if($page) 
		$start = ($page - 1) * $limit; 			//first item to display on this page
	else
		$start = 0;								//if no page var is given, set start to 0
	
	/* Get data. */
    //queries the entire books databse and returns each post in the style of the form
	$getbooksquery = ("SELECT * FROM Books ORDER BY PostNumber DESC LIMIT $start, $limit");
	$getbooks = mysql_query($getbooksquery);
	if(!$getbooks) die ("Can't connect to books list: " .mysql_error());
	
	/* Setup page vars for display. */
	if ($page == 0) $page = 1;					//if no page var is given, default to 1.
	$prev = $page - 1;							//previous page is page - 1
	$next = $page + 1;							//next page is page + 1
	$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
	$lpm1 = $lastpage - 1;						//last page minus 1
	
	/* 
		Now we apply our rules and draw the pagination object. 
		We're actually saving the code to a variable in case we want to draw it more than once.
	*/
	$pagination = "";
	if($lastpage > 1)
	{	
		$pagination .= "<div class=\"pagination\">";
		//previous button
		if ($page > 1) 
			$pagination.= "<a href=\"$targetpage?page=$prev\">previous</a>";
		else
			$pagination.= "<span class=\"disabled\">previous</span>";	
		
		//pages	
		if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$pagination.= "<span class=\"current\">$counter</span>";
				else
					$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
			}
		}
		elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
		{
			//close to beginning; only hide later pages
			if($page < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";		
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
				$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
				$pagination.= "...";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";		
			}
			//close to end; only hide early pages
			else
			{
				$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
				$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
				$pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
				}
			}
		}
		
		//next button
		if ($page < $counter - 1) 
			$pagination.= "<a href=\"$targetpage?page=$next\">next</a>";
		else
			$pagination.= "<span class=\"disabled\">next</span>";
		$pagination.= "</div>\n";		
	}
?>           
				
<?php

while ($getbooksarray = mysql_fetch_array($getbooks)){
$postnumber = $getbooksarray['PostNumber'];

echo"<table
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
".$getbooksarray['Title']."
</h2></div>
</td>
<td
style='text-align: center; vertical-align: top; width: 257px; height: 49px; background-color: white; text-transform: uppercase;'>
<div class='post' style='font-size: 20pt; color: #000000;'><h2>
$".$getbooksarray['Price']."<br>
</h2></div>
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
<td style='vertical-align: top; height: 30px; width: 496px;'>Author: ".$getbooksarray['Author']."<br>
</td>
<td style='vertical-align: top; height: 24px; width: 498px;'>Year: ".$getbooksarray['year']."<br>
</td>
</tr>
<tr>
<td style='vertical-align: top; height: 30px; width: 496px;'>Course: ".$getbooksarray['Class']."<br>
</td>
<td style='vertical-align: top; height: 27px; width: 498px;'>Condition: ".$getbooksarray['bookcondition']."<br>
</td>
</tr>
<tr>
<td style='vertical-align: top; height: 30px; width: 496px;'>ISBN: ".$getbooksarray['isbn']." <br>
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
<td style='vertical-align: top; width: 499px;'><form method = 'post' action = 'buy.php' ><input type = 'hidden' name = 'postnumber' value = '$postnumber' ><button type = 'submit' name = 'buy' style='width: 395px; height: 39px'><img src='images/buy2.jpg'>BUY</button></form>
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

<?=$pagination?><br><br>

Don't see the book your looking for? <a href = 'add' class='darker'>Add a book to your wishlist</a> to get notified when someone posts it.


							 
							
					</section>
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