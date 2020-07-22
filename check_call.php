<?php
//header('Location: http://www.example.com/');
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

date_default_timezone_set('Asia/Jakarta');

$cid = $_GET['cid'];

$config_file = '/etc/oubounddb.conf';
$lines = file($config_file);
$dbhost = 'localhost';
$dbuser = '';
$dbpswd = '';
$dbname = '';
foreach ($lines as $l) {
	if (strpos($l,"mysqlrootuser")!==false) {
		$dbuser = trim(str_replace('mysqlrootuser=', '', $l));
	}
	if (strpos($l,"mysqlrootpwd")!==false) {
		$dbpswd = trim(str_replace('mysqlrootpwd=', '', $l));
	}
	if (strpos($l,"mysqlrootdb")!==false) {
		$dbname = trim(str_replace('mysqlrootdb=', '', $l));
	}
}

$con=new mysqli($dbhost,$dbuser,$dbpswd,$dbname);
// Check connection
if ($con->connect_error)
{
	echo "Failed to connect to MySQL: " . $con->connect_error;
	/*exit;*/
}

$sql = "SELECT stime_perday, etime_perday FROM v_campaign WHERE campaign_id = $cid";
$start = 0;
$end = 0;
//echo $sql;
$r = $con->query($sql);
if ($r->num_rows > 0) {
    // output data of each row
    while($row = $r->fetch_assoc()) {
        $start = $row["stime_perday"];
        $end = $row["etime_perday"];
    }
    $data = 0;
    if(strtotime(date('H:i:s'))<strtotime($start) || strtotime(date('H:i:s'))>strtotime($end)){
    	$data = 0;
    }else{
    	$data = 1;
    }
    echo "data: {$data}\n\n";
} else {
     echo "data: 0\n\n";
}

flush();