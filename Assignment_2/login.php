<?php // login.php
const DB_HASH = "dKj38*E97dkl-";

// This is used for localhost work privately
//  $host = 'localhost';
//  $data = 'srleoford_db';
//  $user = 'root';         // Change as necessary
//  $pass = 'root';        // Change as necessary
$host = 'cssrvlab01.utep.edu';
$data = 'srleoford_db';
$user = 'srleoford';
$pass = '*utep2022!';
$chrs = 'utf8mb4';
$attr = "mysql:host=$host;dbname=$data;charset=$chrs";
$opts =
    [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

function destroy_session_and_data() {
  session_start();
  $_SESSION = array();
  setcookie(session_name(), '', time() - 2592000, '/'); session_destroy();
}
?>
