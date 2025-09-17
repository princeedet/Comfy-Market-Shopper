<?php
session_start();
if (isset($_SESSION['user'])) {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comfy Market Shopper - Admin Login</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="img/Logo with wordmark.png"/>
</head>
<style>
    body {
        background: url('img/bg.png') repeat; /* use background pattern */
    }
</style>

<body>
    <div class="login-container">
        <div class="login-box">
            <div class="logo">
                <img src="img/Logo with wordmark.png" alt="Comfy Market Shopper" />
                <h2>Admin Portal</h2>
                <p>Please fill in login credentials</p>
            </div>

            <form action="auth.php" method="POST">
                <label>Email address</label>
                <input type="email" name="email" required>

                <label>Password</label>
                <div class="password-wrapper">
                    <input type="password" name="password" id="password" required>
                    <span id="togglePassword" onclick="togglePassword()">👁</span>
                </div>



                <a href="#" class="forgot">Forgot password?</a>

                <button type="submit">Log In</button>
            </form>
        </div>
    </div>

    <script>
        function togglePassword() {
            let pass = document.getElementById("password");
            let toggle = document.getElementById("togglePassword");

            if (pass.type === "password") {
                pass.type = "text";
                toggle.textContent = "🙈"; // change icon to hide
            } else {
                pass.type = "password";
                toggle.textContent = "👁"; // change icon to show
            }
        }
    </script>

</body>

</html>