<?php
    session_start();
    if (isset($_SESSION['unique_id'])) { //if user is logged in
        header("location: users.php");
    }
?>

<?php include_once "header.php"; ?>
<body>
    <div class="wrapper">
        <section class="form login">
            <header>Chat App</header>
            <form action="#">
                <div class="error-txt">This is an error message</div>
                <div class="field input">
                    <label> Email Address</label>
                    <input type="text" name="email" placeholder="Enter your Email" />
                </div>
                <div class="field input">
                    <label> Password</label>
                    <input type="password" name="password" placeholder="Enter new password"/>
                    <i class="fas fa-eye"></i>
                </div>
                <div class="field button">
                    <label> </label>
                    <input type="submit" value="Continue to chat" />
                </div>
            </form>
            <div class="link">Not yet signed up? <a href="index.php">Signup now</a></div>
        </section>
    </div>
    <script src="js/pass-show-hide.js"></script>
    <script src="js/login.js"></script>
</body>
</html>