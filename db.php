    <?php
    $driver = 'mysql';
    $servername = "localhost";
    $username = "root";
    $password = "Qwart3r";
    $dbname = "users";
    $user='newuser';
    $pass='newpass';
    $table='usersinfo_t';
    $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

        try {
            $dbh = new PDO("$driver:host=$servername", $username, $password);

            $dbh->exec("CREATE DATABASE IF NOT EXISTS `$dbname`;
                CREATE USER '$user'@'localhost' IDENTIFIED BY '$pass';
                GRANT ALL ON `$dbname`.* TO '$user'@'localhost';
                FLUSH PRIVILEGES;")
            or die(print_r($dbh->errorInfo(), true));

            $dbh = new PDO("mysql:host=$servername;dbname=$dbname", $user, $pass);
            // set the PDO error mode to exception
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "CREATE TABLE IF NOT EXISTS $table (
     ID INT( 11 ) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
     login VARCHAR( 50 ) NOT NULL,
      password VARCHAR( 255 ) NOT NULL,
	  rates VARCHAR( 255 ) DEFAULT NULL,
	  admin bool DEFAULT true,
      reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
      )";
            $dbh->exec($sql);
            if (isset($_COOKIE['page_visit'])) {
                setcookie('page_visit', ++$_COOKIE['page_visit'], time() + 3000);
            } else {
                setcookie('page_visit', 1, time() + 3000);
                $_COOKIE['page_visit'] = 1;
            }
            session_start();

            if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
                // last request was more than 30 minutes ago
                session_unset();     // unset $_SESSION variable for the run-time
                session_destroy();   // destroy session data in storage
            }
            $_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
            if (!isset($_SESSION['CREATED'])) {
                $_SESSION['CREATED'] = time();
            } else if (time() - $_SESSION['CREATED'] > 1800) {
                // session started more than 30 minutes ago
                session_regenerate_id(true);    // change session ID for the current session and invalidate old session ID
                $_SESSION['CREATED'] = time();  // update creation time

            }
        }
        
        catch (PDOException $e) {
            die($e->getMessage());
            $conn = null;
        }
        // set the PDO error mode to exception
        // prepare sql and bind parameters

    // R::setup( 'mysql:host=localhost;dbname=project1(auth-users)','root', 'Qwart3r' ); //for both mysql or mariaDB
    
