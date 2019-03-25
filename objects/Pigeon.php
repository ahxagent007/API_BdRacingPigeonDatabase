<?php
class Pigeon{
 
    // database connection and table name
    private $conn;
    private $table_name = "pigeons";
 
    // object properties
    public $PigeonRingNumber;
    public $Position;
    public $RaceName;
    public $OwnerName;
    public $ClubName;
    public $PigeonVelocity;
    public $TotalPigeons;
    public $RaceDate;
    public $Distance;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    

    // read products
    function read(){

        // select all query
        $query = "SELECT
                    *
                FROM
                    " . $this->table_name;
        
        /* . " p
                    LEFT JOIN
                        categories c
                            ON p.category_id = c.id
                ORDER BY
                    p.created DESC"*/

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }
    
    function TopPigeonsViaVelocity(){
        
         // select all query
        $query = "SELECT
                    *
                FROM
                    " . $this->table_name."
                    ORDER BY PigeonVelocity DESC LIMIT 500;
                    ";
        
        /* . " p
                    LEFT JOIN
                        categories c
                            ON p.category_id = c.id
                ORDER BY
                    p.created DESC"*/

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
        
        
    }

    function readOnlyFirst(){

        // select all query
        $query = "SELECT
                    *
                FROM
                    " . $this->table_name."
                    WHERE Position = 1;
                    ";
        
        /* . " p
                    LEFT JOIN
                        categories c
                            ON p.category_id = c.id
                ORDER BY
                    p.created DESC"*/

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }
    
    function readOnlyVelocity(){

        // select all query
        $query = "SELECT
                    *
                FROM
                    " . $this->table_name."
                    ORDER BY PigeonVelocity DESC LIMIT 200;
                    ";
        

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }
    
    // create product
    function create(){

        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    PigeonRingNumber=:PigeonRingNumber, Position=:Position, RaceName=:RaceName, OwnerName=:OwnerName, ClubName=:ClubName, PigeonVelocity=:PigeonVelocity, TotalPigeons=:TotalPigeons, RaceDate=:RaceDate";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->PigeonRingNumber=htmlspecialchars(strip_tags($this->PigeonRingNumber));
        $this->Position=htmlspecialchars(strip_tags($this->Position));
        $this->RaceName=htmlspecialchars(strip_tags($this->RaceName));
        $this->OwnerName=htmlspecialchars(strip_tags($this->OwnerName));
        $this->ClubName=htmlspecialchars(strip_tags($this->ClubName));
        $this->PigeonVelocity=htmlspecialchars(strip_tags($this->PigeonVelocity));
        $this->TotalPigeons=htmlspecialchars(strip_tags($this->TotalPigeons));
        $this->RaceDate=htmlspecialchars(strip_tags($this->RaceDate));

        // bind values
        $stmt->bindParam(":PigeonRingNumber", $this->name);
        $stmt->bindParam(":Position", $this->price);
        $stmt->bindParam(":RaceName", $this->description);
        $stmt->bindParam(":OwnerName", $this->category_id);
        $stmt->bindParam(":ClubName", $this->created);
        $stmt->bindParam(":PigeonVelocity", $this->name);
        $stmt->bindParam(":TotalPigeons", $this->price);
        $stmt->bindParam(":RaceDate", $this->description);

        // execute query
        if($stmt->execute()){
            return true;
        }

        return false;

    }

    
    // search products
    function search($keywords){
 
    // select all query
    $query = "SELECT
                *
            FROM
                " . $this->table_name . " p
                
            WHERE
                p.PigeonRingNumber LIKE ? OR p.OwnerName LIKE ? 
            ORDER BY Position ASC
                ";//OR p.Position = ?
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $keywords=htmlspecialchars(strip_tags($keywords));
    $keywords = "%{$keywords}%";
 
    // bind
    $stmt->bindParam(1, $keywords);
    $stmt->bindParam(2, $keywords);
    //$stmt->bindParam(3, $keywords);
 
    // execute query
    $stmt->execute();
 
    return $stmt;
}
    
    // read products with pagination
    public function readPaging($from_record_num, $records_per_page){
 
    // select query
    $query = "SELECT
                *
            FROM
                " . $this->table_name . " p
                
            LIMIT ?, ?";
        
        /*LEFT JOIN
                    categories c
                        ON p.category_id = c.id
            ORDER BY p.created DESC*/
 
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
 
    // bind variable values
    $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
    $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
 
    // execute query
    $stmt->execute();
 
    // return values from database
    return $stmt;
}

    // used for paging products
    public function count(){
    $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . "";
 
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    return $row['total_rows'];
}
    
     // used when filling up the update product form
//    function readOne(){
//
//        // query to read single record
//        $query = "SELECT
//                    *
//                FROM
//                    " . $this->table_name . " p
//                WHERE
//                    p.id = ?
//                LIMIT
//                    0,1";
//
//        // prepare query statement
//        $stmt = $this->conn->prepare( $query );
//
//        // bind id of product to be updated
//        $stmt->bindParam(1, $this->id);
//
//        // execute query
//        $stmt->execute();
//
//        // get retrieved row
//        $row = $stmt->fetch(PDO::FETCH_ASSOC);
//
//        // set values to object properties
//        $this->name = $row['name'];
//        $this->price = $row['price'];
//        $this->description = $row['description'];
//        $this->category_id = $row['category_id'];
//        $this->category_name = $row['category_name'];
//    }

    // update the product
//    function update(){
//
//        // update query
//        $query = "UPDATE
//                    " . $this->table_name . "
//                SET
//                    name = :name,
//                    price = :price,
//                    description = :description,
//                    category_id = :category_id
//                WHERE
//                    id = :id";
//
//        // prepare query statement
//        $stmt = $this->conn->prepare($query);
//
//        // sanitize
//        $this->name=htmlspecialchars(strip_tags($this->name));
//        $this->price=htmlspecialchars(strip_tags($this->price));
//        $this->description=htmlspecialchars(strip_tags($this->description));
//        $this->category_id=htmlspecialchars(strip_tags($this->category_id));
//        $this->id=htmlspecialchars(strip_tags($this->id));
//
//        // bind new values
//        $stmt->bindParam(':name', $this->name);
//        $stmt->bindParam(':price', $this->price);
//        $stmt->bindParam(':description', $this->description);
//        $stmt->bindParam(':category_id', $this->category_id);
//        $stmt->bindParam(':id', $this->id);
//
//        // execute the query
//        if($stmt->execute()){
//            return true;
//        }
//
//        return false;
//    }
    
    // delete the product
//    function delete(){
//
//        // delete query
//        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
//
//        // prepare query
//        $stmt = $this->conn->prepare($query);
//
//        // sanitize
//        $this->id=htmlspecialchars(strip_tags($this->id));
//
//        // bind id of record to delete
//        $stmt->bindParam(1, $this->id);
//
//        // execute query
//        if($stmt->execute()){
//            return true;
//        }
//
//        return false;
//
//    }
//   
    
}
