<?php
require_once 'login.php';

session_start();

try
{
    $pdo = new PDO($attr, $user, $pass, $opts);
}
catch (\PDOException $e)
{
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

echo "Welcome to the Main Page! <br>";

if (isset($_POST['username']) &&
    isset($_POST['password'])) {
    $un_temp = sanitise($pdo, $_POST['username']);
    $pw_temp = sanitise($pdo, $_POST['password']);
    $query   = "SELECT * FROM users WHERE username=$un_temp";
    $result  = $pdo->query($query);



    if (!$result->rowCount()) {
        echo "User not found <br>";
        echo " <form method='post' action='signin.php'> 
        <input type='submit' value='Click here to sign in'> 
    </form> ";
        die();
    }

    $row = $result->fetch();
    $fn  = $row['forename'];
    $sn  = $row['surname'];
    $un  = $row['username'];
    $pw  = $row['password'];
    $isadmin = $row['isadmin'];


    if (password_verify(str_replace("'", "", $pw_temp . DB_HASH), $pw))
    {
        $_SESSION['forename'] = $fn;
        $_SESSION['surname']  = $sn;
        $_SESSION['user'] = $un;


        $updateLastLogin = "UPDATE users SET lastlogin=CURRENT_TIMESTAMP WHERE username=$un_temp";
        $result = $pdo->query($updateLastLogin);

        echo htmlspecialchars("Hi $fn $sn,
        you are logged in as '$un'") . "<br>";

        if ($isadmin) {
            $_SESSION['isadmin'] = true;

            echo "<form method='post' action='user.php'> 
                         <input type='submit' value='User Page'> 
                         </form>
                         <form method='post' action='admin.php'> 
                         <input type='submit' value='Admin Page'> 
                         </form> 
                         <form method='post' action='signin.php'> 
                         <input type='submit' name='signedout' value='Sign Out'> 
                         </form> ";
        }
        else {
            echo "<form method='post' action='user.php'> 
                         <input type='submit' value='User Page'> 
                         </form>
                         <form method='post' action='signin.php'> 
                         <input type='submit' name='signedout' value='Sign Out'> 
                         </form> ";
        }
    }
    else die("Invalid username/password combination");
}
else {

    if (!isset($_SESSION['user'])) {
        echo " <form method='post' action='signin.php'> 
        <input type='submit' value='Click here to sign in'> 
    </form> ";
    } else {
        if (isset($_SESSION['isadmin'])) {
            $buttons = "<form method='post' action='user.php'> 
              <input type='submit' value='User Page'> 
              </form>
              <form method='post' action='admin.php'> 
              <input type='submit' value='Admin Page'> 
              </form> 
              <form method='post' action='signin.php'> 
              <input type='submit' name='signedout' value='Sign Out'> 
              </form> ";
            echo $buttons;
        } else {
            $buttons = "<form method='post' action='user.php'> 
              <input type='submit' value='User Page'> 
              </form>
              <form method='post' action='signin.php'> 
              <input type='submit' value='Sign Out' name='signedout''> 
              </form> 
              ";
            echo $buttons;
        }
    }
}


function sanitise($pdo, $str)
{
    $str = htmlentities($str);
    return $pdo->quote($str);
}