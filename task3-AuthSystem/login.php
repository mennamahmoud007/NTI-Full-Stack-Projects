<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "includes/header.php";
require_once "database/connection.php";
?>
<div class="container">
<form action="" method="POST">

    <label>Email</label>
    <input type="email" name="email">

    <br><br>

    <label>Password</label>
    <input type="password" name="password">

    <br><br>

    <button type="submit" name="login">
        Login
    </button>
    <p class="form-link">
    Don't have an account?
    <a href="register.php">Register</a>
</p>
</form>
</div>
<?php 
if (isset($_POST["login"])) {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    if (empty($email) || empty($password)) {

        echo '<div class="error"> Please fill all fields.. </div>';

    } else {
        $stmt = mysqli_prepare(
    $conn,
    "SELECT * FROM users WHERE email = ?"
        );
        mysqli_stmt_bind_param(
        $stmt,
        "s",
        $email,
        );
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($password, $row["password"])) {
                //echo "Login Success";
                $_SESSION["user_id"] = $row["id"];
                $_SESSION["user_name"] = $row["name"];
                $_SESSION["user_email"] = $row["email"];
                header("Location: index.php");
                exit();
            } else {
                echo'<div class="error">
                 Wrong Password.
                </div>';
            }
        } else {
                    echo '<div class="error"> Email doesnot exist.</div>';

        }
    }
}

?>

<?php
require_once "includes/footer.php";
?>