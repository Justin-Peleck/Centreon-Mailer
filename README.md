# Centreon Mailer

Centreon Mailer is a notification mobule for sending notifications by e-mail.

Is a script for generating Centreon issue notifications in a more colorful and readable HTML format.

It is based on Macros available under the URL: https://assets.nagios.com/downloads/nagioscore/docs/nagioscore/3/en/macrolist.html#hoststate

The basic idea is inspired by the script of LLFT https://github.com/LLFT/Centreon-Notification-PHP

## Fonctionnalités

- **Hosts Notification**: The Module sends email notifications when the Host is unavailable, unplayable etc...
- **Services Notification**: The Module sends email notifications when the service is unavailable, unplayable etc..

## Technology Using

- **Mail Format** : [HTML, CSS]
- **Script** : [PHP, PHPMailer]


## Requirement:
_ Server PHP 7 or older installed on your Poller

## SETUP

### On your Server 
 
* Copy the script to __/usr/lib64/nagios/plugins/mail/__

* Edit the script __/usr/lib64/nagios/plugins/mail/notify-by-email-php.php__ Configure your server's configuration information (host, port, user, password etc.) in config/config.php: 
      
* __Make the file executable__


### On Centreon 
 
* create a notification command named: __notify-by-email-php__
* Fill in the command line field with this: 
> $USER1$/mail/centreon-mailer/centreon-mailer.php "NOTIFICATIONTYPE=$NOTIFICATIONTYPE$" "HOSTNAME=$HOSTNAME$" "HOSTALIAS=$HOSTALIAS$" "HOSTADDRESS=$HOSTADDRESS$" "HOSTDURATION=$HOSTDURATION$" "HOSTID=$HOSTID$" "HOSTSTATE=$HOSTSTATE$" "HOSTOUTPUT=$HOSTOUTPUT$" "LASTHOSTCHECK=$LASTHOSTCHECK$" "LASTHOSTSTATECHANGE=$LASTHOSTSTATECHANGE$" "LASTSERVICECHECK=$LASTSERVICECHECK$" "LASTSERVICESTATECHANGE=$LASTSERVICESTATECHANGE$" "LONGDATETIME=$LONGDATETIME$" "NOTIFICATIONAUTHOR=$NOTIFICATIONAUTHOR$" "NOTIFICATIONCOMMENT=$NOTIFICATIONCOMMENT$" "SERVICEDESC=$SERVICEDESC$" "SERVICEID=$SERVICEID$" "SERVICEOUTPUT=$SERVICEOUTPUT$" "SERVICESTATE=$SERVICESTATE$" "SERVICEDURATION=$SERVICEDURATION$" "NOTIFICATIONNUMBER=$NOTIFICATIONNUMBER$" "CONTACTEMAIL=$CONTACTEMAIL$"

* Activate the Shell and Save
* Then you just have to create a contact template that points to the new notification.
* To finish by generating the files that are going well

## TEST

* If you want to test sending mail from your server

>  php -f mail/centreon-mailer/centreon-mailer.php "NOTIFICATIONTYPE=PROBLEM" "HOSTNAME=HOSTNAME" "HOSTALIAS=HOSTALIAS" "HOSTADDRESS=HOSTADDRESS" "HOSTDURATION=HOSTDURATION" "HOSTID=HOSTID" "HOSTSTATE=HOSTSTATE" "HOSTOUTPUT=HOSTOUTPUT" "LASTHOSTCHECK=1616083992" "LASTHOSTSTATECHANGE=1616083992" "LASTSERVICECHECK=1616083992" "LASTSERVICESTATECHANGE=1616083992" "LONGDATETIME=LONGDATETIME" "NOTIFICATIONAUTHOR=NOTIFICATIONAUTHOR" "NOTIFICATIONCOMMENT=NOTIFICATIONCOMMENT" "SERVICEDESC=SERVICEDESC" "SERVICEID=SERVICEID" "SERVICEOUTPUT=SERVICEOUTPUT" "SERVICESTATE=SERVICESTATE" "SERVICEDURATION=SERVICEDURATION" "NOTIFICATIONNUMBER=NOTIFICATIONNUMBER" "CONTACTEMAIL=__YOUR-EMAIL-ADDRESS__"

