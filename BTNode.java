/**** This class defines the blueprint of a node that wraps information of a generic type T, 
 **** and that has 2 links to 2 potential "children" called left and right.
 ****/

public class BTNode<T> {
    
    private T data;
    private BTNode<T> left;
    private BTNode<T> right;
    
    // Constructors ****************************************************************
    public BTNode() {}
    
    public BTNode(T d) {
        data = d;
        left = null;
        right = null;
    }
    
    // Setters *********************************************************************
    public void setData(T d) {
        data = d;   
    }
    
    public void setLeft(BTNode<T> L) {
        left = L;
    }
    
    public void setRight(BTNode<T> R) {
        right = R;
    }
    
    // Getters **********************************************************************
    public T getData() {
        return data;   
    }
    
    public BTNode<T> getLeft() {
        return left;   
    }
    
    public BTNode<T> getRight() {
        return right;   
    }
    
    // Other methods ***************************************************************
    /* printNode prints the content of the current node */
    public void printNode() {
        if (data == null)
            System.out.println("?");
        else
            System.out.println(data.toString());
    }

    /* Height computes the height of the current node */
    public int height() {
        int leftHeight, rightHeight;
        if (hasLeft()) 
            leftHeight = left.height();
        else leftHeight = -1;
        if (hasRight()) 
            rightHeight = right.height();
        else rightHeight = -1;
        return 1 + Math.max(leftHeight, rightHeight);
    }
    
    public int sizeBelow() {
        int leftSize, rightSize;
        if (hasLeft()) 
            leftSize = left.sizeBelow();
        else leftSize = 0;
        if (hasRight()) 
            rightSize = right.sizeBelow();
        else rightSize = 0;
        return 1 + leftSize + rightSize;
    }

    public boolean hasLeft() {
        return this.getLeft() != null;
    }
    
    public boolean hasRight() {
        return this.getRight() != null;
    }
}