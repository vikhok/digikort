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

    function get_company_info($company_id) {
        global $pdo;
        $sql = "SELECT company_id 
            FROM company 
            WHERE company_id = ?";

        $query = $pdo->prepare($sql);
        $query->bindParam(1, $company_id, PDO::PARAM_INT);    

        try {
            $query->execute();
            return $query->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
    }

    function edit_company($company_id, $company_name, $descriptions, $web_url) {
        global $pdo;
        $sql1 = "UPDATE company SET (company_name, descriptions, web_url) VALUES (?, ?, ?) WHERE company_id = ?";
        $query1 = $pdo->prepare($sql1);
        $query1->bindParam(1, $company_name, PDO::PARAM_STR);
        $query1->bindParam(2, $descriptions, PDO::PARAM_STR);
        $query1->bindParam(3, $web_url, PDO::PARAM_STR);
        $query1->bindParam(4, $company_id, PDO::PARAM_INT);

            try{
                $query1->execute();
                return true;
            } catch (PDOException $e) {
                //echo $e->getMessage();
                return false;
            }
    }

    function delete_company($company_id, $company_name, $descriptions, $web_url) {
        global $pdo;
        $sql1 = "DELETE FROM company WHERE company_id = ?";
        $query1 = $pdo->prepare($sql1);
        $query1->bindParam(1, $company_id, PDO::PARAM_INT);

        try{
            $query1->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
        
    }


    function update_user_profile($first_name, $last_name, $phone, $email, $job_title, $user_id) {
        global $pdo;
        $sql1 = "UPDATE user SET (first_name, last_name, phone, email) VALUES (?, ?, ?, ?) WHERE user_id = ?";
        $query1 = $pdo->prepare($sql1);
        $query1->bindParam(1, $first_name, PDO::PARAM_STR);
        $query1->bindParam(2, $last_name, PDO::PARAM_STR);
        $query1->bindParam(3, $phone, PDO::PARAM_STR);
        $query1->bindParam(4, $email, PDO::PARAM_STR);
        $query1->bindParam(5, $user_id, PDO::PARAM_INT);

        $pdo->beginTransaction();

        try {
            $query1->execute();
            $sql2 = "UPDATE business_card SET (job_title) VALUE (?) WHERE user_id ?";
            $query2 = $pdo->prepare($sql2);
            $query2->bindParam(1, $job_title, PDO::PARAM_STR);
            $query2->bindParam(2, $user_id, PDO::PARAM_INT);

            try {
                $query2->execute();
                $pdo->commit();
                return true;
            } catch (PDOException $e) {
                //echo $e->getMessage();
                $pdo->rollBack();
                return false;
            }

        } catch (PDOException $e) {
            //echo $e->getMessage();
            $pdo->rollBack();
            return false;
        }
    }

?>