function onLoad(){
  let md, page;
  if(window.location.search){
    let urlParams = new URLSearchParams(window.location.search)
    md = urlParams.get("md")
    page = urlParams.get("page")
  }else{
    md = "home"
  }

  let links = [
    {label: "Home", href: "?md=home"},
    {label: "Project Proposal", href: "?md=proposal"},
    {label: "Week 1 Update", href: "?md=week1"},
    {label: "Week 2 Update", href: "?md=week2"},
    {label: "Results", href: "?md=results"},
    {label: "4420 Lab 2", href: "?page=lab2"},
    {label: "Final SQLITE3", href: "?page=sql"},
    {label: "Final MongoDB", href: "?page=mongo"},
  ]
  for (link of links){
    let li = $(`<li></li>`);
    li.addClass("navItem")
    let href = $(`<a href='${link.href}'>${link.label}</a>`);

    li.append(href)
    $("#navbar").append(li)
  }
  
  function md2html(md, element){
    element.html(marked.parse(md))
    Prism.highlightAll()
  }
  if (md) {
    Promise.all([
      fetch(`https://jhicks.cs3680.com/4420/pages/${md}.md`)
          .then(x => x.text())
      ]).then(([res]) => {
        let element = $(`<div id=${md}></div>`)
      $("#container").append(element)
      md2html(res, element)
      });
  }
  else if (page == "lab2") {
    let iframe = $(`<iframe></iframe>`);
    iframe.attr("src", `https://jhicks.cs3680.com/4420/${page}`)
    iframe.attr("id", "dataWindow")
    let title = "4420 Lab 2"
    $("#container").append($(`<h1 id='title'>${title}</h1>`))
    $("#container").append(iframe)
  }
  else if (page == "sql") {
    let iframe = $(`<iframe></iframe>`);
    iframe.attr("src", `https://jhicks.cs3680.com/4420/${page}`)
    iframe.attr("id", "dataWindow")
    let title = "SQLITE3 Micro Service"
    $("#container").append($(`<h1 id='title'>${title}</h1>`))
    $("#container").append(iframe)
  }
  else if (page == "mongo") {
    let iframe = $(`<iframe></iframe>`);
    iframe.attr("src", `https://jhicks.cs3680.com/4420/${page}`)
    iframe.attr("id", "dataWindow")
    let title = "MongoDB Micro Service"
    $("#container").append($(`<h1 id='title'>${title}</h1>`))
    $("#container").append(iframe)
  }
  
}

$(onLoad);






