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
            return false;
        }

        $user = $query->fetch(PDO::FETCH_OBJ);
        if($user) {
            if($password == password_verify($password, $user->pass)) {
                return $user;
            } else return false;
        } else return false;
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
        $sql = "SELECT bc.user_id, bc.company_id, bc.administrator, 
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
        $query->bindParam(1, $company_id, PDO::PARAM_INT);

        try {
            $query->execute();
            return $query->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            //echo $e->getMessage();
            return false;
        }
    }

    function create_account($first_name, $last_name, $email, $phone, $password_hash) {
        global $pdo;
        $sql = "INSERT INTO user (first_name, last_name, email, phone, pass) VALUES (?, ?, ?, ?, ?)";
        $query = $pdo->prepare($sql);
        $query->bindParam(1, $first_name, PDO::PARAM_STR);
        $query->bindParam(2, $last_name, PDO::PARAM_STR);
        $query->bindParam(3, $email, PDO::PARAM_STR);
        $query->bindParam(4, $phone, PDO::PARAM_STR);
        $query->bindParam(5, $password_hash, PDO::PARAM_STR);
        
        try {
            $query->execute();
            $user_id = $pdo->lastInsertId();
            return $user_id;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    function get_user_socialmedia($user_id) {
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

    function update_user_profile($user_id, $first_name, $last_name, $phone, $email, $job_title, $linkedin, $github, $instagram) {
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

            $sql2 = "UPDATE business_card SET (job_title) VALUE (?) WHERE user_id = ?";
            $query2 = $pdo->prepare($sql2);
            $query2->bindParam(1, $job_title, PDO::PARAM_STR);
            $query2->bindParam(2, $user_id, PDO::PARAM_INT);
            $query2->execute();

            $sql3 = "UPDATE user_social SET (linkedin, github, instagram) VALUES (?, ?, ?) WHERE user_id = ?";
            $query3 = $pdo->prepare($sql3);
            $query3->bindParam(1, $linkedin, PDO::PARAM_STR);
            $query3->bindParam(2, $github, PDO::PARAM_STR);
            $query3->bindParam(3, $instagram, PDO::PARAM_STR);
            $query3->bindParam(4, $user_id, PDO::PARAM_INT);
            $query3->execute();

            $pdo->commit();
            return true;
        } catch (PDOException $e) {
            //echo $e->getMessage();
            $pdo->rollBack();
            return false;
        }
    }

    function get_all_companies() {
        global $pdo;
        $sql = "SELECT company_id, company_name FROM company";
        $query = $pdo->prepare($sql);
        
        try {
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach($results as $result) {
                $new_results[] = $result["company_name"];
            }
            return $new_results;
            } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
            
    // DISSE VAR SLETTET MED UHELL:

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

    function get_all_users() {
        global $pdo;
        $sql = "SELECT user_id, first_name, last_name FROM user";
        $query = $pdo->prepare($sql);

        try {
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach($results as $result) {
                $new_results[] = $result["first_name"] . " " . $result["last_name"];
            }
            return $new_results;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    function join_company($company_name, $user_id, $administrator) {
        global $pdo;

        $sql1 = "SELECT company_id FROM company WHERE company_name = ?";
        $query1 = $pdo->prepare($sql1);
        $query1->bindParam(1, $company_name, PDO::PARAM_STR);

        try {
            $query1->execute();
            $company_id = $query1->fetch(PDO::FETCH_COLUMN);

            $sql2 = "INSERT INTO business_card (company_id, user_id, administrator) VALUES (?,?,?)";
            $query2 = $pdo->prepare($sql2);
            $query2->bindParam(1, $company_id, PDO::PARAM_INT);
            $query2->bindParam(2, $user_id, PDO::PARAM_INT);
            $query2->bindParam(3, $administrator, PDO::PARAM_BOOL);

            $query2->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    function get_all_notes($user_id) {
        global $pdo;
        $sql = "SELECT note_id, note_heading, note_subject, note_date FROM note WHERE user_id = ?";
        $query = $pdo->prepare($sql);
        $query->bindParam(1, $user_id, PDO::PARAM_INT);

        try {
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach($results as $result) {
                $notes[] = [$result["note_id"], $result["note_heading"], $result["note_subject"], $result["note_date"]];
            }
            return $notes;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
      
    // function get_user_notes($user_id) {
    //     global $pdo;

    //     $sql = "SELECT * FROM notes WHERE user_id = :user_id";
    //     $query = $pdo->prepare($sql);
    //     $query->execute(['user_id' => $user_id]);

    //     $user_notes = $query->fetchAll(PDO::FETCH_ASSOC);

    //     return $user_notes;
    // }

    function create_note() {
        if(isset($_POST['note_title']) && isset($_POST['note_text'])) {
            $note_title = trim($_POST['note_title']);
            $note_text = trim($_POST['note_text']);
    
            if(!empty($note_title) && !empty($note_text)) {
                $user_id = $_SESSION['user_id'];
                $note_id = create_note($user_id, $note_title, $note_text);
    
                if($note_id) {
                    $_SESSION['success'] = "Note added successfully!";
                    header("Location: index.php");
                    exit();
                } else {
                    $_SESSION['error'] = "Note creation failed. Please try again.";
                }
            } else {
                $_SESSION['error'] = "Please enter both title and text for your note.";
            }
        }
    }
    
    
    function edit_note($note_id, $user_id, $note_title, $note_text) {
        global $pdo;
        $sql = "UPDATE note SET note_title = ?, note_text = ? WHERE note_id = ? AND user_id = ?";
        $query = $pdo->prepare($sql);
        $query->bindParam(1, $note_title, PDO::PARAM_STR);
        $query->bindParam(2, $note_text, PDO::PARAM_STR);
        $query->bindParam(3, $note_id, PDO::PARAM_INT);
        $query->bindParam(4, $user_id, PDO::PARAM_INT);
    
        try {
            $query->execute();
            return true;
        } catch (PDOException $e) {
            //echo $e->getMessage();
            return false;
        }
    }
    
    function delete_note($note_id, $user_id) {
        global $pdo;
        $sql = "DELETE FROM note WHERE note_id = ? AND user_id = ?";
        $query = $pdo->prepare($sql);
        $query->bindParam(1, $note_id, PDO::PARAM_INT);
        $query->bindParam(2, $user_id, PDO::PARAM_INT);
    
        try {
            $query->execute();
            return $query->rowCount();
        } catch (PDOException $e) {
            //echo $e->getMessage();
            return false;
        }
    }
?>
