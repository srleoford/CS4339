<?php
require_once "FamilyMember.php";
//
/** TODO: Translate from Java correctly */
//class Settlement {
//	public function stringCompareTo($v1, $v2)
//	{
//		$limit = min(strlen($v1), strlen($v2));
//		$k = 0;
//		while ($k < $limit)
//		{
//			$c1 = $v1[$k];
//			$c2 = $v2[$k];
//			if ($c1 != $c2)
//			{
//				return ord($c1) - ord($c2);
//			}
//			$k++;
//		}
//		return strlen($v1) - strlen($v2);
//	}
//}

class FamilyMember
{
    private $fname;
    private $lname;
    private $siblings;

    public function __construct()
    {
        $arguments = func_get_args();
        $numArgs = func_num_args();

        if (method_exists($this, $function = '__construct'.$numArgs))
        {
            call_user_func_array(array($this, $function), $arguments);
        }
    }

    public function __construct0()
    {
    }

    public function __construct3(string $fn, string $ln, int $s)
    {
        $this->fname = $fn;
        $this->lname = $ln;
        $this->siblings = $s;
    }

//    public static function FamilyMember_1()
//    {
//        $local_this = new FamilyMember();
//        return $local_this;
//    }
//    public static function FamilyMember_2($fn, $ln, $s)
//    {
//        $local_this = new FamilyMember();
//        $this->fname = $fn;
//        $this->lname = $ln;
//        $this->siblings = $s;
//        return $local_this;
//    }
    public function setFName(string $fn) : void
    {
        $this->fname = $fn;
    }
    public function setLName($ln) : void
    {
        $this->lname = $ln;
    }
    public function setSiblings($s) : void
    {
        $this->siblings = $s;
    }
    public function getFName() : string
    {
        return $this->fname;
    }
    public function getLName() : string
    {
        return $this->lname;
    }
    public function getSiblings() : int
    {
        return $this->siblings;
    }
    public function toString()
    {
        return $this->fname . " " . $this->lname . ", who had: " . strval($this->siblings) . " siblings.";
    }

    public function compareTo(FamilyMember $fm) : int
    {
        $v1 = strcmp($this->lname, $fm->lname);
        $v2 = strcmp($this->fname, $fm->fname);
        $v3 = $this->siblings < $fm->siblings ? -1 : ($this->siblings > $fm->siblings ? 1 : 0);
        if ($v1 != 0)
        {
            return $v1;
        }
        if ($v2 != 0)
        {
            return $v2;
        }
        return $v3;
    }
}