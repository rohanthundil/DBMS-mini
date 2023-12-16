<?php
session_start();

include("Patient.php");
include("Home.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Something was posted
    $user_id = $_POST['user_id'];
    $password = $_POST['password'];

    if (!empty($user_id) && !empty($password) && !is_numeric($user_id)) {
        // Read from database using prepared statement to prevent SQL injection
        $query = "SELECT * FROM login WHERE Email = ? LIMIT 1";
        $stmt = $con->prepare($query);
        $stmt->bind_param("s", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);

            if ($user_data['Password'] === $password) {
                $_SESSION['user_name'] = $user_data['Name']; // Set the user_name in the session variable
                $_SESSION['user_id'] = $user_data['Email']; // Set the user_id in the session variable

                echo '<script>alert("Login successful");</script>'; // Move this line here
                header("Location: data.php"); // Redirect after successful login
                exit;
            }
        }
        echo '<script>alert("Wrong username or password!");</script>';
    } else {
        echo '<script>alert("Wrong username or password!");</script>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <style type="text/css">
        h1 {
        color: white;
      }
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: Arial, sans-serif;
    }

    body {
        background-image: url("DOCTOR.jpg");
        background-size: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .container {
        width: 300px;
        padding: 30px;
        border: 1px solid #ccc;
        background-color: rgba(255, 255, 255, 0.5); /* Updated: Change the background-color to transparent */
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .container h1 {
        text-align: center;
        margin-bottom: 20px;
        color: white; /* Updated: Set the color to white */
    }

    .container input[type="text"],
    .container input[type="password"] {
        width: 100%;
        padding: 12px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 4px;
        outline: none;
        font-size: 14px;
    }

    .container input[type="submit"] {
        width: 100%;
        padding: 12px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        transition: background-color 0.3s ease;
    }

    .container input[type="submit"]:hover {
        background-color: #45a049;
    }

    .signup {
        text-align: center;
        margin-top: 20px;
        color: white; /* Updated: Set the color to white */
    }

    .signup a {
        color: #4CAF50;
        text-decoration: none;
        font-weight: bold;
    }

    .forgot-password {
        text-align: right;
        margin-top: 10px;
    }

    .forgot-password a {
        color: #4CAF50;
        text-decoration: none;
        font-weight: bold;
    }
</style>

</head>

<body>
    <div id="wrapper-div">

        <div id="main-div" class="clearfix">
        
                <?php if (isset($_SESSION['login_error'])) : ?>
                    <p style="color: red;"><?php echo $_SESSION['login_error']; ?></p>
                    <?php unset($_SESSION['login_error']); ?>
                <?php endif; ?>
                <form action="login.php" method="POST">
                    <h1>Login</h1>
                    <div class="formcontainer">

                        <div class="container">
                            <label for="user_id"><strong>User ID</strong></label>
                            <input type="text" placeholder="Enter Username" name="user_id" required>
                            <label for="password"><strong>Password</strong></label>
                            <input type="password" placeholder="Enter Password" name="password" required>
                        </div>

                        <button type="submit">Login</button>
                        <div class="checktext">
                            <input type="checkbox" name="remember">
                        </div>
                    </div>
                    <a href="signup.php">Signup</a>
                    <a href="nurse.php">Admin Login</a>
                </form>

            </div>
        </div>
    </div>
    </div>
</body>

</html>
