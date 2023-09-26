function ModID(id) {
    alert(id)
}

const Left = document.querySelector("body > div:nth-child(3) > div > div.Index > div.Left");
const Num = document.querySelector("body > div:nth-child(3) > div > div.Index > p");
const Right = document.querySelector("body > div:nth-child(3) > div > div.Index > div.Right");

const Search = document.querySelector("body > div:nth-child(2)");
const Mods = document.querySelector("body > div:nth-child(3)");

const searchFilter = document.getElementById('NameInput');
const SourceSelect = document.getElementById('SourceSelect');
const gameVersion = document.getElementById('VersionInput');

// 上一页
Left.addEventListener('click', function () {
    const numValue = parseInt(Num.textContent, 10);
    if (!isNaN(numValue) && numValue !== 0) {
        Search.style.display = 'block';
        Mods.style.display = 'none';
        window.location.href = '/Mods.php?index=' + (numValue - 1) + '&searchFilter=' + searchFilter.value + '&SourceSelect=' + SourceSelect.value + "&gameVersion=" + gameVersion.value;
    }
})

// 下一页
Right.addEventListener('click', function () {
    const numValue = parseInt(Num.textContent, 10);
    if (!isNaN(numValue)) {
        Search.style.display = 'block';
        Mods.style.display = 'none';
        window.location.href = 'Mods.php?index=' + (numValue + 1) + '&searchFilter=' + searchFilter.value + '&SourceSelect=' + SourceSelect.value + "&gameVersion=" + gameVersion.value;
    }
})

const SearchButton = document.querySelector("body > div:nth-child(1) > div.ListContent > div.ButtonContainer > button.SearchButton");
const ResetButton = document.querySelector("body > div:nth-child(1) > div.ListContent > div.ButtonContainer > button.ResetButton");

// 搜索
SearchButton.addEventListener('click', function () {
    Search.style.display = 'block';
    Mods.style.display = 'none';
    window.location.href = 'Mods.php?index=0&searchFilter=' + searchFilter.value + '&SourceSelect=' + SourceSelect.value + "&gameVersion=" + gameVersion.value;
})

// 重置条件
ResetButton.addEventListener('click', function () {
    searchFilter.value = '';
    SourceSelect.selectedIndex = 0;
    gameVersion.value = '全部'
});

// 获取滚动条位置
function getScrollPosition() {
    return window.scrollY || window.pageYOffset;
}

// 监听滚动事件
let i = 0;
window.addEventListener('scroll', function () {
    const Top = this.document.querySelector('.Top');
    const scrollPosition = getScrollPosition();
    const scrollThreshold = 0.1 * document.documentElement.scrollHeight;
    if (scrollPosition >= scrollThreshold) {
        Top.style.display = 'flex';
        const SetInterval = setInterval(function () {
            if (i < 1) {
                Top.style.opacity = i;
                i = i + 0.1;
            } else {
                clearInterval(SetInterval);
                i = 1
                Top.style.opacity = 1;
            }
        }, 20)
    } else {
        const SetInterval = setInterval(function () {
            if (i > 0) {
                i = i - 0.1;
                Top.style.opacity = i;
            } else {
                clearInterval(SetInterval);
                i = 0
                Top.style.opacity = 0;
                Top.style.display = 'none';
            }
        }, 20)
    }
});