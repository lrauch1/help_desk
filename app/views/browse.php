<?php
include 'header.php';
echo<<<EOD
<table border=1 style="width:100%;" id="sortme">
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
EOD;
switch($ses['me']->type){
    case "Admin":
        $toDisplay = $tickets;//admins see all
        break;
    case "Technician":
        $toDisplay = [];//technicians see unassigned and assigned to self
        foreach ($tickets as $ticket)
            if($ticket->tech_id==1||$ticket->tech_id==$ses['me']->id)
                $toDisplay[] = $ticket;
        break;
    case "User":
        $toDisplay = [];//users only see tickets they created
        foreach ($tickets as $ticket)
            if($ticket->creator_id==$ses['me']->id)
                $toDisplay[] = $ticket;
        break;
    default:
        die("Something broke!");//we should never get to here unless i break something
}
foreach ($toDisplay as $ticket) {
echo<<<EOD
    <tr>
        <td>{$ticket->status}</td>
        <td>{$ticket->subject}</td>
        <td>{$ticket->priority}/5</td>
        <td>{$ticket->creator->fname} {$ticket->creator->lname}</td>
        <td>{$ticket->created}</td>
        <td>{$ticket->tech->fname} {$ticket->tech->lname}</td>
    </tr>
EOD;
}
echo<<<EOD
</tbody>
</table>
</body>
</html>
EOD;
var_dump($toDisplay);
