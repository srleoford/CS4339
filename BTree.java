
public class BTree<T> {

    private BTNode<T> root;
    private int size;
    private int height;
    
//    public BTree() {}
//    
//    public BTree(BTNode<T> N) {
//        root = N;
//        size = N.sizeBelow();
//        height = N.height();
//    }
//    
//    public void setRoot(BTNode<T> N) {
//        root = N;
//        size = N.sizeBelow();
//        height = N.height();
//    }
//
//    public BTNode<T> getRoot() {
//        return root;   
//    }
    public int getSize() {
        return size;   
    }

    public int getHeight() {
        return height;   
    }

    public void resetSize() {
        size = root.sizeBelow();
    }

    public void resetHeight() {
        height = root.height();
    }
    
    public void print() {
        preOrderTraversal();
    }

    public void insertData(String treePath, T data) throws EvalSectionException { 
        // if treePath = "R", it means that the data to insert will be the root
        if (treePath.equals("R")) {
            root = new BTNode<T>(data);
            resetSize();
            resetHeight();
            return;
        }
        
        if (root == null){
            root = new BTNode(null);
        }
        BTNode<T> iter = root;
        // And now we follow the tree path:
        for (int j = 0; j < treePath.length() - 1; j++) {
            switch (treePath.charAt(j)) {
                case 'F':
                    if (!iter.hasLeft())
                        iter.setLeft(new BTNode(null));
                    iter = iter.getLeft();
                    break;
                case 'M':
                    if (!iter.hasRight())
                        iter.setRight(new BTNode(null));
                    iter = iter.getRight();
                    break;
                default:
                    throw new EvalSectionException("'F' or 'M' expected in treepath");
            }
        }   
        // Let's build the node to be plugged
        BTNode<T> N = new BTNode<T>(data);
 
        if (treePath.charAt(treePath.length()-1) == 'F') {
            iter.setLeft(N);   
        }
        if (treePath.charAt(treePath.length()-1) == 'M') {
            iter.setRight(N);   
        }
        resetSize();
        resetHeight();
    }

    public void preOrderTraversal() {
        preOrderTraversal(root,0);  
    }
    void preOrderTraversal(BTNode<T> node, int level) {
        for (int i=0; i<level; i++)
            System.out.print("  ");        
        if (node == null) {
            System.out.println("[]");
            return;
        } 
        node.printNode();        
        preOrderTraversal(node.getLeft(), level+1);
        preOrderTraversal(node.getRight(), level+1);
    }   
    
}