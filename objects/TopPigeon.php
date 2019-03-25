<?php
class TopPigeon{
 
    // database connection and table name
    private $conn;
    private $table_name = "pigeons";
 
    // object properties
    public $PigeonRingNumber;
    public $OwnerName;
    public $PositionLessThenFifty;
    public $ClubName;

 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    

    // read products
    function TopPigeonsViaRaceCount(){

        // select all query
        $query ="SELECT
                    PigeonRingNumber, OwnerName, COUNT(Position) AS PositionLessThenFifty, ClubName
                FROM
                    " . $this->table_name."
                    GROUP BY PigeonRingNumber, OwnerName
                    ORDER BY PositionLessThenFifty DESC
                    LIMIT 500;
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

    function TopPigeonsViaTopResult(){

        // select all query
        $query = "SELECT
                    PigeonRingNumber, OwnerName, COUNT(Position) AS PositionLessThenFifty, ClubName
                FROM
                    " . $this->table_name."
                    WHERE Position <= 50
                    GROUP BY PigeonRingNumber, OwnerName
                    ORDER BY PositionLessThenFifty DESC
                    LIMIT 500;
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
    

    

    

    // used for paging products
    public function count(){
    $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . "";
 
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    return $row['total_rows'];
    }
}
    
