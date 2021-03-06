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
// confirm ride
if(isset($_POST['btn_confirm'])) {
	$txt_confirm_ride = trim($_POST['txt_confirm_ride']);
	// database query
	try
		{
			$stmt = $DB_con->prepare("SELECT * FROM ride_history WHERE ride_id=?");
			$stmt->execute(array($txt_confirm_ride));
			//ride id vaild or not
			if($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
				
				// ride in past date
			$now = date("Y-m-d");
			$stmt = $DB_con->prepare("SELECT * FROM ride_history WHERE date<?");
			$stmt->execute(array($now));
			//ride id is in past date
			if($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
				
				$ride_giver_id = $row['user_id'];
				// ride giver and ride taker same?
				if($user_id != $ride_giver_id){
				$stmt1 = $DB_con->prepare("SELECT * FROM confirmed_rides where ride_id=? and ride_taker_id=?");
				$stmt1->execute(array($txt_confirm_ride,$user_id));
				//already confirmed?
				if($row1=$stmt1->fetch(PDO::FETCH_ASSOC)) {
				echo "You already confirmed this ride ..!";
				}
				//if not confirmed already
				else { 
				$stmt2 = $DB_con->prepare("INSERT INTO confirmed_rides(ride_id,ride_giver_id,ride_taker_id) VALUES(?,?,?)");
				$stmt2->execute(array($txt_confirm_ride,$ride_giver_id,$user_id));
				//decrease available rides count
				$stmt2 = $DB_con->prepare("UPDATE ride_history SET available_rides = available_rides - 1 where ride_id = ?");
				$stmt2->execute(array($txt_confirm_ride));
				echo "successful";
				}
			}//if ride giver and ride taker are same
			else {
				echo "You cannot confirm this ride. Because you have given availability for this ride.";
			}
			}//ride id invalid
			else {
				echo "Invalid ride id ..!";
			}
			} else {
				echo "Invalid ride id ..!";
			}
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" type="text/css"  />
<link rel="stylesheet" href="style.css" type="text/css"  />
<link rel="stylesheet" href="styles.css">
<link rel="stylesheet" href="styless.css">
<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
<script src="script.js"></script>
<title>welcome - <?php print($userRow['emailid']); ?></title>
</head>

<body>

<div class="header">
	<div class="left">
    	<label><a href="#">UWindsor Ride-Share</a></label>
    </div>
    <div class="right">
    	<label><a href="logout.php?logout=true"><i class="glyphicon glyphicon-log-out"></i> logout</a></label>
    </div>
</div>
<div id='cssmenu'>
<ul>
   <li><a href='home.php'>Home</a></li>
   <li><a href='list.php'>Ride Search</a></li>
   <li class='active'><a href='confirm-ride.php'>Book Ride</a></li>
   <li><a href='cancel-ride.php'>Cancel Ride</a></li>
</ul>
</div>
<div class="content">

welcome : <?php print($userRow['username']); ?>
<div class="form-container">
<form id="form_search" method="post">
<h2>Book Ride</h2><hr />
<div class="form-group">
            	<input type="text" class="form-control" name="txt_confirm_ride" placeholder="Enter Ride id" required />
            </div>
			*Get the Ride id from Ride Search Page
<div class="clearfix"></div><hr />
<div class="form-group">
            	<button type="submit" class="btn btn-block btn-primary" name="btn_confirm">
                	<i class="glyphicon glyphicon-open-file"></i>&nbsp;Confirm
                </button>
            </div>
			</form>
</div>
</div>
</body>
</html>