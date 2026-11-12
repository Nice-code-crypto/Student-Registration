<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

$host = '127.0.0.1';
$dbname = 'university2_db';
$username = 'root';
$password = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];
    $old = $_POST;

    $fullname = trim($_POST['fullname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $dob = trim($_POST['dob'] ?? '');
    $programme = $_POST['programme'] ?? '';
    $level = $_POST['level'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $policy = isset($_POST['policy']) ? true : false;

   
    if (strlen($fullname) < 3 || strlen($fullname) > 80) {
        $errors[] = "Full name must be between 3 and 80 characters.";
    } elseif (!preg_match("/^[a-zA-ZÀ-ÿ\s'-]+$/", $fullname)) {
        $errors[] = "Full name contains invalid characters.";
    }

   
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }

    
    if (!preg_match('/^[6235789]\d{8}$/', $phone)) {
        $errors[] = "Telephone must be a valid 9-digit numeric format (e.g., 6XXXXXXXX).";
    }

   
    if (empty($dob)) {
        $errors[] = "Date of birth is required.";
    } else {
        $dobDate = new DateTime($dob);
        $today = new DateTime();
        if ($dobDate >= $today) {
            $errors[] = "Date of birth must be a valid past date.";
        }
    }


    if (empty($programme)) { $errors[] = "Please select a programme."; }
    if (empty($level)) { $errors[] = "Please select a level."; }
    if (empty($gender)) { $errors[] = "Please select a gender option."; }
    if (!$policy) { $errors[] = "You must agree to the registration policy."; }

    
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['old'] = $old;
        header("Location: index.php");
        exit();
    }

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

       
        $stmtCheck = $pdo->prepare("SELECT id FROM lab01_students WHERE email = ?");
        $stmtCheck->execute([$email]);
        if ($stmtCheck->rowCount() > 0) {
            $_SESSION['errors'] = ["This email address is already registered."];
            $_SESSION['old'] = $old;
            header("Location: index.php");
            exit();
        }

       
        $sql = "INSERT INTO lab01_students (fullname, email, phone, dob, programme, level, gender) 
                VALUES (:fullname, :email, :phone, :dob, :programme, :level, :gender)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':fullname' => $fullname,
            ':email' => $email,
            ':phone' => $phone,
            ':dob' => $dob,
            ':programme' => $programme,
            ':level' => $level,
            ':gender' => $gender
        ]);

        echo "<div style='text-align:center; margin-top:50px; font-family:Arial;'>";
        echo "<h2 style='color:green;'>Registration Successful!</h2>";
        echo "<p>Your record has been safely stored with timestamp.</p>";
        echo "<a href='index.php' style='display:inline-block; margin-top:20px; padding:10px 20px; background:#003366; color:#fff; text-decoration:none; border-radius:4px;'>Back to Form</a>";
        echo "</div>";

    } catch (PDOException $e) {
        echo "<h3 style='color:red;'>Database Error: " . $e->getMessage() . "</h3>";
    }
}