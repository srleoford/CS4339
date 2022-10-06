public class Tokenizer {

    private char[] e; //char array containing input file characters
    private int i; //index of the current character
    char currentChar; //the actual current character

    public Tokenizer(String s) {
        // constructor
        e = s.toCharArray();
        i = 0;
    }

    public Token nextToken() {
        // skip blanklike characters
        while (i < e.length && " \n\t\r".indexOf(e[i]) >= 0) {
            i++;
        }
        if (i >= e.length) {
            return new Token(TokenType.EOF);
        }
        // check for INT
        String inputString = "";
        while (i < e.length && "0123456789".indexOf(e[i]) >= 0) {
            inputString += e[i++];
        }
        if (!"".equals(inputString)) {
            return new Token(TokenType.INT, inputString);
        }
        // We're left with strings or one character tokens
        switch (e[i++]) {
            case '[':
                return new Token(TokenType.LSQUAREBRACKET,"[");
            case ']':
                return new Token(TokenType.RSQUAREBRACKET,"]");
            case '-':
                return new Token(TokenType.DASH,"-");
            case ',':
                return new Token(TokenType.COMMA,",");
            case '"':
                String value="";
                while (i<e.length && e[i]!='"'){
                    char c=e[i++];
                    if (i>=e.length)
                        return new Token(TokenType.OTHER);
                    // check for escaped double quote
                    if (c=='\\' && e[i]=='"'){
                        c='"';
                        i++;
                    }
                    value+=c;
                } 
                i++;
                return new Token(TokenType.STRING, value);                
        }
        // OTHER should result in exception
        return new Token(TokenType.OTHER);
    }
}