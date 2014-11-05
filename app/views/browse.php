<?php
$ses = Session::all();
echo<<<EOD
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <table border=1 style="width:100%;">
            <tr>
                <td>
                    <strong>
                        Welcome, {$ses['me']->type} {$ses['me']->fname} {$ses['me']->lname}!
                    </strong>
                </td>
                <td>
                    <a href="/secure/browse">Home</a>
                </td>
                <td>
                    <a href="/logout">Logout</a>
                </td>
            </tr>
        </table>
    </body>
</html>
EOD;
                        