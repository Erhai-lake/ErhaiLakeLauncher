function ModID(id) {
    alert(id)
}

const Left = document.querySelector("body > div:nth-child(2) > div > div.Index > div.Left")
const Right = document.querySelector("body > div:nth-child(2) > div > div.Index > div.Right")
const Num = document.querySelector('.Num')

const SearchButton = document.querySelector("body > div:nth-child(1) > div.ListContent > div.ButtonContainer > button.SearchButton");
const ResetButton = document.querySelector("body > div:nth-child(1) > div.ListContent > div.ButtonContainer > button.ResetButton");
let searchFilter = document.getElementById('NameInput');

Left.addEventListener('click', function () {
    const numValue = parseInt(Num.textContent, 10);
    if (!isNaN(numValue) && numValue !== 0) {
        window.location.href = '/Mods.php?index=' + (numValue - 1) + '&searchFilter=' + searchFilter.value;
    }
})

Right.addEventListener('click', function () {
    const numValue = parseInt(Num.textContent, 10);
    if (!isNaN(numValue)) {
        window.location.href = 'Mods.php?index=' + (numValue + 1) + '&searchFilter=' + searchFilter.value;
    }
})

SearchButton.addEventListener('click', function () {
    window.location.href = 'Mods.php?index=0&searchFilter=' + searchFilter.value;
})

ResetButton.addEventListener('click', function () {

})