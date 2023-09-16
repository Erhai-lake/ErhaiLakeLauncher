var SelectedDiv = null;
function Selected(event, type) {
    if (SelectedDiv !== null) {
        SelectedDiv.classList.remove('Selected');
    }
    var div = event.currentTarget;
    div.classList.add('Selected');
    document.getElementById("MainIframe").src = type + ".php";
    SelectedDiv = div;
}
document.querySelector('.Selected').click();

// 获取通知容器
var notificationContainer = document.getElementById("notificationContainer");
// 添加通知
function addNotification(type, message) {
    // 创建通知元素
    var notification = document.createElement("div");
    notification.className = type;
    notification.textContent = message;
    // 添加点击事件，点击时移除通知
    notification.addEventListener("click", function () {
        removeNotification(notification);
    });
    // 添加通知到容器，并设置定时器自动移除
    notificationContainer.appendChild(notification);
    // 3秒后自动移除通知
    setTimeout(function () {
        removeNotification(notification);
    }, 3100);
}

// 移除通知
function removeNotification(notification) {
    notificationContainer.removeChild(notification);
}

// addNotification("Normal", "这是常规通知");
// addNotification("Tip", "这是提示通知");
// addNotification("Warn", "这是警告通知");