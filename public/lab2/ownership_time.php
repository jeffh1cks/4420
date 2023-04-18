<?php

require_once("config.php");
require_once("nav.php");

define('DEVELOPER', true);
if(DEVELOPER) {
error_reporting(E_ALL);
ini_set("display_errors",1);
ini_set("error_log",'myLogFile.log');
}

// TODO #3: right now this page only shows the amount of time an NFT has been 
// owned since its last purchase. It does not take into account any previous
// ownership of NFTs. 

// So if an owner currently does not own any NFTs, but has
// owned many in the past, that owner's info is missing from this page.

// Try to come up with a query that, for each nft and owner combination, displays
// the cumulative amount of time of ownership - past and present. You may need to 
// utilize SQLite's date/time functions, along with any of the following:

// inner joins, left/right outer joins, subqueries, aggregate functions.

// use aggregate functions to sum seconds owned for nftid ownerid combo

//tried to get data for sellerid and sellerdayowned from ledger but no success

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

// $q1 = $db->prepare("SELECT nftid, sellerid as ownerid, SUM(sellerdaysowned *24 *3600) as secondsowned from ledger group by nftid, sellerid;");
// $r1 = $q1->execute();
// $sellerLedger = [];
// while($sellerinfo = $r1->fetchArray(SQLITE3_ASSOC)) {
//     $sellerLedger [] = $sellerinfo;
//}

//$ledger1 = array_merge($ledger,$sellerLedger);
echo makeTable($ledger);
?>

