<?php
include_once "Token.php";
include_once "Tokenizer.php";

//$tokenType = new TokenType("DASH");
//print_r($tokenType);
//$token = new Token($tokenType);
//print_r($token);
// Executes printToken() first, then returns the value to print the original "print command"
//print_r("This is the new token ", $token->printToken());

$i = 0;
$inputString = array();
$string = "Hello There! Welcome to this test!!!";
$tokenzier = new Tokenizer($string);
print("Here's the new tokenizer: \n");
print_r($tokenzier);
print_r("--------------------------------------------------\n");
print("Getting the following token \n");
$nextToken = $tokenzier->nextToken();
print_r($nextToken);
print_r("--------------------------------------------------\n");
print("Getting the next token \n");
$newToken = $tokenzier->nextToken();
print_r($newToken);
print_r("--------------------------------------------------\n");
