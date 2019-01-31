<?php

function goSql($qr) { /*функция подкл к базе */
	/*$connection = sqlsrv_connect( '(local)', [ 'Database' => 'test', 'UID' => 'name', 'PWD' => 'pass' ]);
	$result = sqlsrv_query($connection, $qr);*/ 
	$db = @odbc_connect('SERVER_NAME', 'userNaME', 'password') or die(odbc_errormsg($db)); 
	$stmt = @odbc_exec($db, $qr) or die(odbc_errormsg($db));
	return $stmt;
}

function parseArray($response, $draft) {
	$group = [];
	foreach ($response as $item) {
		$newKey = str_replace(' 00:00:00', '', $item['DateEnter']);
		if (!isset($group[$newKey])) { $group[$newKey]   = [];   }
		if ($item['Draft'] == $draft){ $group[$newKey][] = $item;}
		if(count($group[$newKey])==0) unset($group[$newKey]);
	}
	return $group; //htmlspecialchars(json_encode($group), ENT_QUOTES, 'UTF-8');
}

function getEnterMore () {
	$now = new DateTime();
	$from = !empty($_GET['ed_DateFrom']) ? preg_replace('/^(\d{1,2})\.(\d{1,2})\.(\d{4})$/', '$3-$2-$1', $_GET['ed_DateFrom']) : $now->format('Y-m-d'); //9.1.19: [КОСТЯ]: изменил с \d{2} на \d{1,2} (апасна!)
	$qr = <<<QUERY
		EXEC  [test_db].[dbo].[testProcedure_getEnterMore] '{$_GET['port']}' ,'{$_GET['HoursFrom']}' ,'{$_GET['MinsFrom']}' ,'{$_GET['HoursTo']}' ,'{$_GET['MinsTo']}' ,'{$from}';
		EXEC  [test_db].[dbo].[testProcedure_getExitMore] '{$_GET['port']}' ,'{$_GET['HoursFrom']}' ,'{$_GET['MinsFrom']}' ,'{$_GET['HoursTo']}' ,'{$_GET['MinsTo']}' ,'{$from}';
		EXEC  [test_db].[dbo].[testProcedure_getInPort] '{$_GET['port']}' ,'{$_GET['HoursFrom']}' ,'{$_GET['MinsFrom']}' ,'{$_GET['HoursTo']}' ,'{$_GET['MinsTo']}' ,'{$from}'; 
		EXEC  [test_db].[dbo].[testProcedure_getExitRiver] '{$_GET['port']}' ,'{$_GET['HoursFrom']}' ,'{$_GET['MinsFrom']}' ,'{$_GET['HoursTo']}' ,'{$_GET['MinsTo']}' ,'{$from}';
--		SELECT '';
		EXEC  [test_db].[dbo].[testProcedure_getEnterRiver] '{$_GET['port']}' ,'{$_GET['HoursFrom']}' ,'{$_GET['MinsFrom']}' ,'{$_GET['HoursTo']}' ,'{$_GET['MinsTo']}' ,'{$from}';

QUERY;


	$arr = $mas = $d = [];
	$stmt = goSql ($qr);

	while ($result = odbc_fetch_array($stmt)) { $arr[] = odbc_fetch_arraywhile($result, 1); }

	$d['first'] = $arr;
	$arr = []; if (odbc_next_result($stmt)) { while ($result = odbc_fetch_array($stmt)) { $arr[] = odbc_fetch_arraywhile($result, 2); } }; $d['second'] = $arr; 
	$arr = []; if (odbc_next_result($stmt)) { while ($result = odbc_fetch_array($stmt)) { $arr[] = odbc_fetch_arraywhile($result, 3); } }; $d['third'] = $arr; 
	$arr = []; if (odbc_next_result($stmt)) { while ($result = odbc_fetch_array($stmt)) { $arr[] = odbc_fetch_arraywhile($result, 4); } }; $d['fourth'] = $arr; 
//	$arr = []; if (odbc_next_result($stmt)) { while ($result = odbc_fetch_array($stmt)) { $arr[] = odbc_fetch_arraywhile($result, 5); } }; $d['fifth'] = $arr; 
	$arr = []; if (odbc_next_result($stmt)) { while ($result = odbc_fetch_array($stmt)) { $arr[] = odbc_fetch_arraywhile($result, 6); } }; $d['sixth'] = $arr; 

	return json_encode($d, JSON_UNESCAPED_UNICODE);
}

function InsertInportMore($request) { 
	$qr = <<<QUERY
		EXEC  [test_db].[dbo].[testProcedure_insertIntraport] '{$request->EntID}','{$request->ed_Port}' ,'{$request->timeFrom->HH}' ,'{$request->timeFrom->mm}' ,'{$request->timeTo->HH}' ,'{$request->timeTo->mm}','{$request->ed_DateFrom}';
QUERY;

	$stmt = goSql ($qr);
	$arr = $mas = $d = [];
	while ($result = odbc_fetch_array($stmt)) {} 
}

function toDraft($request) { 
	$qr = <<<QUERY
		UPDATE  [test_db].[testTable].[Entering] SET Draft = 1
		WHERE [EntID] =  '{$request->EntID}' AND [Status] = '{$request->FlagStatus}' AND Port = '{$request->ed_Port}';
QUERY;


	$stmt = goSql ($qr);
	$arr = $mas = $d = [];
	while ($result = odbc_fetch_array($stmt)) {} 
}

function toProd($request) { 
	$qr = <<<QUERY
		UPDATE  [test_db].[testTable].[Entering] SET Draft = 0
		WHERE [EntID] =  '{$request->EntID}' AND [Status] = '{$request->FlagStatus}' AND Port = '{$request->ed_Port}';
QUERY;


	$stmt = goSql ($qr);
	$arr = $mas = $d = [];
	while ($result = odbc_fetch_array($stmt)) {} 
}




function odbc_fetch_arraywhile($result, $FlagStatus) {
	$arr = [];
	$mas = []; 
	$mas['rShipName'] = iconv('windows-1251', 'UTF-8', $result['rShipName']);
	$mas['Length'] = iconv('windows-1251', 'UTF-8', $result['Length']); 
	$mas['ShipTypeNameRus'] = iconv('windows-1251', 'UTF-8', $result['ShipTypeNameRus']);
	$mas['CountryNameRus'] = iconv('windows-1251', 'UTF-8', $result['CountryNameRus']);
	$mas['HourMinute'] = iconv('windows-1251', 'UTF-8', $result['HourMinute']);
	$mas['DepositStern'] = iconv('windows-1251', 'UTF-8', $result['DepositStern']);
	$mas['SurfaceDimension'] = iconv('windows-1251', 'UTF-8', $result['SurfaceDimension']);
	$mas['Note'] = iconv('windows-1251', 'UTF-8', $result['Note']);
	$mas['EntID'] = iconv('windows-1251', 'UTF-8', $result['EntID']);
	$mas['ShipID'] = iconv('windows-1251', 'UTF-8', $result['ShipID']);
	$mas['IMO'] = iconv('windows-1251', 'UTF-8', $result['IMO']);
	$mas['Draft'] = iconv('windows-1251', 'UTF-8', $result['Draft']);
	$mas['DateEnter'] = iconv('windows-1251', 'UTF-8', $result['DateEnter']);
	$mas['CompanyName'] = iconv('windows-1251', 'UTF-8', $result['CompanyName']);
	$mas['Route'] = iconv('windows-1251', 'UTF-8', $result['Route']);
	$mas['Terminal'] = iconv('windows-1251', 'UTF-8', $result['Terminal']);
	$mas['NeedForEmerg'] = iconv('windows-1251', 'UTF-8', $result['NeedForEmerg']);
	$mas['Enter_Cargo'] = iconv('windows-1251', 'UTF-8', $result['Enter_Cargo']);
	$mas['Enter_Cargo_Danger'] = iconv('windows-1251', 'UTF-8', $result['Enter_Cargo_Danger']);
	$mas['FlagStatus'] = $FlagStatus;
	$arr = $mas;
	return $arr;
}

function activeClose($id, $knopka) {
	$connection = sqlsrv_connect( '192.000.000.103', [ 'Database' => 'dbName', 'UID' => 'name', 'PWD' => 'password' ]);
	if (false === $connection) { echo json_encode( [ 'result' => 'Error', ]); }
	if ($knopka === 'true') {
		$query = sprintf('update testDB.Entering set Status = 1 where EntID = %s', $id);
		$result = sqlsrv_query($connection, $query);
		if ($result === false) {
			if (($errors = sqlsrv_errors()) != null) {
				foreach ($errors as $error) {
					echo "SQLSTATE: " . $error['SQLSTATE'] . "<br />";
					echo "code: " . $error['code'] . "<br />";
					echo "message: " . $error['message'] . "<br />";
				}
				die;
			}
		}
		$result = [ 'STATUS' => 'OK' ];
	} else {
		$query = sprintf('update testDB.Entering set Status = 0 where EntID = %s', $id);
		$result = sqlsrv_query($connection, $query);
		if ($result === false) {
			if (($errors = sqlsrv_errors()) != null) {
				foreach ($errors as $error) {
					echo "SQLSTATE: " . $error['SQLSTATE'] . "<br />";
					echo "code: " . $error['code'] . "<br />";
					echo "message: " . $error['message'] . "<br />";
				}
				die;
			}
		}
		$result = [ 'STATUS' => 'OK' ];
	}
	return $result;
}
/*
function getPorts($SQL = ""){	 
    $ret = array_merge($ret, $db->GetArray("select PortCode, PortNameRus from DictionaryPorts where PortCode like 'RU%'" . $SQL . " and PortCode!='RUNIL' order by PortNameRus"));
//	dbLogProcedures("select PortCode, PortNameRus from DictionaryPorts", " where PortCode like |RU%|".$SQL." and PortCode!=|RUNIL| order by PortNameRus");
    if (count($ret) < 1) return 'dbGetPortsExit, error:';
    return $ret;

	$qr = <<<QUERY
		select PortCode, PortNameRus from DictionaryPorts where PortCode like 'RU%' and PortCode!='RUNIL' order by PortNameRus;
QUERY;


	$stmt = goSql ($qr);
	$arr = $mas = $d = [];
	while ($result = odbc_fetch_array($stmt)) {} 
 
}
*/ 

function getPorts () {
	$port = !isset($_GET['port']) && !empty($_GET['port']) ? ' and PortCode = ' .$_GET['port'] : '';
	$qr = <<<QUERY
		select PortCode value, PortNameRus text from [testDB].[dbo].[DictionaryPorts] where PortCode like 'RU%' and PortCode!='RUNIL' {$port} order by PortNameRus;
QUERY;

	$arr = [];
	$stmt = goSql ($qr); 
	
	$arr = [0=>[value=>null,text=>'все']];

//$result = odbc_fetch_array($stmt);
//print_r($result);die; 
		while ($result = odbc_fetch_array($stmt) ) {
			$arr[] = [
				'text'	=>	iconv('windows-1251', 'UTF-8', $result['text']),
				'value' => 	$result['value']
			];
		}   
		echo json_encode($arr);
		die; 
		return json_encode($arr, JSON_UNESCAPED_UNICODE);
}