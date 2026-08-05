<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

require_once "includes/header.php";
require_once "database/connection.php";

?>

<div class="container">

    <form action="" method="POST">

        <h2>Create New Post</h2>

        <label>Title</label>
        <input type="text" name="title">

        <label>Content</label>
        <textarea name="content" rows="6" required></textarea>

        <button type="submit" name="create_post">
            Publish
        </button>

    </form>

</div>
<?php 
if (isset($_POST["create_post"])){
    $title = trim($_POST["title"]);
    $content = trim($_POST["content"]);
    $user_id = $_SESSION["user_id"];
    if(empty($title) || empty($content)){
         echo '<div class="error"> Please fill all fields. </div>';
    }else{
        $stmt = mysqli_prepare(
            $conn,
            "INSERT INTO posts (title, content, user_id)
             VALUES (?, ?, ?)"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "ssi",
            $title,
            $content,
            $user_id
        );

      if (mysqli_stmt_execute($stmt)) {
        header("Location: index.php");
        exit();
    } else {

        echo '<div class="error">
                Error: ' . mysqli_error($conn) . '
               </div>';
    }
     
    }

}

?>

<?php

require_once "includes/footer.php";

?>