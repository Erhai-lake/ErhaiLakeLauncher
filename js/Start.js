var SelectedDiv = null;
function Selected(event, type) {
    if (SelectedDiv !== null) {
        SelectedDiv.classList.remove('Selected');
    }
    var div = event.currentTarget;
    div.classList.add('Selected');
    document.getElementById("Skin3DIframe").src = "/Skin3D.php";
    SelectedDiv = div;
}
document.querySelector('.Selected').click();

Adaption()
window.addEventListener('resize', function () {
    Adaption()
});

function Adaption() {
    // var windowWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
    var windowHeight = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
    if (windowHeight < 595) {
        document.querySelector('.Skin2D').style.display = "block";
        document.querySelector('.Skin3D').style.display = "none";
    } else {
        document.querySelector('.Skin2D').style.display = "none";
        document.querySelector('.Skin3D').style.display = "block";
    }
}

var SentenceTitle = document.getElementById("SentenceTitle");
var SentenceSource = document.getElementById("SentenceSource");
var uuid = "";

// 更新一言
Sentence();
function Sentence() {
    fetch("https://v1.hitokoto.cn?min_length=5&max_length=70")
        .then(response => response.json())
        .then(data => {
            SentenceTitle.textContent = data.hitokoto;
            SentenceSource.textContent = data.from_who + "[" + data.from + "]";
            uuid = data.uuid
        })
        .catch(error => {
            SentenceTitle.textContent = "发生错误";
            SentenceSource.textContent = error
        });
}

function SentenceOpen() {
    Sentence()
}