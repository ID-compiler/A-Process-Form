<?php
// Database connection settings
$servername = "localhost";
$username = "root"; // Set your own MySQL username
$password = ""; // Set your MySQL password
$dbname = "student_management"; // Name of the database

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create the database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully<br>";
} else {
    echo "Error creating database: " . $conn->error;
}

// Select the database
$conn->select_db($dbname);

// Create the Student table
$createStudentTable = "
CREATE TABLE IF NOT EXISTS Student (
    student_id VARCHAR(10) PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    dob DATE NOT NULL,
    gender VARCHAR(10) NOT NULL,
    address TEXT NOT NULL,
    mobile VARCHAR(15) NOT NULL,
    email VARCHAR(100) NOT NULL,
    department VARCHAR(50) NOT NULL
)";
if ($conn->query($createStudentTable) === TRUE) {
    echo "Student table created successfully<br>";
} else {
    echo "Error creating Student table: " . $conn->error;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $student_id = $_POST['student_id'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $department = $_POST['department'];

    // Insert data into the Student table
    $insertStudent = "INSERT INTO Student (student_id, name, dob, gender, address, mobile, email, department)
                      VALUES ('$student_id', '$name', '$dob', '$gender', '$address', '$mobile', '$email', '$department')";
    if ($conn->query($insertStudent) === TRUE) {
        echo "New record created successfully<br>";
    } else {
        echo "Error: " . $insertStudent . "<br>" . $conn->error;
    }
}

// CRUD: Fetch and display all student details
$fetchStudents = "SELECT * FROM Student";
$result = $conn->query($fetchStudents);

if ($result->num_rows > 0) {
    echo "<h2>Student Records:</h2>";
    while ($row = $result->fetch_assoc()) {
        echo "ID: " . $row["student_id"] . " - Name: " . $row["name"] . " - Department: " . $row["department"] . "<br>";
    }
} else {
    echo "No records found<br>";
}

// Close connection
$conn->close();
?>
