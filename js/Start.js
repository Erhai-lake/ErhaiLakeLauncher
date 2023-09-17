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

let Sentence = document.querySelector(".Sentence");
let number = document.getElementById("heart-number");
let intervalId = null;
// 更新一言
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
                from_who = "无";
            }
            if (from == null) {
                from = "无";
            }
            SentenceSource.textContent = `${from_who}[${from}]`;
            if (intervalId != null) {
                clearInterval(intervalId);
            }
            intervalId = setInterval(function () {
                const xhr = new XMLHttpRequest();
                xhr.open("GET", `https://hitokoto.cn/?uuid=${data.uuid}`, true);
                xhr.send();
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        const html = xhr.responseText;
                        const div = document.createElement("div");
                        div.innerHTML = html;
                        const likeNumber1 = div.querySelector("#like_number1");
                        const dataBadge = likeNumber1.getAttribute("data-badge");
                        number.innerText = dataBadge;
                    }
                };
            }, 1000);
        })
        .catch(error => {
            Sentence.title = "非常抱歉,有问题请及时反馈,谢谢";
            SentenceTitle.textContent = "发生错误";
            SentenceSource.textContent = error;
            number.innerText = "no";
        });
}

// 页面加载完成后更新一言
Sentencehs();

// 监听一言模块的点击事件
Sentence.addEventListener("click", function (event) {
    Sentencehs();
});

// 监听点赞按钮的点击事件
number.addEventListener("click", function (event) {
    event.stopPropagation(); // 阻止事件冒泡
    window.open("https://hitokoto.cn/?uuid=" + Sentence.title);
});