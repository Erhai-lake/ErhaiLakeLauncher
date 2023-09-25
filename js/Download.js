const MainIframe = document.getElementById("MainIframe")

let SelectedDiv = null;
function Selected(event, type) {
    if (SelectedDiv !== null) {
        SelectedDiv.classList.remove('Selected');
    }
    let div = event.currentTarget;
    div.classList.add('Selected');
    MainIframe.src = type;
    SelectedDiv = div;
}
document.querySelector('.Selected').click();

function Refresh(url) {
    MainIframe.src = url;
}