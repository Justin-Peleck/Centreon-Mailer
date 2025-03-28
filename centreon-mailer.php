<?php

/*
 * DO NOT ALTER OR REMOVE COPYRIGHT NOTICES OR THIS HEADER.
 *
 * Copyright (c) 2023-2024 Oracle and/or its affiliates. All rights reserved.
 *
 * Oracle and Java are registered trademarks of Oracle and/or its affiliates.
 * Other names may be trademarks of their respective owners.
 *
 * The contents of this file are subject to the terms of either the GNU
 * General Public License Version 2 only ("GPL") or the Common
 * Development and Distribution License("CDDL") (collectively, the
 * "License"). You may not use this file except in compliance with the
 * License. You can obtain a copy of the License at
 * http://www.netbeans.org/cddl-gplv2.html
 * or nbbuild/licenses/CDDL-GPL-2-CP. See the License for the
 * specific language governing permissions and limitations under the
 * License.  When distributing the software, include this License Header
 * Notice in each file and include the License file at
 * nbbuild/licenses/CDDL-GPL-2-CP.  Oracle designates this
 * particular file as subject to the "Classpath" exception as provided
 * by Oracle in the GPL Version 2 section of the License file that
 * accompanied this code. If applicable, add the following below the
 * License Header, with the fields enclosed by brackets [] replaced by
 * your own identifying information:
 * "Portions Copyrighted [year] [name of copyright owner]"
 *
 * If you wish your version of this file to be governed by only the CDDL
 * or only the GPL Version 2, indicate your decision by adding
 * "[Contributor] elects to include this software in this distribution
 * under the [CDDL or GPL Version 2] license." If you do not indicate a
 * single choice of license, a recipient has the option to distribute
 * your version of this file under either the CDDL, the GPL Version 2 or
 * to extend the choice of license to its licensees as provided above.
 * However, if you add GPL Version 2 code and therefore, elected the GPL
 * Version 2 license, then the option applies only if the new code is
 * made subject to such option by the copyright holder.
 *
 * Contributor(s):
 *
 */



/**
 * Centreon Mailer
 * @author Justin N'GUESSAN <Justin Peleck Peniel>
 * @copyright (c) 2025, Justin N'GUESSAN
 * @version 1.0
 * @email : justin.nguessan@africanticgroup.com
 * @email : justinpeleck@gmail.com
 * @website https://africanticgroup.com
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';

//Load Composer's autoloader
require 'vendor/autoload.php';

//Load Config
require 'config/config.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

//Create an config instance;
//$server = new Config();


parse_str(implode('&', array_slice($argv, 1)), $_GET);

if (empty($_GET)) {
    echo "parameters is null";
    exit(1);
}


//htmlentities()
$url = Config::server_address();
$notifType = $_GET['NOTIFICATIONTYPE'];
$hostName = $_GET['HOSTNAME'];
$hostAlias = $_GET['HOSTALIAS'];
$hostAddress = $_GET['HOSTADDRESS'];
$hostDuration = $_GET['HOSTDURATION'];
$hostId = $_GET['HOSTID'];
$hostState = $_GET['HOSTSTATE'];
$hostOutput = $_GET['HOSTOUTPUT'];
$lastHostCheck = date('m/d/Y H:i:s', $_GET['LASTHOSTCHECK']);
$lastHostStateChange = date('m/d/Y H:i:s', $_GET['LASTHOSTSTATECHANGE']);
$lastServiceCheck = date('m/d/Y H:i:s', $_GET['LASTSERVICECHECK']);
$lastServiceStateChange = date('m/d/Y H:i:s', $_GET['LASTSERVICESTATECHANGE']);
$longDateTime = $_GET['LONGDATETIME'];
$notificationAuthor = $_GET['NOTIFICATIONAUTHOR'];
$notificationComment = $_GET['NOTIFICATIONCOMMENT'];
$serviceDesc = $_GET['SERVICEDESC'];
$serviceId = $_GET['SERVICEID'];
$serviceOutput = $_GET['SERVICEOUTPUT'];
$serviceState = $_GET['SERVICESTATE'];
$serviceDuration = $_GET['SERVICEDURATION'];
$notificationNumber = $_GET['NOTIFICATIONNUMBER'];
$contactEmail = $_GET['CONTACTEMAIL'];

switch ($hostState) {

    case 'UP':
        $bgc_hostState = "#87bd23";
        break;
    case 'DOWN':
        $bgc_hostState = "#ed1c24";
        break;
    case 'UNREACHABLE':
        $bgc_hostState = "#818285";
        break;
    default :
        $bgc_hostState = "#666666";
        break;
}

switch ($serviceState) {
    case 'WARNING':
        $bgc_serviceState = "#f48400";
        break;
    case 'CRITICAL':
        $bgc_serviceState = "#f40000";
        break;
    case 'OK':
        $bgc_serviceState = "#00b71a";
        break;
    default :
        $bgc_serviceState = "#666666";
        break;
}

switch ($notifType) {
    case 'PROBLEM':
        $bgc_notifType = "#ffb24e";
        break;
    case 'RECOVERY':
        $bgc_notifType = "#87bd23";
        break;
    case 'ACKNOWLEDGEMENT':
        $bgc_notifType = "#edd91c";
        break;
    default :
        $bgc_notifType = "#666666";
        break;
}


try {
    //Server settings
    $mail->SMTPDebug = false;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host = Config::server_host();                     //Set the SMTP server to send through
    $mail->SMTPAuth = true;                                   //Enable SMTP authentication
    $mail->Username = Config::server_user();                     //SMTP username
    $mail->Password = Config::server_password();                               //SMTP password
    $mail->SMTPSecure = Config::server_security();            //Enable implicit TLS encryption
    $mail->Port = Config::server_port();                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom(Config::server_mail_config()['form_email'], Config::server_mail_config()['form_email']);
    $mail->addAddress($_GET['CONTACTEMAIL'], 'Admin Centreon');     //Add a recipient
    $mail->addReplyTo(Config::server_mail_config()['reply_email'], Config::server_mail_config()['reply_name']);

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = "[CENTREON] $notifType $hostName [$hostState]";

    $body = '<html>';
    $body .= "<head><meta charset='UTF-8'><meta http-equiv='Content-type' content='text/html; charset=UTF-8'></head>\r\n";
    $body .= "<body>\r\n";
    $body .= "<table border=0 width='98%' cellpadding=0 cellspacing=0>\r\n";
    $body .= "<tr><td valign='top'>\r\n";
    $body .= "<table border=0 cellpadding=0 cellspacing=0 width='98%'>\r\n";
    $body .= "<tr bgcolor=$bgc_hostState><td><b>Hostname: </b></td><td><a href='$url/centreon/main.php?p=20202&o=hd&host_name=$hostName'>$hostAlias [$hostState]</a></td></tr>\r\n";
    $body .= "<tr bgcolor=#fefefe><td><b>Address: </b></td><td>$hostAddress</td></tr>\r\n";
    $body .= "<tr bgcolor=#eeeeee><td><b>Date/Time: </b></td><td>$longDateTime</td></tr>\r\n";
    if ($notificationNumber > 1) {
        $body .= "<tr bgcolor=#fefefe><td><b>Notification: </b></td><td>$notificationNumber</td></tr>\r\n";
    }
    if (empty($serviceId)) {
        $body .= "<tr bgcolor=#fefefe><td><b>Info: </b></td><td><font color=$bgc_hostState>$hostOutput</font></td></tr>\r\n";
        $body .= "<tr bgcolor=#eeeeee><td><b>Last host check: </b></td><td>$lastHostCheck</td></tr>\r\n";
        $body .= "<tr bgcolor=#fefefe><td><b>Last Host State Change: </b></td><td>$lastHostStateChange</td></tr>\r\n";
    } else {
        $body .= "</table>\r\n";
        $body .= "</td></tr>\r\n";
        $body .= "<tr><td valign='top'>\r\n";
        $body .= "<table border=0 cellpadding=0 cellspacing=0 width='88%'>\r\n";
        $body .= "<tr bgcolor=$bgc_serviceState><td><b>Service: </b></td><td><a href='$url/centreon/main.php?p=20201&o=svcd&host_name=$hostName&service_description=$serviceDesc'>$serviceDesc [$serviceState]</a></td></tr>\r\n";
        $body .= "<tr bgcolor=$bgc_serviceState><td colspan=2 style='text-align:center'><font color=ffffff>Service Summary</font></b></td></tr> \r\n";
        $body .= "<tr bgcolor=#fefefe><td><b>Service Output : </b></td><td>$serviceOutput</td></tr>\r\n";
        $body .= "<tr bgcolor=#eeeeee><td><b>Last Service Check : </b></td><td>$lastServiceCheck</td></tr>\r\n";
        $body .= "<tr bgcolor=#fefefe><td><b>Last State Change : </b></td><td>$lastServiceStateChange</td></tr>\r\n";
        if ($serviceState != 'OK') {
            $body .= "<tr bgcolor=#eeeeee><td><b>Service Duration: </b></td><td>$serviceDuration</td></tr>\r\n";
        }
    }

    if ($notifType == 'PROBLEM') {
        if (empty($serviceId)) {
            $body .= "<tr bgcolor=$bgc_hostState><td><b>Actions: </b></td><td><a href='$url/centreon/main.php?p=20202&o=hak&cmd=14&host_name=$hostName&en=1'>Acknowledge</a></td></tr>\r\n";
        } else {
            $body .= "<tr bgcolor=$bgc_serviceState><td><b>Actions: </b></td><td><a href='$url/centreon/main.php?p=20201&o=svcak&cmd=15&host_name=$hostName&service_description=$serviceDesc&en=1'>Acknowledge</a></td></tr>\r\n";
        }
    }
    if ($notifType == 'ACKNOWLEDGEMENT') {
        $body .= "<tr bgcolor=$bgc_notifType><td width='140'><b>Comment :</font></b></td><td><b>$notificationComment</b> - by $notificationAuthor </td></tr>\r\n";
    }
    $body .= "</table>\r\n";
    $body .= "</td></tr>\r\n";
    $body .= "</table>\r\n";
    $body .= "</body></html>\r\n";

    $mail->Body = $body;

    /* Send eMail Now... */
    $mail->send();

} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
