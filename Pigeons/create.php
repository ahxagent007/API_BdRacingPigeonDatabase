<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate product object
include_once '../objects/Pigeon.php';
 
$database = new Database();
$db = $database->getConnection();
 
$pigeon = new Pigeon($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// make sure data is not empty
if(
    !empty($data->PigeonRingNumber) &&
    !empty($data->Position) &&
    !empty($data->RaceName) &&
    !empty($data->ClubName) && 
    !empty($data->OwnerName) &&
    !empty($data->PigeonVelocity) &&
    !empty($data->TotalPigeons) &&
    !empty($data->RaceDate) 
){
 
    // set product property values
    $pigeon->PigeonRingNumber = $data->PigeonRingNumber;
    $pigeon->Position = $data->Position;
    $pigeon->RaceName = $data->RaceName;
    $pigeon->OwnerName = $data->OwnerName;
    $pigeon->ClubName = $datra->ClubName;
    $pigeon->PigeonVelocity = $data->PigeonVelocity;
    $pigeon->TotalPigeons = $data->TotalPigeons;
    $pigeon->RaceDate = $data->RaceDate;
    
    /*
        PigeonRingNumber;
    Position;
    RaceName;
   OwnerName;
    ClubName;
   PigeonVelocity;
    TotalPigeons;
    RaceDate;
    */
 
    // create the product
    if($product->create()){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "Pigeon was created."));
    }
 
    // if unable to create the product, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to create Pigeon."));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable to create Pigeon. Data is incomplete."));
}
?>