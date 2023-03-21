<?php
    define("DB_HOST", "localhost");
    define("DB_USER", "root");
    define("DB_PASS", "");
    define("DB_NAME", "digikort");
    $dsn = "mysql:dbname=" . DB_NAME . ";host=" . DB_HOST;
    $pdo;
    try {
        $pdo = new PDO($dsn, DB_USER, DB_PASS);
    } catch (PDOException $e) {
        //echo "Error connecting to database: " . $e->getMessage();
    }

    function login($email, $password) {
        global $pdo;
        $sql = "SELECT email, pass FROM user WHERE email = ?";
        $query = $pdo->prepare($sql);
        $query->bindParam(1, $email, PDO::PARAM_STR);

        try {
            $query->execute();
        } catch (PDOException $e) {
            //echo $e->getMessage();
        }

        $user = $query->fetch(PDO::FETCH_OBJ);
        if($user) {
            if($password == $user->pass/*password_verify($password, $user->pass)*/) {
                return $user;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function get_user($card_id) {
        global $pdo;
        $sql = "SELECT bc.user_id, bc.company_id, bc.job_title, bc.administrator, 
            u.first_name, u.last_name, u.email, u.phone, 
            c.company_name
            FROM business_card AS bc 
            JOIN user AS u 
            ON bc.user_id = u.user_id 
            JOIN company AS c 
            ON bc.company_id = c.company_id 
            WHERE bc.card_id = ?";
        $query = $pdo->prepare($sql);
        $query->bindParam(1, $card_id, PDO::PARAM_INT);

        try {
            $query->execute();
            return $query->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            //echo $e->getMessage();
            return false;
        }
    }

    function get_location($company_id) {
        global $pdo;
        $sql = "SELECT address, city, zip FROM location WHERE company_id = ?";
        $query = $pdo->prepare($sql);
        $query->bindParam(1, $company_id, PDO::PARAM_STR);

        try {
            $query->execute();
            return $query->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            //echo $e->getMessage();
            return false;
        }
    }









?>