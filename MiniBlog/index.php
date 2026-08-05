<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}
require_once "includes/header.php";
require_once "database/connection.php";
?>

<section>
<div class="hero">
    <h1>Hello, <?= htmlspecialchars($_SESSION["user_name"]) ?> </h1>
    <p>See what everyone is sharing today.</p>
</div>
    <?php 
    $sql = '
    select u.name, p.title , p.content, p.user_id,p.id
    from users u join posts p
    on u.id=p.user_id
    ';
    $result = mysqli_query($conn, $sql);
    ?>

 <?php if ($result && mysqli_num_rows($result) > 0): ?>

    <div class="posts-container">

        <?php while ($row = mysqli_fetch_assoc($result)): ?>

            <div class="post">

                <div class="post-header">

                    <div class="avatar small-avatar">
                        <?= strtoupper($row["name"][0]) ?>
                    </div>

                    <div class="author-info">
                        <h4><?= htmlspecialchars($row["name"]) ?></h4>
                
                    </div>

                </div>

                <h3><?= htmlspecialchars($row["title"]) ?></h3>

                <p><?= nl2br(htmlspecialchars($row["content"])) ?></p>

                <?php if ($row["user_id"] == $_SESSION["user_id"]): ?>

                    <div class="post-actions">

                        <a href="edit_post.php?id=<?= $row["id"] ?>" class="btne">
                            Edit
                        </a>

                        <a
                            href="delete_post.php?id=<?= $row["id"] ?>"
                            class="btnd"
                            onclick="return confirm('Delete this post?')"
                        >
                            Delete
                        </a>

                    </div>

                <?php endif; ?>

            </div>

        <?php endwhile; ?>

    </div>

<?php else: ?>

    <div class="post">

        <h3>No Posts Yet</h3>

        <p>Be the first one to publish a post.</p>

    </div>

<?php endif; ?>

</section>

<?php
require_once "includes/footer.php";
?>