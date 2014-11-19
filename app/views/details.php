<?php
include 'header.php';
//var_dump($ticket);
echo<<<EOD
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
        <td>{$ticket->status}</td>
        <td>
            <a href="/secure/details/{$ticket->id}">
                {$ticket->subject}
            </a>
        </td>
        <td>{$ticket->priority}/5</td>
        <td>{$ticket->creator->fname} {$ticket->creator->lname}</td>
        <td>{$ticket->created}</td>
        <td>{$ticket->tech->fname} {$ticket->tech->lname}</td>
    </tr>
</tbody>
</table>
<form method=post action="/secure/details/$id">
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
echo<<<EOD
<tr>
<td>{$msg->user->fname} {$msg->user->lname}</td>
<td>{$msg->timestamp}</td>
<td class=content>{$msg->text}</td>
</tr>
EOD;
}
$disabler = ($ticket->status=="Closed" || $ticket->status=="Cancelled")? "disabled": "enabled";
//disables inputs if ticket is closed or cancelled
echo<<<EOD
    <tr>
            <td>{$ses['me']->fname} {$ses['me']->lname}</td>
                        <td>Change Status: <select name=status {$disabler}>
EOD;
echo "<option selected>{$ticket->status}</option>";
if(($ticket->status=="New" || $ticket->status=="Stalled")&&($ses['me']->type=="Technician"||$ses['me']->type=="Admin"))
echo '<option>In Progress</option>';
if(($ticket->status=="New" || $ticket->status=="In Progress" || $ticket->status=="Stalled")&&($ses['me']->type=="Technician"||$ses['me']->type=="Admin"))
echo '<option>Closed</option>';
if(($ticket->status=="In Progress" || $ticket->status=="New" || $ticket->status=="Stalled")&& $ses['me']->type=="User")
echo '<option>Cancelled</option>';
if($ticket->status=="In Progress"&&($ses['me']->type=="Technician"||$ses['me']->type=="Admin"))
echo '<option>Stalled</option>';
echo<<<EOD
                </select><br><center><input type=submit value=Send {$disabler}></center>
            </td>
            <td><input type=text name=msg style="width:100%" autocomplete=no {$disabler}></td>
    </tr>
</table>
</form>
EOD;
            