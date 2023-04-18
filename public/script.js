
function md2html(md, element){
    element.innerHTML = marked.parse(md);
    Prism.highlightAll()
}
Promise.all([
    fetch('https://jhicks.cs3680.com/4420/proposal.md')
        .then(x => x.text())
  ]).then(([res]) => {
    md2html(res, document.getElementById("proposal"))
  });






