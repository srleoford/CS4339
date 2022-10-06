import java.net.URL;
import java.io.*;
/**
 * @author Luc Longpre for Secure Web-Based Systems, Fall 2022
 *
 * This program parses a family tree input file
 * builds the binary tree data structure
 * and displays the family tree.
 * (It is modification of a CS 2401 binary tree assignment for a Spring 2019 course I taught with Dr. Ceberio)
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
public class Fall22JavaProg {
  
    static Token currentToken;
    static Tokenizer t;
    static String EOL=System.lineSeparator(); // new line, depends on OS

    public static void main(String[] args) throws Exception {
        // open the URL into a buffered reader,
        // print the header,
        // parse each section, printing a formatted version
        //     followed by the result of the execution
        // print the footer.
        
// To get input from localhost        
        String inputSource;
        inputSource = "http://localhost/4339_f22_assignment1/cs4339Fall22family.txt";
        URL inputUrl = new URL(inputSource);
        BufferedReader in = new BufferedReader(new InputStreamReader(inputUrl.openStream()));
// To get input from a local file
        //FileReader fr = new FileReader("cs4339Fall22family.txt");
        //BufferedReader in = new BufferedReader(fr);
        String header = "<html>"+EOL
                + "  <head>"+EOL
                + "    <title>CS 4339/5339 PHP assignment</title>"+EOL
                + "  </head>"+EOL
                + "  <body>"+EOL
                + "    <pre>";
        String footer = "    </pre>"+EOL
                + "  </body>"+EOL
                + "</html>";
        String inputLine;
        String inputFile = "";
        while ((inputLine = in.readLine()) != null) {
            inputFile += inputLine + EOL;
        }
        //System.out.println(inputFile);
        t = new Tokenizer(inputFile);
        System.out.println(header);
        currentToken = t.nextToken();
        int section = 0;
        
        // Loop through all sections, for each section printing result
        // If a section causes exception, catch and jump to next section
        while (currentToken.type != TokenType.EOF) {
            //currentToken.printToken();
            // = t.nextToken();
            System.out.println("section " + ++section);
            try {
                evalSection();
            } catch (EvalSectionException ex) {
//                // skip to the end of section
                while (currentToken.type != TokenType.RSQUAREBRACKET
                        && currentToken.type != TokenType.EOF) {
                    currentToken = t.nextToken();
                }
                currentToken = t.nextToken();
            }
        }
        System.out.println(footer);
    }

    static void evalSection() throws EvalSectionException {
        // <section> ::= '[' <member>* ']'
        if (currentToken.type != TokenType.LSQUAREBRACKET) {
            throw new EvalSectionException("A section must start with \"[\","
                    + "found " + currentToken.printToken());
        }
        System.out.println("[");
        currentToken = t.nextToken();
        BTree<FamilyMember> tree = new BTree<>();
        while (currentToken.type != TokenType.RSQUAREBRACKET
                && currentToken.type != TokenType.EOF) {
            processMember(tree);
        }
        System.out.println("tree height: "+tree.getHeight());
        System.out.println("tree size: "+tree.getSize());
        tree.print();
        System.out.println("]");
        currentToken = t.nextToken();
        //System.out.println("next Token:"+currentToken.printToken());
    }
    static void processMember(BTree<FamilyMember> tree) throws EvalSectionException {
        // <member> ::= STRING '-' STRING ',' INT ',' STRING
        if (currentToken.type != TokenType.STRING) {
            currentToken.printToken();
            throw new EvalSectionException("A member must start with a String");
        }
        String firstName=currentToken.value;
        currentToken = t.nextToken();
        if (currentToken.type != TokenType.DASH) {
            throw new EvalSectionException("First name and last name must be separated by a dash");
        }
        currentToken = t.nextToken();  
        if (currentToken.type != TokenType.STRING) {
            throw new EvalSectionException("A String was expected for last name");
        }
        String lastName=currentToken.value;  
        currentToken = t.nextToken();      
        if (currentToken.type != TokenType.COMMA) {
            throw new EvalSectionException("A comma was expected");
        }
        currentToken = t.nextToken();  
        if (currentToken.type != TokenType.INT) {
            throw new EvalSectionException("An integer was expected");
        }
        int siblings=Integer.parseInt(currentToken.value);  
        currentToken = t.nextToken();
        if (currentToken.type != TokenType.COMMA) {
            throw new EvalSectionException("A comma was expected");
        }
        currentToken = t.nextToken();
        if (currentToken.type != TokenType.STRING) {
            System.out.println(currentToken.type);
            throw new EvalSectionException("A string was expected for tree path");
        }
        String treePath=currentToken.value;          
        if (!treePath.matches("^[FMR]+$")) {
          // string contains a character other than F, M and/or R
            throw new EvalSectionException("Only 'F', 'M' and 'R' in tree path");
        }
        FamilyMember m = new FamilyMember(firstName, lastName, siblings);
        tree.insertData(treePath,m);
        currentToken = t.nextToken(); 
    }    
}