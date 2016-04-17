<?php
if (!defined('APPPATH'))
    exit('No direct script access allowed');
/*
    File: _template1.php
    Authors: Adam, Matthew, Maxwell, Justin

    Description: Template1 is the secondary template for this site the main diffrence is that this is used when 
    a user is logged on as it has a logout button where the login section is on the main 
    template.
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>{title}</title>
        <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        
        <link rel="stylesheet" type="text/css" href="/assets/css/styles.css"/>
    </head>
    <body>
        <div class="container">
            <div id="topstuff" class="row">
                <p></p>
            </div>           
            <div id="content">
                <link rel="stylesheet" type="text/css" media="all" href="assets/css/styles.css" />
<div id='cssmenu'>
<ul class="navigation">
                <li>
                    <a class="active" href="/">Home</a>
                </li>
                <li>
                    <a href="/index.php/Portfolio">Portfolio</a>
                </li>
                <li>
                    <a href="/index.php/Assembly">Assembly</a>
                </li>
                <li>
                    <a href="/index.php/Player_page">Player Page</a>
                </li>
                <div align="right">
                <li>
                {user}
                </li>
                <button onclick="logoutFunction()"> Log Out </button>
                </div>
                
            </ul>
</div>
                {content}
            </div>
            <div id="footer" class="span12">
                Copyright &copy; 2014-2015,  <a href="mailto:someone@somewhere.com">Me</a>.
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
        <script src="/assets/js/logon.js"></script>
    </body>
</html>
