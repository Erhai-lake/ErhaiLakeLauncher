function ModID(id) {
    alert(id)
}

// 检索动效
const Search = document.getElementById("Search");
const Mods = document.getElementById("Mods");

// 过滤器
// 名字
const searchFilter = document.getElementById('NameInput');
// 来源
const SourceSelect = document.getElementById('SourceSelect');
// 版本
const gameVersion = document.getElementById('VersionInput');
// 分类
const categoryId = document.getElementById('TypeSelect');
// mod加载器
const modLoaderType = document.getElementById('LoaderSelect');

// 分页函数
const IndexNum = document.getElementById("IndexNum");
// 上一页
function Up() {
    const numValue = parseInt(IndexNum.textContent, 10);
    if (!isNaN(numValue) && numValue !== 0) {
        Search.style.display = 'block';
        Mods.style.display = 'none';
        SearchFunction(numValue - 1, searchFilter.value, SourceSelect.value, gameVersion.value, categoryId.value, modLoaderType.value)
    }
}
// 下一页
function Down() {
    const numValue = parseInt(IndexNum.textContent, 10);
    if (!isNaN(numValue)) {
        Search.style.display = 'block';
        Mods.style.display = 'none';
        SearchFunction(numValue + 1, searchFilter.value, SourceSelect.value, gameVersion.value, categoryId.value, modLoaderType.value)
    }
}

const SearchButton = document.querySelector(".SearchButton");
const ResetButton = document.querySelector(".ResetButton");

// 搜索
SearchButton.addEventListener('click', function () {
    Search.style.display = 'block';
    Mods.style.display = 'none';
    SearchFunction(0, searchFilter.value, SourceSelect.value, gameVersion.value, categoryId.value, modLoaderType.value)
})

// 检索函数
function SearchFunction(index, searchFilter, SourceSelect, gameVersion, categoryId, modLoaderType) {
    let URL = 'Mods.php?index=' + index + '&searchFilter=' + encodeURIComponent(searchFilter) + '&SourceSelect=' + SourceSelect + "&gameVersion=" + gameVersion + "&categoryId=" + categoryId + "&modLoaderType=" + modLoaderType;
    console.log(URL);
    window.location.href = URL;
}

// 回车事件
searchFilter.addEventListener('keydown', function (event) {
    if (event.key === 13) {
        SearchButton.click();
    }
});

// 重置条件
ResetButton.addEventListener('click', function () {
    searchFilter.value = '';
    SourceSelect.selectedIndex = 0;
    gameVersion.value = '全部'
    categoryId.selectedIndex = 0;
    modLoaderType.selectedIndex = 0;
});

// 获取滚动条位置
function getScrollPosition() {
    return window.scrollY || window.pageYOffset;
}

// 监听滚动事件
let i = 0;
window.addEventListener('scroll', function () {
    const BackTo = document.getElementById("BackTo");
    const scrollPosition = getScrollPosition();
    const scrollThreshold = 0.1 * document.documentElement.scrollHeight;
    if (scrollPosition >= scrollThreshold) {
        BackTo.style.display = 'flex';
        const SetInterval = setInterval(function () {
            if (i < 1) {
                BackTo.style.opacity = i;
                i = i + 0.1;
            } else {
                clearInterval(SetInterval);
                i = 1
                BackTo.style.opacity = 1;
            }
        }, 20)
    } else {
        const SetInterval = setInterval(function () {
            if (i > 0) {
                i = i - 0.1;
                BackTo.style.opacity = i;
            } else {
                clearInterval(SetInterval);
                i = 0
                BackTo.style.opacity = 0;
                BackTo.style.display = 'none';
            }
        }, 20)
    }
});