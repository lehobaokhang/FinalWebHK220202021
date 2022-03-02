<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Statistical</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    </head>

    <body>
        <?php
    require_once('db.php');
    $info = countUser();
    $user = getFullInformation();
    $app_info = getAppRequest();

    $money = getFullMoney();
    $total_money = countTotalMoneyCard();

    $app_download = getFullAppDownload();
    $count_app_download = countTotalAppDpwnload();

    $commnent = getFullCommnent();
    $total_comment = countTotalComment();

    $pay_in = getFullPayin();
    $total_payin =  countTotalPayin();
    
    if (isset($_GET['app_id_request'])) {
        confirmApp($_GET['app_id_request']);
        echo '<script>
        alert("Duyệt app thành công");
        window.location.href="statistical.php";        
        </script>';
    }

    if (isset($_GET['app_id'])) {
        header('Location: ./info_app.php?app_id=' . $_GET['app_id']);
    }
    ?>

        <div class="container">

            <h2>Statistical</h2>
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#home">User</a></li>
                <li><a data-toggle="tab" href="#menu1">Money Card Created</a></li>
                <li><a data-toggle="tab" href="#menu2">App Downloaded</a></li>
                <li><a data-toggle="tab" href="#menu3">App in meApp</a></li>
                <li><a data-toggle="tab" href="#menu4">Commnent</a></li>
                <li><a data-toggle="tab" href="#menu5">Pay in money</a></li>
            </ul>

            <div class="tab-content">
                <div id="home" class="tab-pane fade in active">
                    <h3>Tolal user: <?= $info ?> people.</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Username</th>
                                <th scope="col">First name</th>
                                <th scope="col">Last name</th>
                                <th scope="col">Address</th>
                                <th scope="col">Birthday</th>

                            </tr>
                        </thead>
                        <?php
                    while ($row = mysqli_fetch_assoc($user)) { ?>

                        <tbody>
                            <tr>
                                <td><?= $row['username'] ?></td>
                                <td><?= $row['first_name'] ?></td>
                                <td><?= $row['last_name'] ?></td>
                                <td><?= $row['address'] ?></td>
                                <td><?= $row['birth'] ?></td>
                            </tr>
                        </tbody>

                        <?php } ?>

                    </table>
                    <a class="btn btn-danger top-50" href="index.php" role="button" class="col col-lg-2">Back
                        Home</a>
                </div>



                <div id="menu1" class="tab-pane fade">
                    <h3>Tolal card created: <?= $total_money ?> card.</h3>

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Option Money</th>
                                <th scope="col">Seri</th>
                                <th scope="col">Exp</th>
                                <th scope="col">Date created</th>

                            </tr>
                        </thead>
                        <?php
                    while ($row = mysqli_fetch_assoc($money)) { ?>

                        <tbody>
                            <tr>
                                <td><?= $row['option_money'] ?></td>
                                <td><?= $row['seri'] ?></td>
                                <td><?= $row['exp'] ?></td>
                                <td><?= $row['date_create_money'] ?></td>
                            </tr>
                        </tbody>

                        <?php } ?>

                    </table>
                    <a class="btn btn-danger top-50" href="index.php" role="button" class="col col-lg-2">Back
                        Home</a>
                </div>
                <div id="menu2" class="tab-pane fade">
                    <h3>Tolal app downloaded: <?= $count_app_download ?> app.</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Username</th>
                                <th scope="col">App</th>
                                <th scope="col">Developer</th>
                                <th scope="col">Download Date</th>
                                <th scope="col">Prices</th>
                            </tr>
                        </thead>
                        <?php
                    while ($row = mysqli_fetch_assoc($app_download)) { ?>

                        <tbody>
                            <tr>
                                <td><?= $row['username'] ?></td>
                                <td><?= $row['app_name'] ?></td>
                                <td><?= $row['name_dev'] ?></td>
                                <td><?= $row['download_date'] ?></td>
                                <td><?= $row['price'] ?></td>
                            </tr>
                        </tbody>

                        <?php } ?>

                    </table>
                    <a class="btn btn-danger top-50" href="index.php" role="button" class="col col-lg-2">Back
                        Home</a>
                </div>
                <div id="menu3" class="tab-pane fade">
                    <h3>Danh sách app</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Tên app</th>
                                <th scope="col">Tên nhà phát triển</th>
                                <th scope="col">Xem app</th>
                            </tr>
                        </thead>
                        <?php
                    $info_all = getAllInfoApp();
                    foreach ($info_all as $key) {
                    ?>
                        <tbody>
                            <tr>
                                <td><?= $key[1] ?></td>
                                <td><?= $key[3] ?></td>
                                <td><a href="index.php?app_id=<?php echo $key[0] ?>"
                                        class="default-btn font-size-sm font-style-2 bg-color-1 mr-half my-half">Xem</span></a>
                                </td>
                            </tr>
                        </tbody>

                        <?php } ?>

                    </table>
                    <a class="btn btn-danger top-50" href="index.php" role="button" class="col col-lg-2">Back
                        Home</a>
                </div>

                <div id="menu5" class="tab-pane fade">
                    <h3>Tolal pay in money: <?= $total_payin ?>.</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">User name</th>
                                <th scope="col">Date Pay In</th>
                                <th scope="col">Money</th>
                                <th scope="col">Seri</th>


                            </tr>
                        </thead>
                        <?php
                    while ($row4 = mysqli_fetch_assoc($pay_in)) { ?>

                        <tbody>
                            <tr>
                                <td><?= $row4['username'] ?></td>
                                <td><?= $row4['date_create'] ?></td>
                                <td><?= $row4['money'] ?></td>
                                <td><?= $row4['seri'] ?></td>
                            </tr>
                        </tbody>

                        <?php } ?>

                    </table>
                    <a class="btn btn-danger top-50" href="index.php" role="button" class="col col-lg-2">Back
                        Home</a>
                </div>

                <div id="menu4" class="tab-pane fade">
                    <h3>Tolal comment: <?= $total_comment ?> comment.</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ID of App</th>
                                <th scope="col">User name</th>
                                <th scope="col">Commnent</th>
                                <th scope="col">Commnent Date</th>

                            </tr>
                        </thead>
                        <?php
                    while ($row4 = mysqli_fetch_assoc($commnent)) { ?>

                        <tbody>
                            <tr>
                                <td><?= $row4['app_id'] ?></td>
                                <td><?= $row4['username'] ?></td>
                                <td><?= $row4['comment'] ?></td>
                                <td><?= $row4['date_comment'] ?></td>
                            </tr>
                        </tbody>

                        <?php } ?>

                    </table>
                    <a class="btn btn-danger top-50" href="index.php" role="button" class="col col-lg-2">Back
                        Home</a>
                </div>
            </div>
        </div>

    </body>

</html>
