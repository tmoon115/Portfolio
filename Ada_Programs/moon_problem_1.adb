--
--Problem 1: List & Average
--Tyler Moon
--CSCI 4200-DA
--Dr. Abi Salimi
--
with Ada.Integer_Text_IO, Ada.Text_IO, Ada.Float_Text_IO;
use Ada.Integer_Text_IO, Ada.Text_IO, Ada.Float_Text_IO;

procedure moon_Problem_1 is
   
   procedure User_Input is
      
      -- Declare variables
      arraySize : constant Integer := 100;
      listLen : Integer;
      listElement : Integer;
      sum : Float := 0.0;
      average : Float := 0.0;
      count : Integer := 0;
      
      -- created an array sized 1 through 100
      listArray : array(1 .. arraySize) of Integer;
      
      
   begin
      -- get the initial number and use it in the for loop
      -- to read the others into the array
      Get(listLen);
  
      for i in 1 .. listLen loop
         Get(listElement);
         listArray(i) := listElement;
      end loop;
      
      New_Line;
      
      -- Output list
      Put_Line("The List: ");
      for i in 1 .. listLen loop
         Put(listArray(i));
      end loop;
      
      New_Line(2);
      
      -- Calculates the average by first getting the sum of numbers and prints it
      Put_Line("The Average: ");
      for i in 1 .. listLen loop
	sum := sum + Float(listArray(i));
      end loop;
 
      average := sum / Float(listLen);
      Put(average, 1, 2, 0);
      
      New_Line(2);
      
      -- Runs through list to see how many values are greater than the average
      Put("Number of values greater than the average: ");
      for i in 1 .. listLen loop
         if Float(listArray(i)) > average then
            count := count + 1;
         end if;
      end loop;
      Put(count, width => 3);
      
      New_Line(2);
      
   end User_Input;
   
begin
   -- The main program calling the User_Input procedure
   Put_Line("Enter number of integers followed by the integer values: ");
   User_Input;
end moon_Problem_1;
