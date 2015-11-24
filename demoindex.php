<?php
include_once("demodb.php");
?>
<link rel="stylesheet" href="demo.css" type="text/css" />
<link rel="stylesheet" href="style.css" type="text/css"  />
<link rel="stylesheet" href="styles.css">
<link rel="stylesheet" href="styless.css">
<div id="wrapper">
	<div id="header">Here's the list</div>
	<div id="content">
	<div id="content-left">Ride Id</div>
	<div id="content-main">From</div>
	<div id="content-main">To</div>
	<div id="content-main">Date</div>
	<div id="content-main">Time</div>
	<div id="content-right">Available Rides</div>
        <?php 
        $query = "SELECT * FROM ride_history where date>?";       
        $records_per_page=2;
        $newquery = $paginate->paging($query,$records_per_page);
        $paginate->dataview($newquery);
        $paginate->paginglink($query,$records_per_page);  
        ?>
</div>
	<div id="bottom"></div>
</div>