<?php
include 'header.php';
echo <<<EOD
<h2 style="text-align:center;display:none;" id=update>Settings Updated!</h2>
<form method="post" action="/secure/update/user/{$ses['me']->id}">
    <table border="1">
        <tr>
            <th>First Name:</th>
            <td><input type="text" name="fname" value="{$ses['me']->fname}"></td>
        </tr>
        <tr>
            <th>Last Name:</th>
            <td><input type="text" name="lname" value="{$ses['me']->lname}"></td>
        </tr>
        <tr>
            <th>Username:</th>
            <td><input type="text" name="uname" value="{$ses['me']->uname}"></td>
        </tr>
        <tr>
            <th>Current Password:<br><span class="small">(required)</span></th>
            <td><input type="password" name="opword"></td>
        </tr>
        <tr>
            <th>New Password:</th>
            <td><input type="password" name="npword"></td>
        </tr>
        <tr>
            <th>Confirm Password:</th>
            <td><input type="password" name="cpword"></td>
        </tr>
        <tr>
            <th></th>
            <td><input type="submit"></td>
        </tr>
            <tr>
            <td colspan="2" style="textalign:center;">
EOD;
    if(isset($_GET['badpass']))
        echo "<span style='color:red;'>Incorrect Password!</span>";
    if(isset($_GET['badconfirm']))
        echo "<span style='color:red;'>New Passwords Don't Match!</span>";
echo<<<EOD
            </td>
        </tr>
    </table>
</form>
EOD;
            