let request = {
    method: "getLedger",
    params: {
    },
    id: 7,
    jsonrpc: 2.0,
}

sendRequest('ledger',request, (response) => {
    let output = "<table>"
    output += `<tr>`
    output += `<th>ledgerid</th><th>nftid</th><th>buyerid</th><th>sellerid</th>
                <th>buyerprice</th><th>sellerprice</th><th>sellerdaysowned</th>
                <th>changedon</th>`
    output += '</tr>'
    for (let res of response.result) {
        output += `<tr>`
        output += `<td>${res.id}</td><td>${res.nftid}</td><td>${res.buyerid}</td><td>${res.sellerid}</td>
        <td>${res.buyerprice}</td><td>${res.sellerprice}</td><td>${res.sellerdaysowned}</td>
        <td>${res.changedon}</td>`
        output += `</tr>`
    }
    output += `</table>`
    $(`#getLedgerResponse`).html(output)
});
