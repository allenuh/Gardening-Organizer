<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="loginbox">
    <form action="login.php" method="post">
        <h2 class=logintext>LOGIN</h2> 
        <?php if (isset($_GET['error'])) { ?>
            <p class="error"> <?php echo $_GET['error']; ?></p>
        <?php } ?>
        
        <label>Username</label>
        <input type="text" name="uname" placeholder="username"><br>

        <label>Password</label>
        <input type="password" name="password" placeholder="password"><br>

        <button type="submit">Login</button>
        <a href="signup.php" class="ca">Create an account?</a>
    </form>
</body>
</html>