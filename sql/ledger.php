<html>
    <head>
        <link rel="stylesheet" href="style.css">
    </head>
<?php

require_once("config.php");

define('DEVELOPER', true);
if(DEVELOPER) {
error_reporting(E_ALL);
ini_set("display_errors",1);
ini_set("error_log",'myLogFile.log');
}

if (isset($_POST["newledger_submit"])) {
    // check to see if owner is valid
    $q1 = $db->prepare("SELECT ownerid FROM owner WHERE ownerid = :buyerid");
    $q1->bindValue(":buyerid", $_POST["buyerid"], SQLITE3_INTEGER);
    $r1 = $q1->execute();
    $owner = null;

    if ($owners = $r1->fetchArray(SQLITE3_ASSOC)) {
        $owner = $owners["ownerid"];
    }

    //grab information for the specific nftid
    $q = $db->prepare("SELECT ownerid, nftid, price, julianday(CURRENT_TIMESTAMP) - julianday(lastbought) 
        AS daysowned FROM nft WHERE nftid = :nftid");
    $q->bindValue(":nftid", $_POST["nftid"], SQLITE3_INTEGER);
    $r = $q->execute();
    $nft = $r->fetchArray(SQLITE3_ASSOC);

    if(isset($nft) && isset($owner)) {
            $sellerid = $nft["ownerid"];
            $sellerprice = $nft["price"];
            $daysowned = $nft["daysowned"];
        if (($nft["nftid"] == $_POST["nftid"]) && ($nft["ownerid"] != $_POST["buyerid"])) {
            $insert = $db->prepare("INSERT INTO ledger (nftid, buyerid, buyerprice, sellerid, sellerprice, sellerdaysowned) 
                VALUES (:nftid, :buyerid, :purchaseprice, :sellerid, :sellerprice, :daysowned)");
            $insert->bindValue(":nftid", $_POST["nftid"], SQLITE3_INTEGER);
            $insert->bindValue(":buyerid", $_POST["buyerid"], SQLITE3_INTEGER);
            $insert->bindValue(":purchaseprice", $_POST["purchaseprice"], SQLITE3_FLOAT);
            $insert->bindValue(":sellerid", $sellerid, SQLITE3_INTEGER);
            $insert->bindValue(":sellerprice", $sellerprice, SQLITE3_FLOAT);
            $insert->bindValue(":daysowned", $daysowned, SQLITE3_TEXT);
            $insert->execute();

            $update = $db->prepare("UPDATE nft SET ownerid = :ownerid, price = :price, lastbought = CURRENT_TIMESTAMP
                WHERE nftid = :nftid");
            $update->bindValue(":nftid", $_POST["nftid"], SQLITE3_INTEGER);
            $update->bindValue(":ownerid", $_POST["buyerid"], SQLITE3_INTEGER);
            $update->bindValue(":price", $_POST["purchaseprice"], SQLITE3_FLOAT);
            
            $update->execute();
        }
    }
}
require_once("nav.php");

$insertForm = new PhpFormBuilder();

$insertForm->add_input("NFT ID", array(
    "type" => "number",
    "min" => "0",
    "step" => "1",
    "required" => true
), "nftid");
$insertForm->add_input("New Owner's ID", array(
    "type" => "number",
    "min" => "0",
    "step" => "1",
    "required" => true
), "buyerid");
$insertForm->add_input("Purchase price", array(
    "type" => "number",
    "required" => true,
    "min" => "0.00",
    "step" => "0.01",
    "placeholder" => "1.00"
), "purchaseprice");
$insertForm->add_input("Buy", array(
    "type" => "submit",
    "value" => "Buy"
), "newledger_submit");

echo "<h4>Create NFT Purchase</h4>";
$insertForm->build_form();

$select = $db->prepare("SELECT * from ledger");
$ledgerResults = $select->execute();
$ledger = [];
while ($ledgerRow = $ledgerResults->fetchArray(SQLITE3_ASSOC)) {
    $ledger []= $ledgerRow;
}

echo makeTable($ledger);
?>

</html>

