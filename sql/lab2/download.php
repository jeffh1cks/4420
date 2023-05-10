<?php

require_once("config.php");

if (isset($_REQUEST["download_nftid"])) {
    $nftid = intval(htmlspecialchars($_REQUEST["download_nftid"]));

    $q = $db->prepare("select payloadtype, length(payload) as numbytes, payloadfilename, payload from nft where nftid = :nftid");
    $q->bindParam(":nftid", $nftid, SQLITE3_INTEGER);
    $r = $q->execute();

    if ($data = $r->fetchArray(SQLITE3_ASSOC)) {
        header("Content-length: " . $data["numbytes"]);
        header("Content-type: " . $data["payloadtype"]);
        header("Content-Disposition: attachment; filename=" . $data["payloadfilename"]);
        ob_clean();
        flush();
        echo $data["payload"];
    }
    else {
        echo "no file found by nftid " . $nftid;
    }

    unset($_POST["download_nftid"]);
}
else {
    echo "no";
}


?>