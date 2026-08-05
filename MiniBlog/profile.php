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
$stmtu = mysqli_prepare(
    $conn,
    "SELECT * FROM users WHERE id = ?"
);
mysqli_stmt_bind_param($stmtu,"i",$id);
mysqli_stmt_execute($stmtu);
$resultu = mysqli_stmt_get_result($stmtu);
$user = mysqli_fetch_assoc($resultu);
?>

<?php
$stmtp = mysqli_prepare(
    $conn,
    "SELECT * FROM posts WHERE user_id = ?"
    );
    
    mysqli_stmt_bind_param($stmtp, "i", $id);
    mysqli_stmt_execute($stmtp);
    
    $resultp = mysqli_stmt_get_result($stmtp);
    $totalposts = mysqli_num_rows($resultp);

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
        <p><strong>Total Posts:</strong> <?= $totalposts ?></p>

    </div>
    
</div>

<?php if ($totalposts > 0): ?>
  <div class="container">
    <h2 class="profiletitle">Your Posts</h2>  
<?php while ($post = mysqli_fetch_assoc($resultp)): ?>

    <div class="post">

        <h3><?= htmlspecialchars($post["title"]) ?></h3>

        <p><?= nl2br(htmlspecialchars($post["content"])) ?></p>

        <a href="edit_post.php?id=<?= $post["id"] ?>" class="btne">
            Edit
        </a>

        <a href="delete_post.php?id=<?= $post["id"] ?>"
           class="btnd"
           onclick="return confirm('Delete this post?')">
            Delete
        </a>

    </div>
    
    <?php endwhile; ?>
</div>

<?php else: ?>

    <div class="post">

        <h3>No Posts Yet</h3>

        <p>You haven't published any posts.</p>

    </div>

<?php endif; ?>

<?php
require_once "includes/footer.php";
?>