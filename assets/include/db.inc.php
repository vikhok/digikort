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
        $sql = "SELECT user_id, email, pass FROM user WHERE email = ?";
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

    function get_user_company_old($user_id) {
        global $pdo;
        $sql = "SELECT bc.user_id, bc.company_id, bc.job_title, bc.administrator, 
            u.first_name, u.last_name, u.email, u.phone, 
            c.company_name
            FROM business_card AS bc 
            JOIN user AS u 
            ON bc.user_id = u.user_id 
            JOIN company AS c 
            ON bc.company_id = c.company_id 
            WHERE bc.user_id = ?";
        $query = $pdo->prepare($sql);
        $query->bindParam(1, $user_id, PDO::PARAM_INT);

        try {
            $query->execute();
            return $query->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            //echo $e->getMessage();
            return false;
        }
    }

    function get_user($user_id) {
        global $pdo;
        $sql = "SELECT first_name, last_name, email, phone FROM user WHERE user_id = ?";
        $query = $pdo->prepare($sql);
        $query->bindParam(1, $user_id, PDO::PARAM_INT);

        try {
            $query->execute();
            return $query->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            //echo $e->getMessage();
            return false;
        }
    }

    function get_user_company($user_id) {
        global $pdo;
        $sql = "SELECT bc.user_id, bc.company_id, bc.job_title, bc.administrator, 
            c.company_name
            FROM business_card AS bc 
            JOIN company AS c 
            ON bc.company_id = c.company_id 
            WHERE bc.user_id = ?";
        $query = $pdo->prepare($sql);
        $query->bindParam(1, $user_id, PDO::PARAM_INT);

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

    function create_account($first_name, $last_name, $email, $phone, $password) {
        global $pdo;
        $sql1 = "INSERT INTO user (first_name, last_name, email, phone, pass) VALUES (?, ?, ?, ?, ?)";
        $query1 = $pdo->prepare($sql1);
        $query1->bindParam(1, $first_name, PDO::PARAM_STR);
        $query1->bindParam(2, $last_name, PDO::PARAM_STR);
        $query1->bindParam(3, $email, PDO::PARAM_STR);
        $query1->bindParam(4, $phone, PDO::PARAM_STR);
        $query1->bindParam(5, $password, PDO::PARAM_STR);
        
        //$pdo->beginTransaction();
        try {
            $query1->execute();
            $user_id = $pdo->lastInsertId();
            /*
            try {
                $sql2 = "INSERT INTO business_card (user_id) VALUE (?)";
                $query2 = $pdo->prepare($sql2);
                $query2->bindParam(1, $last_inserted_id, PDO::PARAM_INT);
                $query2->execute();
            } catch (PDOException $e) {
                echo $e->getMessage();
                $pdo->rollBack();
                return false;
            }
            */
            //$pdo->commit();
            return $user_id;
        } catch (PDOException $e) {
            echo $e->getMessage();
            //$pdo->rollBack();
            return false;
        }
    }

    function get_user_social($user_id) {
        global $pdo;
        $sql = "SELECT linkedin, github, instagram FROM user_social WHERE user_id = ?";
        $query = $pdo->prepare($sql);
        $query->bindParam(1, $user_id, PDO::PARAM_INT);

        try {
            $query->execute();
            return $query->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            //echo $e->getMessage();
            return false;
        }
    }

    function update_user_social($linkedin, $github, $instagram, $user_id) {
        global $pdo;
        $sql = "UPDATE user_social SET (linkedin, github, instagram) VALUES (?, ?, ?) WHERE user_id = ?";
        $query = $pdo->prepare($sql);
        $query->bindParam(1, $linkedin, PDO::PARAM_STR);
        $query->bindParam(2, $github, PDO::PARAM_STR);
        $query->bindParam(3, $instagram, PDO::PARAM_STR);
        $query->bindParam(4, $user_id, PDO::PARAM_INT);


        try {
            $query->execute();
            return $query->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            //echo $e->getMessage();
            return false;
        }
    }







?>