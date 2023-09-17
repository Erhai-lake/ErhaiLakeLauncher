let SelectedDiv = null;
function Selected(event, type) {
    if (SelectedDiv !== null) {
        SelectedDiv.classList.remove('Selected');
    }
    let div = event.currentTarget;
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
    // let windowWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
    let windowHeight = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
    if (windowHeight < 595) {
        document.querySelector('.Skin2D').style.display = "block";
        document.querySelector('.Skin3D').style.display = "none";
    } else {
        document.querySelector('.Skin2D').style.display = "none";
        document.querySelector('.Skin3D').style.display = "block";
    }
}

// 更新一言
Sentence();
function Sentence() {
    let Sentence = document.querySelector(".Sentence");
    let SentenceTitle = document.getElementById("SentenceTitle");
    let SentenceSource = document.getElementById("SentenceSource");
    fetch("https://v1.hitokoto.cn?min_length=5&max_length=70")
        .then(response => response.json())
        .then(data => {
            Sentence.title = data.uuid;
            SentenceTitle.textContent = data.hitokoto;
            SentenceSource.textContent = data.from_who + "[" + data.from + "]";
        })
        .catch(error => {
            Sentence.title = "非常抱歉,有问题请及时反馈,谢谢";
            SentenceTitle.textContent = "发生错误";
            SentenceSource.textContent = error
        });
}

// 监听鼠标右键事件
document.addEventListener("contextmenu", function(event) {
  var target = event.target;
  if (target.classList.contains("Sentence")) {
    let Sentence = document.querySelector(".Sentence");
    window.open("https://hitokoto.cn/?uuid=" + Sentence.title);
  }
});