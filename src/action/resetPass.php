<?php
include("../includes/init.php");
if (isset($_POST['email'])) {
    $json = new stdClass();
    $json->status = "fail";
    $json->msg = "Failed to connect to the database.";
    try {

        $con = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

        if (!$con || $con->connect_errno) {
            die("Connection Failed: " . $con->connect_errno);
        }

        $email = sanitizeInput($_POST['email']);

        $sql = "SELECT uid, fname, lname, uEmail FROM User WHERE uEmail = ? LIMIT 1";
        if ($stmt = $con->prepare($sql)) {

            $stmt->bind_param('s', $email);
            $stmt->execute();
            $stmt->bind_result($uid, $fname, $lname, $uEmail);
            while ($stmt->fetch()) {

            }
            if ($uid) {

                //There was a User with this email, generate new reset token
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $randstring = "";
                for ($i = 0; $i < 32; $i++) {
                    $offset = rand(0, strlen($characters) - 1);
                    $randstring .= $characters[$offset];
                }

                $sql2 = "UPDATE User SET authToken = ? WHERE uid = ?";
                if ($pstmt = $con->prepare($sql2)) {
                    $pstmt->bind_param('si', $randstring, $uid);
                    $pstmt->execute();
                    $pstmt->close();

                    //Send email to user
                    $to = $uEmail;
                    $headers = "From: QSCUStore@noreply.qscu.shop\r\n";
                    $headers .= "Content-type: text/html; charset=utf-8";
                    $subject = "QSCU Store - Forgot Password";
                    $txt = "<html><head></head><body><p>Hello, " . $fname . " " . $lname . "!</p>";
                    $txt .= "<p>It seems that you recently requested a password reset.</p>";
                    $txt .= "<p>To complete this process, simply follow the link below:</p>";
                    //TODO: Make sure on the final website that this URL below gets evaluated correctly
                    $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . "?uid=" . $uid . "&token=" . $randstring;
                    $url = str_replace("action/resetPass.php", "confirmResetPass.php", $url);
                    $txt .= "<a href=" . $url . ">" . $url . "</a>";
                    $txt .= "<br><br><p>Sincerly, the QSCU Team</p></body></html>";

                    mail($to, $subject, $txt, $headers);
                    $json->status = "success";
                    $json->to = $to;
                    $json->subject = $subject;
                    $json->headers = $headers;
                    $json->msg = "Successfully sent email.";
                } else {
                    $json->status = "fail";
                    $json->msg = "Something went wrong1...";
                }

            } else {
                $json->status = "fail";
                $json->msg = "No users found with this email.";
            }
            $stmt->close();
        } else {
            $json->status = "fail";
            $json->msg = "Something went wrong1...";
        }

    } catch (Exception $e) {
        $json->status = "fail";
        $json->msg = "Failed to connect to the database.";
    }
    print json_encode($json);
}