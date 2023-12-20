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

$cardName = sanitizeInput(isset($_POST['card-name']) ? $_POST['card-name'] : '');
$cardNumber = sanitizeInput(isset($_POST['card-num']) ? $_POST['card-num'] : '');
$expiryDate = sanitizeInput(isset($_POST['expiry-data']) ? $_POST['expiry-data'] : '');
$cvc = sanitizeInput(isset($_POST['cvc']) ? $_POST['cvc'] : '');
$totalAmount = sanitizeInput(isset($_POST['totalAmount']) ? $_POST['totalAmount'] : '');

if (empty($cardName) || empty($cardNumber) || empty($expiryDate) || empty($cvc)) {
    echo "<script>alert('Please fill all the required fields.');</script>";
} else {
    $query = "INSERT INTO paymentdetails (Name, CardNum, Edate, cvc, amount) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssi", $cardName, $cardNumber, $expiryDate, $cvc, $totalAmount);

    if ($stmt->execute()) {
        echo "<script>alert('Payment successfull. Thank you for your purches');</script>";
        echo "<script>window.location.href='index.html';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
