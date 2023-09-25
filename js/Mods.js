function ModID(id) {
    alert(id)
}

let Left = document.querySelector("body > div:nth-child(2) > div > div.Index > div.Left")
let Right = document.querySelector("body > div:nth-child(2) > div > div.Index > div.Right")
let Num = document.querySelector('.Num')

Left.addEventListener('click', function () {
    let numValue = parseInt(Num.textContent, 10);
    if (!isNaN(numValue) && numValue !== 0) {
        window.location.href = '/Mods.php?index=' + (numValue - 1);
    }
})

Right.addEventListener('click', function () {
    let numValue = parseInt(Num.textContent, 10);
    if (!isNaN(numValue)) {
        window.location.href = 'Mods.php?index=' + (numValue + 1);
    }
})