<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}
require_once "includes/header.php";
require_once "database/connection.php";
?>
<?php 

$id = $_SESSION["user_id"];
$stmt = mysqli_prepare(
    $conn,
    "SELECT name,email FROM users WHERE id = ?"
);
mysqli_stmt_bind_param($stmt,"i",$id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);
?>


<div class="container">

    <div class="profile-card">

        <div class="avatar">
            <?= strtoupper($user["name"][0]) ?>
        </div>

        <h2>Welcome Back,</h2>
        <h3><?= htmlspecialchars($user["name"]) ?></h3>

        <div class="info">
            <span>Name</span>
            <p><?= htmlspecialchars($user["name"]) ?></p>
        </div>

        <div class="info">
            <span>Email</span>
            <p><?= htmlspecialchars($user["email"]) ?></p>
        </div>

        <a href="logout.php" class="logout-btn">Logout</a>

    </div>

</div>

<?php
require_once "includes/footer.php";
?>