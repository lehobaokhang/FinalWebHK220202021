<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

define('HOST', '127.0.0.1');
define('USER', 'root');
define('PASS', '');
define('DB', 'database_web');

function open_database(){
    $conn = new mysqli(HOST, USER, PASS, DB);
    if ($conn->connect_error) {
        die('Connect error: ' . $conn->connect_error);
    }

    return $conn;
}

function login($user, $pass)
{
    $sql = "select * from user where username = ?";
    $conn = open_database();

    $stm = $conn->prepare($sql);
    $stm->bind_param('s', $user);
    if (!$stm->execute()) {
        return null;
    }

    $result = $stm->get_result();
    if ($result->num_rows == 0) {
        return null;
    }

    $data = $result->fetch_assoc();

    $hashed_password = $data['password'];
    if (!password_verify($pass, $hashed_password)) {
        return null;
    } else return $data;
}

function is_email_exists($email){
    $sql = 'select username from user where email = ?';
    $conn = open_database();

    $stm = $conn->prepare($sql);
    $stm->bind_param('s', $email);
    if (!$stm->execute()) {
        die('Query error: ' . $stm->error);
    }

    $result = $stm->get_result();
    if ($result->num_rows > 0) {
        return true;
    } else {
        return false;
    }
}

function checkUser($user){
    $sql = 'select username from user where username = ?';
    $conn = open_database();

    $stm = $conn->prepare($sql);
    $stm->bind_param('s',$user);
    if(!$stm->execute()){
        die ('Query error: '.$stm->error);
    }

    $result = $stm->get_result();
    if($result->num_rows > 0){
        return true;
    }
    else{
        return false;
    }
}

function register($user, $email, $first_name, $last_name, $address, $birth, $pass){
    if (is_email_exists($email)) {
        return array('code' => 1, 'error' => 'Email exists');
    }
    if(checkUser($user)){
        return array('code' => 3, 'error' => 'User name exists');
    }

    $level = 2;
    $money = 0;
    $hash = password_hash($pass, PASSWORD_DEFAULT);
    $rand = random_int(0, 1000);
    $token = md5($user . '+' .  $rand);
    $sql = 'insert into user(username, email, first_name, last_name, address, birth, money, password, activate_token, level) values(?,?,?,?,?,?,?,?,?,?)';

    $conn = open_database();
    $stm = $conn->prepare($sql);
    $stm->bind_param('ssssssissi', $user, $email, $first_name, $last_name, $address, $birth, $money, $hash, $token, $level);

    if (!$stm->execute()) {
        return array('code' => 2, 'error' => 'Can not execute command');
    }
    return
        array('code' => 0, 'error' => 'Create account successful');
}

function sendMail($email, $token) {
    $mail = new PHPMailer(true);

    try {
        //Server settings
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();       
        $mail->CharSet = 'UTF-8';                                     //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'jungjung.now@gmail.com';                     //SMTP username
        $mail->Password   = 'lwjdjuihsvejmvge';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        //Recipients
        $mail->setFrom('jungjung.now@gmail.com', 'QTV meApp');
        $mail->addAddress($email, 'Receiver');     //Add a recipient
        /*$mail->addAddress('ellen@example.com');               //Name is optional
        $mail->addReplyTo('info@example.com', 'Information');
        $mail->addCC('cc@example.com');
        $mail->addBCC('bcc@example.com');*/

        //Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Reset Password';
        $mail->Body    = "<p>Hi! Im admin meApp,</p>
        <p>Thanks for use us service!</p>
        <p>Click <a href ='localhost/source/resetPassword.php?email=$email&token=$token'>here</a> to reset your password!</p>"; 
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

function resetPassword($email) {
    if(!is_email_exists($email)) {
        return array('code' => 1, 'error' => 'Email does not exists!');
    }
    $token = md5($email . '+' . random_int(1000, 2000));
    $sql = 'update reset_token set token = ? where email = ?';
    $sql = 'update reset_token set expire_on = ? where email = ?';
    
    $conn = open_database();
    $stm = $conn->prepare($sql);
    $stm->bind_param('ss', $token, $email);

    if(!$stm->execute()) {
        return array('code' => 2, 'error' => 'Can not excute command!');
    }

    if($stm->affected_rows == 0) {
        $exp = time() + 3600*24;
        $sql = 'insert into reset_token values(?,?,?)';
        $stm = $conn->prepare($sql);
        $stm->bind_param('ssi', $email, $token, $exp);

        if($stm->execute()) {
            return array('code' => 1, 'error' => 'Can not excute command!');
        }
    }
    $success = sendMail($email, $token);
    return array('code' => 1, 'success' => $success);
    
}

function update_new_password($email, $pass){
    $hash = password_hash($pass, PASSWORD_DEFAULT);
    $sql = 'update user set password = ? where email = ?';

    $conn = open_database();
    $stm = $conn->prepare($sql);
    $stm->bind_param('ss',$hash,$email);

    if(!$stm->execute()){
        return array('code' => 2, 'error' => 'Cant Execute');
    }

    return array('code' => 0, 'error' => 'Password is changed successfully!');
}

function change_password($user, $pass){
    $hash = password_hash($pass, PASSWORD_DEFAULT);
    $sql = 'update user set password = ? where username = ?';

    $conn = open_database();
    $stm = $conn->prepare($sql);
    $stm->bind_param('ss',$hash,$user);

    if(!$stm->execute()){
        return array('code' => 2, 'error' => 'Cant Execute');
    }

    return array('code' => 0, 'error' => 'Password is changed successfully!');
}

function update_profile($user, $first_name, $last_name, $address, $birth) {
    $sql = 'update user set first_name = ?, last_name = ?, address = ?, birth = ? where username = ?';

    $conn = open_database();
    $stm = $conn->prepare($sql);
    $stm->bind_param('sssss', $first_name, $last_name, $address, $birth,$user);

    if (!$stm->execute()) {
        return array('code' => 1, 'error' => 'Can execute command');
    }
    return array('code' => 0, 'error' => 'Update your profile successfully!');

}

function getInformation($user) {
    $conn = open_database();

    $sql = 'select * from user where username = ?';
    
    $stm = $conn->prepare($sql);
    $stm->bind_param('s', $user);
    $stm->execute();
    $data = $stm->get_result();
    return $data;
}

function getFullInformation() {
    $conn = open_database();

    $sql = 'select * from user';
    
    $stm = $conn->prepare($sql);
    
    $stm->execute();
    $data = $stm->get_result();
    return $data;
}

function countUser() {
    $conn = open_database();
    $sql = 'select count(*) from user';

    $stm = $conn->prepare($sql);
    $stm->execute();

    $count = $stm->get_result();
    $count = $count->fetch_assoc();
    $data = $count['count(*)'];
    return $data;
}


function updateDev ($user, $money, $level) {

    $conn = open_database();

    $sql = 'update user set money = (? - 500000), level = (? - 1) where username = ?';
    
    $stm = $conn->prepare($sql);
    $stm ->bind_param('iis',$money, $level, $user);

    if (!$stm->execute()) {
        return array('code' => 1, 'error' => 'Can execute command');
    }
    return array('code' => 0, 'error' => 'Update your profile successfully!');
}


function payment($user, $money, $seri){
    $conn = open_database();
    $exp = 0;
    $date_create = (date("d-m-Y",time()));
    $sql = 'insert into payment(username, date_create, money, seri, exp) values(?,?,?,?,?)';

    
    $stm = $conn->prepare($sql);
    $stm->bind_param('ssiii', $user, $date_create, $money, $seri, $exp);

    if (!$stm->execute()) {
        return array('code' => 2, 'error' => 'Can not execute command');
    }
    return
        array('code' => 0, 'error' => 'Create account successful');
}


function  pay_fif($user, $money) {

    $conn = open_database();

    $sql = 'update user set money = (? + 50000) where username = ?';
    
    $stm = $conn->prepare($sql);
    $stm ->bind_param('is',$money, $user);

    if (!$stm->execute()) {
        return array('code' => 1, 'error' => 'Can execute command');
    }
    return array('code' => 0, 'error' => 'Update your profile successfully!');
}

function  pay_onehu($user, $money) {

    $conn = open_database();

    $sql = 'update user set money = (? + 100000) where username = ?';
    
    $stm = $conn->prepare($sql);
    $stm ->bind_param('is',$money, $user);

    if (!$stm->execute()) {
        return array('code' => 1, 'error' => 'Can execute command');
    }
    return array('code' => 0, 'error' => 'Update your profile successfully!');
}

function  pay_twohu($user, $money) {

    $conn = open_database();

    $sql = 'update user set money = (? + 200000) where username = ?';
    
    $stm = $conn->prepare($sql);
    $stm ->bind_param('is',$money, $user);

    if (!$stm->execute()) {
        return array('code' => 1, 'error' => 'Can execute command');
    }
    return array('code' => 0, 'error' => 'Update your profile successfully!');
}

function  pay_fivehu($user, $money) {

    $conn = open_database();

    $sql = 'update user set money = (? + 500000) where username = ?';
    
    $stm = $conn->prepare($sql);
    $stm ->bind_param('is',$money, $user);

    if (!$stm->execute()) {
        return array('code' => 1, 'error' => 'Can execute command');
    }
    return array('code' => 0, 'error' => 'Update your profile successfully!');
}

function getHistoryPayment($user) {
    $conn = open_database();

    $sql = 'select * from payment where username = ?';
    
    $stm = $conn->prepare($sql);
    $stm->bind_param('s', $user);
    $stm->execute();
    $data = $stm->get_result();
    return $data;
}

function createMoney($number, $option_money) {
    $conn = open_database();
    
    $check_seri = 'select * from create_money where seri = ?';

    $stm = $conn->prepare($check_seri);


    for($i = 0; $i < $number; $i++){
        while(true) {
            $seri = random_int(1000000000,2147483647);
            
            $stm->bind_param('i',$seri);
            
            $stm->execute();

            $temp1 = $stm->get_result();
            $temp2 = $temp1->fetch_assoc();

            if (empty($temp2)) {
                
                    $date_create_money = (date("d-m-Y",time()));
                    $exp = 1;
                    $sql = 'insert into create_money(option_money, seri, exp, date_create_money) values(?,?,?,?)';
                    
                    $stm2 = $conn->prepare($sql);
                    $stm2->bind_param('iiis', $option_money, $seri, $exp, $date_create_money);

                    if (!$stm2->execute()) {
                                return array('code' => 2, 'error' => 'Can not execute command');
                    }
                    break;
            }
        }

    }
    return array('code' => 0, 'error' => 'Create account successful');
}

function getFullSeri($seri_data) {
    $conn = open_database();

    $sql = 'select * from create_money where seri = ?';
    
    $stm = $conn->prepare($sql);
    
    $stm->bind_param('i', $seri_data);
    $stm->execute();

    $data = $stm->get_result();
    $data1 = $data->fetch_assoc();

    return $data1;
}

function getFullMoney () {
    $conn = open_database();

    $sql = 'select * from create_money';
    
    $stm = $conn->prepare($sql);
    
    $stm->execute();
    $data = $stm->get_result();
    return $data;
}

function updateExpCode($seri){
    $conn = open_database();

    $sql = 'update create_money set exp = 0 where seri = ?';

    $stm = $conn->prepare($sql);
    $stm ->bind_param('i',$seri);

    if (!$stm->execute()) {
        return array('code' => 1, 'error' => 'Can execute command');
    }
    return array('code' => 0, 'error' => 'Update your profile successfully!');
}

function getFullAppInfo() {
    $conn = open_database();

    $sql = 'select * from app_info';
    
    $stm = $conn->prepare($sql);
    
    $stm->execute();
    $data = $stm->get_result();
    return $data;
}


function countApp() {
    $conn = open_database();
    $sql = 'select count(*) from app_info';

    $stm = $conn->prepare($sql);
    $stm->execute();

    $count = $stm->get_result();
    $count = $count->fetch_assoc();
    $data = $count['count(*)'];
    return $data;
}

function countTotalMoneyCard() {
    $conn = open_database();
    $sql = 'select count(*) from create_money';

    $stm = $conn->prepare($sql);
    $stm->execute();

    $count = $stm->get_result();
    $count = $count->fetch_assoc();
    $data = $count['count(*)'];
    return $data;
}


function getFullAppDownload() {
    $conn = open_database();

    $sql = 'select * from download_info';
    
    $stm = $conn->prepare($sql);
    
    $stm->execute();
    $data = $stm->get_result();
    return $data;
}


function countTotalAppDpwnload() {
    $conn = open_database();
    $sql = 'select count(*) from download_info';

    $stm = $conn->prepare($sql);
    $stm->execute();

    $count = $stm->get_result();
    $count = $count->fetch_assoc();
    $data = $count['count(*)'];
    return $data;
}

function getFullCommnent() {
    $conn = open_database();

    $sql = 'select * from app_comment';
    
    $stm = $conn->prepare($sql);
    
    $stm->execute();
    $data = $stm->get_result();
    return $data;
}

function countTotalComment() {
    $conn = open_database();
    $sql = 'select count(*) from app_comment';

    $stm = $conn->prepare($sql);
    $stm->execute();

    $count = $stm->get_result();
    $count = $count->fetch_assoc();
    $data = $count['count(*)'];
    return $data;
}

function getFullPayin() {
    $conn = open_database();

    $sql = 'select * from payment';
    
    $stm = $conn->prepare($sql);
    
    $stm->execute();
    $data = $stm->get_result();
    return $data;
}

function countTotalPayin() {
    $conn = open_database();
    $sql = 'select count(*) from payment';

    $stm = $conn->prepare($sql);
    $stm->execute();

    $count = $stm->get_result();
    $count = $count->fetch_assoc();
    $data = $count['count(*)'];
    return $data;
}



function
uploadApp($appname, $short_des, $detail_des, $theloai, $giaban, $username_of_dev)
{
    $error = array();
    $appstatus = 1;

    if ($appname != '') {
        $appstatus++;
    } else return array("Vui lòng nhập tên ứng dụng");
    if ($short_des != '') {
        $appstatus++;
    }
    if ($detail_des != '') {
        $appstatus++;
    }
    if ($theloai != '') {
        $appstatus++;
    }
    $sql = 'insert into app_info (app_id, app_name, kind_id, short_describe, detail_describe, app_price, app_status, app_name_dev) values(?, ?, ?, ?, ?, ?, ?, ?)';
    $conn = open_database();
    $stm = $conn->prepare($sql);

    $temp = "select MAX(app_id) FROM app_info";
    $stm1 = mysqli_query($conn, $temp);
    $row = mysqli_fetch_assoc($stm1);
    $result = $row['MAX(app_id)'];

    $app_id = (int)$result + 1;

    if ($theloai === "Ứng dụng") {
        $kind = 1;
    } elseif ($theloai === "Trò chơi") {
        $kind = 2;
    } elseif ($theloai === "Office") {
        $kind = 3;
    } else {
        $kind = 0;
    }

    $filepath = 'uploads/' . $app_id;
    if (!file_exists($filepath))
        mkdir($filepath);

    if ($_FILES['icon']['size'] > 0) {
        $extention_icon = pathinfo($_FILES['icon']['name'], PATHINFO_EXTENSION);
        if (!in_array($extention_icon, ['jpg'])) {
            array_push($error, "Định dạng file icon không đúng");
        } else {
            $app_icon = 'icon_' . $appname . '.' . $extention_icon;
            $tmp_icon = $_FILES['icon']['tmp_name'];
            if (!move_uploaded_file($tmp_icon, 'uploads/' . $app_id . '/' . $app_icon)) {
                array_push($error, "Upload app icon không thành công");
            } else $appstatus++;
        }
    }
    if ($_FILES['installfile']['size'] > 0) {
        $appstatus++;
        $extenions_install = pathinfo($_FILES['installfile']['name'], PATHINFO_EXTENSION);
        $install_size = $_FILES['installfile']['size'];

        if ($install_size > 10 * 1024 * 1024) {
            array_push($error, "Kích thước file cài đặt của app quá lớn. Kích thước tối đa là 10MB");
        } else if (!in_array($extenions_install, ['zip'])) {
            array_push($error, "Định dạng file cài đặt không đúng");
        } else {
            $app_install = 'install_' . $appname . '.' . $extenions_install;
            $tmp_install = $_FILES['installfile']['tmp_name'];

            if (!move_uploaded_file($tmp_install, 'uploads/' . $app_id . '/' . $app_install)) {
                array_push($error, "Upload app install không thành công");
            } else $appstatus++;
        }

        if (!uploadScreenshot($app_id))
            array_push($error, "Upload app screenshot không thành công. Vui lòng kiểm tra lại screenshot bạn upload.");
        else $appstatus++;
    }
    if ($appstatus >= 8) $appstatus = 1;
    else $appstatus = 0;

    $stm->bind_param('isissiis', $app_id, $appname, $kind, $short_des, $detail_des, $giaban, $appstatus, $username_of_dev);

    if (empty($error)) {
        if (!$stm->execute()) {
            array_push($error, "Thêm dữ liệu vào hệ thống thất bại");
        }
    }
    return $error;
}

function uploadScreenshot($appid)
{
    if ($_FILES['screenshot']['size'][0] != 0) {
        $allowed = array("jpg", "png");
        foreach ($_FILES['screenshot']['name'] as $key => $val) {
            $extention = pathinfo($val, PATHINFO_EXTENSION);
            if (!in_array($extention, $allowed)) {
                return false;
            }
        }

        foreach ($_FILES['screenshot']['name'] as $key => $val) {
            $extention = pathinfo($val, PATHINFO_EXTENSION);
            $screenshot_name = 'Screenshot' . $key . '.' . $extention;

            $tmp_screenshot = $_FILES['screenshot']['tmp_name'][$key];

            if (!move_uploaded_file($tmp_screenshot, 'uploads/' . $appid . '/' . $screenshot_name)) {
                return false;
            }
        }
    }
    return true;
}


function getTopAppbyKind($top, $kind_id)
{
    $conn = open_database();
    $sql = "select * from app_info where kind_id = " . $kind_id . " order by app_downloads desc limit ?," . $top;
    $stm = $conn->prepare($sql);

    for ($i = 0; $i < $top; $i++) {
        $stm->bind_param('i', $i);
        $stm->execute();
        $result = $stm->get_result();
        $data = mysqli_fetch_assoc($result);
        showApp($data);
    }
}

function getTopAppbyDownLoad($top)
{
    $conn = open_database();
    $sql = "select * from app_info order by app_downloads desc limit ?," . $top;
    $stm = $conn->prepare($sql);

    for ($i = 0; $i < $top; $i++) {
        $stm->bind_param('i', $i);
        $stm->execute();
        $result = $stm->get_result();
        $data = mysqli_fetch_assoc($result);
        showApp($data);
    }
}


function showApp($info)
{
    if ($info['app_price'] === 0) $temp = 'Miễn phí';
    else $temp = $info['app_price'] . ' VNĐ';
    $image_path = './uploads/' . $info['app_id'] . '/icon_' . $info['app_name'] . '.jpg';

    echo '<article class="book-card bg-white my-1 d-block">';
    echo '<img src="' . $image_path . '" class="book-card-img d-block">';
    echo '<div class="p-half pointer d-flex flex-column justify-between h-200">';
    echo '<p class="font-style-2 font-size-md color-1 pointer black-highlight">' . $info['app_name'] . '</p>';
    echo '<div>';
    echo '<p class="font-size-sm font-style-2 color-3 gray-highlight"> ' . $info['app_name_dev'] . '</p>';
    echo '<p class="font-size-s font-style-2 color-3  py-1 gray-highlight">Rating: ' . $info['app_rate'] . '/5</p>';
    echo '<p class="py-1 d-flex justify-between align-center">';
    echo '<span class="font-size-md color-1 font-style-2 gray-highlight">' . $temp . '</span>';
    echo '<a href="index.php?app_id=' . $info['app_id'] . '" class="default-btn font-size-sm font-style-2 bg-color-1 mr-half my-half">Xem</span></a>';
    echo '</p> ';
    echo '</div>';
    echo '</div> ';
    echo '</article>';
}

function getInfoApp($app_id)
{
    $conn = open_database();
    $sql = "select * from app_info where app_id = ?";
    $stm = $conn->prepare($sql);
    $stm->bind_param('i', $app_id);
    $stm->execute();
    $result = $stm->get_result();
    $data = mysqli_fetch_assoc($result);
    return $data;
}

function downloadApp($app_id, $app_name, $app_downloads, $price, $user, $name_dev)
{
    $conn = open_database();
    $filepath = 'uploads/' . $app_id . '/install_' . $app_name . '.zip';
    echo $app_downloads;
    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filepath));
        ob_clean();
        flush();
        readfile($filepath);

        $newCount = $app_downloads + 1;
        $updateCount = "update app_info set app_downloads = " . $newCount . "where id= " . $app_id;
        $sql = "insert into download_info(username, app_name, download_date, price, name_dev) values(?,?,?,?,?)";
        $stm = $conn->prepare($sql);
        $date_create = (date("d-m-Y", time()));
        $stm->bind_param('sssis', $user, $app_name, $date_create, $price, $name_dev);
        $stm->execute();
        mysqli_query($conn, $updateCount);
        exit;
    }
}


function search_result($search)
{
    $temp = array();
    $conn = open_database();
    $sql = "select * from app_info";
    $stm = mysqli_query($conn, $sql);
    $data = mysqli_fetch_all($stm);

    foreach ($data as $key) {
        if (strpos(strtolower($key[1]), strtolower($search))) {
            array_push($temp, $key);
        }
    }
    return $temp;
}


function getFilebyDevName($app_name_dev)
{
    $conn = open_database();
    $sql = "select * from app_info where app_name_dev = ?";
    $stm = $conn->prepare($sql);
    $stm->bind_param('s', $app_name_dev);
    $stm->execute();
    $result = $stm->get_result();
    $data = mysqli_fetch_all($result);
    return $data;
}

function addRequest()
{
    $conn = open_database();
    $sql = "insert into app_censorship(app_id) values(?)";
    $stm = $conn->prepare($sql);
    $stm->bind_param('i', $_GET['request_id']);
    $stm->execute();
}

function getAppRequest()
{
    $conn = open_database();
    $sql = "select * from app_censorship where admin_confirm = 0";
    $stm = mysqli_query($conn, $sql);
    $data = mysqli_fetch_all($stm);
    return $data;
}

function confirmApp($app_id)
{
    $conn = open_database();
    $sql = "update app_censorship SET admin_confirm=? WHERE app_id = ?";
    $sql1 = "update app_info SET app_upload=? WHERE app_id = ?";
    $stm = $conn->prepare($sql);
    $stm1 = $conn->prepare($sql1);
    $temp = 1;
    $stm->bind_param('ii', $temp, $app_id);
    $stm1->bind_param('ii', $temp, $app_id);
    $stm->execute();
    $stm1->execute();
}

function getAllInfoApp()
{
    $conn = open_database();
    $sql = 'select * from app_info';
    $stm = mysqli_query($conn, $sql);
    $data = mysqli_fetch_all($stm);
    return $data;
}

function buyApp($app_id, $app_name, $app_downloads, $user, $price, $name_dev)
{
    $conn = open_database();
    $sql = "select * from user where username = ?";
    $stm = $conn->prepare($sql);
    $stm->bind_param('s', $user);
    $stm->execute();
    $temp = $stm->get_result();
    $data = $temp->fetch_assoc();
    if ($data['money'] >= $price) {
        $sql1 = "update user set money = ? where username = ?";
        $stm1 = $conn->prepare($sql1);
        $money_new = $data['money'] - $price;
        $stm1->bind_param('is', $money_new, $user);
        $stm1->execute();
        downloadApp($app_id, $app_name, $app_downloads, $price, $user, $name_dev);
    } else {
        echo '<script>
            alert("Bạn không đủ tiền trong tài khoản");
            </script>';
        return;
    }
}

function getAllCmt($app_id)
{
    $conn = open_database();
    $sql = "select * from app_comment where app_id = ?";
    $stm = $conn->prepare($sql);
    $stm->bind_param('i', $app_id);
    $stm->execute();
    $temp = $stm->get_result();
    $data = $temp->fetch_all();
    return $data;
}

function postCmt($app_id, $user, $commentapp)
{
    $conn = open_database();
    $sql = "insert into app_comment(app_id, username, comment, date_comment) values(?,?,?,?)";
    $stm = $conn->prepare($sql);
    $date_create = (date("d-m-Y", time()));
    $stm->bind_param('isss', $app_id, $user, $commentapp, $date_create);
    $stm->execute();
}

function getOrder($dev)
{
    $conn = open_database();
    $sql = "select * from download_info where name_dev=? and price > 0";
    $temp = 0;
    $stm = $conn->prepare($sql);
    $stm->bind_param('s', $dev);
    $stm->execute();
    $data = $stm->get_result();
    return $data->fetch_all();
}

function checkDownloadApp($user, $dev, $name_app)
{
    $conn = open_database();
    $sql = "select * from download_info where name_dev= ? and username=? and app_name=?";
    $stm = $conn->prepare($sql);
    $stm->bind_param('sss', $dev, $user, $name_app);
    $stm->execute();
    $data = $stm->get_result();
    return $data->fetch_all();
}
