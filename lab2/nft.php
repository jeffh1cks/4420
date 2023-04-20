<?php

require_once("config.php");

if (isset($_POST["newnft_submit"])) {
    $insert = $db->prepare("INSERT INTO nft (nftname, price, ownerid, payload) 
    VALUES (:nftname, :nftprice, :nftowner, :payload)");
    
    $insert->bindValue(":nftname", $_POST["nftname"], SQLITE3_TEXT);
    $insert->bindValue(":nftprice", $_POST["nftprice"], SQLITE3_FLOAT);
    $insert->bindValue(":nftowner", $_POST["nftowner"], SQLITE3_INTEGER);
    $insert->bindValue("payload", $_POST["payload"], SQLITE3_BLOB);
    
    $insert->execute();

    $le = $db->lastErrorMsg();
    if (strlen($le) > 0 && $le !== "not an error") {
        echo "<br>$le<br>";
    }
    echo "<br>";
}
require_once("nav.php");

$insertForm = new PhpFormBuilder();
$insertForm->set_att('enctype', 'multipart/form-data');

$insertForm->add_input("New NFT's name", array(), "nftname");
$insertForm->add_input("New NFT's price ($)", array(
    "type" => "number",
    "step" => 0.01,
    "placeholder" => "1.00",
    "min" => "0.00"
), "nftprice");
$insertForm->add_input("New NFT's ownerid", array(
    "type" => "number",
    "step" => 1,
    "min" => "1"
), "nftowner");
$insertForm->add_input("New NFT's content", array(
    "required" => true
), "payload");
$insertForm->add_input("New", array(
    "type" => "submit",
    "value" => "Create"
), "newnft_submit");

$insertForm->build_form();

$showForm = new PhpFormBuilder();
$showForm->set_att('enctype', 'multipart/form-data');
$showForm->add_input("Search by NFT ID", array(
    "type" => "number",
    "step" => "1",
    "min"  => "0"
), "shownft_id");
$showForm->add_input("Show", array(
    "type" => "submit",
    "value" => "Show NFTs"
), "shownft_submit");

$showForm->build_form();

$showOwnerForm = new PhpFormBuilder();
$showOwnerForm->add_input("Search by Owner ID", array(
    "type" => "number",
    "step" => "1",
    "min"  => "0"
), "ownerid");
$showOwnerForm->add_input("Show", array(
    "type" => "submit",
    "value" => "Show NFTs by owner"
), "shownftowner_submit");

$showOwnerForm->build_form();

function displayNFT($nft, $cols) {
    $output = "<div>";
    
    foreach($cols as $col) {
        if ($nft[$col] == "") continue;
        
        if ($col === "price") {
            $nft[$col] = '$' . number_format($nft[$col], 2);
        }
        $output .= $col . ": " . $nft[$col] . "<br>";

    }

    $output .= "</div>";

    echo $output . "<br>";
}

if (isset($_POST["shownft_submit"])) {
    $q = null;
    $nftToSearch = null;

    if (!empty($_POST["shownft_id"])) {
        $nftToSearch =  htmlspecialchars($_POST["shownft_id"]);
        $q = $db->prepare("SELECT *, length(payload) as bytes FROM nft where nftid = :nftid");
        $q->bindValue(":nftid", $nftToSearch, SQLITE3_INTEGER);
    }
    else {
        $q = $db->prepare("SELECT *,  length(payload) as bytes FROM nft order by createdon desc");
    }
    

    $r = $q->execute();
    
    $cols = [];

    $rows = [];
    
    while($nft = $r->fetchArray(SQLITE3_ASSOC)) {
        if (count($cols) === 0) {
            $cols = array_keys($nft);
        }

        $rows []= $nft;
    }

    if (count($rows) === 0) {
        if ($nftToSearch !== null) {
            echo "No NFTs found with nftid $nftToSearch<br>";
        }
        else {
            echo "No NFTs found<br>";
        }
        
    }

    else {
        foreach($rows as $nft) {
            displayNFT($nft, $cols);
        }
    }
}

if (isset($_REQUEST["ownerid"])) {
    $q = null;
    $ownerid = null;

    if (isset($_REQUEST["ownerid"])) {
        if (!empty($_REQUEST["ownerid"]) || $_REQUEST["ownerid"] === "0") {
            $ownerid =  intval(htmlspecialchars($_REQUEST["ownerid"]));
        }
    }

    if ($ownerid !== null) {
        $q = $db->prepare("SELECT *,  length(payload) as bytes FROM nft where ownerid = :ownerid");
        $q->bindValue(":ownerid", $ownerid, SQLITE3_INTEGER);
    }
    else {
        $q = $db->prepare("SELECT *,  length(payload) as bytes FROM nft order by createdon desc");
    }
    

    $r = $q->execute();
    
    $cols = [];

    $rows = [];
    
    while($nft = $r->fetchArray(SQLITE3_ASSOC)) {
        if (count($cols) === 0) {
            $cols = array_keys($nft);
        }

        $rows []= $nft;
    }

    if (count($rows) === 0) {
        if ($ownerid !== null) {
            echo "No NFTs found with ownerid $ownerid<br>";
        }
        else {
            echo "No NFTs found<br>";
        }
        
    }

    else {
        foreach($rows as $nft) {
            displayNFT($nft, $cols);
        }
    }
}



?>

