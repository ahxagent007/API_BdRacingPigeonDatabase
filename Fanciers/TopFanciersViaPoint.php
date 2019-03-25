<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/TopFancier.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$topFancier = new TopFancier($db);
 
// query products
$stmt = $topFancier->TopFanciersViaPoint();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // products array
    $fanciers_arr=array();
    $fanciers_arr["records"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $fancier_item=array(
            "OwnerName" => $OwnerName,
            "PositionLessThenThirty" => $PositionLessThenThirty,
            "RacePlayed" => $RacePlayed
        );
 
        array_push($fanciers_arr["records"], $fancier_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show products data in json format
    echo json_encode($fanciers_arr);
}
 
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no products found
    echo json_encode(
        array("message" => "No Fancier found.")
    );
}
?>