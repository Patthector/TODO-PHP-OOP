<?php

$user = "bluejaxo_a2wp973";
$pass = "Tpv@(2SJ16";
# -------------
try{
	$db = new PDO("mysql:host=localhost;dbname=bluejaxo_makeitstickapp",$user,$pass);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (Exception $e){
	echo "Unable to connect DB, " . $e->getMessage();
	exit;
}
//echo "Successful DB connection!";
