<?php
require_once "BTNode.php";

class BTNode
{
    private $data;
    private $left;
    private $right;

    // Constructors ****************************************************************
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

    public function __construct1(T $d)
    {
        $this->data = $d;
        $this->left = null;
        $this->right = null;
    }
    // Setters *********************************************************************
    public function setData($d)
    {
        $this->data = $d;
    }
    public function setLeft(BTNode $L)
    {
        $this->left = $L;
    }
    public function setRight(BTNode $R)
    {
        $this->right = $R;
    }
    // Getters **********************************************************************
    public function getData() : T
    {
        return $this->data;
    }
    public function getLeft() : BTNode
    {
        return $this->left;
    }
    public function getRight() : BTNode
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
        $leftHeight = 0;
        $rightHeight = 0;

        // Check the left height
        if ($this->hasLeft())
        {
            $leftHeight = $this->left->height();
        }
        else
        {
            $leftHeight = -1;
        }

        // Check the right height
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
        $leftSize = 0;
        $rightSize = 0;

        //Check left sizeBelow()
        if ($this->hasLeft())
        {
            $leftSize = $this->left->sizeBelow();
        }
        else
        {
            $leftSize = 0;
        }

        //Check right sizeBelow()
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
