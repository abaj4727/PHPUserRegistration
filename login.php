<?php
include "Database\db_config.php";
?>
<div class="card-header">
      <h2>Login</h2>
    </div>
<div class="card-body">
    <form action="login.php" method="post">

        <label>Email</label><br>
        <input type="text" id="email" name="email"><br>
        <label>Password</label><br>
        <input type="text" id="password" name="password"><br>
        <button type="submit">Register</button>
    </form>
</div>


<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Trim and sanitize input
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    if (empty($email) || empty($password)) {
        echo "Email and password are required.";
        exit;
    }
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            echo "Welcome, " . htmlspecialchars($row['username']) . "!";
            session_start();
            $_SESSION['user_id'] = $row['id'];
             $_SESSION['email'] = $row['email'];
             header("Location: index.php");
             exit;
        } else {
            echo "Invalid email or password.";
        }
    } else {
        echo "Invalid email or password.";
    }
    $stmt->close();
    $conn->close();
}
?>
