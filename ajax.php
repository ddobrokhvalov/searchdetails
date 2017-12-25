<?
if($_REQUEST["query"] || $_REQUEST["sku"]){
	require_once $_SERVER["DOCUMENT_ROOT"]."/common/spares_parts.controller.php";
	$controller = new sparesPartsController();
	$res = $controller->Search($_REQUEST["query"], $_REQUEST["sku"]);
	echo $res;
}else{
	echo json_encode(array("error"=>"empty request"));
}