<html>
    <head>
        <link rel="stylesheet" href="style.css">
    </head>

<?php

require_once("config.php");

if (isset($_POST["newowner_submit"])) {
    $insert = $db->prepare("INSERT INTO owner (ownername) VALUES (:name)");

    $insert->bindValue(":name", $_POST["ownername"], SQLITE3_TEXT);

    $insert->execute();

    $le = $db->lastErrorMsg();
    if (strlen($le) > 0 && $le !== "not an error") {
        echo "<br>$le<br>";
    }

    echo "<br>";
}

require_once("nav.php");

$insertForm = new PhpFormBuilder();

$insertForm->add_input("New Owner's name", array(), "ownername");
$insertForm->add_input("New", array(
    "type" => "submit",
    "value" => "Create"
), "newowner_submit");

$insertForm->build_form();

$showForm = new PhpFormBuilder();
$showForm->add_input("Search by Owner Name", array(
    "type" => "text",
), "showowner_name");
$showForm->add_input("Show", array(
    "type" => "submit",
    "value" => "Show Owner"
), "showowner_submit");

$showForm->build_form();

function displayOwner($owner, $cols) {
    $output = "";
    
    foreach($cols as $col) {
        if ($col === "NFTs") {
            $output .= $col . ": <a href=\"nft.php?ownerid=" . $owner["ownerid"] . "\">". $owner[$col] . "</a><br>";
        }
        else {
            $output .= $col . ": " . $owner[$col] . "<br>";
        }
    }

    echo $output . "<br>";
}

if (isset($_POST["showowner_submit"])) {
    $q = null;
    $name = null;

    if (!empty($_POST["showowner_name"])) {
        $name =  htmlspecialchars($_POST["showowner_name"]);
        $q = $db->prepare("SELECT owner.*, count(nftid) as NFTs FROM owner left join nft on owner.ownerid = nft.ownerid where lower(ownername) like lower(:name) group by owner.ownerid");
        $q->bindValue(":name", "%$name%", SQLITE3_TEXT);
    }
    else {
        $q = $db->prepare("SELECT owner.*, count(nftid) as NFTs FROM owner left join nft on owner.ownerid = nft.ownerid  group by owner.ownerid order by ownerid desc");
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
        if ($name !== null) {
            echo "No owners found by the name $name<br>";
        }
        else {
            echo "No owners found<br>";
        }
        
    }

    else {
        foreach($rows as $nft) {
            displayOwner($nft, $cols);
        }
    }
}


?>
</html>

