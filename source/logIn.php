<?php
session_start();
if (isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}

require_once('db.php');
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <link rel="stylesheet" href="style.css">
        <title>Login</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>

    <body class="body">

        <?php

    $error = [];
    $user = '';
    $pass = '';

    if (isset($_POST['user']) && isset($_POST['pass'])) {
        $user = $_POST['user'];
        $pass = $_POST['pass'];

        if (empty($user)) {
            $error['user'] = 'Please enter your user name!';
        } else if (empty($pass)) {
            $error['pass'] = 'Please enter your password!';
        } else if (strlen($pass) < 6) {
            $error['pass'] = 'Password must have at least 6 characters!';
        }else {
            $data = login($user, $pass);
            if ($data) {
                $_SESSION['user'] = $user;
                $_SESSION['name'] = $data['firstname'] . ' ' . $data['lastname'];
                header('Location: index.php');
                exit();
            } else {
                $error['pass'] = 'Invalid username or password!';
            }
        }
    }
    ?>

        <form action="" method="post" class="form-group-signin">
            <table class="d-table">
                <tr>
                    <td>
                        <h1 class="brand">meApp</h1>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="text" class="form-control" id="user" name="user" placeholder="Username"
                            value="<?= $user ?>">
                        <span class="back-login"
                            style="color: red"><?php echo (isset($error['user']))?$error['user']:'' ?></span>
                    </td>

                </tr>

                <tr>
                    <td>
                        <input type="password" name="pass" value="<?= $pass ?>" class="form-control" id="pass"
                            placeholder="Password">
                        <span class="back-login"
                            style="color: red"><?php echo (isset($error['pass']))?$error['pass']:'' ?></span>
                    </td>
                </tr>

                <tr>
                    <td>
                        <input <?= isset($_POST['remember']) ? 'checked' : '' ?> type="checkbox" name="remember"
                            class="checkBox" id="remember">
                        <label for="remember" class="rememberme">Remember me</label>
                    </td>
                </tr>

                <tr>
                    <td>
                        <button type="submit" class="signIn">Log in</button>
                    </td>
                </tr>

                <tr>
                    <td class="forgot-td">
                        <a class="forgot" href="forgotPassword.php">Forgot password?</a>
                    </td>
                </tr>

                <tr>
                    <td>
                        <hr width="30%" align="center" />
                    </td>
                </tr>

                <tr>
                    <td>
                        <a href="Register.php" class="signup">Sign up here</a>
                    </td>
                </tr>
            </table>
        </form>

    </body>

</html>
