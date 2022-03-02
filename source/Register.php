<?php
session_start();
if (isset($_SESSION['user'])) {
    header('Location: logIn.php');
    exit();
}

require_once('db.php');
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <link rel="stylesheet" href="style.css">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Sign Up</title>

    </head>

    <body class="body">
        <?php
    $error = [];
    $email = '';
    $user = '';
    $first_name = '';
    $last_name = '';
    $address = '';
    $birth ='';
    $pass = '';
    $pass_confirm = '';

    if (isset($_POST['email']) && isset($_POST['user']) && isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['address']) 
    && isset($_POST['birth']) && isset($_POST['pass']) && isset($_POST['pass_confirm'])
    ) {
        $email = $_POST['email'];
        $user = $_POST['user'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $address = $_POST['address'];
        $birth = $_POST['birth'];
        $pass = $_POST['pass'];
        $pass_confirm = $_POST['pass_confirm'];

        if (empty($user)) {
            $error['user'] = 'Please enter your username!';
        } else if(empty($email)) {
            $error['email'] = 'Please enter your emails!';
        } else if(filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
            $error['email'] = 'Email adress not valid!';
        }else if(empty($first_name)) {
            $error['first_name'] = 'Please enter your first name!';
        } else if (empty($last_name)) {
            $error['last_name'] = 'Please enter your last name!';
        } else if(empty($address)) {
            $error['address'] = 'Please enter your address!';
        } else if (empty($birth)) {
            $error['birth'] = 'Please enter your birth day!';
        } else if(empty($pass)) {
            $error['pass'] = 'Please enter your password!';
        } else if (strlen($pass) < 6) {
            $error['pass'] = 'Password must have at least 6 characters!';
        } else if (empty($pass_confirm)) {
            $error['pass_confirm'] = 'Please enter password confirm!';
        } else if($pass != $pass_confirm){
            $error['pass_confirm'] = 'Password confirm does not match!';
        }
        else {
            // register a new account
            $result = register($user, $email, $first_name, $last_name, $address, $birth, $pass);
            if ($result['code'] == 0) {
                $error = $result['code'];
                echo "<script>
                    alert('Create account successfully!');
                    window.location='index.php';    
                </script>";
                            
            } else if($result['code'] == 3){
                $error['user'] = 'This user name is already exists!';
            }else if ($result['code'] == 1) {
                $error['email'] = 'This email is already exists!';
            } else {
                $error['pass_confirm'] = 'An error occurerd. Pleased try again later!';
            }
        }
    }
    ?>
        <form action="" method="post" class="form-group-signup" novalidate>
            <table>
                <tr>
                    <td>
                        <h1 class="brand">Sign Up</h1>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input value="<?= $user ?>" type="text" class="form-control" id="user" name='user'
                            placeholder="Enter your username">
                        <span class="back-login"
                            style="color: red"><?php echo (isset($error['user']))?$error['user']:'' ?></span>
                    </td>
                </tr>

                <tr>
                    <td>
                        <input value="<?= $email ?>" type="text" name="email" class="form-control" id="email"
                            placeholder="Enter your email">
                        <span class="back-login"
                            style="color: red"><?php echo (isset($error['email']))?$error['email']:'' ?></span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input value="<?= $first_name ?>" type="text" , class="form-control" , name="first_name"
                            id='first_name' placeholder="Enter your first name">
                        <span class="back-login"
                            style="color: red"><?php echo (isset($error['first_name']))?$error['first_name']:'' ?></span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input value="<?= $last_name ?>" id="last_name" type="text" , class="form-control" ,
                            name="last_name" placeholder="Enter your last name">
                        <span class="back-login"
                            style="color: red"><?php echo (isset($error['last_name']))?$error['last_name']:'' ?></span>
                    </td>
                </tr>

                <tr>
                    <td>
                        <input value="<?= $address ?>" name="address" id="address" type="text" , class="form-control"
                            placeholder="Enter your address">
                        <span class="back-login"
                            style="color: red"><?php echo (isset($error['address']))?$error['address']:'' ?></span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input value="<?= $birth ?>" id="birth" name="birth" type="date" class="form-control">
                        <span class="back-login"
                            style="color: red"><?php echo (isset($error['birth']))?$error['birth']:'' ?></span>
                    </td>
                </tr>

                <tr>
                    <td>
                        <input value="<?= $pass ?>" type="password" name="pass" class="form-control" id="pass"
                            placeholder="Enter your password">
                        <span class="back-login"
                            style="color: red"><?php echo (isset($error['pass']))?$error['pass']:'' ?></span>
                    </td>
                </tr>

                <tr>
                    <td>
                        <input value="<?= $pass_confirm ?>" type="password" name="pass_confirm" class="form-control"
                            id="pass_confirm" placeholder="Confirm your password">
                        <span class="back-login"
                            style="color: red"><?php echo (isset($error['pass_confirm']))?$error['pass_confirm']:'' ?></span>
                    </td>
                </tr>

                <tr>
                    <td>
                        <button type="submit" class="signIn">Sign up</button>
                    </td>
                </tr>

                <tr>
                    <td class="forgot-td">
                        <a href="logIn.php" class="back-login" style="text-decoration:none">Or back to login</a>
                    </td>
                </tr>

            </table>
        </form>
    </body>

</html>
