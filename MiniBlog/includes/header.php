<!DOCTYPE html>

<html>

<head>

<link rel="stylesheet" href="assets/css/style.css">

</head>
<body>
<nav class="navbar">

   <a href="index.php">
       <h2 class="logo">MiniBlog</h2>
   </a>

    <div class="nav-links">

        <?php if (isset($_SESSION["user_id"])): ?>

            <a href="index.php">Home</a>

            <a href="create_post.php">Create Post</a>

            <a href="profile.php">Profile</a>

            <a href="logout.php">Logout</a>

        <?php else: ?>

            <a href="login.php">Login</a>

            <a href="register.php">Register</a>

        <?php endif; ?>

    </div>

</nav>
