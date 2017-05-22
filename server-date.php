<?php
$concertdate = strtotime($_POST["date"]);
$serverdate = strtotime(date('Y-m-d'));
echo json_encode(($concertdate > $serverdate));
?> 