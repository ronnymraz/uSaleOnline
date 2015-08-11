<?php
/*
This is the form that allows a user to add a book to their wishlist by adding validating their title and isbn number
*/
require_once "accessdatabase.php";
$db_server = mysql_connect($db_hostname, $db_username, $db_password);

if(!$db_server) die("Unable to connect to MySQL: " . mysql_error());

mysql_select_db($db_database, $db_server)
or die("Unable to select database : " . mysql_error());
$postnumber = "";
session_start();
	$sessionemail = $_SESSION['email'];
	$sessionpassword = $_SESSION['password'];
if(!isset($_SESSION['email']))
{
header('Location:login.html');
}

if(isset($_POST['ISBN']))
	$isbn = mysql_real_escape_string($_POST['ISBN']);
if(isset($_POST['Title']))
	$title = mysql_real_escape_string($_POST['Title']);
$error = validate_isbn($isbn);
if($error!=""){ 
}else{

$useridquery = mysql_query("SELECT * FROM user WHERE Email = '$sessionemail'");
if (!$useridquery) die ("Couldn't get userid: " . mysql_error());
$useridarray = mysql_fetch_array($useridquery);
$userid = $useridarray['UserID'];

$wishlistquery = "INSERT INTO wishlist VALUES('$userid','$sessionemail', '$isbn', '$title')";
$wishlistadd = mysql_query($wishlistquery);
if(!$wishlistadd) die ("Couldn't add to wishlist: " . mysql_error());
else header('Location: wishlistsuccess.php');
}
function validate_isbn($field){
if ($field == "") return "";
if (preg_match("/[^0-9{13}]/", $field)) return "Invalid ISBN number. <br />";
if (strlen($field)<13) return "Invalid ISBN Number. <br />";
else return "";
}

?>

<!DOCTYPE HTML>
<html>
<head>
<title>U Sale | Add To Wish List</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="description" content="" />
<meta name="keywords" content="" />
<noscript>
<link rel="stylesheet" href="css/5grid/core.css" />
<link rel="stylesheet" href="css/5grid/core-desktop.css" />
<link rel="stylesheet" href="css/5grid/core-1200px.css" />
<link rel="stylesheet" href="css/5grid/core-noscript.css" />
<link rel="stylesheet" href="../css/style.css" />
<link rel="stylesheet" href="css/style-desktop.css" />
</noscript>
<script src="css/5grid/jquery.js"></script>
<script src="css/5grid/init.js?use=mobile,desktop,1000px&mobileUI=1&mobileUI.theme=none&mobileUI.openerWidth=52"></script>
<!--[if IE 9]><link rel="stylesheet" href="css/style-ie9.css" /><![endif]-->
</head><body class="onecolumn">
<div id="wrapper">
	<div id="header-wrapper">
		<header id="header">
			<div class="5grid-layout">
				<div class="row">
					<div class="12u" id="logo"> <!-- Logo -->
						<h1><a href="."><img src = "../images/logo.png"></a></h1>
						<p><a href="logout">Log Out</a>
					</div>
				</div>
			</div>
			<div class="5grid-layout">
				<div class="row">
					<div class="12u" id="menu">
						<div id="menu-wrapper">
							<nav class="mobileUI-site-nav">
								<ul>
								 	
									<li><a href="search">Search</a></li>
									<li><a href="browse">Browse</a></li>
									<li><a href="sell">Sell</a></li>
									<li class="current_page_item"><a href="account">Account</a></li>
								</ul>
							</nav>
						</div>
					</div>
				</div>
			</div>
		</header>
	</div>
	<div id="page-wrapper" class="5grid-layout">
		<div class="row titlebg">
			<h2>Add to Wish List</h2>
		</div>
		<div class="row" id="content">
			<div class="12u">
				<section>
					<div class="post" align = "center">
						<h2>Add To Wish List</h2>
						<p>Please enter as much information as possible</p>
                        <p><?php echo $error?></p>
						<form method="POST" action="addtowishlist.php" >
<table class="signup" border="0" cellpadding="2" cellspacing = "0" >
<th colspan = "2" align = "center"></th>
<tr><td><br>Title   </td><td><br><input type = "text" maxlength = "32"
name = "Title" /></tr></td>
<tr><td><br>ISBN</td><td><br><input type = "text" maxlength = "13"
name = "ISBN" /></tr></td>


<tr><br><td colspan = "2" align = "center"><br><input type = "submit" value="Add" /></td></tr></table></form>
					</div>
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