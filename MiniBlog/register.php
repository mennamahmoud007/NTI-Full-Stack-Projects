<?php
require_once "includes/header.php";
require_once "database/connection.php";
?>
<div class="container">
<form action="" method="POST">

    <label>Name</label>
    <input type="text" name="name">
    <br><br>

    <label>Email</label>
    <input type="email" name="email">
    <br><br>
    <label>Password</label>

    <input type="password" name="password">
    <br><br>
    <button type="submit" name="register">
        Register
    </button>
    <p class="form-link">
    Already have an account?
    <a href="login.php">Login</a>
</p>
</form>
</div>
<?php 

if (isset($_POST["register"])) {

    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);//for hashing

    if (empty($name) || empty($email) || empty($password)) {

        echo '<div class="error"> Please fill all fields. </div>';


    } else {
        $checkEmail = mysqli_prepare(
        $conn,
        "SELECT id FROM users WHERE email = ?"
    );
    mysqli_stmt_bind_param(
        $checkEmail,
        "s",
        $email
    );
    mysqli_stmt_execute($checkEmail);
    $result = mysqli_stmt_get_result($checkEmail);
    if (mysqli_num_rows($result) > 0) {
    echo '<div class="error"> Email already exists. </div>';

    } else {
        $stmt = mysqli_prepare(
            $conn,
            "INSERT INTO users (name, email, password)
             VALUES (?, ?, ?)"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "sss",
            $name,
            $email,
            $password
        );

      if (mysqli_stmt_execute($stmt)) {

    echo '<div class="success">
            User Added Successfully.
          </div>';
    } else {

        echo '<div class="error">
                Error: ' . mysqli_error($conn) . '
               </div>';
    }
     }
    }
}
?>

<?php
require_once "includes/footer.php";
?>