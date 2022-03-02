<?php
    session_start();
    if (!isset($_SESSION['user'])) {
        header('Location: logIn.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <link rel="stylesheet" href="style.css">
        <title>Upgrade to Development</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>

    <body class="body-pro2">
        <?php
         require_once ('db.php');
         $user = $_SESSION['user'];
         $info = getInformation($user);
         $info = $info->fetch_assoc();
         $message = '';
        
        if(isset($_POST['submit'])){
           
            if($_FILES['image']['size'][0] === 0){
                $message = 'Please choose your CMND font image!';
            }else if($_FILES['image']['size'][1] === 0){
                $message = 'Please choose your CMND back image!';
            } else if($_FILES['image']['size'][0] === $_FILES['image']['size'][1]) {
                $message = 'CMND image front must be different CMND image back, please try again!';
            } else if($info['money'] < 500000)  {
                $message = 'Your money dont enough, please pay money more!';
            }
            else {
                $extension=array('jpeg','jpg','png','gif');
                foreach ($_FILES['image']['tmp_name'] as $key => $value) {
                    $filename=$_FILES['image']['name'][$key];
                    $filename_tmp=$_FILES['image']['tmp_name'][$key];
                    echo '<br>';
                    $ext=pathinfo($filename,PATHINFO_EXTENSION);

                    if(in_array($ext,$extension)){
                        if(!file_exists('upload/'.$filename)){
                            move_uploaded_file($filename_tmp, 'upload/'.$filename);
                            
                        }
                        
                    }
		        }
                $user = $_SESSION['user'];
                $money = $_POST['money'];
                $level = $_POST['level'];
                $resutl = updateDev($user,$money,$level);
                if($resutl['code'] == 0) {
                    echo "<script>
                            alert('Update to Development successfully!');
                            window.location='logIn.php'
                        </script>";

                }
	        }
        }
    ?>

        <form enctype="multipart/form-data" action="" method="post" class="form-group-signin">
            <table>
                <tr>
                    <td>
                        <h1 class="brand">Upgrade Development</h1>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p class="hello-dev">Hello,</p>
                        <p class="regis-dev"><?= $info['first_name']?> <?= $info['last_name']?></p>
                        <p class="regis-devs">Account balance: <?=$info['money']?> VNĐ</p>
                    </td>
                    <input type="hidden" value="<?=$info['money']?>" name="money" />
                    <input type="hidden" value="<?=$info['level']?>" name="level" />

                </tr>

                <tr>
                    <td>
                        <p>✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽</p>
                        <p class="Dk">You must pay 500,000 VND to become Dev
                            and must provide the same information through the identification card for us to review.</p>
                        <p>-----------------------------------------------------------------------------------</p>
                        <p class="Dk">Benifit: After you up to Dev, you can upload app or something else of Development!
                        </p>
                        <p>-----------------------------------------------------------------------------------</p>
                        <p class="Dk">Contact with us: admin@gmail.com---------meApp</p>
                        <p>✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽</p>

                    </td>
                </tr>

                <tr>
                    <td>CMND front
                        <input type="file" name="image[]" multiple>
                    </td>


                </tr>

                <tr>
                    <td>CMND back
                        <input type="file" name="image[]" multiple>

                    </td>
                </tr>

                <tr>
                    <td>
                        <button type="submit" name="submit" value="Submit" class="signIn">Register</button>
                    </td>
                </tr>

                <tr>
                    <td>
                        <span class="message"><?=$message?></span>
                    </td>
                </tr>


                <tr>
                    <td>
                        <hr width="30%" align="center" />
                    </td>
                </tr>

                <tr>
                    <td>
                        <a href="index.php" class="back-login">Or back to home</a>
                    </td>
                </tr>
            </table>
        </form>

    </body>

</html>
