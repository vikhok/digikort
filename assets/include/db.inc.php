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
        $sql = "SELECT * FROM user WHERE email = ?";
        $query = $pdo->prepare($sql);
        $query->bindParam(1, $email, PDO::PARAM_STR);

        try {
            $query->execute();
        } catch (PDOException $e) {
            //echo $e->getMessage();
        }

        $user = $query->fetch(PDO::FETCH_OBJ);
        if($user) {
            if(password_verify($password, $user->pass)) {
                $_SESSION["user"]["user_id"] = $user->user_id;
                $_SESSION["user"]["first_name"] = $user->first_name;
                $_SESSION["user"]["last_name"] = $user->last_name;
                $_SESSION["user"]["job_title"] = $user->job_title;
                $_SESSION["user"]["email"] = $user->email;
                $_SESSION["user"]["phone"] = $user->phone;
                $_SESSION["user"]["logged_in"] = true;
                header("Location: " . $_SESSION["site"]["last_visited"]);
                exit();
            } else {
                $failed = "<h4><span style='color:red'>
                    Feil epost og/eller passord.
                    </span></h4>";
            }
        } else {
            $failed = "<h4><span style='color:red'>
                Feil epost og/eller passord.
                </span></h4>";
        }
        return $failed;
    }

    function get_business_card($user_id) {
        global $pdo;
        $sql = "SELECT * FROM business_card WHERE user_id = ?";
        $query = $pdo->prepare($sql);
        $query->bindParam(1, $_GET["user_id"], PDO::PARAM_STR);

        try {
            $query->execute();
            return $query->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            //echo $e->getMessage();
            return NULL;
        }
    } 







?>