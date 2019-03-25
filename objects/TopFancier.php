<?php
class TopFancier{
 
    // database connection and table name
    private $conn;
    private $table_name = "pigeons";
 
    // object properties
    public $OwnerName;
    public $PositionLessThenThirty;
    public $RacePlayed;

 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    

    // read products
    function TopFanciersViaPoint(){

        // select all query
        $query ="SELECT
                    OwnerName, COUNT(Position) AS PositionLessThenThirty, COUNT(DISTINCT RaceDate) AS RacePlayed, ClubName, (COUNT(Position) / COUNT(DISTINCT RaceDate)) AS Points
                FROM
                    " . $this->table_name."
                    WHERE Position <=30
                    GROUP BY OwnerName
                    ORDER BY Points DESC;
                    ";
                    
                    
/*SELECT OwnerName,COUNT(Position) AS LessThenThirty, COUNT(DISTINCT RaceDate) AS RacePlayed, ClubName, (COUNT(Position) / COUNT(DISTINCT RaceDate)) AS Points
FROM pigeons WHERE Position <= 30 GROUP BY OwnerName ORDER BY Points DESC;*/

/*              SELECT
                    OwnerName, COUNT(Position) AS PositionLessThenThirty, COUNT(DISTINCT RaceDate) AS RacePlayed
                FROM
                    " . $this->table_name."
                    WHERE Position <=30
                    GROUP BY OwnerName
                    ORDER BY PositionLessThenThirty DESC;*/

        
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
    
