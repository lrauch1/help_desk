<?php

include 'admin_header.php';
echo "<h2 style=\"text-align:center;display:none;\" id=update>Ticket Updated!</h2>";
$created = str_replace(" ", "T", $ticket->created);
$creatorSelect = "<select name=creator_id>";
foreach ($users as $user) {
    if ($user->id == 1)
        continue; //skip "Not Assigned" dummy user
    $creatorSelect .= "<option value={$user->id}";
    if ($ticket->creator_id == $user->id)
        $creatorSelect .= " selected";
    $creatorSelect .= ">{$user->fname} {$user->lname}</option>";
}
$creatorSelect .= "</select>";
$techSelect = "<select name=tech_id>";
foreach ($users as $user) {
    $techSelect .= "<option value={$user->id}";
    if ($ticket->tech_id == $user->id)
        $techSelect .= " selected";
    $techSelect .= ">{$user->fname} {$user->lname}</option>";
}
$techSelect .= "</select>";
Session::put('updateBackUrl', "/admin/editTicket/$id");
echo<<<EOD
<form method=post action="/secure/update/ticket/$id">
<table border=1 style="width:100%;">
<thead>
    <tr>
        <th>Status</th>
        <th>Subject</th>
        <th>Priority</th>
        <th>Created By</th>
        <th>Created On</th>
        <th>Assigned To</th>
    </tr>
</thead>
<tbody>
    <tr>
        <td>
            <select name=status>
EOD;
foreach (Ticket::$status_types as $status) {
    echo "<option";
    if ($ticket->status == $status)
        echo " selected";
    echo ">$status</option>";
}
echo<<<EOD
            </select>
        </td>
        <td><input type=text name=subject value="{$ticket->subject}"></td>
        <td><input type=number name=priority min=1 max=5 value={$ticket->priority}>/5</td>
        <td>{$creatorSelect}</td>
        <td><input type=datetime-local name=created value="{$created}"></td>
        <td>{$techSelect}</td>
        <td><input type=submit name=submit value=Modify><br><input type=submit name=submit value=Delete></td>
    </tr>
</tbody>
</table>
</form>
<!--form method=post action="/secure/details/$id"-->
<table border=1 style="width:100%;">
    <col style="width:10%">
    <col style="width:15%">
    <col style="width:75%">
    <tr>
        <th>User</th>
        <th>Time</th>
        <th>Message</th>
    </tr>
EOD;
foreach ($messages as $msg) {
    $timestamp = str_replace(" ", "T", $msg->timestamp);
    $usrSelect = "<select name=user_id>";
    foreach ($users as $user) {
        if ($user->id == 1)
            continue; //skip "Not Assigned" dummy user
        $usrSelect .= "<option value={$user->id}";
        if ($msg->user_id == $user->id)
            $usrSelect .= " selected";
        $usrSelect .= ">{$user->fname} {$user->lname}</option>";
    }
    $usrSelect .= "</select>";
    echo<<<EOD
<form method=post action="/secure/update/message/{$msg->id}">
<tr>
<td>{$usrSelect}</td>
<td><input type=datetime-local name=timestamp value="{$timestamp}"></td>
<td class=content><textarea name=text style="width:100%;height:100px;">{$msg->text}</textarea></td>
<td><input type=submit name=submit value=Modify><br><input type=submit name=submit value=Delete></td>
</tr>
</form>
EOD;
}
echo<<<EOD
    <tr>
        <td>{$ses['me']->fname} {$ses['me']->lname}</td>
        <td><center><input type=submit value=Send></center>
        </td>
        <td><input type=text name=msg style="width:100%" autocomplete=no></td>
    </tr>
</table>
<!--/form-->
EOD;
