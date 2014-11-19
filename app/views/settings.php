<?php
include 'header.php';
echo <<<EOD
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
    </table>
</form>
EOD;
            