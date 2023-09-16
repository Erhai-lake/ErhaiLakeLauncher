<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>洱海启动器</title>
    <link rel="stylesheet" href="css/Main.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <style>
        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        button {
            margin: 10px;
            padding: 5px 10px;
        }
    </style>
</head>

<body>
    <button onclick="a()">常规通知</button>
    <button onclick="b()">提示通知</button>
    <button onclick="c()">警告通知</button>
    <button onclick="a100()">常规通知 * 100</button>
    <button onclick="b100()">提示通知 * 100</button>
    <button onclick="c100()">警告通知 * 100</button>
    <button onclick="d100()">随机通知 * 100</button>
    <script>
        function a() {
            window.parent.parent.addNotification('Normal', '常规通知测试');
        }

        function b() {
            window.parent.parent.addNotification('Tip', '提示通知测试');
        }

        function c() {
            window.parent.parent.addNotification('Warn', '警告通知测试');
        }

        function a100() {
            let ia = 0
            const setInterval1 = setInterval(function() {
                if (ia >= 100) {
                    clearInterval(setInterval1)
                } else {
                    a()
                    ia++
                }
            }, 30);
        }


        function b100() {
            let ib = 0
            const setInterval2 = setInterval(function() {
                if (ib >= 100) {
                    clearInterval(setInterval2)
                } else {
                    b()
                    ib++
                }
            }, 30);
        }


        function c100() {
            let ic = 0
            const setInterval3 = setInterval(function() {
                if (ic >= 100) {
                    clearInterval(setInterval3)
                } else {
                    c()
                    ic++
                }
            }, 30);
        }


        function d100() {
            let id = 0
            const setInterval4 = setInterval(function() {
                if (id >= 100) {
                    clearInterval(setInterval4)
                } else {
                    const funcList = [a, b, c];
                    const randomFunc = funcList[Math.floor(Math.random() * funcList.length)];
                    randomFunc()
                    id++
                }
            }, 30);
        }
    </script>
</body>

</html>