<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "webproject";

$conn = new mysqli($hostname, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

if (empty($email) || empty($password)) {
    echo "<script>alert('Please fill all the boxes.');</script>";
    echo "<script>window.location.href = 'login.html';</script>";
} else {
    $checkQuery = "SELECT * FROM logininfo WHERE email='$email'";
    $result = $conn->query($checkQuery);

    if ($result->num_rows > 0) {
        echo "<script>alert('Username already exists. Please choose a different username.');</script>";
        echo "<script>window.location.href = 'login.html';</script>";
    } else {
        $insertQuery = "INSERT INTO logininfo (email, password) VALUES ('$email', '$password')";

        if ($conn->query($insertQuery) === TRUE) {

            echo "<script>alert('Record added successfully. Please Login');</script>";
            echo "<script>window.location.href = 'login.html';</script>";
            exit();
        } else {
            echo "<script>alert('Error: " . $insertQuery . "<br>" . $conn->error . "');</script>";
        }
    }
}
$conn->close();


?>


