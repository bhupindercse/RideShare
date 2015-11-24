<?php
if(isset($_POST['submit'])) {
	echo $_POST['x'];
	echo $_POST['y'];
	echo $_POST['txt'];
}
?>
<form action="" method="post">
<label name="x" id="y">hello world</label>
<input type="text" name="txt" id="txt" value="hii" />
<input type="submit" value="Submit" name="submit" id="submit" />
</form>