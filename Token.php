<?php
include_once "TokenType.php";

class Token
{
    public TokenType $tokenType;
    public string $value;

    public function __construct()
    {
        $arguments = func_get_args();
        $numArgs = func_num_args();

        if (method_exists($this, $function = '__construct'.$numArgs))
        {
            call_user_func_array(array($this, $function), $arguments);
        }
    }

    public function __construct1($tokenType)
    {
        $this->tokenType = $tokenType;
        $this->value = "";
    }

    public function __construct2($tokenType, $value)
    {
        $this->tokenType = $tokenType;
        $this->value = $value;
    }

    public function printToken(): string
    {
        print($this->tokenType->value.$this->value);

        switch ($this->tokenType)
        {
            case "LSQUAREBRACKET":
                return "LSQUAREBRACKET";
            case "RSQUAREBRACKET":
                return "RSQUAREBRACKET";
            case "DASH":
                return "DASH";
            case "COMMA":

                return "COMMA";
            case "INT":
                return "INT" . $this->value;
            case "STRING":
                return "STRING" . $this->value;
            default:
                return "OTHER";
        }
    }
}

