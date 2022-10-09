<?php
require_once "BTNode.php";

class BTree {

    private BTNode $root;
    private int $size;
    private int $height;

    public function getSize() : int
    {
        return $this->size;
    }

    public function getHeight() : int
    {
        return $this->height;
    }

    public function resetSize()
    {
        $this->size = $this->root->sizeBelow();
    }

    public function resetHeight()
    {
        $this->height = $this->root->height();
    }

    public function print()
    {
        preOrderTraversal();
    }

    public function insertData(string $treePath, $data): void
    {
        try
        {
            if(!strcmp($treePath, "R"))
            {
                $this->root = new BTNode($data);
                $this->resetSize();
                $this->getHeight();
                return;
            }

            if ($this->root == null)
            {
                $this->root = new BTNode(null);
            }
            // Type of BTNode
            $iter = $this->root;

            $treePath = str_split($treePath);
            // Follow the tree path
            for ($j = 0; $j < count($treePath) - 1; $j++)
            {
                switch ($treePath[$j])
                {
                    case 'F':
                        if(!$iter.hasLeft())
                            $iter.setLeft(new BTNode(null));
                        $iter = $iter.getLeft();
                        break;
                    case 'M':
                        if(!$iter.hasRight())
                            $iter.setRight(new BTNode(null));
                        $iter = $iter.getRight();
                        break;
                    default:
                        throw EvalSectionException("'F' or 'M' expected in treepath");
                }
            }

            // Let's build the node to be plugged
            $N = new BTNode($data);

            if ($treePath[count($treePath) - 1] == 'F')
            {
                $iter.setLeft($N);
            }

            if ($treePath[count($treePath) - 1] == 'M')
            {
                $iter.setRight($N);
            }
            $this->resetSize();
            $this->resetHeight();
        }
        catch (EvalSectionException $e)
        {
            print(PHP_EOL . "Parsing or execution Exception: " . $e->getMessage() . PHP_EOL);
        }
    }

    public function preOrderTraversal()
    {
        $this->preOrderTraversalByLevel($this->root, 0);
    }

    function preOrderTraversalByLevel(BTNode $node, int $level)
    {
        for ($i = 0; $i < $level; $i++)
            echo '  ';
        if ($node == null)
        {
            print("[]" . PHP_EOL);
            return;
        }
        $node.printNode();
        $this->preOrderTraversalByLevel($node->getLeft(), $level+1);
        $this->preOrderTraversalByLevel($node->getRight(), $level+1);
    }
}