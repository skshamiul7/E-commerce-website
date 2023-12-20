<?php

$hostname = "localhost";
$username = "root";
$password = "";
$database = "webproject";

$conn = new mysqli($hostname, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function sanitizeInput($input)
{
    return htmlspecialchars(stripslashes(trim($input)));
}

$email = sanitizeInput(isset($_POST['email']) ? $_POST['email'] : '');
$password = sanitizeInput(isset($_POST['password']) ? $_POST['password'] : '');

if (empty($email) || empty($password)) {
    echo "<script>
            alert('Please fill all the boxes.');
            window.location.href = 'login.html'; 
          </script>";
} else {
    $query = "SELECT * FROM logininfo WHERE email=? AND password=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>
                alert('Login successful!');
                window.location.href = 'index.html';
              </script>";
    } else {
        echo "<script>
                alert('Invalid username or password. Please try again....');
                window.location.href = 'login.html';
              </script>";
    }
}

//$stmt->close();
$conn->close();

?>

