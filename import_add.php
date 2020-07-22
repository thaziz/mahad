<?php
/*error_reporting(E_ALL);
ini_set('display_errors', 1);

date_default_timezone_set('Asia/Jakarta');

require_once 'application/third_party/Box/Spout/Autoloader/autoload.php';
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;
use Box\Spout\Writer\Style\Style;
use Box\Spout\Writer\Style\Border;
use Box\Spout\Writer\Style\BorderBuilder;
use Box\Spout\Writer\Style\Color;
use Box\Spout\Writer\Style\StyleBuilder;
use Box\Spout\Writer\WriterFactory;

$cid = 35;

$dbhost = 'localhost';
$dbuser = 'root';
$dbpswd = 'dut4_MEDIA';
$dbname = 'outbound';

$con=new mysqli($dbhost,$dbuser,$dbpswd,$dbname);
// Check connection
if ($con->connect_error)
{
	//echo "Failed to connect to MySQL: " . $con->connect_error;
	exit;
}
function get_assign_id($con, $cid, $adm_name){
	$sql = "SELECT assign_id FROM v_assign_campaign WHERE campaign_id = $cid AND adm_id = (SELECT adm_id FROM v_admin WHERE adm_name = '$adm_name')";
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

	return $assign_id;
}

function get_adm_id($con, $cid, $adm_name){
	$sql = "SELECT adm_id FROM v_admin WHERE adm_name = '$adm_name'";
	$adm_id = 0;
	//echo $sql;
	$r = $con->query($sql);
	if ($r->num_rows > 0) {
	    // output data of each row
	    while($row = $r->fetch_assoc()) {
	        $adm_id = $row["adm_id"];
	    }
	} else {
	     $adm_id = 0;
	}

	return $adm_id;
}
function get_data_id($con, $cid, $field, $val){
	$sql = "SELECT data_id FROM data_campaign_$cid WHERE $field LIKE '$val'";
	//echo $sql.'<br>';
	$data_id = 0;
	//echo $sql;
	$r = $con->query($sql);
	if ($r->num_rows > 0) {
	    // output data of each row
	    while($row = $r->fetch_assoc()) {
	        $data_id = $row["data_id"];
	    }
	} else {
	     $data_id = 0;
	}

	return $data_id;
}

function get_data_id_like($con, $cid, $field, $val){
	$sql = "SELECT data_id FROM data_campaign_$cid WHERE $field LIKE '%$val%'";
	//echo $sql.'<br>';
	$data_id = 0;
	//echo $sql;
	$r = $con->query($sql);
	if ($r->num_rows > 0) {
	    // output data of each row
	    while($row = $r->fetch_assoc()) {
	        $data_id = $row["data_id"];
	    }
	} else {
	     $data_id = 0;
	}

	return $data_id;
}

function call_id_gen(){
	$micron = str_replace('.','',microtime(true));
	return date('Ymd').substr($micron,-12);
}

function inserting_call($con, $cid, $call, $cc){
	$attemp = $call['call_attemp'];
	unset($call['call_attemp']);
	for($i=0;$i<$attemp;$i++){
		$call['call_id'] = call_id_gen();
		$cc['call_id'] = $call['call_id'];
		$call['attemp_date'] = '2018-12-11 '.date('H:i:s', strtotime(date('H:i:s').' +3 hours'));
		$cc['call_date'] = $call['attemp_date'];
		$sql1 = "INSERT INTO call_attemp_$cid (`".implode('`, `',array_keys($call))."`) VALUES('".implode("', '",array_values($call))."')";
		$sql2 = "INSERT INTO v_campaign_call (`".implode('`, `',array_keys($cc))."`) VALUES('".implode("', '",array_values($cc))."')";
		if ($con->query($sql1) === TRUE) {
		    echo "New record created successfully<br>";
		} else {
		    echo "Error: " . $sql1 . "<br>" . $con->error;
		}
		if ($con->query($sql2) === TRUE) {
		    echo "New record created successfully<br>";
		} else {
		    echo "Error: " . $sql2 . "<br>" . $con->error;
		}
	}

}

function update_data($con, $cid, $data){

	$value = '';
	foreach ($data as $key => $val) {
		$value .= "`$key`='$val', ";
	}
	$value = trim($value, ", ");
	if(!empty($value)){
		$sql1 = "UPDATE data_campaign_$cid SET $value WHERE `data_id`=".$data['data_id'];
		if ($con->query($sql1) === TRUE) {
		    echo "record update successfully<br>";
		} else {
		    echo "Error: " . $sql1 . "<br>" . $con->error;
		}
	}

}


$reader = ReaderFactory::create(Type::XLSX);
$reader->open('file_import.xlsx');
//$reader->open('file_import.xlsx');
$data = array();
$call = array();
$cc = array();
$data_ex = array();
foreach ($reader->getSheetIterator() as $sheet) {
	$index=0;
	if ($sheet->getIndex() === 0) {
		//$rows = $sheet->getRowIterator();
		//print_r($rows);
		foreach ($sheet->getRowIterator() as $row) {
			$data_id = 0;
			if($index>10 && empty($row[1])){
				break;
			}
			if($index>1){
				if(isset($row[5]) && !empty($row[5])){
					$_cc = array();
					$_call = array();
					$_data = array();
					$_data['assign_id'] = get_assign_id($con, $cid, $row[1]);
					$_call['agent_id'] = get_adm_id($con, $cid, $row[1]);
					$_call['data_id'] = get_data_id($con, $cid, 'form_phone_number', $row[4]);
					$_data['data_id'] = $_call['data_id'];
					$data_id = $_call['data_id'];
					//$_call['call_id'] = call_id_gen();
					$_call['call_status'] = strtolower($row[5])=='connected'?'Contacted':$row[5];
					$_call['api_status'] = strtolower($row[5])=='connected'?'ANSWER':'CONGESTION';
					//$_call['call_date'] = '2018-12-11 '.date('H:i:s', strtotime(date('H:i:s').' +3 hours'));;
					$_call['call_attemp'] = isset($row[6]) && !empty($row[6])?preg_replace('/[^0-9]/', '', $row[6]):1;
					$_call['form_status_survey'] = isset($row[7]) && !empty($row[7])?trim(str_replace('Survey', '', $row[7])):'';
					$_data['form_status_survey'] = isset($row[7]) && !empty($row[7])?trim(str_replace('Survey', '', $row[7])):'';
					$_call['form_failed_reason'] = isset($row[8]) && !empty($row[8])?$row[8]:'';
					$_data['form_failed_reason'] = isset($row[8]) && !empty($row[8])?$row[8]:'';
					$_call['form_question_1'] = isset($row[9]) && !empty($row[9])?$row[9]:'';
					$_call['form_question_1'] = isset($row[9]) && !empty($row[9])?$row[9]:'';
					$_data['form_question_2_barcode'] = isset($row[10]) && !empty($row[10])?$row[10]:'';
					$_data['form_question_2_barcode'] = isset($row[10]) && !empty($row[10])?$row[10]:'';
					$_data['form_question_2_pks'] = isset($row[11]) && !empty($row[11])?$row[11]:'';
					$_data['form_question_2_pks'] = isset($row[11]) && !empty($row[11])?$row[11]:'';
					$_data['form_question_3_reason_jika_tidak_mau'] = isset($row[12]) && !empty($row[12])?$row[12]:'';
					$_data['form_question_3_reason_jika_tidak_mau'] = isset($row[12]) && !empty($row[12])?$row[12]:'';
					$_data['form_question_3_kontrak'] = isset($row[13]) && !empty($row[13])?$row[13]:'';
					$_data['form_question_3_kontrak'] = isset($row[13]) && !empty($row[13])?$row[13]:'';
					$_data['form_question_4_feedback'] = isset($row[14]) && !empty($row[14])?$row[14]:'';
					$_data['form_question_4_feedback'] = isset($row[14]) && !empty($row[14])?$row[14]:'';
					$_data['form_question_4_question'] = isset($row[15]) && !empty($row[15])?$row[15]:'';
					$_data['form_question_4_question'] = isset($row[15]) && !empty($row[15])?$row[15]:'';
					$_data['form_question_5'] = isset($row[16]) && !empty($row[16])?$row[16]:'';
					$_data['form_question_5'] = isset($row[16]) && !empty($row[16])?$row[16]:'';
					$_data['form_question_6'] = isset($row[17]) && !empty($row[17])?$row[17]:'';
					$_data['form_question_6'] = isset($row[17]) && !empty($row[17])?$row[17]:'';
					$_data['form_question_7'] = isset($row[18]) && !empty($row[18])?$row[18]:'';
					$_data['form_question_7'] = isset($row[18]) && !empty($row[18])?$row[18]:'';

					$_cc['agent_name'] = $row[1];
					//$_cc['call_date'] = $_call['call_date'];
					$_cc['agent_id'] = $_call['agent_id'];
					$_cc['api_status'] = $_call['api_status'];
					$_cc['call_status'] = $_call['call_status'];
					$_cc['data_id'] = $_call['data_id'];
					//echo $_call['data_id'].' -> '.$_call['agent_id'].' -> '.$_data['assign_id'].'<br>';
					update_data($con, $cid, $_data);
					inserting_call($con, $cid, $_call, $_cc);
				}else{
					$data_id=1;
				}

				//echo $call_id.'<br>';
				if($data_id==0){
					$_item = array();
					for($i=0; $i<19; $i++){
						if(isset($row[$i])){
							$_item[] = $row[$i];
						}else{
							$_item[] = '';
						}
					}
					$data_ex[] = $_item;
				}
				//echo "Assign id = $assign_id -> Adm id = $adm_id -> Data ID = $data_id<br>".PHP_EOL;
			}
			$index++;
		}

	}

}
if(count($data_ex)>0){
	$border = (new BorderBuilder())
	            ->setBorderBottom(Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID)
	            ->setBorderTop(Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID)
	            ->setBorderLeft(Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID)
	            ->setBorderRight(Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID)
	            ->build();

	$style = (new StyleBuilder())
	            ->setBorder($border)
	            ->build();
	$writer = WriterFactory::create(Type::XLSX);
	$filename='data_notfound.xlsx';
	//header('Content-type: application/vnd.ms-excel');
	//header('Content-Disposition: attachment; filename="'.$filename.'"');
	//$writer->openToFile('php://output');
	//$writer->addMergeCell('A1',$alpha.'1');
	$writer->openToBrowser($filename);
	$writer->addRowsWithStyle($data_ex, $style);
	$writer->close();
}