<?php
/*
    File: _template.php
    Authors: Adam, Matthew, Maxwell, Justin

    Description: _template.php is the main template it is used when the user is currently logged out.
*/
if (!defined('APPPATH'))
    exit('No direct script access allowed');
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
                <div align="right">

                <li>
                <input id="username" >Username</input>
                <input id="password" type="password">Password</input>
                <button onclick="window.location.assign('/index.php/Register/index/')"> Register </button>
                <button onclick="logonFunction()"> Log in </button>
                </li>
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
