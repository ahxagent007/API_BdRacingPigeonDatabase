
<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/Pigeon.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$pigeon = new Pigeon($db);
 
// query products
$stmt = $pigeon->readOnlyFirst();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // products array
    $pigeons_arr=array();
    $pigeons_arr["records"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $pigeon_item=array(
            "PigeonRingNumber" => $PigeonRingNumber,
            "Position" => $Position,
            "RaceName" => $RaceName,
            "OwnerName" => $OwnerName,
            "ClubName" => $ClubName,
            "PigeonVelocity" => $PigeonVelocity,
            "TotalPigeons" => $TotalPigeons,
            "RaceDate" => $RaceDate,
            "Distance" => $Distance
        );
 
        array_push($pigeons_arr["records"], $pigeon_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show products data in json format
    echo json_encode($pigeons_arr);
}
 
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no products found
    echo json_encode(
        array("message" => "No Pigeon found.")
    );
}
?>