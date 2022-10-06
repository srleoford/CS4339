<?php

/* TODO: Translate from Java correctly */
class Settlement {
	public function stringCompareTo($v1, $v2)
	{
		$limit = min(strlen($v1), strlen($v2));
		$k = 0;
		while ($k < $limit)
		{
			$c1 = $v1[$k];
			$c2 = $v2[$k];
			if ($c1 != $c2)
			{
				return ord($c1) - ord($c2);
			}
			$k++;
		}
		return strlen($v1) - strlen($v2);
	}
}

class FamilyMember implements array()FamilyMember
{
    function __construct(){
        $this->fname = NULL;
        $this->lname = NULL;
        $this->siblings = 0;
    }
    private $fname;
    private $lname;
    private $siblings;
    public static function FamilyMember_1()
    {
        $local_this = new FamilyMember();
        return $local_this;
    }
    public static function FamilyMember_2($fn, $ln, $s)
    {
        $local_this = new FamilyMember();
        $this->fname = $fn;
        $this->lname = $ln;
        $this->siblings = $s;
        return $local_this;
    }
    public function setFName($fn)
    {
        $this->fname = $fn;
    }
    public function setLName($ln)
    {
        $this->lname = $ln;
    }
    public function setSiblings($s)
    {
        $this->siblings = $s;
    }
    public function getFName()
    {
        return $this->fname;
    }
    public function getLName()
    {
        return $this->lname;
    }
    public function getSiblings()
    {
        return $this->siblings;
    }
    public function toString()
    {
        return $this->fname . " " . $this->lname . ", who had: " . strval($this->siblings) . " siblings.";
    }
    public function compareTo($fm)
    {
        $v1 = Settlement::stringCompareTo($this->lname,$fm->lname);
        $v2 = Settlement::stringCompareTo($this->fname,$fm->fname);
        $v3 = $this->siblings < $fm->siblings ? -1 : $this->siblings > $fm->siblings ? 1 : 0;
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