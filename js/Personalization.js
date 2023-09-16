function ajax(URL) {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", URL, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var responseData = JSON.parse(xhr.responseText);
            return responseData;
        }
    };
    xhr.send();
}

// 主题
var radioButtons = document.querySelectorAll('input[name="theme"]');
radioButtons.forEach(function (radioButton) {
    radioButton.addEventListener("click", function () {
        var selectedValue = document.querySelector('input[name="theme"]:checked').value;
        document.getElementById("zdy").style.display = 'none'
        switch (selectedValue) {
            case 'custom':
                document.getElementById("zdy").style.display = 'flex'
                break
            default:
                ajax('/backend/Config.php?type=theme&value=' + selectedValue);
                break
        }
    });
});

const redSlider = document.getElementById('redSlider');
const greenSlider = document.getElementById('greenSlider');
const blueSlider = document.getElementById('blueSlider');
const redValue = document.getElementById('redValue');
const greenValue = document.getElementById('greenValue');
const blueValue = document.getElementById('blueValue');
const colorPreview = document.getElementById('colorPreview');
redSlider.addEventListener('input', updateColor);
greenSlider.addEventListener('input', updateColor);
blueSlider.addEventListener('input', updateColor);
function updateColor() {
    const red = redSlider.value;
    const green = greenSlider.value;
    const blue = blueSlider.value;
    redValue.textContent = red;
    greenValue.textContent = green;
    blueValue.textContent = blue;
    const color = `rgb(${red},${green},${blue})`;
    colorPreview.style.backgroundColor = color;
}

// 主页
var checkboxes = document.querySelectorAll('input[name="homepage"]');
checkboxes.forEach(function (checkbox) {
    checkbox.addEventListener("click", function () {
        var selectedValue = checkbox.value;
        switch (selectedValue) {
            case 'Custom':
                ajax('/backend/Config.php?type=homepage&value=' + selectedValue);
                if (checkbox.checked) {
                    document.getElementById("zdylj").style.display = 'block'
                } else {
                    document.getElementById("zdylj").style.display = 'none'
                }
                break
            default:
                ajax('/backend/Config.php?type=homepage&value=' + selectedValue);
                break
        }
    });
});