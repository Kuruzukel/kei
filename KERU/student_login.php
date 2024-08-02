<?php
session_start();
include('connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['studentId'];
    $password = $_POST['password'];

    // Prepare and bind
    $stmt = $conn->prepare("SELECT * FROM student_list WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $student_id, $password);

    // Execute statement
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['student_id'] = $student_id ;
        echo "Login successful. Welcome, Student ID: $student_id";
        header("location: dashboard.html");
    } else {
        echo "Invalid Student ID or Password.";
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
    <meta name="viewport" content="width=device-width, initial-scale=0.5">
</head>
<body>
<div class="background"></div>

<div class="overlay-box">

    <h2 class="overlay-heading">BSIS GRADING SYSTEM</h2>
    <h1>Student Login</h1>
    <form method="POST" action="">
        <label for="studentId"><i class="fas fa-user-cog"></i> Student ID:</label>
        <input type="number" id="studentId" name="studentId" placeholder="Enter your student ID" maxlength="4" autocomplete="off" required><br>
        <label for="password"><i class="fas fa-lock"></i> Password:</label>
        <div class="password-input-container">
            <input type="password" id="password" name="password" placeholder="Enter your password" maxlength="8" autocomplete="off" required><br>
            <i class="fas fa-eye" id="togglePassword"></i>
        </div>
        <button type="submit">Login</button>
        
        <img src="PP2.png" alt="Logo" class="logo">
        

    </form>
</div>

<script>
    document.getElementById('studentId').addEventListener('input', function () {
        if (this.value.length > 4) {
            this.value = this.value.slice(0, 4);
        }
    });

    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');

    togglePassword.addEventListener('click', function () {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.classList.toggle('fa-eye-slash');
    });
</script>
</body>
</html>
