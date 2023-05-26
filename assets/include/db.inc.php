<?php
    // ini_set('display_errors', 1);
    // ini_set('display_startup_errors', 1);
    // error_reporting(E_ALL);    

    // define("DB_HOST", getenv('DB_HOST') ? getenv('DB_HOST') : 'localhost');
    // define("DB_USER", getenv('DB_USER') ? getenv('DB_USER') : 'root');
    // define("DB_PASS", getenv('DB_PASS') ? getenv('DB_PASS') : '');
    // define("DB_NAME", getenv('DB_NAME') ? getenv('DB_NAME') : 'digikort');

    
    define("DB_HOST", "mysql-digikort.mysql.database.azure.com");
    define("DB_USER", "sadigikort");
    define("DB_PASS", "J53KuXrfZbvGxU");
    define("DB_NAME", "digikort");

    // $options = [
    //     PDO::MYSQL_ATTR_SSL_CA => '/etc/apache2/certificate.crt',
    //     PDO::MYSQL_ATTR_SSL_CERT => '/etc/apache2/certificate.crt',
    //     PDO::MYSQL_ATTR_SSL_KEY => '/etc/apache2/private.key',
    // ];

    $dsn = "mysql:dbname=" . DB_NAME . ";host=" . DB_HOST;
    $pdo;
    try {
        $pdo = new PDO($dsn, DB_USER, DB_PASS);
    } catch (PDOException $e) {
        echo "Error connecting to database: " . $e->getMessage();
    }

    // $host = 'localhost';
    // $dbname = 'digikort';
    // $username = 'root';
    // $password = 'pass';
    // $socket = '/var/run/mysqld/mysqld.sock';
    //;unix_socket=$socket

   

    // try {
    //     $pdo = new PDO("mysql:dbname=$dbname", $username, $password);
    //     echo "Connected successfully";
    // } catch (PDOException $e) {
    //     die("Connection failed: " . $e->getMessage());
    // }


    function login($email, $password) {
        global $pdo;
        $sql = "SELECT u.user_id, u.email, u.pass, bc.administrator 
            FROM user AS u 
            LEFT JOIN business_card AS bc 
            ON u.user_id = bc.user_id 
            WHERE u.email = ?";
        $query = $pdo->prepare($sql);
        $query->bindParam(1, $email, PDO::PARAM_STR);

        try {
            $query->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }

        $user = $query->fetch(PDO::FETCH_OBJ);
        if($user) {
            if(password_verify($password, $user->pass)) {
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
        $sql = "SELECT first_name, last_name, job_title, email, phone FROM user WHERE user_id = ?";
        $query = $pdo->prepare($sql);
        $query->bindParam(1, $user_id, PDO::PARAM_INT);

        try {
            $query->execute();
            return $query->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    function get_user_with_socials_and_company($user_id) {
        global $pdo;
        $sql = "SELECT u.first_name, u.last_name, u.job_title, u.email, u.phone, us.linkedin, us.github, us.instagram, bc.company_id 
            FROM user AS u 
            LEFT JOIN user_social AS us 
            ON u.user_id = us.user_id 
            LEFT JOIN business_card AS bc 
            ON u.user_id = bc.user_id 
            WHERE u.user_id = ?";
        $query = $pdo->prepare($sql);
        $query->bindParam(1, $user_id, PDO::PARAM_INT);

        try {
            $query->execute();
            return $query->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            echo $e->getMessage();
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
        $sql = "SELECT company_address, company_city, company_zip FROM company WHERE company_id = ?";
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

    function update_user_profile($user_id, $first_name, $last_name, $job_title, $email, $phone, $linkedin, $github, $instagram) {
        global $pdo;

        $sql1 = "UPDATE user SET first_name = ?, last_name = ?, job_title = ?, email = ?, phone = ? WHERE user_id = ?";
        $query1 = $pdo->prepare($sql1);
        $query1->bindParam(1, $first_name, PDO::PARAM_STR);
        $query1->bindParam(2, $last_name, PDO::PARAM_STR);
        $query1->bindParam(3, $job_title, PDO::PARAM_STR);
        $query1->bindParam(4, $email, PDO::PARAM_STR);
        $query1->bindParam(5, $phone, PDO::PARAM_STR);
        $query1->bindParam(6, $user_id, PDO::PARAM_INT);

        $pdo->beginTransaction();
        try {
            $query1->execute();

            $sql3 = "UPDATE user_social SET linkedin = ?, github = ?, instagram = ? WHERE user_id = ?";
            $query3 = $pdo->prepare($sql3);
            $query3->bindParam(1, $linkedin, PDO::PARAM_STR);
            $query3->bindParam(2, $github, PDO::PARAM_STR);
            $query3->bindParam(3, $instagram, PDO::PARAM_STR);
            $query3->bindParam(4, $user_id, PDO::PARAM_INT);
            $query3->execute();

            $pdo->commit();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
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

    function get_company_socialmedia($company_id) {
        global $pdo;
        $sql = "SELECT linkedin, github, instagram FROM company_social WHERE company_id = ?";
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
            

    function get_company_info($company_id) {
        global $pdo;
        $sql = "SELECT company_name, company_desc, company_email, company_url, company_address, company_city, company_zip, access_code 
            FROM company WHERE company_id = ?";
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

    function verify_admin_role($company_id, $user_id) {
        global $pdo;
        $sql = "SELECT administrator FROM business_card WHERE company_id = ? AND user_id = ?";
        $query = $pdo->prepare($sql);
        $query->bindParam(1, $company_id, PDO::PARAM_INT);
        $query->bindParam(2, $user_id, PDO::PARAM_INT);

        try {
            $query->execute();
            $object = $query->fetch(PDO::FETCH_ASSOC);
            if($object && $object["administrator"]) {
                return true;
            } else return false;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    function give_admin_role($company_id, $user_id) {
        global $pdo;
        $sql = "UPDATE business_card SET administrator = ? WHERE company_id = ? AND user_id = ?";
        $query = $pdo->prepare($sql);
        $admin = true;
        $query->bindParam(1, $admin, PDO::PARAM_BOOL);
        $query->bindParam(2, $company_id, PDO::PARAM_INT);
        $query->bindParam(3, $user_id, PDO::PARAM_INT);

        try {
            $query->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    function update_company($company_name, $company_desc, $company_email, $company_url, $company_address, $company_city, $company_zip, $access_code, $company_id) {
        global $pdo;
        $sql = "UPDATE company SET company_name = ?, company_desc = ?, company_email = ?, 
            company_url = ?, company_address = ?, company_city = ?, company_zip = ?, access_code = ? 
            WHERE company_id = ?";
        $query = $pdo->prepare($sql);
        $query->bindParam(1, $company_name, PDO::PARAM_STR);
        $query->bindParam(2, $company_desc, PDO::PARAM_STR);
        $query->bindParam(3, $company_email, PDO::PARAM_STR);
        $query->bindParam(4, $company_url, PDO::PARAM_STR);
        $query->bindParam(5, $company_address, PDO::PARAM_STR);
        $query->bindParam(6, $company_city, PDO::PARAM_STR);
        $query->bindParam(7, $company_zip, PDO::PARAM_INT);
        $query->bindParam(8, $access_code, PDO::PARAM_STR);
        $query->bindParam(9, $company_id, PDO::PARAM_INT);

        try{
            $query->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    function delete_company($company_id) {
        global $pdo;
        $sql = "DELETE FROM company WHERE company_id = ?";
        $query = $pdo->prepare($sql);
        $query->bindParam(1, $company_id, PDO::PARAM_INT);

        try{
            $query->execute();
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

    function add_company($company_name, $company_desc, $company_email, $company_url, $company_address, $company_city, $company_zip, $access_code, $user_id) {
        global $pdo;
        $sql1 = "INSERT INTO company (company_name, company_email, company_desc, company_url, company_address, company_city, company_zip, access_code) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $query1 = $pdo->prepare($sql1);
        $query1->bindParam(1, $company_name, PDO::PARAM_STR);
        $query1->bindParam(2, $company_email, PDO::PARAM_STR);
        $query1->bindParam(3, $company_desc, PDO::PARAM_STR);
        $query1->bindParam(4, $company_url, PDO::PARAM_STR);
        $query1->bindParam(5, $company_address, PDO::PARAM_STR);
        $query1->bindParam(6, $company_city, PDO::PARAM_STR);
        $query1->bindParam(7, $company_zip, PDO::PARAM_INT);
        $query1->bindParam(8, $access_code, PDO::PARAM_STR);
        
        $pdo->beginTransaction();
        try {
            $query1->execute();
            $company_id = $pdo->lastInsertId();
            $administrator = true;

            $sql2 = "INSERT INTO business_card (company_id, user_id, administrator) VALUES (?, ?, ?)";
            $query2 = $pdo->prepare($sql2);
            $query2->bindParam(1, $company_id, PDO::PARAM_INT);
            $query2->bindParam(2, $user_id, PDO::PARAM_INT);
            $query2->bindParam(3, $administrator, PDO::PARAM_BOOL);
            $query2->execute();

            $pdo->commit();
            return $company_id;
        } catch (PDOException $e) {
            //echo $e->getMessage();
            $pdo->rollback();
            return false;
        }
    }

   function join_company($company_name, $access_code, $user_id, $administrator = false) {
        global $pdo;
        $sql1 = "SELECT company_id FROM company WHERE company_name = ? AND access_code = ?";
        $query1 = $pdo->prepare($sql1);
        $query1->bindParam(1, $company_name, PDO::PARAM_STR);
        $query1->bindParam(2, $access_code, PDO::PARAM_STR);

        $pdo->beginTransaction();
        try {
            $query1->execute();
            $company_id = $query1->fetch(PDO::FETCH_COLUMN);

            $sql2 = "INSERT INTO business_card (company_id, user_id, administrator) VALUES (?, ?, ?)";
            $query2 = $pdo->prepare($sql2);
            $query2->bindParam(1, $company_id, PDO::PARAM_INT);
            $query2->bindParam(2, $user_id, PDO::PARAM_INT);
            $query2->bindParam(3, $administrator, PDO::PARAM_BOOL);

            $query2->execute();
            $pdo->commit();
            return $company_id;
        } catch (PDOException $e) {
            //echo $e->getMessage();
            $pdo->rollBack();
            return false;
        }
    }
    
    // NOTES:

    function get_all_notes($user_id) {
        global $pdo;
        $sql = "SELECT note_id, note_subject, note_body, note_date FROM note WHERE user_id = ?";
        $query = $pdo->prepare($sql);
        $query->bindParam(1, $user_id, PDO::PARAM_INT);

        try {
            $query->execute();
            $notes = $query->fetchAll(PDO::FETCH_ASSOC);
            return $notes;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    function get_note($user_id, $note_id) {
        global $pdo;
        $sql = "SELECT note_subject, note_body, note_date FROM note WHERE user_id = ? AND note_id = ?";
        $query = $pdo->prepare($sql);
        $query->bindParam(1, $user_id, PDO::PARAM_INT);
        $query->bindParam(2, $note_id, PDO::PARAM_INT);

        try {
            $query->execute();
            $note = $query->fetch(PDO::FETCH_OBJ);
            return $note;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
      

    function create_note($user_id, $encrypted_subject, $encrypted_body) {
        global $pdo;
        $sql = "INSERT INTO note (user_id, note_subject, note_body, note_date) VALUES (?, ?, ?, ?)";
        $query = $pdo->prepare($sql);
        $date = date("Y-m-d H:i:s");
        $query->bindParam(1, $user_id, PDO::PARAM_INT);
        $query->bindParam(2, $encrypted_subject, PDO::PARAM_STR);
        $query->bindParam(3, $encrypted_body, PDO::PARAM_STR);
        $query->bindParam(4, $date, PDO::PARAM_STR);

        try {
            $query->execute();
            $note_id = $pdo->lastInsertId();
            return $note_id;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    
    function update_note($note_id, $encrypted_subject, $encrypted_body) {
        global $pdo;
        $sql = "UPDATE note SET note_subject = ?, note_body = ?, note_date = ? WHERE note_id = ?";
        $query = $pdo->prepare($sql);
        $date = date("Y-m-d H:i:s");
        $query->bindParam(1, $encrypted_subject, PDO::PARAM_STR);
        $query->bindParam(2, $encrypted_body, PDO::PARAM_STR);
        $query->bindParam(3, $date, PDO::PARAM_STR);
        $query->bindParam(4, $note_id, PDO::PARAM_INT);
       
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
            return true;
        } catch (PDOException $e) {
            //echo $e->getMessage();
            return false;
        }
    }

    // Reset password:    
      
    function create_validation_code($email, $verification, $valid_time) {
        global $pdo;
        $sql = "INSERT INTO reset_password (email, security_code, valid_to) 
            VALUES (?, ?, date_add(CURRENT_TIMESTAMP, interval ? minute))";
        $query = $pdo->prepare($sql);
        $query->bindParam(1, $email, PDO::PARAM_STR);
        $query->bindParam(2, $verification, PDO::PARAM_STR);
        $query->bindParam(3, $valid_time, PDO::PARAM_INT);

        try {
            $query->execute();
            return true;
        } catch (PDOException $e) {
            //echo $e->getMessage();
            return false;
        }
    }

    function delete_validation_code($email) {
        global $pdo;
        $sql = "DELETE FROM reset_password WHERE email = ?";
        $query = $pdo->prepare($sql);
        $query->bindParam(1, $email, PDO::PARAM_STR);

        try {
            $query->execute();
            return true;
        } catch (PDOException $e) {
            //echo $e->getMessage();
            return false;
        }
    }

    function validate_password_reset($email, $verification) {
        global $pdo;
        $sql = "SELECT * FROM reset_password WHERE email = ? and security_code = ?";
        $query = $pdo->prepare($sql);
        $query->bindParam(1, $email, PDO::PARAM_STR);
        $query->bindParam(2, $verification, PDO::PARAM_STR);

        try {
            $query->execute();
            $valid = $query->fetch(PDO::FETCH_OBJ);
            if($valid) return true;
            else return false;
        } catch (PDOException $e) {
            //echo $e->getMessage();
            return false;
        }
    }

    
    function update_password($email, $password_hash) {
        global $pdo;
        $sql = "UPDATE user SET pass = ? WHERE email = ?";
        $query = $pdo->prepare($sql);
        $query->bindParam(1, $password_hash, PDO::PARAM_STR);
        $query->bindParam(2, $email, PDO::PARAM_STR);

        try {
            $query->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    function leave_company($user_id, $company_id) {
        global $pdo;
        $sql = "DELETE FROM business_card WHERE user_id = ? AND company_id = ?";
        $query = $pdo->prepare($sql);
        $query->bindParam(1, $user_id, PDO::PARAM_INT);
        $query->bindParam(2, $company_id, PDO::PARAM_INT);

        try {
            $query->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    function get_all_employees($company_id) {
        global $pdo;
        $sql = "SELECT bc.user_id, bc.administrator, u.first_name, u.last_name, u.job_title, u.email
            FROM business_card AS bc 
            LEFT JOIN user AS u 
            ON bc.user_id = u.user_id 
            WHERE bc.company_id = ?";
        $query = $pdo->prepare($sql);
        $query->bindParam(1, $company_id, PDO::PARAM_INT);

        try {
            $query->execute();
            $employee_list = $query->fetchAll(PDO::FETCH_ASSOC);
            return $employee_list;
        } catch (PDOException $e) {
            //echo $e->getMessage();
            return false;
        }
    }

    function delete_user($user_id) {
        global $pdo;
        $sql = "DELETE FROM user WHERE user_id = ?";
        $query = $pdo->prepare($sql);
        $query->bindParam(1, $user_id, PDO::PARAM_INT);

        try {
            $query->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
?>
