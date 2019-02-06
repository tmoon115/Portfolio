/*
 * Parser Assignment
 * Tyler Moon
 * CSCI 4200-DA
 * Dr. Abi Salimi
 */

package parserPackage;
import java.io.*;

public class Parse 
{

	/* Declaring constants */
	private static final int LEXLENGTH = 100, LETTER = 0, DIGIT = 1, UNKNOWN = 99, END_FILE = 98;
	
	/* Declaring Global Variables */
	private static int charClass, lexLen;
	private static String nextToken, fileLine;
	private static char[] lexeme = new char[LEXLENGTH];
	private static char nextChar;
	private static BufferedReader inputRead, characterRead;
	private static FileReader fileCharacters, fileInput;
	
	/* Token Codes */
	private static final String INT_LIT = "INT_LIT";
	private static final String IDENT = "IDENT";
	private static final String ASSIGN_OP = "ASSIGN_OP";
	private static final String ADD_OP = "ADD_OP";
	private static final String SUB_OP = "SUB_OP";
	private static final String MULT_OP = "MULT_OP";
	private static final String DIV_OP = "DIV_OP";
	private static final String LEFT_PAREN = "LEFT_PAREN";
	private static final String RIGHT_PAREN = "RIGHT_PAREN";
	private static final String EOF = "END_OF_FILE";
	
/********************************************************************/

	/*Open the input data file and process its contents*/
	public static void main(String[] args) throws FileNotFoundException 
	{
		
		fileCharacters = new FileReader("src\\parserPackage\\statements.txt");
		fileInput = new FileReader("src\\parserPackage\\statements.txt");
		
		characterRead = new BufferedReader(fileCharacters);
		inputRead = new BufferedReader(fileInput);
		
		System.out.println("Tyler C. Moon, CSCI4200-DA, Fall 2018, Parser");
		System.out.println("********************************************************************************\n");
		
		if (fileInput == null)
		{
			System.out.println("ERROR - cannot open statements.txt \n");
		}else
		{
			try
			{
				while(characterRead.ready())
				{
					fileLine = inputRead.readLine();
					System.out.println("Parsing the statement: " + fileLine + "\n");
					getChar();
					do{
						// gets first token for assign
						lex();
						
						// starts the recursive calls for the statement
						assign();
						
					}while(!nextToken.equals(EOF));
					
					System.out.println("");
					System.out.println("********************************************************************************");
					System.out.println("");
				}
				// End of file was detected, so prints the final message
				
				cleanPrint();
			
			} catch (IOException e) 
			{
				e.printStackTrace();
			}
		}
	}
	
/********************************************************************/
	
	// The assign method is entered, grabs the =, then gets the next token for expr()
		private static void assign() throws IOException
		{
			
			System.out.println("Enter <assign>");
			
			// Gets the '='
			lex();
			
			// First token after '=' to give to expr()
			lex();
			
			expr();
			
			System.out.println("Exit <assign>");
		}
		
		// expr() calls term and then goes into a loop if it's + or -
		private static void expr() throws IOException
		{
			
			System.out.println("Enter <expr>");
			term();
			
			while(nextToken == ADD_OP || nextToken == SUB_OP)
			{
				lex();
				term();
			}
			System.out.println("Exit <expr>");
			
		}
		
		// term() calls factor and then goes into a loop if it's * or /
		private static void term() throws IOException
		{
			
			System.out.println("Enter <term>");
			factor();
			
			while(nextToken == MULT_OP || nextToken == DIV_OP)
			{
				lex();
				factor();
			}
			System.out.println("Exit <term>");
			
		}
		
		private static void factor() throws IOException
		{
			
			System.out.println("Enter <factor>");
			
			if(nextToken == IDENT || nextToken == INT_LIT)
				lex();
			//for RHS being (<expr>), check for rigth paren after detecting left paren
			else 
			{
				if(nextToken == LEFT_PAREN)
				{
					lex();
					expr();
					
					if(nextToken == RIGHT_PAREN)
						lex();
					else
						error();
				}
				//it's not an identifier, integer, or a left paren, so error
				else
					error();
			}
			System.out.println("Exit <factor>");
			
		}
		
		private static void error()
		{
			System.out.println("Invalid syntax for parsing");
		}

/********************************************************************/
	/*lookup operators and parentheses and return their token value*/
	private static String lookup (char ch)
	{
		switch (ch)
		{
		case '(':
			addChar();
			nextToken = LEFT_PAREN;
			break;
			
		case ')':
			addChar();
			nextToken = RIGHT_PAREN;
			break;
			
		case '+':
			addChar();
			nextToken = ADD_OP;
			break;
			
		case '-':
			addChar();
			nextToken = SUB_OP;
			break;
			
		case '*':
			addChar();
			nextToken = MULT_OP;
			break;
			
		case '/':
			addChar();
			nextToken = DIV_OP;
			break;
			
		case '=':
			addChar();
			nextToken = ASSIGN_OP;
			break;
			
		default:
			lexeme[0] = 'E';
			lexeme[1] = 'O';
			lexeme[2] = 'F';
			lexeme[3] = ' ';
			lexLen = 4;
			nextToken = EOF;
			break;
		}
		return nextToken;
	}
	
/********************************************************************/
	
	/*adds next char to lexeme*/
	static void addChar(){
		
		if(lexLen <= (LEXLENGTH-2))
		{
			lexeme[lexLen++] = nextChar;
			lexeme[lexLen] = ' ';
		}else{
			System.out.println("ERROR - lexeme is too long \n");
		}
	}
	
/********************************************************************/
	
	/*get the next char of an input and determine its character class*/
	static void getChar()
	{
		
		char c = 0;
		try {
			c = (char)characterRead.read();
		} catch (IOException e) 
		{
			e.printStackTrace();
		}
		nextChar = c;
		if((int)nextChar != 0)
		{
			if(isalpha(nextChar))
			{
				charClass = LETTER;
			}else if(isdigit(nextChar))
			{
				charClass = DIGIT;
			}else
			{ 
				charClass = UNKNOWN;
			}
		}else
		{
			charClass = END_FILE;
		}
	}
	
/********************************************************************/
	
	/*call getChar function until it returns a non-whitespace character*/
	static void getNonBlank()
	{
		
		while(isspace(nextChar))
		{
			getChar();
		}
	}
	
/********************************************************************/
	
	static String lex()
	{
		
		lexLen = 0;
		getNonBlank();
		switch (charClass)
		{
		/*Parse identifiers */
		case LETTER:
			addChar();
			getChar();
			while(charClass == LETTER || charClass == DIGIT)
			{
				addChar();
				getChar();
			}
			nextToken = IDENT;
			break;
			
		/*Parse integer literals */
		case DIGIT:
			addChar();
			getChar();
			while(charClass == DIGIT){
				addChar();
				getChar();
			}
			nextToken = INT_LIT;
			break;
			
		/*Parentheses and operators*/
		case UNKNOWN:
			lookup(nextChar);
			getChar();
			break;
			
		/*End of the file*/
		case END_FILE:
			nextToken = EOF;
			lexeme[0] = 'E';
			lexeme[1] = 'O';
			lexeme[2] = 'F';
			lexeme[3] = ' ';
			lexLen = 4;
			break;
		}
		
		// prints if it is not EOF
		if (!nextToken.equals(EOF))
		{
			cleanPrint();
		}
		
		return nextToken;
	}
	

/********************************************************************/
	
	/*returns true if char is a letter*/
	static boolean isalpha(char c){
		
		int ascii = (int) c;
		if((ascii > 64 && ascii < 91) || (ascii > 96 && ascii < 123)){
			return true;
		}else {return false;}
	}
	
/********************************************************************/
	
	/*returns true if char is a digit*/
	static boolean isdigit(char c){
		
		int ascii = (int) c;
		if(ascii > 47 && ascii < 58){
			return true;
		}else {return false;}
	}
	
/********************************************************************/
	
	/*returns true if char is a space*/
	static boolean isspace(char c){
		
		int ascii = (int) c;
		if(ascii == 32){
			return true;
		}else {return false;}
	}
	
/********************************************************************/
	
	
	/* Prints the output in a clean format and prints the lexeme within the array */
	private static void cleanPrint()
	{
		int spaceAmount = 17;
		int longest = EOF.length();
		int spacing = longest + spaceAmount;
		
		int i = 0;
		String cleanLex = "";
		
		while (lexeme[i] != ' ' && i < LEXLENGTH-1)
		{
			cleanLex += lexeme[i];
			
			if (lexeme[i+1] == ' ')
				break;
			else
				i++;
		}
		
		System.out.println(String.format("%-" + spacing + "s%-" + spacing + "s",
				"Next token is: " + nextToken, "Next lexeme is " + cleanLex));
	}
	
}


