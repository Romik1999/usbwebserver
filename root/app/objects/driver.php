<?php

class Driver
{

    private $conn;
    private $table_name = "driver";

    public $id;
    public $surname;
    public $name;
    public $patronymic;
    public $birthday;
    public $phone;
    public $driving_license;
    public $data_driving_license;
    public $allowed_category;
    public $cars;

    public $errors = [];

    public function __construct($db)
    {
        $this->conn = $db;
    }

    function create()
    {
        $query = "INSERT INTO " . $this->table_name . "  SET 
                name=:name, 
                surname=:surname, 
                patronymic=:patronymic, 
                birthday=:birthday,
                phone=:phone, 
                driving_license=:driving_license, 
                data_driving_license=:data_driving_license,
                allowed_category=:allowed_category";

        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->surname = htmlspecialchars(strip_tags($this->surname));
        $this->patronymic = htmlspecialchars(strip_tags($this->patronymic));

        $this->validateCyrillic('surname');
        $this->validateCyrillic('name');
        $this->validateCyrillic('patronymic');

        if (!empty($this->errors)) {
            return false;
        }

        $stmt->bindParam(":surname", $this->surname);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":patronymic", $this->patronymic);
        $stmt->bindParam(":birthday", DateTime::createFromFormat('d-m-Y', $this->birthday)->format('Y-m-d'));
        $stmt->bindParam(":phone", $this->phone);
        $stmt->bindParam(":driving_license", $this->driving_license);
        $stmt->bindParam(":data_driving_license", DateTime::createFromFormat('d-m-Y', $this->data_driving_license)->format('Y-m-d'));
        $stmt->bindParam(":allowed_category", json_encode($this->allowed_category));

        try {
            $this->conn->beginTransaction();
            $stmt->execute();
            $lastDriverId = $this->conn->lastInsertId();

            $query2 = "INSERT INTO driver_car (driver_id, car_id) VALUES 
                       (?, ?)";
            $stmt2 = $this->conn->prepare($query2);
            foreach ($this->cars as $car) {
                $stmt2->execute([$lastDriverId, $car]);
            }
            $this->conn->commit();
            return true;
        } catch (PDOException $e) {
            $this->conn->rollback();
            print_r("Error" . $e->getMessage());
        }


    }

    function readAll($from_record_num, $records_per_page)
    {
        $query = "
        SELECT name, surname, patronymic, birthday, phone, driving_license, data_driving_license, allowed_category, GROUP_CONCAT(state_number) as state_number, driver.id as id
        FROM driver_car 
        INNER JOIN driver ON driver.id = driver_car.driver_id 
        INNER JOIN car ON car.id = driver_car.car_id 
        GROUP BY driver_id
        ORDER BY name ASC LIMIT {$from_record_num}, {$records_per_page}";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    public function countAll()
    {
        $query = "SELECT id FROM " . $this->table_name . "";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $num = $stmt->rowCount();

        return $num;
    }

    function readOne()
    {
        try {
            $query = "
        SELECT name, surname, patronymic, birthday, phone, driving_license, data_driving_license, allowed_category, GROUP_CONCAT(state_number) as state_number, driver.id as id
        FROM driver_car 
        INNER JOIN driver ON driver.id = driver_car.driver_id 
        INNER JOIN car ON car.id = driver_car.car_id 
         WHERE driver.id = ? 
         GROUP BY driver_id
         LIMIT 0,1
         ";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $this->id);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->surname = $row["surname"];
            $this->name = $row["name"];
            $this->patronymic = $row["patronymic"];
            $this->birthday = $row["birthday"];
            $this->phone = $row["phone"];
            $this->driving_license = $row["driving_license"];
            $this->data_driving_license = $row["data_driving_license"];
            $this->allowed_category = $row["allowed_category"];
            $this->cars = $row["state_number"];
        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }
    }

    function update()
    {
        try {
            $query = "UPDATE " . $this->table_name . " SET
                surname = :surname,
                name = :name,
                patronymic = :patronymic,
                birthday = :birthday,
                phone = :phone,
                driving_license = :driving_license,
                data_driving_license = :data_driving_license,
                allowed_category = :allowed_category
            WHERE
                id = :id";

            $stmt = $this->conn->prepare($query);

            $this->surname = htmlspecialchars(strip_tags($this->surname));
            $this->name = htmlspecialchars(strip_tags($this->name));
            $this->patronymic = htmlspecialchars(strip_tags($this->patronymic));
            $this->id = htmlspecialchars(strip_tags($this->id));

            $stmt->bindParam(":surname", $this->surname);
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":patronymic", $this->patronymic);
            $stmt->bindParam(":birthday", $this->birthday);
            $stmt->bindParam(":phone", $this->phone);
            $stmt->bindParam(":driving_license", $this->driving_license);
            $stmt->bindParam(":data_driving_license", $this->data_driving_license);
            $stmt->bindParam(":allowed_category", json_encode($this->allowed_category));
            $stmt->bindParam(":id", $this->id);

            try {
                $this->conn->beginTransaction();
                $stmt->execute();

                $query2 = "INSERT INTO driver_car (driver_id, car_id) VALUES 
                       (?, ?)";
                $stmt2 = $this->conn->prepare($query2);
                foreach ($this->cars as $car) {
                    $stmt2->execute([$this->id, $car]);
                }
                $this->conn->commit();
                return true;
            } catch (PDOException $e) {
                $this->conn->rollback();
                print_r("Error" . $e->getMessage());
            }
        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }
    }

    function delete()
    {
        try {
            $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $this->id);

            try {
                $this->conn->beginTransaction();
                $stmt->execute();

                $query2 = "DELETE FROM driver_car WHERE driver_id = ?";
                $stmt2 = $this->conn->prepare($query2);
                $stmt2->execute([$this->id]);
                $this->conn->commit();
                return true;
            } catch (PDOException $e) {
                $this->conn->rollback();
                print_r("Error" . $e->getMessage());
            }
        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }
    }

//    function read()
//    {
//        $query = "
//SELECT name,
//FROM " . $this->table_name . "
//WHERE id = ? limit 0,1";
//
//        $stmt = $this->conn->prepare($query);
//        $stmt->bindParam(1, $this->id);
//        $stmt->execute();
//
//        $row = $stmt->fetch(PDO::FETCH_ASSOC);
//
//        $this->name = $row["name"];
//    }

    //Валидация
    public function validateCyrillic($attribute)
    {
        if (!preg_match('/^[а-яА-ЯёЁ ]+$/ui', $this->$attribute)) {
            $this->errors[$attribute] = 'Это поле может состоять только из русских букв и пробелов.';
        }
    }

}
