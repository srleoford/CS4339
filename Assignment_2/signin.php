<?php
require_once 'login.php';


echo "Welcome to the Sign-In Page! <br>";

if (isset($_POST['signedout'])) {
    destroy_session_and_data();
    echo "Signed out!";
}

session_start();

try
{
    $pdo = new PDO($attr, $user, $pass, $opts);
}
catch (\PDOException $e)
{
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

    echo "<form method='post' action='mainpage.php' id='login'> 
    Username: <input type='text' id='username' name='username'><br>
    Password: <input type='password' id='password' name='password'><br>
    <input type='submit' value='Login'> </form>
    ";

    if (isset($_SESSION['user'])) {
        echo "<form method='post' action='signin.php'> 
                         <input type='submit' name='signedout' value='Sign Out'>
                         </form> <br>";
    }
    echo "<form method='post' action='mainpage.php'> 
              <input type='submit' value='Main Page'> 
              </form>";
