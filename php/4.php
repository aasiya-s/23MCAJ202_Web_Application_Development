<?php
// Database connection details
$host = 'localhost';
$user = 'root'; 
$password = ''; 
$dbname = 'webexp'; // 
// Connect to the database
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from the  table
$sql = "SELECT id, name, age FROM student";
$result = $conn->query($sql);

// Display data
echo "<h1>Student Details</h1>";
echo "<table border='1' style=' width: 30%; text-align: left;'>";
echo "<tr><th>ID</th><th>Name</th><th>Age</th></tr>";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row['id'] . "</td><td>" . $row['name'] . "</td><td>" . $row['age'] . "</td></tr>";
    }
} else {
    echo "<tr><td colspan='3'>No data found</td></tr>";
}

echo "</table>";

// Close the connection
$conn->close();
?>