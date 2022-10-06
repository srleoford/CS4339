<?php
include_once "Token.php";
include_once "TokenType.php";

class Tokenizer {

    //String that will be treated as a char array
    private array $charArray;
    private int $i;
    public $currentChar;

    public function __construct($string)
    {
        $this->charArray = str_split($string);
        $this->i = 0;
        $this->currentChar = $this->charArray[0];
    }

//    public function nextToken(): Token
//    {
//        print("This is i: " . $this->i);
//        // Skip whitespace characters
//        while ($this->i < count($this->charArray) && strrchr(" \n\t\r", $this->charArray[$this->i]) >= 0)
//        {
//            $this->i++;
//            $this->currentChar = $this->charArray[$this->i];
//        }
//        print("This is the current character index: " . (string)$this->i . "\n");
//        if ($this->i >= count($this->charArray))
//        {
//            return new Token(new TokenType(TokenType::EOF));
//        }
//        // Check for INT
//        $inputString = array();
//        while ($this->i < count($this->charArray) && strrchr("0123456789", $this->charArray[$this->i]) >= 0)
//        {
//            array_push($inputString, $this->charArray[$this->i++]);
//        }
//        if (strcmp("", implode($inputString)) != 0)
//        {
//            print("This is the input string: " . implode("", $inputString) . "\n");
//            return new Token( new TokenType(TokenType::INT), implode("", $inputString));
//        }
//
//        // We're left with strings or character tokens
//        switch ($this->charArray[$this->i])
//        {
//            case '[':
//                return new Token(new TokenType(TokenType::LSQUAREBRACKET),"[");
//            case ']':
//                return new Token(new TokenType(TokenType::RSQUAREBRACKET),"]");
//            case '-':
//                return new Token(new TokenType(TokenType::DASH),"-");
//            case ',':
//                return new Token(new TokenType(TokenType::COMMA),",");
//            case '"':
//                $value = "";
//                while ($this->i < count($this->charArray) && $this->charArray[$this->i] != '"')
//                {
//                    $c = $this->charArray[$this->i++];
//                    if ($this->i >= count($this->charArray))
//                        return new Token( new TokenType(TokenType::OTHER));
//                    // check for escaped double quote
//                    if ($c == '\\' && $this->charArray[$this->i] == '"') {
//                        $c='"';
//                        $this->i++;
//                    }
//                    $value = $value . $c;
//                }
//                $this->i++;
//                return new Token(new TokenType(TokenType::STRING), $value);
//        }
//        // OTHER should result in exception
//        return new Token(new TokenType(TokenType::OTHER));
//    }

    public function nextToken() : Token
    {
        // Skip whitespace characters
        $i = $this->i;
        $strArray = $this->charArray;
        while ($i < count($strArray) && ctype_space($strArray[$i]))
            $i++;

        print("This is the current index: $i. This is the current char: $strArray[$i]\n");

        if ($i >= count($strArray))
            return new Token(new TokenType(TokenType::EOF));
        print("We are at the end of the string.\n");
        // Check for integer
        $numString = "";
        while ($i < count($strArray) && ctype_digit($strArray[$i])) {
            $numString = $numString . $strArray[$i];
            print("This is the new string: $numString");
        }
        print("This is the return string: $numString\n");

        if (strcmp("", $numString))
            return new Token(new TokenType(TokenType::INT), $numString);

        print("The return string wasn't empty: " . boolval($numString == "") ."\n");

        //What's left is strings/one character tokens
        switch ($strArray[$i]) {
            case '[':
                return new Token(new TokenType(TokenType::LSQUAREBRACKET));
            case ']':
                return new Token(new TokenType(TokenType::RSQUAREBRACKET));
            case '-':
                return new Token(new TokenType(TokenType::DASH));
            case ',':
                return new Token(new TokenType(TokenType::COMMA));
            case '"':
                $value = "";
                while ($i < count($strArray) && $strArray[$i] != '"') {
                    $this->currentChar = $strArray[$i++];
                    if ($i >= count($strArray))
                        return newToken(new TokenType(TokenType::OTHER));

                    //Check for escaped double quote
                    if ($this->currentChar == '\\' && $strArray[$i] == '"') {
                        $this->currentChar = '"';
                        $i++;
                    }
                    $value = $value . $this->currentChar;
                }
                $i++;
                return new Token(new TokenType(TokenType::STRING, $value));
        }

        return new Token(new TokenType(TokenType::OTHER));
    }
}


$tokenizer = new Tokenizer("    Let's check this string!");
print_r($tokenizer);

print_r("--------------------------------------------------\n");
$nextToken = $tokenizer->nextToken();
print_r("Here is the token: '" . $nextToken->value. "'|\n");