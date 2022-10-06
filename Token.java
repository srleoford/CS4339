public class Token {
    TokenType type;
    String value;
    
    Token(TokenType theType){
        type = theType;
        value = "";
    }
    Token (TokenType theType, String theValue){
        type = theType;
        value = theValue;
    }
    String printToken(){
        System.out.println(type+value);
        switch (type) {
            case LSQUAREBRACKET:
                return "LSQUAREBRACKET";
            case RSQUAREBRACKET:
                return "RSQUAREBRACKET";   
            case DASH:
                return "DASH";
            case COMMA:
                return "COMMA";
            case INT:
                return "INT "+value;
            case STRING:
                return "STRING "+value;
            default:
                return "OTHER";
        }
    } 
}
