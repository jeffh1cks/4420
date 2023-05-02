<html>
    <head>
        <link rel="stylesheet" href="style.css">
    </head>
</html>
<?php

require_once("config.php");
require_once("nav.php");

define('DEVELOPER', true);
if(DEVELOPER) {
error_reporting(E_ALL);
ini_set("display_errors",1);
ini_set("error_log",'myLogFile.log');
}

$select = $db->prepare("SELECT nftid, ownerid, round((sum(daysowned)* 24 * 3600),2) as secondsowned
From 
(
SELECT nftid, ownerid, (julianday(current_timestamp) - julianday(lastbought)) as daysowned from nft
Union all
SELECT nftid, sellerid as ownerid, SUM(sellerdaysowned) as daysowned from ledger group by nftid, sellerid
)
Group by nftid, ownerid order by round((sum(daysowned) *24*3600),2) desc");
$ledgerResults = $select->execute();
$ledger = [];

while ($ledgerRow = $ledgerResults->fetchArray(SQLITE3_ASSOC)) {
    $ledger []= $ledgerRow;
}

echo makeTable($ledger);
?>

