/*
 * Lexical Analyzer
 * Tyler Moon
 * CSCI 4200-DA
 * Dr. Abi Salimi
 */

package lexicalAnalyzerPackage;

import java.io.BufferedReader;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.Reader;

class LexicalAnalyzer 
{
	/* Declaring constants */
	private static final int LEXLENGTH = 100, LETTER = 0, DIGIT = 1, UNKNOWN = 99, END_FILE = 98;
	
	/* Declaring Global Variables */
	private static int charClass, lexLen, lexCharCount = 0;
	private static String nextToken,fileLine;
	private static char[] lexeme = new char[LEXLENGTH];
	private static char nextChar;
	private static BufferedReader lineRead;
	private static boolean endOfLine = false;
	
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
	
	public static void main(String[] args) throws IOException 
	{
		try {
		//Reading the input file from the package
		InputStream lexInput = new FileInputStream("src/lexicalAnalyzerPackage/lexInput.txt");
		Reader lexInputReader = new InputStreamReader(lexInput);
		lineRead = new BufferedReader(lexInputReader);
		
		System.out.println("Tyler C. Moon, CSCI4200-DA, Fall 2018, Lexical Analyzer");
	
		fileLine = lineRead.readLine();
		
		while (fileLine != null)
		{
			System.out.println("********************************************************************************\n");
			System.out.println("Input: " + fileLine);
			
			getChar();
			do
			{
				lex();
					
			} while (endOfLine != true);
				
			endOfLine = false;
			lexCharCount = 0;
			
			fileLine = lineRead.readLine();
		}
		charClass = END_FILE;
		lex();
		
		System.out.println("********************************************************************************\n");
		cleanPrint();
		System.out.println();
		System.out.println("Lexical analysis of the program is complete!");
		
		}catch (FileNotFoundException e)
		{
			System.out.println("Could not find the lexInput.txt file. Check the path in the main.");
		}
		
	}

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
			addChar();
			nextToken = EOF;
			break;
		}
		return nextToken;
	}
	
	/*********************************************************/
	/* addChar adds the next character to the lexeme */
	
	private static void addChar()
	{
		if (lexLen <= LEXLENGTH-2)
		{
			lexeme[lexLen++] = nextChar;
			lexeme[lexLen] = ' ';
		}
		else
			System.out.println("Error - lexeme is too long \n");
	}
	
	/* getChar gets the next character of input file and determine its character class */
	
	private static void getChar() throws IOException
	{
		nextChar = fileLine.charAt(lexCharCount);
		
		if(lexCharCount <= (fileLine.length()-1))
		{
			if (Character.isLetter(nextChar))
				charClass = LETTER;
			else if (Character.isDigit(nextChar))
				charClass = DIGIT;
			else
				charClass = UNKNOWN;
		}
	
		//Increment the charAt for the next getChar() call
		lexCharCount++;
	}
	
	/* getNonBlank is a method to call getChar until it returns a non-whitespace character*/
	
	private static void getNonBlank() throws IOException
	{
		while (Character.isWhitespace(nextChar))
		{
			getChar();
		}
	}
	
	/**
	 * @throws IOException *******************************************************/
	/* lex - simple lexical analyzer for arithmetic expressions*/
	
	private static String lex() throws IOException
	{
		lexLen = 0;
		getNonBlank();
		switch (charClass)
		{
		/* Parse identifiers */
		case LETTER:
			addChar();
			
			// Check at each case to see if endOfLine has been reached
			if (lexCharCount > (fileLine.length()-1))
			{
				endOfLine = true;
				break;
			}
			
			getChar();
			while (charClass == LETTER || charClass == DIGIT )
			{
				addChar();
				
				if (lexCharCount > (fileLine.length()-1))
				{
					endOfLine = true;
					break;
				}
				getChar();
			}
			nextToken = IDENT;
			break;
			
		/* Parse integer literals */
		case DIGIT:
			addChar();
			
			if (lexCharCount > (fileLine.length()-1))
			{
				endOfLine = true;
				break;
			}
			getChar();
			while (charClass == DIGIT)
			{
				addChar();
				
				if (lexCharCount > (fileLine.length()-1))
				{
					endOfLine = true;
					break;
				}
				getChar();
			}
			nextToken = INT_LIT;
			break;
			
		/* Parentheses and operators */
		case UNKNOWN:
			lookup(nextChar);
			
			if (lexCharCount > (fileLine.length()-1))
			{
				endOfLine = true;
				break;
			}
			getChar();
			break;
			
		/* EOF */
		case END_FILE:
			nextToken = EOF;
			lexeme[0] = 'E';
			lexeme[1] = 'O';
			lexeme[2] = 'F';
			lexeme[3] = ' ';
			break;
		}
		
		if (!nextToken.equals(EOF))
			cleanPrint();
		
		return nextToken;
	}/* End of lex() */
	
	
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