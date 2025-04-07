<?php
// Array to store names of students
$students = array("Aasiya", "Aysha", "Nouri", "Fidha", "Adhila");

// Display the original list of student names
echo "<h3>Original List of Students:</h3>";
print_r($students);

// Sort the array in ascending order and display it
asort($students);
echo "<h3>List of Students in Ascending Order:</h3>";
print_r($students);

// Sort the array in descending order and display it
arsort($students);
echo "<h3>List of Students in Descending Order:</h3>";
print_r($students);
?>