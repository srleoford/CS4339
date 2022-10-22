<?php

// Check if there's anyone signed in.
// If not, print msg.
// Else, print someone is signed in
if (!empty($_POST['user']))
    $user = $_POST['user'];
else if (!empty($_POST['admin']))
    $user = $_POST['admin'];
else
    $user = "(Unknown)";

echo "$user is logged in." . "<br>";

$login = "<form method='post' id='login'> 
    Username: <input type='text' id='username' name='username'><br>
    Password: <input type='password' id='password' name='password'><br>
    <input type='submit' value='Login'>";

$signoutBTN = "
        <input type='submit' name='signout' value='Sign Out'> </form> <br>
    ";
if ($user != "(Unknown)")
    $login = $login . $signoutBTN;
else
    $login = $login . "</form> <br>";


echo $login;
