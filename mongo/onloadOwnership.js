let buildTable = function(output) {
    let table = "<table>"
    table += `<tr>`
    table += `<th>nftid</th><th>ownerid</th><th>secondsowned</th>`
    table += '</tr>'
    for (res of output) {
        table += `<tr>`
        table += `<td>${res.nftid}</td><td>${res.ownerid}</td><td>${res.secondsOwned}</td>`
        table += `</tr>`
    }
    table += "</table>"
    return table;
}
let request = {
    method: "getOwnership",
    params: {
    },
    id: 8,
    jsonrpc: 2.0,
}

sendRequest('ownership',request, (response) => {
    let output = response.result
    let finalTable = buildTable(output)
    $(`#getOwnerTime`).html(finalTable)
});




