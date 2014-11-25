<?php
include 'admin_header.php';
//if(isset($GET['updated']))

//if(!Session::pull('updateBackUrl'))
  //  echo "<span style='colour:red;'>Bad Credentials!</span>";


echo<<<EOD
<table border=1 style="width:100%;" id="sortme">
<thead>
    <tr>
        <th>Username</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Account Type</th>
    </tr>
</thead>
<tbody>
EOD;
foreach ($users as $user) {
echo<<<EOD
    <tr>
        <td>
            <a href="/admin/editAccount/{$user->id}">
                {$user->uname}
            </a>
        </td>
        <td>{$user->fname}</td>
        <td>{$user->lname}</td>
        <td>{$user->type}</td>
    </tr>
EOD;
}
echo<<<EOD
</tbody>
</table>
<a href="/admin/editAccount/new">New Account</a>
EOD;
