<?php
// Enable error reporting for debugging
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Step 1: Connect to the Database
$conn = new mysqli('localhost', 'root', '', 'webexp'); // Adjust username/password if needed

// Check connection
if ($conn->connect_error) {
    die("<p style='color: red;'>Database connection failed: " . $conn->connect_error . "</p>");
}

// Initialize message variable
$successMessage = "";

// Step 2: Add Book to the Database
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_book'])) {
    $accession_number = $_POST['accession_number'];
    $title = $_POST['title'];
    $authors = $_POST['authors'];
    $edition = $_POST['edition'];
    $publisher = $_POST['publisher'];

    // Check for duplicate entry before inserting
    $check_stmt = $conn->prepare("SELECT accession_number FROM books WHERE accession_number = ?");
    $check_stmt->bind_param("i", $accession_number);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        // Book already exists message
        $successMessage = "<p style='color: red;'>Book already exists in the database!</p>";
    } else {
        // Insert new record
        $stmt = $conn->prepare("INSERT INTO books (accession_number, title, authors, edition, publisher) VALUES (?, ?, ?, ?, ?)");
        if (!$stmt) {
            die("<p style='color: red;'>Prepare failed: " . $conn->error . "</p>");
        }

        $stmt->bind_param("issss", $accession_number, $title, $authors, $edition, $publisher);
        
        if ($stmt->execute()) {
            $successMessage = "<p style='color: green;'>Book added successfully!</p>";
        } else {
            $successMessage = "<p style='color: red;'>Error: " . $stmt->error . "</p>";
        }

        $stmt->close();
    }

    $check_stmt->close();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Book Management</title>
    <link rel="stylesheet" href="1.css">
</head>
<body>

    <div class="form-container">
        <h1>Book Management System</h1>

        <!-- Display success message inside the container -->
        <?php echo $successMessage; ?>

        <!-- Form to Add Book -->
        <h2>Add a New Book</h2>
        <form method="POST">
            <label>Accession Number:</label><br>
            <input type="number" name="accession_number" required><br> <!-- Ensured it's a number -->
            <label>Title:</label><br>
            <input type="text" name="title" required><br>
            <label>Authors:</label><br>
            <input type="text" name="authors"><br>
            <label>Edition:</label><br>
            <input type="text" name="edition"><br>
            <label>Publisher:</label><br>
            <input type="text" name="publisher"><br>
            <button type="submit" name="add_book">Add Book</button>
        </form>

        <!-- Form to Search Book -->
        <h2>Search for a Book</h2>
        <form method="GET">
            <label>Book Title:</label><br>
            <input type="text" name="search_title" required><br>
            <button type="submit" name="search_book">Search</button>
        </form>

        <?php
        // Step 3: Search for Books by Title
        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['search_book'])) {
            $search_title = $_GET['search_title'];

            // Use prepared statement for search query
            $stmt = $conn->prepare("SELECT * FROM books WHERE title LIKE ?");
            if (!$stmt) {
                die("<p style='color: red;'>Prepare failed: " . $conn->error . "</p>");
            }

            $search_param = "%$search_title%";
            $stmt->bind_param("s", $search_param);
            $stmt->execute();
            $result = $stmt->get_result();

            echo "<h2>Search Results:</h2>";
            if ($result->num_rows > 0) {
                echo "<table border='1'>
                        <tr>
                            <th>Accession Number</th>
                            <th>Title</th>
                            <th>Authors</th>
                            <th>Edition</th>
                            <th>Publisher</th>
                        </tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row['accession_number']) . "</td>
                            <td>" . htmlspecialchars($row['title']) . "</td>
                            <td>" . htmlspecialchars($row['authors']) . "</td>
                            <td>" . htmlspecialchars($row['edition']) . "</td>
                            <td>" . htmlspecialchars($row['publisher']) . "</td>
                          </tr>";
                }
                echo "</table>";
            } else {
                echo "<p style='color: red;'>No books found with the title '$search_title'.</p>";
            }

            $stmt->close();
        }
        ?>

    </div>

</body>
</html>

<?php
// Close the connection properly
$conn->close();
?>