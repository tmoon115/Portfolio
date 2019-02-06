--
--Problem 2: Palindrome
--Tyler Moon
--CSCI 4200-DA
--Dr. Abi Salimi
--
with Ada.Text_IO, Ada.Strings.Equal_Case_Insensitive;
use Ada.Text_IO;

procedure Moon_palindrome is
   
   -- The function to reverse the string, using a loop that reads the string 
   -- backwards and stores it in Result
   function reverseString (Text : String) return String is
      Result : String (Text'Range);
   begin
      for i in Text'range loop
         Result (Result'Last - i + Text'First) := Text(i);
      end loop;
      return Result;
   end reverseString;
   
   -- The procedure to get user input, call reverseString function, and check
   -- for equality
   procedure Palindrome is
      userInput : String := Get_Line;
      reverseText : String := reverseString(userInput);
   begin
      New_Line;
      Put_Line("Reverse: " & reverseText);
      New_Line;
      
      -- Using case insensitive so capitalization does not matter
      if Ada.Strings.Equal_Case_Insensitive(userInput, reverseText)  then
            Put_Line("""" & userInput & """ IS a Palindrome!");
         else
            Put_Line("""" & userInput & """ is NOT a Palindrome!");
      end if;
   end Palindrome;

-- The main begins prompting user and then calls Palindrome procedure
begin
   Put_Line("Enter a string: ");
   Palindrome;
   New_Line;
   
end Moon_palindrome;
