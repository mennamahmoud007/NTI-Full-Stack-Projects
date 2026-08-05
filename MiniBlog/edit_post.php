<?php 
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}
require_once "includes/header.php";
require_once "database/connection.php";

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
        echo "You are not authorized to edit this post.";
        exit();
    }
}
?>

<div class="container">

    <form method="POST">

        <h2>Edit Post</h2>

        <input type="hidden" name="post_id" value="<?= $post["id"] ?>">

        <label for="title">Title</label>
        <input
            type="text"
            name="title"
            id="title"
            value="<?= htmlspecialchars($post["title"]) ?>"
            required
        >

        <label for="content">Content</label>
        <textarea
            name="content"
            id="content"
            rows="6"
            required
        ><?= htmlspecialchars($post["content"]) ?></textarea>

        <button type="submit" name="update" class="update-btn">
            Update Post
        </button>

    </form>

</div>

<?php 
if (isset($_POST["update"])) {
    $post_id = $_POST["post_id"];
    $title = trim($_POST["title"]);
    $content = trim($_POST["content"]);

    if (empty($title) || empty($content)) {
        echo '<div class="error">Please fill all fields.</div>';
    } else {
        $stmt = mysqli_prepare(
            $conn,
            "UPDATE posts 
            SET title = ?, content = ? WHERE id = ?"
        );
        mysqli_stmt_bind_param(
            $stmt,
            "ssi",
            $title,
            $content,
            $post_id
        );

        if (mysqli_stmt_execute($stmt)) {
            header("Location: index.php");
            exit();
        } else {
            echo '<div class="error">Error updating post. Please try again.</div>';
        }
    }
}

?>

<?php 
require_once "includes/footer.php";
?>