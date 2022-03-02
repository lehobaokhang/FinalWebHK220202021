<?php
    session_start();
    if (!isset($_SESSION['user'])) {
        header('Location: login.php');
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
</head>

<body class="body-pro">
    <?php
         require_once ('db.php');
         $user = $_SESSION['user'];
         $info = getInformation($user);
         $info = $info->fetch_assoc();
    ?>

    <?php 
        $error = [];
        
            if(isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['address']) 
            && isset($_POST['birth'])) {
                
                $first_name = $_POST['first_name'];
                $last_name = $_POST['last_name'];
                $address = $_POST['address'];
                $birth = $_POST['birth'];
                $user = $_SESSION['user'];
                
                
                    $result = update_profile($user, $first_name, $last_name, $address, $birth);
                    if($result['code'] == 0) {
                        echo "<script>
                                alert('Update profile successfully!');
                                window.location='updateProfiles.php';  
                            </script>";
                    } 
            }
        
        
    ?>

    <form action="" method="post" class="form-group-signin">
        <table>
            <tr>
                <td>
                    <h1 class="brand">Update Profile</h1>
                </td>
            </tr>

            <tr>
                <td>First name
                    <input type="text" , class="form-control" , name="first_name" id='first_name'
                        placeholder="Enter your first name" value="<?= $info['first_name'] ?>">
                </td>
            </tr>
            <tr>
                <td>Last name
                    <input value="<?= $info['last_name'] ?>" id="last_name" type="text" , class="form-control" ,
                        name="last_name" placeholder="Enter your last name">
                </td>
            </tr>

            <tr>
                <td>
                    Address
                    <input value="<?= $info['address'] ?>" name="address" id="address" type="text" ,
                        class="form-control" placeholder="Enter your address">
                </td>
            </tr>
            <tr>
                <td>
                    Birthday
                    <input value="<?= $info['birth'] ?>" id="birth" name="birth" type="date" class="form-control">
                </td>
            </tr>

            <tr>
                <td>
                    <button type="submit" class="signIn" id="">Update</button>
                </td>
            </tr>

            <tr>
                <td class="forgot-td">
                    <a class="back-login" href="logIn.php" style="text-decoration:none">Back home</a>
                </td>
            </tr>

        </table>
    </form>
</body>

</html>