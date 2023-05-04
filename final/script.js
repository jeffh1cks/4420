function displayResult(response) {
    if (response.id == 2){
        let output = "";
        for (let res of response.result) {
            if (res.name == $('#ownerName').val()) {output = ""}
            output += `ownerid: ${res.id}<br>`
            output += `ownername: ${res.name}<br>`
            output += `NFTs: ${res.nfts.length}<br>`
            output += `<br>`
            if (res.name == $('#ownerName').val()) {break;}
        }
        $(`#getOwnersResponse`).html(output)
    }
    else if (response.id == 4){
        let output = "";
        for (let res of response.result) {
            if (res.id == $('#nftid').val()) {output = ""}
            output += `nftid: ${res.id}<br>`
            output += `ownerid: ${res.ownerid}<br>`
            output += `nftname: ${res.name}<br>`
            output += `price: $${res.price}<br>`
            output += `Created On: ${res.createdon}<br>`
            output += `Last Bought: ${res.lastbought}<br>`
            output += `Payload: ${res.payload}<br>`
            output += `Bytes: ${res.bytes}<br>`
            output += `<br>`
            if (res.id == $('#nftid').val()) {break;}
        }
        $(`#getNftsResponse`).html(output)
    }
    else if (response.id == 5){
        let output = "";
        let nftownerid = $('#nftownerid').val();
        if (nftownerid == "") {
            for (let res of response.result) {
                output += `nftid: ${res.id}<br>`
                output += `ownerid: ${res.ownerid}<br>`
                output += `resname: ${res.name}<br>`
                output += `price: $${res.price}<br>`
                output += `Created On: ${res.createdon}<br>`
                output += `Last Bought: ${res.lastbought}<br>`
                output += `Payload: ${res.payload}<br>`
                output += `Bytes: ${res.bytes}<br>`
                output += `<br>`
            }
        }
        for (let res of response.result) {
            if (res.ownerid == $('#nftownerid').val()) {
                output += `nftid: ${res.id}<br>`
                output += `ownerid: ${res.ownerid}<br>`
                output += `resname: ${res.name}<br>`
                output += `price: $${res.price}<br>`
                output += `Created On: ${res.createdon}<br>`
                output += `Last Bought: ${res.lastbought}<br>`
                output += `Payload: ${res.payload}<br>`
                output += `Bytes: ${res.bytes}<br>`
                output += `<br>`
            }
        }
        $(`#getNftsResponse`).html(output)
    }
}
function displayError(xhr, statusCode, err) {
    let output = ""
    output += `ERROR: ${error} <br>`
    output += `MESSAGE: ${xhr.responseJSON.error.message}`

    $(`#error`).html(output)
    $("#error").removeClass("hidden");
}

function sendRequestOwners(request){
    $("#error").html("")
    $("#error").addClass("hidden")

    $.ajax({
        url: "https://jhicks.cs3680.com/api/owner",
        type: "POST",
        data: JSON.stringify(request),
        contentType: "application/json; charset=utf-8",
        datatype: "json",
        success: displayResult,
        error: displayError,
    })
}
function sendRequestNfts(request){
    $("#error").html("")
    $("#error").addClass("hidden")

    $.ajax({
        url: "https://jhicks.cs3680.com/api/nft",
        type: "POST",
        data: JSON.stringify(request),
        contentType: "application/json; charset=utf-8",
        datatype: "json",
        success: displayResult,
        error: displayError,
    })
}

$("#createOwner").click(function(){
    let request = {
        method: "createOwner",
        params: {
            name: $("#name").val(),
        },
        id: 1,
        jsonrpc: 2.0,
    }
    sendRequestOwners(request);
})

$("#getOwners").click(function(){
    let request = {
        method: "getOwners",
        params: {
        },
        id: 2,
        jsonrpc: 2.0,
    }
    sendRequestOwners(request);
})
$("#createNft").click(function(){
    let request = {
        method: "createNft",
        params: {
            ownerid: $("#ownerid").val(),
            name: $("#name").val(),
            price: $("#price").val(),
            payload: $("#payload").val()
        },
        id: 3,
        jsonrpc: 2.0,
    }
    sendRequestNfts(request);
})
$("#getNfts").click(function(){
    let request = {
        method: "getNfts",
        params: {
        },
        id: 4,
        jsonrpc: 2.0,
    }
    sendRequestNfts(request);
})
$("#getOwnersNft").click(function(){
    let request = {
        method: "getNfts",
        params: {
        },
        id: 5,
        jsonrpc: 2.0,
    }
    sendRequestNfts(request);
})
