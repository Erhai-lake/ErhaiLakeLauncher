let SelectedDiv = null;
function Selected(event, type) {
    if (SelectedDiv !== null) {
        SelectedDiv.classList.remove('Selected');
    }
    let div = event.currentTarget;
    div.classList.add('Selected');
    document.getElementById("MainIframe").src = type + ".php";
    SelectedDiv = div;
}
document.querySelector('.Selected').click();

function Refresh(url) {
    document.getElementById("MainIframe").src = url;
}