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
Sentencehs();
let Sentence = document.querySelector(".Sentence");
let number = document.getElementById("heart-number");
function Sentencehs() {
    let SentenceTitle = document.getElementById("SentenceTitle");
    let SentenceSource = document.getElementById("SentenceSource");
    let from_who = null;
    let from = null;
    fetch("https://v1.hitokoto.cn?min_length=5&max_length=70")
        .then(response => response.json())
        .then(data => {
            Sentence.title = data.uuid;
            SentenceTitle.textContent = data.hitokoto;
            from_who = data.from_who;
            from = data.from;
            if (from_who == null) {
                from_who = "无"
            }
            if (from == null) {
                from = "无"
            }
            SentenceSource.textContent = `${from_who}[${from}]`;
            let xhr = new XMLHttpRequest();
            let url = `https://hitokoto.cn/?uuid=${data.uuid}`;
            xhr.open("GET", url, true);
            xhr.send();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    let html = xhr.responseText;
                    let div = document.createElement("div");
                    div.innerHTML = html;
                    let likeNumber1 = div.querySelector("#like_number1");
                    let dataBadge = likeNumber1.getAttribute("data-badge");
                    number.innerText = dataBadge;
                }
            };
        })
        .catch(error => {
            Sentence.title = "非常抱歉,有问题请及时反馈,谢谢";
            SentenceTitle.textContent = "发生错误";
            SentenceSource.textContent = error
            number.innerText = "no";
        });
}

// 监听鼠标左键事件
Sentence.addEventListener("click", function (event) {
    Sentencehs();
})

// 监听鼠标左键事件
number.addEventListener("click", function (event) {
    event.stopPropagation()
    window.open("https://hitokoto.cn/?uuid=" + Sentence.title);
})