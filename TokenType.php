<?php
class TokenType
{
    const LSQUAREBRACKET = "LSQUAREBRACKET";
    const RSQUAREBRACKET = "RSQUAREBRACKET";
    const DASH = "DASH";
    const COMMA = "COMMA";
    const INT = "INT";
    const STRING = "STRING";
    const EOF = "EOF";
    const OTHER = "OTHER";

    public string $value;

    public function __construct($value)
    {
        $this->value = $value;
    }
}