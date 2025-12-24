<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Smart_wallet";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$sender_id = $_SESSION['user_id'];
$card_id = $_SESSION['card_id'] ?? null;
$amount = floatval($_POST['amount']);
$description = $_POST['description'] ?? '';
$receiver_email = $_POST['receiver_email'] ?? null;
$receiver_id = $_POST['receiver_id'] ?? null;



// Check if card exists and belongs to sender
$stmt = $conn->prepare("SELECT balance FROM cards WHERE Card_id = ? AND user_id = ?");
$stmt->bind_param("ii", $card_id, $sender_id);
$stmt->execute();
$stmt->bind_result($current_balance);
if (!$stmt->fetch()) {
    die("Card not found or does not belong to user.");
}
$stmt->close();

if ($current_balance < $amount) {
    die("Insufficient funds.");
}

// Deduct money from sender's card
$new_balance = $current_balance - $amount;
$stmt = $conn->prepare("UPDATE cards SET balance = ? WHERE Card_id = ?");
$stmt->bind_param("di", $new_balance, $card_id);
$stmt->execute();
$stmt->close();

// Add a corresponding expense transaction for the sender
$stmt = $conn->prepare("INSERT INTO expences_tracker (card_id, Expences, description, Date) VALUES (?, ?, ?, NOW())");
$stmt->bind_param("ids", $card_id, $amount, $description);
$stmt->execute();
$stmt->close();

if ($receiver_id) {

    // Get receiver main card
    $stmt = $conn->prepare(
        "SELECT Card_id FROM cards WHERE user_id = ? AND is_main = 1 LIMIT 1"
    );
    $stmt->bind_param("i", $receiver_id);
    $stmt->execute();
    $stmt->bind_result($receiver_card);
    $stmt->fetch();
    $stmt->close();

    if ($receiver_card) {

        // Add money to balance
        $stmt = $conn->prepare(
            "UPDATE cards SET balance = balance + ? WHERE Card_id = ?"
        );
        $stmt->bind_param("di", $amount, $receiver_card);
        $stmt->execute();
        $stmt->close();

        // Record income
        $stmt = $conn->prepare(
            "INSERT INTO incomes_tracker (card_id, Incomes, description, Date)
             VALUES (?, ?, ?, NOW())"
        );
        $stmt->bind_param("ids", $receiver_card, $amount, $description);
        $stmt->execute();
        $stmt->close();

        // OPTIONAL: send email
        sendMONEY($receiver_email, $amount, $_SESSION['user']);
    }
}


// Handle receiver
if ($receiver_email) {
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $receiver_email);
    $stmt->execute();
    $stmt->bind_result($receiver_id_found);
    $stmt->fetch();
    $stmt->close();
    $receiver_id = $receiver_id_found;
}

// Add to receiver's first card if user exists
if ($receiver_id) {
    $stmt = $conn->prepare("SELECT Card_id FROM cards WHERE user_id = ? LIMIT 1");
    $stmt->bind_param("i", $receiver_id);
    $stmt->execute();
    $stmt->bind_result($receiver_card);
    $stmt->fetch();
    $stmt->close();

    if ($receiver_card) {
        // Increase balance
        $stmt = $conn->prepare("UPDATE cards SET balance = balance + ? WHERE Card_id = ?");
        $stmt->bind_param("di", $amount, $receiver_card);
        $stmt->execute();
        $stmt->close();

        // Add income transaction
        $stmt = $conn->prepare("INSERT INTO incomes_tracker (card_id, Incomes, description, Date) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("ids", $receiver_card, $amount, $description);
        $stmt->execute();
        $stmt->close();
    }
}

// Redirect back to dashboard
header("Location: test.php?success=sent");
exit();
?>