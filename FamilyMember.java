public class FamilyMember implements Comparable<FamilyMember> {
    private String fname;
    private String lname;
    private int siblings;
    
    public FamilyMember() {}
    
    public FamilyMember(String fn, String ln, int s) {
        fname = fn;
        lname = ln;
        siblings = s;
    }

    public void setFName(String fn) {
        fname = fn;
    }
    
    public void setLName(String ln) {
        lname = ln;
    }
    
    public void setSiblings(int s) {
        siblings = s;
    }
    
    public String getFName() {
        return fname;   
    }
    
    public String getLName() {
        return lname;   
    }
    
    public int getSiblings() {
        return siblings;   
    }
    
    public String toString() {
        return fname + " " + lname + ", who had: " + siblings + " siblings.";   
    }
    
    @Override
    public int compareTo(FamilyMember fm) {
        int v1 = lname.compareTo(fm.lname);
        int v2 = fname.compareTo(fm.fname);
        int v3 = siblings<fm.siblings?-1:siblings>fm.siblings?1:0;
        if (v1!=0) return v1;
        if (v2!=0) return v2;
        return v3;
    }
}