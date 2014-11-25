<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
$ses = Session::all();
if ($ses['auth'] == 1)
    echo "<h1><span style='colour:red;'>Please verify credentials to login as admin</span></h1>";
else
    echo "<h1><span style='colour:red;'>Welcome to the ticket manager, please log in or register</span></h1>";
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ticket Manager</title>
    </head>
    <body>
        <table>
            <form method="post" action="/logincheck">
                <tr>
                    <td>Username</td>
                    <td><input type="text" name="uname"></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><input type="password" name="pword"></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" value="Login"></td>
                </tr>
                <tr>
                    <td colspan="2" style="textalign:center;">
                        <?php
                        if (isset($_GET['badcreds']))
                            echo "<span style='colour:red;'>Bad Credentials!</span>";
                        ?>
                    </td>
                </tr>
            </form>
        </table>
        <a href="/register">Register</a>
    </body>
</html>