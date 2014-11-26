<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Help Desk</title>
    </head>
    <body>
        <h1>Welcome to the Help Desk, please log in or register</h1>
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
            </form>
            <tr>
                <td colspan="2" style="textalign:center;">
                    <?php
                        if(isset($_GET['badcreds']))
                            echo "<span style='color:red;'>Bad Credentials!</span>";
                    ?>
                </td>
            </tr>
        </table>
        <a href="/register">Register</a>
    </body>
</html>