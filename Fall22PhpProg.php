<?php
include_once "Token.php";
include_once "Tokenizer.php";
include_once "TokenType.php";
include_once "BTNode.php";
include_once "BTree.php";
include_once "FamilyMember.php";

/**
 * @author Scott Ledford
 *
 * This program parses a family tree input file
 * builds the binary tree data structure
 * and displays the family tree.
 * It must be mentioned this is based off of a Java version
 * program that @author Luc Longpre wrote for Secure Web-based Systems, Fall 2022
 *
 *
 * <input> ::= <section>*
 * <section> ::= '[' <member>* ']'
 * <member> ::= STRING '-' STRING ',' INT ',' STRING
 *
 * Example of a section:
 * ["John"-"Smith", 2, 0
 * "Sofia"-"Garcia", 1, "M"
 * "Samuel"-"Martinez", 3, "MF"]
 *
 * Meaning:
 *  John Smith is the root of our family tree and has 2 siblings
 *  Sofia garcia is his mother and has 1 sibling
 *  Samuel-Martinez is his mother's father and has 3 siblings
 *
 */

/** open the URL into a buffered reader,
 * print the header,
 * parse each section, printing a formatted version
 * followed by the result of the execution
 * print the footer.
 */

class Fall22PhpProg
{
    public Token $currentToken;
    public Tokenizer $t;
    public string $EOL;

    public function __construct()
    {
        $this->currentToken = null;
        $this->t = null;
        $this->EOL = PHP_EOL;
    }

    public function main() : void
    {
        /** To get input from localhost */
        $inputSource = "";
        //$inputSource = "http://localhost/4330_f22assignment1/cs4339Fall22family.txt";
        //$inputURL = new \http\Url($inputSource);

        /** To get input from a local file */
        $file = '';
        if (file_exists("cs4339Fall22family.txt"))
        {
            $file = fopen("cs4339Fall22family.txt", "r+") or
            die("Unable to open!\n");

        }
        else
        {
            print("The file does not exist!\n");
        }

        $header = "<html>" . $this->EOL
            . "  <head>" . $this->EOL
            . "    <title>CS 4339/5339 PHP assignment</title>" . $this->EOL
            . "  </head>" . $this->EOL
            . "  <body>" . $this->EOL
            . "    <pre>";
        $footer = "    </pre>" . $this->EOL
            . "  </body>" . $this->EOL
            . "</html>";
        $inputFile = "";
        while (($line = fgets($file)) != false) {
            $inputFile = $line . $this->EOL;
        }

        $t = new Tokenizer($inputFile);
        echo $header;
        $currentToken = $t->nextToken();
        (int)$section = 0;

        while ($currentToken->tokenType != TokenType::EOF) {
            print("section " . ++$section . $this->EOL);
            try {
                $this->evalSection();
            } catch (EvalSectionException $ex) {
                while ($currentToken->tokenType != TokenType::RSQUAREBRACKET
                    && $currentToken->tokenType != TokenType::EOF) {
                    $currentToken = $t->nextToken();
                }
                $currentToken = $t->nextToken();
            }
        }
        print($footer . $this->EOL);
    }

    function evalSection() : void
    {
        $currentToken = $this->currentToken;
        $t = $this->t;
        $EOL = $this->EOL;
        try
        {
            if ($currentToken != TokenType::LSQUAREBRACKET) {
                throw new EvalSectionException("A section must start with \"[\","
                    . "found " . $currentToken->printToken());
            }
            print("[" . $EOL);
            $currentToken = $t->nextToken();
            $tree = new BTree();
            while ($currentToken->tokenType != TokenType::RSQUAREBRACKET
                && $currentToken->tokenType != TokenType::EOF)
            {
                processMember($tree);
            }
            print("tree height: " . $tree->getHeight() . $EOL);
            print("tree size: " . $tree->getSize() . $EOL);
            $tree->print();
            print("]" . $EOL);
            $currentToken = $t->nextToken();
        }
        catch (EvalSectionException $ex)
        {
            print($EOL . "Parsing or execution Exception: " . $ex->getMessage() . $EOL);
        }
    }

    function processMember($tree) : void
    {
        $currentToken = $this->currentToken;
        $t = $this->t;
        $EOL = $this->EOL;
        try
        {
            if ($currentToken->tokenType != TokenType::STRING)
            {
                $currentToken->printToken();
                throw new EvalSectionException("A member must start with a String");
            }
            $firstName = $currentToken->value;
            $currentToken = $t->nextToken();
            if ($currentToken->tokenType != TokenType::DASH)
            {
                throw new EvalSectionException("First name and last name must be separated by a dash");
            }
            $currentToken = $t->nextToken();
            if ($currentToken->tokenType != TokenType::STRING)
            {
                throw new EvalSectionException("A String was expected for last name");
            }
            $lastName = $currentToken->value;
            $currentToken = $t->nextToken();
            if ($currentToken->tokenType != TokenType::COMMA)
            {
                throw new EvalSectionException("A comma was expected");
            }
            $currentToken = $t->nextToken();
            if ($currentToken->tokenType != TokenType::INT)
            {
                throw new EvalSectionException("An integer was expected");
            }
            $siblings = (int) $currentToken->value;
            $currentToken = $t->nextToken();
            if ($currentToken->tokenType != TokenType::COMMA)
            {
                throw new EvalSectionException("A comma was expected");
            }
            $currentToken = $t->nextToken();
            if ($currentToken->tokenType != TokenType::STRING)
            {
                print($currentToken->tokenType . $EOL);
                throw new EvalSectionException("A string was expected for tree path");
            }
            $treePath = (string) $currentToken->value;
            if(strstr($treePath, "^[FMR]+S"))
            {
                throw new EvalSectionException("Only 'F', 'M' and 'R' in tree path");
            }
            $m = new FamilyMember($firstName, $lastName, $siblings);
            $tree->insertData($treePath,$m);
            $currentToken = $t->nextToken();
        }
        catch (EvalSectionException $ex)
        {
            print($EOL . "Parsing or execution Exception: " . $ex->getMessage() . $EOL);
        }
    }
}

$treePath1 = "MM";
$treePath2 = "F";
$treePath3 = "R";
$treePath4 = "FF";
$treePath5 = "FM";
$treePath6 = "MF";
$treePath13 = "MM";
$treePath7 = "FMF";
$treePath8 = "MMM";
$treePath9 = "FFF";
$treePath10 = "FFM";
$treePath11 = "MFF";
$treePath12 = "MMF";
for ($i = 0; $i < 13; $i++)
    print_r("Result of comparing treePath to '^[FMR]+$': {}")