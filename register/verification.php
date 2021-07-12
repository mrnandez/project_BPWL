<?php

require 'vendor/autoload.php';
require_once 'register-system.php';
require_once '../config.php';

// Create the Transport
$transport = (new Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl'))
  ->setUsername(EMAIL)
  ->setPassword(PASSWORD)
;

// Create the Mailer using your created Transport
$mailer = new Swift_Mailer($transport);

function sendVerificationUsername($username, $token)
{
    global $mailer;

    $body = "
    <!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>
    <html xmlns='http://www.w3.org/1999/xhtml'>
    <head>
        <meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=1' />
        
        <style>
        .body {
            background-color: #3498db
        }
    
        a {
            color: inherit;
            text-decoration: none !important;
            text-decoration: none;
        }
    
        a.cta_button {
            color: #fff
        }
    
        @media only screen {
            html {
                min-height: 100%;
                background: 0 0
            }
        }
    
        @media only screen and (max-width:596px) {
    
            .row{
                width:100%!important;
                width:100%;
            }
            
            .fi{
                font-size:14px!important;
            }
            .ttl, .ttl a{
                font-size: 22px!important;
            }
            .dscr, .dscr p, .dscr span{
                font-size: 18px !important;
            }
            .small-12 .dscr{
                width: 100%;
                width:100%!important;
                min-width:100%;
            }
            .small-float-center, .small-text-center {
                text-align: center !important;
            }
            .small-float-center {
                margin: 0 auto !important;
                float: none !important;
            }
            .small-text-left {
                text-align: left !important;
            }
            .small-text-right {
                text-align: right !important;
            }
            .hide-for-large {
                display: block !important;
                width: auto !important;
                overflow: visible !important;
                max-height: none !important;
                font-size: inherit !important;
                line-height: inherit !important
            }
            center{
                min-width:0!important;
            }
            table.container{
                width: 100%!important;
            }
            table.body table.container .hide-for-large, table.body table.container .row.hide-for-large {
                display: table !important;
                width: 100% !important
            }
            table.body table.container .callout-inner.hide-for-large {
                display: table-cell !important;
                width: 100% !important
            }
            table.body table.container .show-for-large {
                display: none !important;
                width: 0;
                mso-hide: all;
                overflow: hidden
            }
            td.small-1, td.small-10, td.small-11, td.small-12, td.small-2, td.small-3, td.small-4, td.small-5, td.small-7, td.small-8, td.small-9, th.small-1, th.small-10, th.small-11, th.small-12, th.small-2, th.small-3, th.small-4, th.small-5, th.small-7, th.small-8, th.small-9 {
                display: inline-block !important
            }
            table.body img {
                width: auto;
                height: auto
            }
            table.body center {
                min-width: 0 !important
            }
            table.body .container {
                width: 95% !important
            }
            table.body .column, table.body .columns {
                height: auto !important;
                -moz-box-sizing: border-box;
                -webkit-box-sizing: border-box;
                box-sizing: border-box;
            }
            table.body .columns.large-6, table.body .columns.large-4, table.body .columns.large-3{
                padding-left: 8px !important;
                padding-right: 8px !important
            }
            table.body .collapse .column, table.body .collapse .columns, table.body .column .column, table.body .column .columns, table.body .columns .column, table.body .columns .columns {
                padding-left: 0 !important;
                padding-right: 0 !important
            }
            td.small-1, th.small-1 {
                width: 8.33333% !important
            }
            td.small-2, th.small-2 {
                width: 16.66667% !important
            }
            td.small-3, th.small-3 {
                width: 25% !important
            }
            td.small-4, th.small-4, img.small-4 {
                width: 33.33333% !important
            }
            td.small-5, th.small-5 {
                width: 41.66667% !important
            }
            td.small-6, th.small-6, img.small-6 {
                display: inline-block !important;
                width: 50% !important
            }
            td.small-7, th.small-7 {
                width: 58.33333% !important
            }
            td.small-8, th.small-8 {
                width: 66.66667% !important
            }
            td.small-9, th.small-9 {
                width: 75% !important
            }
            td.small-10, th.small-10 {
                width: 83.33333% !important
            }
            td.small-11, th.small-11 {
                width: 91.66667% !important
            }
            td.small-12, th.small-12, img.small-12 {
                width: 100% !important
            }
            .column td.small-12, .column th.small-12, .columns td.small-12, .columns th.small-12 {
                display: block !important;
                width: 100% !important
            }
            img.sclbtn{
                min-width:24px!important;
                min-height:24px!important;
                max-width:100px!important;
                max-width:100px!important;
            }
        }
        </style>
    </head>
 <td style='font-size: 20px;line-height:1;border:none;background-color:#fda11f;;padding: 13px 30px; -webkit-border-radius: 5px; -moz-border-radius:5px; border-radius:5px;' bgcolor='#fda11f'>
 <a class='cta_button' href='http://localhost/projects/register/confirm.php?code=$token' target='_blank' style='line-height:1;display:block;font-style:normal;font-size: 20px; font-family: helvetica,arial,verdana,sans-serif; font-weight: normal; color:#ffffff; text-decoration: none; display: inline-block;'>
 Verifikasi
 </a>
</td>
    </body>
        </html>";

    // Create a message
    $message = (new Swift_Message('Verifikasi Email - IniStore'))
->setFrom(['no-reply@ad4msan.blog' => 'Wandi'])
->setTo($username)
->setBody($body, 'text/html')
;

    // Send the message
    $result = $mailer->send($message);
}
