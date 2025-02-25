<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "leather_shop";

// Connect to database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle Sign Up
if (isset($_POST['signup'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password

    // Insert user data into database
    $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
    if ($conn->query($sql) === TRUE) {
        echo "Registration successful. You can now log in.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle Sign In
if (isset($_POST['signin'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Retrieve user data
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            echo "Login successful. Welcome " . $row['name'] . "!";
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found with this email.";
    }
}

// Close connection
$conn->close();
?>
