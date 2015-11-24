<?php
include_once 'dbconfig.php';
if(!$user->is_loggedin())
{
	$user->redirect('index.php');
}
$user_id = $_SESSION['user_session'];
$stmt = $DB_con->prepare("SELECT * FROM users WHERE id=:user_id");
$stmt->execute(array(":user_id"=>$user_id));
$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" type="text/css"  />
<link rel="stylesheet" href="style.css" type="text/css"  />
<link rel="stylesheet" href="styles.css">
<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
<script src="script.js"></script>
<title>welcome - <?php print($userRow['emailid']); ?></title>
</head>

<body>

<div class="header">
	<div class="left">
    	<label><a href="#">Ride-Share</a></label>
    </div>
    <div class="right">
    	<label><a href="logout.php?logout=true"><i class="glyphicon glyphicon-log-out"></i> logout</a></label>
    </div>
</div>
<div id='cssmenu'>
<ul>
   <li><a href='home.php'>Home</a></li>
   <li><a href='update.php'>Update Profile</a></li>
   <li class='active'><a href='confirm-ride.php'>Ride Search</a></li>
   <li><a href='cancel-ride.php'>Cancel Ride</a></li>
</ul>
</div>

    
welcome : <?php print($userRow['username']); ?>

<?php
    $query_list_records = "SELECT * FROM ride_history";
    $PDA = $DB_con->prepare($query_list_records);  
    $PDA -> execute(array());
    
    echo "<table border='1'>
<tr>
<th> From </th>
<th> To </th>
<th> Date </th>
<th> Time </th>
<th> Available Rides </th>
</tr>";

while($row = $PDA -> fetch(PDO::FETCH_ASSOC))
{
echo "<tr>";
echo "<td>" . $row['location_from'] . "</td>";
echo "<td>" . $row['location_to'] . "</td>";
echo "<td>" . $row['date'] . "</td>";
echo "<td>" . $row['time_hours'] . ":". $row['time_minutes'] . ":" . $row['time_period'] . "</td>";
echo "<td>" . $row['available_rides'] . "</td>";
echo "</tr>";

}

echo "</table>"; 
?>

</body>
</html>