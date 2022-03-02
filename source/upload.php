<?php
session_start();
include('db.php');
$username_of_dev = $_SESSION['user'];
$info = getInformation($_SESSION['user']);
$info = $info->fetch_assoc();
if ($info['level'] != 0 && $info['level'] != 1 ||  !isset($_SESSION['user'])) header('Location: index.php');
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <title>Document</title>
        <link rel="stylesheet" href="./style.css">
    </head>
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    </style>

    <body>
        <?php
          require_once('db.php');
          $user = $_SESSION['user'];
          $info = getInformation($user);
          $info = $info->fetch_assoc();
          $level = $info['level'];
      
          ?>

        <?php
    $appname = '';
    $short_des = '';
    $detail_des = '';
    $theloai = '';
    $giaban = 0;
    if (isset($_POST["submit"])) {
        if (isset($_POST['appname'])) {
            $appname = $_POST['appname'];
        }
        if (isset($_POST['shortdes'])) {
            $short_des = $_POST['shortdes'];
        }
        if (isset($_POST['detaildes'])) {
            $detail_des = $_POST['detaildes'];
        }
        if (isset($_POST['theloai'])) {
            $theloai = $_POST['theloai'];
        }
        if (isset($_POST['giaban'])) {
            $giaban = $_POST['giaban'];
        }
        $error = uploadApp($appname, $short_des, $detail_des, $theloai, $giaban, $username_of_dev);
        if (empty($error)) {
            echo '<script>
            alert("Upload app thành công");
            window.location.href="upload.php";        
            </script>';
        }
    }
    ?>
        <header>
            <nav class="bg-color-3 d-flex justify-around p-1">
                <ul class="list-style-none d-flex align-center justify-center">
                    <li>
                        <a href="./index.php" class="image-highlight">
                            <img src="./image/store-icon.png" alt="bookshop-logo">
                            <span class="color-white font-style-3 font-size-md pl-1">meApp</span>
                        </a>
                    </li>
                    <li class="pl-2 d-none visible-in-md">
                        <a href="./index.php">
                            <img src="./image/home-icon.svg" alt="home-logo" class="navbar-icon">
                            <span class="color-1 font-style-1 font-size-sm pl-1 white-highlight">Trang chủ</span>
                        </a>
                    </li>
                    <li class="pl-2 d-none visible-in-md">
                        <a href="./bangxephang.php">
                            <span class="color-2 font-style-1 font-size-sm pl-1 white-highlight">Bảng xếp hạng</span>
                        </a>
                    </li>
                    <li class="pl-2 d-none visible-in-md">
                        <a href="./topcophi.php">
                            <span class="color-2 font-style-1 font-size-sm pl-1 white-highlight">Có tính phí</span>
                        </a>
                    </li>
                    <li class="pl-2 d-none visible-in-md">
                        <a href="./topmienphi.php">
                            <span class="color-2 font-style-1 font-size-sm pl-1 white-highlight">Không tính phí</span>
                        </a>
                    </li>
                    <li class="pl-2 d-none visible-in-md">
                        <a href="./topthinhhanh.php">
                            <span class="color-2 font-style-1 font-size-sm pl-1 white-highlight">Thịnh hành</span>
                        </a>
                    </li>
                    <?php if ($level == 1 || $level == 0) { ?>
                    <li class="pl-2 d-none visible-in-md">
                        <div class="dropdown">
                            <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Development
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="app_manager.php">App Manager</a>
                                <a class="dropdown-item" href="upload.php">Upload App</a>
                                <a class="dropdown-item" href="view-order.php">View Order</a>
                            </div>
                        </div>
                    </li>
                    <?php } ?>

                    <?php if ($level == 0) { ?>
                    <li class="pl-2 d-none visible-in-md">
                        <div class="dropdown">
                            <button class="btn btn-danger dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Admin
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="appApprove.php">App Approval</a>
                                <a class="dropdown-item" href="categoryApp.php">Category Manager</a>
                                <a class="dropdown-item" href="createMoney.php">Create Money Code</a>
                                <a class="dropdown-item" href="statistical.php">Statistical</a>
                            </div>
                        </div>
                    </li>
                    <?php } ?>
                </ul>

                <ul class="list-style-none d-flex justify-around align-center user-info">

                    <li>
                        <a href="#">
                            <span data-toggle="modal" data-target="#myModal" style="color: white"><img
                                    src="./image/person.svg" alt="user-img" class="image-user"></span>
                            <div class="modal fade2" id="myModal" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header" rows="20">

                                            <h4 class="modal-title"><?= $info['first_name'] ?> <?= $info['last_name'] ?>
                                            </h4>
                                            <?php if ($level == 2) { ?>
                                            <h4 class="modal-title" style="font-size: 15px; color: red">User</h4>

                                            <?php } elseif ($level == 1) { ?>
                                            <h4 class="modal-title" style="font-size: 15px; color: red">Development</h4>
                                            <?php } else { ?>
                                            <h4 class="modal-title" style="font-size: 15px; color: red">Admin</h4>
                                            <?php } ?>
                                        </div>
                                        <div class="modal-body">
                                            <p>Address:<?= $info['address'] ?> </p>
                                            <p>Birth day:<?= $info['birth'] ?></p>

                                        </div>
                                        <div class="modal-footer">

                                            <button type="button" class="btn btn-default"
                                                data-dismiss="modal">Close</button>

                                        </div>
                                    </div>

                                </div>
                            </div>

                        </a>
                    </li>


                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" style="color: white">
                            <?= $_SESSION['user'] ?> <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="payment.php">Pay in money</a></li>
                            <li><a href="historyPayment.php">History pay in money</a></li>

                            <?php if ($level == 2) { ?>
                            <li><a href="upgradeDev.php">Update Account to Dev</a></li>
                            <?php } ?>

                            <li><a href="changePassword.php">Change Password</a></li>
                            <li><a href="updateProfiles.php">Edit Profile</a></li>
                            <li><a href="logOut.php">Log out</a></li>


                        </ul>
                    </li>
                    <span>&nbsp;</span>
                    <span>&nbsp;</span>

                    <li class="dropdown" col="10">
                        <a href="#">
                            <img src="./image/money.svg" alt="user-img" class="image-user">
                            <span>&nbsp;</span>
                            <span style="color:white"><?= $info['money'] ?> VNĐ </span>
                        </a>
                    </li>
                    </a>
                    </li>
                </ul>
            </nav>
        </header>
        <main class="pb-4">
            <!-- Tiêu đề -->
            <div class="bg-white border">
                <section class="featured-book mx-auto p-1">
                    <h1 class="font-style-2 font-size-lg color-1 black-highlight">Đăng tải ứng dụng mới</h1>
                </section>
            </div>

            <!-- Form -->
            <div class="book-genre-container mx-auto p-1">
                <h4 class="font-style-2 font-size-md color-2 border-bottom my-1 py-1 black-highlight pointer">Vui lòng
                    điền đầy đủ thông tin bên dưới</h4>
                <div class="form-card font-size-md">
                    <form method="post" action="./upload.php" enctype="multipart/form-data">
                        <div class="content">
                            <div class="form-group">
                                <label for="name">Tên ứng dụng</label>
                                <input value="<?= $appname ?>" name="appname" class="form-control1" id="name"
                                    type="text" placeholder="Tên ứng dụng">
                            </div>

                            <div class="form-group">
                                <label for="mo-ta-chi-tiet">Mô tả ngắn</label>
                                <input value="<?= $short_des ?>" name="shortdes" class="form-control1"
                                    id="mo-ta-chi-tiet" type="text" placeholder="Mô tả ngắn về ứng dụng của bạn">
                            </div>

                            <div class="form-group">
                                <label for="mo-ta-chi-tiet">Mô tả chi tiết</label>
                                <input value="<?= $detail_des ?>" name="detaildes" class="form-control1"
                                    id="mo-ta-chi-tiet" type="text" placeholder="Mô tả chi tiết về ứng dụng của bạn">
                            </div>

                            <div class="form-group">
                                <label for="the-loai">Thể loại</label>
                                <select value="<?= $theloai ?>" name="theloai" id="the-loai" class="form-control1">
                                    <option>Ứng dụng</option>
                                    <option>Trò chơi</option>
                                    <option>Office</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="name">Giá bán</label>
                                <input value="<?= $giaban ?>" name="giaban" class="form-control1" id="price" type="text"
                                    placeholder="Giá bán(Nhập 0 nếu app miễn phí)">
                            </div>

                            <div class="form-group">
                                <label for="icon">Icon</label>
                                <input class="form" id="icon" type="file" name="icon">
                            </div>

                            <div class="form-group">
                                <label for="screen-short">Screenshot</label>
                                <input multiple class="form" id="screenshot" type="file" name="screenshot[]">
                            </div>

                            <div class="form-group">
                                <label for="file-setting">File cài đặt</label>
                                <input class="form" id="file-setting" type="file" name="installfile">
                            </div>
                            <div class="form-group">
                                <?php
                            if (!empty($error))
                                foreach ($error as $key)
                                    echo "<div class='danger-color'>$key</div><br>";
                            ?>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="submit"
                                    class="stock-btn default-btn font-size-sm bg-color-4">Upload</button>
                                <button type="reset"
                                    class="stock-btn default-btn font-size-sm bg-color-1">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
        </main>

        <footer class="bg-white border">
            <section class="d-flex flex-wrap justify-around footer-links-container mx-auto">
                <div class="p-1">
                    <div class="d-flex justify-center align-center">
                        <img src="./image/store-icon.png" alt="bookshop-logo">
                        <span class="color-2 font-style-3 font-size-md pl-1">meApp</span>
                    </div>
                </div>

                <div class="flex-grow-1 p-1">
                    <p class="font-style-2 color-1 font-size-s  border-bottom-2">Thể loại</p>
                    <ul class="list-style-none py-half">
                        <li class="font-style-2 color-2 font-size-sm underline pointer py-half">Game</li>
                        <li class="font-style-2 color-2 font-size-sm underline pointer py-half">Ứng Dụng</li>
                        <li class="font-style-2 color-2 font-size-sm underline pointer py-half">Office</li>
                    </ul>
                </div>

                <div class="flex-grow-1 p-1">
                    <p class="font-style-2 color-1 font-size-s  border-bottom-2">Navigation</p>
                    <ul class="list-style-none py-half">
                        <li class="font-style-2 color-2 font-size-sm underline pointer py-half">Trang chủ</li>
                        <li class="font-style-2 color-2 font-size-sm underline pointer py-half">Đăng Nhập</li>
                        <li class="font-style-2 color-2 font-size-sm underline pointer py-half">Đăng ký</li>
                        <li class="font-style-2 color-2 font-size-sm underline pointer py-half">Điều khoản</li>
                        <li class="font-style-2 color-2 font-size-sm underline pointer py-half">FAQ</li>
                        <li class="font-style-2 color-2 font-size-sm underline pointer py-half">Trợ giúp</li>
                    </ul>
                </div>
                <div class="copyright-section p-1 mx-auto d-flex justify-between align-center">
                    <ul class="list-style-none d-flex">
                        <li><img src="./image/twitter.svg" alt="twitter-logo"
                                class="d-block category-heading-icons pointer ml-half"></li>
                        <li><img src="./image/google.svg" alt="google-logo"
                                class="d-block category-heading-icons pointer ml-half"></li>
                        <li><img src="./image/facebook.svg" alt="facebook-logo"
                                class="d-block category-heading-icons pointer ml-half"></li>
                        <li><img src="./image/linkedin.svg" alt="linkedin-logo"
                                class="d-block category-heading-icons pointer ml-half"></li>
                    </ul>
                </div>
            </section>
        </footer>
    </body>

</html>
