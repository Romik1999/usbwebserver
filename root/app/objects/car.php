<?php

class Car
{

    // подключение к базе данных и имя таблицы
    private $conn;
    private $table_name = "car";

    // свойства объекта
    public $id;
    public $mark;
    public $state_number;
    public $year_issue;
    public $chassis_number;
    public $body_number;
    public $vehicle_category;


    public function __construct($db)
    {
        $this->conn = $db;
    }

    function create()
    {
        try {
            $query = "INSERT INTO " . $this->table_name . " SET 
        mark=:mark, 
        state_number=:state_number, 
        year_issue=:year_issue, 
        chassis_number=:chassis_number, 
        body_number=:body_number, 
        vehicle_category=:vehicle_category";
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":mark", $this->mark);
            $stmt->bindParam(":state_number", $this->state_number);
            $stmt->bindParam(":year_issue", DateTime::createFromFormat('d-m-Y', $this->year_issue)->format('Y-m-d'));
            $stmt->bindParam(":chassis_number", $this->chassis_number);
            $stmt->bindParam(":body_number", $this->body_number);
            $stmt->bindParam(":vehicle_category", $this->vehicle_category);

            return $stmt->execute();
        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }
    }

    function readAll($from_record_num, $records_per_page)
    {
        $query = "SELECT id, mark, state_number, year_issue, chassis_number, body_number, vehicle_category FROM " . $this->table_name . " ORDER BY mark ASC LIMIT {$from_record_num}, {$records_per_page}";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    function getFreeCars()
    {
        try {
            $query = "
            SELECT id, state_number
            FROM car
            WHERE id NOT IN (SELECT  DISTINCT car_id FROM driver_car)
            ORDER BY state_number";

            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            return $stmt;
        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }
    }


    function getBusyCars($id)
    {
        try {
            $query = "
            SELECT car.id as id, state_number
            FROM car
            INNER JOIN driver_car ON car.id = driver_car.car_id
            WHERE driver_car.driver_id = {$id}
            ORDER BY state_number"
            ;

            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            return $stmt;
        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }
    }

    function readOne()
    {

        $query = "SELECT mark, state_number, year_issue, chassis_number, body_number, vehicle_category FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->mark = $row["mark"];
        $this->state_number = $row["state_number"];
        $this->year_issue = $row["year_issue"];
        $this->chassis_number = $row["chassis_number"];
        $this->body_number = $row["body_number"];
        $this->vehicle_category = $row["vehicle_category"];
    }

    public function countAll()
    {
        $query = "SELECT id FROM " . $this->table_name . "";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $num = $stmt->rowCount();

        return $num;
    }

    function delete()
    {

        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);

        if ($result = $stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function update()
    {
        try {
            $query = "UPDATE " . $this->table_name . " SET
                mark = :mark,
                state_number = :state_number,
                year_issue = :year_issue,
                chassis_number = :chassis_number,
                body_number = :body_number,
                vehicle_category = :vehicle_category
            WHERE
                id = :id";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":mark", $this->mark);
            $stmt->bindParam(":state_number", $this->state_number);
            $stmt->bindParam(":year_issue", $this->year_issue);
            $stmt->bindParam(":chassis_number", $this->chassis_number);
            $stmt->bindParam(":body_number", $this->body_number);
            $stmt->bindParam(":vehicle_category", $this->vehicle_category);
            $stmt->bindParam(":id", $this->id);

            return $stmt->execute();
        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }
    }

    function read()
    {

        $query = "SELECT
                    id, state_number
                FROM
                    " . $this->table_name . "
                ORDER BY
                    state_number";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    function readForCreate()
    {
        try {
            $query = "
            SELECT id, state_number
            FROM car
            WHERE id NOT IN (SELECT  DISTINCT car_id FROM driver_car)
            ORDER BY state_number;";

            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            return $stmt;
        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }
    }

    function readName()
    {

        $query = "SELECT mark FROM " . $this->table_name . " WHERE id = ? limit 0,1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->mark = $row["mark"];
    }

}
