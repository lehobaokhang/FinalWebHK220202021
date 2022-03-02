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
        <title>Thông tin chi tiết app</title>
        <link rel="stylesheet" href="./style.css">
        <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    </head>

    <body>
        <?php
    $result = getInfoApp($_GET['app_id_update']);
    $image_path = './uploads/' . $result['app_id'] . '/icon_' . $result['app_name'] . '.jpg';
    $screenshot_path = './uploads/' . $result['app_id'] . '/Screenshot';

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
                    <li class="pl-2">
                        <button type="button"
                            class="d-none stock-btn default-btn font-size-sm font-style-2 bg-color-1">About us</button>
                    </li>
                </ul>

                <ul class="list-style-none d-flex justify-around align-center user-info">
                    <li class="d-none visible-in-lg">
                        <a href="#" class="image-highlight">
                            <img src="./image/notification.png" alt="mail-icon" class="navbar-icon">
                            <span
                                class="d-inline-block bg-color-1 mail-notification font-size-sm font-style-2 color-white">0</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="./image/person.svg" alt="user-img" class="image-highlight pl-1">
                        </a>
                    </li>
                </ul>
            </nav>
        </header>

        <main class="pb-4">
            <!-- Tiêu đề -->
            <div class="bg-white border">
                <section class="featured-book mx-auto p-1">
                    <h1 class="font-style-2 font-size-lg color-1 black-highlight">Thông tin chi tiết của ứng dụng</h1>
                </section>
            </div>

            <!-- Form -->
            <div class="book-genre-container mx-auto p-1">
                <div class="form-card font-size-lg">
                    <img src="<?php echo $image_path ?>" alt="icon-card-img">
                    <div class=" space">
                    </div>
                    <div class="con-table">
                        <p class="font-size-s font-style-2 color-3 py-1 gray-highlight">Tên ứng dụng:
                            <?php echo $result['app_name'] ?></p>
                        <p class="font-size-s font-style-2 color-3 py-1 gray-highlight">Nhà phát triển:
                            <?php echo $result['app_name_dev'] ?></p>
                        <p class="font-size-s font-style-2 color-3 py-1 gray-highlight">Mô tả ngắn:
                            <?php echo $result['short_describe'] ?></p>
                        <p class="font-size-s font-style-2 color-3 py-1 gray-highlight">Mô tả chi tiết:
                            <?php echo $result['detail_describe'] ?></p>
                        <p class="font-size-s font-style-2 color-3 py-1 gray-highlight">Số lượt tải:
                            <?php echo $result['app_downloads'] ?></p>
                        <p class="font-size-s font-style-2 color-3 py-1 gray-highlight">Đánh giá:
                            <?php echo $result['app_rate'] ?> /5.0</p>
                        <form action="" method="post">
                            <button type="sumbit" name="download"
                                class="d-none stock-btn default-btn font-size-sm font-style-2 bg-color-1">Download</button>
                        </form>
                    </div>
                </div>
                <div class="row-image-screenshot">
                    <div class="column-image-screenshot">
                        <img src="<?php echo $screenshot_path ?>0.jpg" class="d-block" alt="screenshot-img"
                            style="width:100%">
                    </div>
                    <div class="column-image-screenshot">
                        <img src="<?php echo $screenshot_path ?>1.jpg" class="d-block" alt="screenshot-img"
                            style="width:100%">
                    </div>
                    <div class="column-image-screenshot">
                        <img src="<?php echo $screenshot_path ?>2.jpg" class="d-block" alt="screenshot-img"
                            style="width:100%">
                    </div>
                </div>

                <h4 class="font-style-2 font-size-md color-2 border-bottom my-1 py-1 black-highlight pointer">App cùng
                    thể loại </h4>
                <section class="book-genre-container mx-auto p-1">
                    <section class="book-cards-container d-flex flex-wrap justify-between">
                        <?php getTopAppbyKind(4, $result['kind_id']); ?>
                    </section>
                </section>
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
