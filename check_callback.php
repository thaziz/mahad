<?php
//header('Location: http://www.example.com/');
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

date_default_timezone_set('Asia/Jakarta');

$cid = $_GET['cid'];
$uid = $_GET['uid'];

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
	//echo "Failed to connect to MySQL: " . $con->connect_error;
	exit;
}

$sql = "SELECT assign_id FROM v_assign_campaign WHERE campaign_id = $cid AND adm_id = $uid";
$assign_id = 0;
//echo $sql;
$r = $con->query($sql);
if ($r->num_rows > 0) {
    // output data of each row
    while($row = $r->fetch_assoc()) {
        $assign_id = $row["assign_id"];
    }
} else {
     $assign_id = 0;
}

$data = 0;
$sql = "SELECT count(a.data_id) as total FROM data_campaign_".$cid." a JOIN (SELECT x.data_id, x.call_status FROM call_attemp_".$cid." x JOIN (SELECT data_id, MAX(attemp_date) call_date FROM call_attemp_".$cid." GROUP BY data_id) y ON x.data_id=y.data_id AND x.attemp_date=y.call_date) b ON (a.data_id=b.data_id) WHERE b.call_status='Callback' AND a.assign_id = $assign_id AND a.callback <= '".date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s').' +0 hours +2minutes'))."'";
//echo $sql;
$result = $con->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $data = $row["total"];
    }
} else {
     $data = 0;
}
echo "data: {$data}\n\n";

flush();