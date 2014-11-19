<?php
include 'admin_header.php';
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
foreach ($tickets as $ticket) {
echo<<<EOD
    <tr>
        <td>{$ticket->status}</td>
        <td>
            <a href="/admin/editTicket/{$ticket->id}">
                {$ticket->subject}
            </a>
        </td>
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
EOD;
