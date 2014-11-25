<?php
include 'admin_header.php';
//echo '<h2 id=update>User updated!</h2>';
$typeSelect="<select name=type>";
foreach (User::$user_types as $type) {
    $typeSelect.="<option";
    if($user->type==$type)
        $typeSelect.=" selected";
    $typeSelect.=">$type</option>";
}
$typeSelect.="</select>";

if(!Session::pull('newAccount')){
$submits="<input type='submit' name='submit' value='Modify'>"
        . "<input type='submit' name='submit' value='Delete'>";
Session::put('updateBackUrl', "/admin/editAccount/{$user->id}");
}else{
$submits="<input type='submit' name='submit' value='Create'>"
        . "<input type='submit' name='submit' value='Cancel'>";
Session::put('updateBackUrl', "/admin/accounts");
}

echo<<<EOD
<form method="post" action="/secure/update/user/{$user->id}">
<!-- fake fields are a workaround for disabling chrome autofill -->
<input style="display:none" type="text" name="fakeusernameremembered"/>
<input style="display:none" type="password" name="fakepasswordremembered"/>

    <table border="1">
        <tr>
            <th>Username:</th>
            <td><input type="text" name="uname" value="{$user->uname}"></td>
        </tr>
        <tr>
            <th>First Name:</th>
            <td><input type="text" name="fname" value="{$user->fname}"></td>
        </tr>
        <tr>
            <th>Last Name:</th>
            <td><input type="text" name="lname" value="{$user->lname}"></td>
        </tr>
        <tr>
            <th>Password:</th>
            <td><input type="password" name="npword" value="iamadefaultvalue"></td>
        </tr>
        <tr>
            <th>Type:</th>
            <td>{$typeSelect}</td>
        </tr>
        <tr>
            <th></th>
            <td>{$submits}</td>
        </tr>
    </table>
</form>
EOD;
            