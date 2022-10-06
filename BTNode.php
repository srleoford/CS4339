<?php

class BTNode<T>
{
    private $data;
    private $left;
    private $right;

    function __construct(){
        $this->data = NULL;
        $this->left = NULL;
        $this->right = NULL;
    }
    // Constructors ****************************************************************
    public static function BTNode_1()
    {
        $local_this = new BTNode();
        return $local_this;
    }
    public static function BTNode_2($d)
    {
        $local_this = new BTNode();
        $this->data = $d;
        $this->left = NULL;
        $this->right = NULL;
        return $local_this;
    }
    // Setters *********************************************************************
    public function setData($d)
    {
        $this->data = $d;
    }
    public function setLeft($L)
    {
        $this->left = $L;
    }
    public function setRight($R)
    {
        $this->right = $R;
    }
    // Getters **********************************************************************
    public function getData()
    {
        return $this->data;
    }
    public function getLeft()
    {
        return $this->left;
    }
    public function getRight()
    {
        return $this->right;
    }
    // Other methods ***************************************************************
    // printNode prints the content of the current node
    public function printNode()
    {
        if ($this->data == NULL)
        {
            echo "?","\n";
        }
        else
        {
            echo json_encode($this->data),"\n";
        }
    }
    // Height computes the height of the current node
    public function height()
    {
        $leftHeight;
        $rightHeight;
        if ($this->hasLeft())
        {
            $leftHeight = $this->left->height();
        }
        else
        {
            $leftHeight = -1;
        }
        if ($this->hasRight())
        {
            $rightHeight = $this->right->height();
        }
        else
        {
            $rightHeight = -1;
        }
        return 1 + max($leftHeight,$rightHeight);
    }
    public function sizeBelow()
    {
        $leftSize;
        $rightSize;
        if ($this->hasLeft())
        {
            $leftSize = $this->left->sizeBelow();
        }
        else
        {
            $leftSize = 0;
        }
        if ($this->hasRight())
        {
            $rightSize = $this->right->sizeBelow();
        }
        else
        {
            $rightSize = 0;
        }
        return 1 + $leftSize + $rightSize;
    }
    public function hasLeft()
    {
        return $this->getLeft() != NULL;
    }
    public function hasRight()
    {
        return $this->getRight() != NULL;
    }
}

<?php