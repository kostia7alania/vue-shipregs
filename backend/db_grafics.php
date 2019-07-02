<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
//header('Content-Type: aplication/json;');// print_r($_REQUEST);die;  //$_SESSION['user']['name']=$_SESSION['AuthUserName'];
error_reporting(E_ALL ^ E_NOTICE);
session_start();
require('./db_grafics_functions.php');
try {
	$response = array();
	switch ( $_GET['action'] ) {
		case 'toExport': $exc = 1;
		case 'getUsers':
			$response = getEnterMore();
			$response = json_decode($response, true);


			//echo(htmlspecialchars(json_encode($response), ENT_QUOTES, 'UTF-8'));  die;


			$response = [
				'first'=>parseArray($response['first'],0),
				'second'=>parseArray($response['second'],0),
				'third'=>parseArray($response['third'],0),
				'fourth'=>parseArray($response['fourth'],0),
				'fifth'=>parseArray($response['fifth'],0),
				'sixth'=>parseArray($response['sixth'],0),
				'_first'=>parseArray($response['first'],1),
				'_second'=>parseArray($response['second'],1),
				'_third'=>parseArray($response['third'],1),
				'_fourth'=>parseArray($response['fourth'],1),
				'_fifth'=>parseArray($response['fifth'],1),
				'_sixth'=>parseArray($response['sixth'],1),

			];
			if($exc) require('toExcel.php');//тут die;

			echo(htmlspecialchars(json_encode($response), ENT_QUOTES, 'UTF-8'));  die;
		break;
/*		case 'getInport':
			$response = getInportMore();
			$response = json_decode($response, true);
			$response = [
				'Inport'=>parseArray($response['Inport'])
			];
			echo(htmlspecialchars(json_encode($response), ENT_QUOTES, 'UTF-8'));  die;
		break;
*/
		case 'add':
			$response = InsertInportMore(json_decode(file_get_contents("php://input")));
			die;
		break;
		case 'toDraft':
			$response = toDraft(json_decode(file_get_contents("php://input")));
			die;
		break;
		case 'toProd':
			$response = toProd(json_decode(file_get_contents("php://input")));
			die;
		break;
		case 'toSend':
			//$response = toSend(json_decode(file_get_contents("php://input")));
			echo 1;
			die;
		break;
		case 'getPorts':
			$response = getPorts();
			$response = json_decode($response, true);
			echo(htmlspecialchars(json_encode($response), ENT_QUOTES, 'UTF-8'));
			break;
		case 'activeclose': //запрос в БД на обновление //проверка результата запроса
			echo json_encode(activeClose($_GET['id'], $_GET['knopka']));die;
			break;
		case 'activecheck': //запрос в БД на обновление //проверка результата запроса
			$result = [ 'STATUS' => 'OK' ];
			echo json_encode($result); die;
			break;
		default: 			throw new Exception('Действие не найдено! (wrong action)');
	} echo $response; //strpos($response, 'ODBC SQL Server Driver');
} catch(Exception $e) {  die ( json_encode(array('error' => $e->getMessage())) ); }

?>