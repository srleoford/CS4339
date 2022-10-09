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