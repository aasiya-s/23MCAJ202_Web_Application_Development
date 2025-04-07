<!DOCTYPE html>
<html>
<head>
    <title>Indian Cricket Players</title>
    <style>
         /* body-styles */
 body {
    font-family: Arial, Helvetica, sans-serif;
    background:rgb(170, 192, 165);
    padding: 0;
}
    </style>
</head>
<body>
    <?php
    // Array to store names of Indian Cricket players
    $players = array("Virat Kohli", "MS Dhoni", "Rohit Sharma", "Sachin Tendulkar", "Yuvraj Singh");

    // Display the names in an HTML table
    echo "<h2>List of Indian Cricket Players</h2>";
    echo "<table border='1' style=' width: 30%; text-align: left;'>";
    echo "<tr><th>Player Name</th></tr>";
    foreach ($players as $player) {
        echo "<tr><td>$player</td></tr>";
    }
    echo "</table>";
    ?>
</body>
</html>