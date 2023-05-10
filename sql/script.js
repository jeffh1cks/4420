function nftOutput(result) {
    let output = ""
    output += `nftid: ${result.nftid}<br>`
    output += `ownerid: ${result.ownerid}<br>`
    output += `nftname: ${result.nftname}<br>`
    output += `price: $${result.price}<br>`
    output += `Created On: ${result.createdon}<br>`
    output += `Last Bought: ${result.lastbought}<br>`
    output += `Payload: ${result.payload}<br>`
    output += `<br>`
    return output;
}
function ownerOutput(result) {
    let output = ""
    output += `ownerid: ${result.ownerid}<br>`
    output += `ownername: ${result.ownername}<br>`
    output += `Nfts: ${result.NFTs}<br>`
    output += `<br>`
    return output
}

function displayResult(response) {
    if (response.id == 1) {
        $(`#getOwnersResponse`).text(response.result)
    }
    else if (response.id == 2){
        let output = "";
        if (response.result.length > 0){
            if($('#ownerName').val()) {
                let valid = false
                for (let res of response.result) {
                    if (res.name == $('#ownerName').val()) {output = ownerOutput(res); valid = true}
                }
                if (!valid) {output = `No owners found by the name ${$('#ownerName').val()}`}
            } else {
                for (let res of response.result) {
                    output += ownerOutput(res)
                }
            }
        } else {output = "No owners in database!"}
        $(`#getOwnersResponse`).html(output)
    }
    else if (response.id == 3) {
        $(`#getNftsResponse`).text(response.result)
    }
    else if (response.id == 4){
        let output = "";
        if($('#nftid').val()) {
            let valid = false
            for (let res of response.result) {
                if (res.nftid == $('#nftid').val()) {output = nftOutput(res); valid=true}
            }
            if (!valid) {output = `No NFTs found with the id: ${$('#nftid').val()}`}
        } else {
            for (let res of response.result) {
                output += nftOutput(res)
            }
        }

        if (response.result.length == 0){output = "No NFTs in database!"}
        $(`#getNftsResponse`).html(output)
    }
    else if (response.id == 5){
        let output = "";
        let nftownerid = $('#nftownerid').val();
        if (nftownerid == "") {
            for (let res of response.result) {
                output += nftOutput(res)
            }
        } else {
            let valid = false
            for (let res of response.result) {
                if (res.ownerid == $('#nftownerid').val()) {output += nftOutput(res); valid = true}
            }
            if (!valid) {output = `No NFTs found with ownerid: ${$('#nftownerid').val()}`}
        }
        if (response.result.length == 0){output = "No NFTs in database!"}
        $(`#getNftsResponse`).html(output)
    }
    else if (response.id == 6) {
        $(`#getLedgerResponse`).text(response.result)
    }
    
}
function displayError(xhr, statusCode, err) {
    let output = ""
    output += `ERROR: ${error} <br>`
    output += `MESSAGE: ${xhr.responseJSON.error.message}`

    $(`#error`).html(output)
    $("#error").removeClass("hidden");
}

function sendRequest(route, request, cb){
    $("#error").html("")
    $("#error").addClass("hidden")

    $.ajax({
        url: `https://jhicks.cs3680.com/api/${route}`,
        type: "POST",
        data: JSON.stringify(request),
        contentType: "application/json; charset=utf-8",
        datatype: "json",
        success: cb,
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
    sendRequest('sql',request, displayResult);
})

$("#getOwners").click(function(){
    let request = {
        method: "getOwners",
        params: {
        },
        id: 2,
        jsonrpc: 2.0,
    }
    sendRequest('sql',request, displayResult);
})
$("#createNft").click(function(){
    let request = {
        method: "createNft",
        params: {
            ownerid: $("#ownerid").val(),
            nftname: $("#name").val(),
            price: $("#price").val(),
            payload: $("#payload").val()
        },
        id: 3,
        jsonrpc: 2.0,
    }
    sendRequest('sql',request,displayResult);
})
$("#getNfts").click(function(){
    let request = {
        method: "getNfts",
        params: {
        },
        id: 4,
        jsonrpc: 2.0,
    }
    sendRequest('sql', request, displayResult);
})
$("#getOwnersNft").click(function(){
    let request = {
        method: "getNfts",
        params: {
        },
        id: 5,
        jsonrpc: 2.0,
    }
    sendRequest('sql', request, displayResult);
})
$("#createLedger").click(function(){
    let request = {
        method: "createLedger",
        params: {
            nftid: $("#nftid").val(),
            buyerid: $("#buyerid").val(),
            buyerprice: $("#buyerprice").val()
        },
        id: 6,
        jsonrpc: 2.0,
    }
    sendRequest('sql', request, displayResult);
})
$("#getLedger").click(function(){
    let request = {
        method: "getLedger",
        params: {
        },
        id: 7,
        jsonrpc: 2.0,
    }
    sendRequest('sql', request, displayResult);
})
