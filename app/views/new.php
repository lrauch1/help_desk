<?php
include 'header.php';
?>
<form method="post" action="/secure/new">
    <table border="1" style="width:100%">
        <tr>
            <th>Subject</th>
            <td><input type="text" name="subject" style="width:99%"></td>
        </tr>
        <tr>
            <th>Description</th>
            <td><textarea name="desc" style="width:99%;height:100px;"></textarea></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit"></td>
        </tr>
    </table>
</form>