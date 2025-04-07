<!DOCTYPE html>
<html>
<head>
    <title>Registration Form</title>
    <link rel="stylesheet" href="1.css">
</head>
<body>
<div class="form-container">
    <h2>Registration Form</h2>
    <form method="POST">
        <!-- Name -->
        <label for="username">Name</label>
        <input type="text" name="username" id="username"><br><br>
        
        <!-- Email -->
        <label for="email">Email</label>
        <input type="text" name="email" id="email"><br><br>
        
        <!-- Password -->
        <label for="password">Password</label>
        <input type="password" name="password" id="password"><br><br>
        
        <!-- Submit Button -->
        <input type="submit" value="Register">
        <!-- Reset Button -->
        <input type="reset" value="Reset">
    </form>

    <!-- Error Messages Display -->
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];

        $errors = []; // Collect errors into an array

        // Validate fields
        if (empty($username) || empty($email) || empty($password)) {
            $errors[] = "All fields are required!";
        } elseif (preg_match('/[0-9]/', $username)) {
            $errors[] = "Username must not contain numbers!";
        } elseif (!strpos($email, "@")) {
            $errors[] = "Invalid email! Email must contain '@'.";
        } elseif (strlen($password) <= 6) {
            $errors[] = "Password must be more than 6 characters!";
        }

        // Display errors
        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo "<p style='color:red;'>$error</p>";
            }
        } else {
            echo "<p style='color:green;'>Registration successful!</p>";
        }
    }
    ?>
</div>
</body>
</html>