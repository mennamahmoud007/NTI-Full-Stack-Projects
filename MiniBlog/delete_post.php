<?php 
session_start();
// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}
// Include the database connection
require_once "database/connection.php";
// Check if the post ID is provided "authentication"
$sql="SELECT * FROM posts WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $_GET["id"]);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
if (mysqli_num_rows($result) === 0) {
    echo "Post not found.";
    exit();
}else {
    $post = mysqli_fetch_assoc($result);
    if ($post["user_id"] != $_SESSION["user_id"]) {
        echo "You are not authorized to delete this post.";
        exit();
    }
}
$sql="DELETE FROM posts WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $_GET["id"]);
if (mysqli_stmt_execute($stmt)) {
    header("Location: index.php");
    exit();
} else {
    echo "Delete Failed";
}

?>