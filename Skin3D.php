<?php
error_reporting(0);

require "Lib/Auxiliary.php";

$Name = $_GET["name"];
if ($Name == "") {
	$UUID = "Null";
} else {
	$UUID = NameUUID($Name);
}
?>

<!DOCTYPE html>
<html lang="zh_CN">

<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<title><?php echo $Name; ?></title>
	<style>
		* {
			user-select: none;
		}

		body {
			display: flex;
			justify-content: center;
			align-items: center;
		}

		h1 {
			font-size: 1.25em;
		}

		h2 {
			font-size: 1em;
		}

		h1,
		h2 {
			margin: 5px 0 0 0;
		}

		#skin_container {
			width: 300px;
			height: 300px;
			cursor: pointer;
		}

		input[type="text"] {
			box-sizing: border-box;
		}

		.control {
			display: inline;
		}

		.control+.control {
			margin-left: 10px;
		}

		.control-section {
			margin-left: 10px;
			margin-bottom: 20px;
		}

		.control-section>h1,
		.control-section>h2 {
			margin-left: -10px;
		}

		table {
			border-collapse: collapse;
		}

		table td,
		table th {
			border: 1px black dashed;
			text-align: left;
		}

		thead th {
			border-top: unset;
		}

		tbody tr:last-child td,
		tbody tr:last-child th {
			border-bottom: unset;
		}

		table th:first-child,
		table td:first-child {
			border-left: unset;
		}

		table th:last-child,
		table td:last-child {
			border-right: unset;
		}

		table td input[type="checkbox"] {
			vertical-align: middle;
			margin: 0;
			width: 100%;
		}

		footer {
			margin-top: 10px;
			padding-top: 10px;
			border-top: 1px grey solid;
		}

		label {
			white-space: nowrap;
		}

		.control-section ul {
			margin-top: 0;
			padding-left: 20px;
		}

		.hidden {
			display: none;
		}

		.main {
			margin: 20px auto;
			text-align: center;
		}
	</style>
</head>

<body>

	<div class="main">
		<canvas id="skin_container"></canvas>
		<br>
		<br>
		<div class="control-section">
			<label><input id="auto_rotate" type="checkbox">旋转</label>
		</div>

		<div class="control-section">
			<h1>动画</h1>
			<div>
				<label><input type="radio" id="animation_none" name="animation" value="" checked>无</label>
				<label><input type="radio" id="animation_idle" name="animation" value="idle">站立</label>
				<label><input type="radio" id="animation_walk" name="animation" value="walk">走路</label>
				<label><input type="radio" id="animation_run" name="animation" value="run">跑步</label>
			</div>
			<button id="animation_pause_resume" type="button" class="control">开始/停止</button>
		</div>

		<div class="control-section">
			<h1>皮肤层</h1>
			<table id="layers_table" align="center">
				<thead>
					<tr>
						<th></th>
						<th>头</th>
						<th>身体</th>
						<th>右臂</th>
						<th>左臂</th>
						<th>右腿</th>
						<th>左腿</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<th>内层</th>
						<td><input type="checkbox" data-layer="innerLayer" data-part="head" checked></td>
						<td><input type="checkbox" data-layer="innerLayer" data-part="body" checked></td>
						<td><input type="checkbox" data-layer="innerLayer" data-part="rightArm" checked></td>
						<td><input type="checkbox" data-layer="innerLayer" data-part="leftArm" checked></td>
						<td><input type="checkbox" data-layer="innerLayer" data-part="rightLeg" checked></td>
						<td><input type="checkbox" data-layer="innerLayer" data-part="leftLeg" checked></td>
					</tr>
					<tr>
						<th>外层</th>
						<td><input type="checkbox" data-layer="outerLayer" data-part="head" checked></td>
						<td><input type="checkbox" data-layer="outerLayer" data-part="body" checked></td>
						<td><input type="checkbox" data-layer="outerLayer" data-part="rightArm" checked></td>
						<td><input type="checkbox" data-layer="outerLayer" data-part="leftArm" checked></td>
						<td><input type="checkbox" data-layer="outerLayer" data-part="rightLeg" checked></td>
						<td><input type="checkbox" data-layer="outerLayer" data-part="leftLeg" checked></td>
					</tr>
				</tbody>
			</table>
		</div>

		<div class="control-section">
			<div>
				<label class="control">模型:
					<div>
						<label><input type="radio" id="skin_model1" name="skin_model" value="default" checked>Default</label>
						<label><input type="radio" id="skin_model2" name="skin_model" value="slim">Slim</label>
					</div>
				</label>
			</div>
		</div>
	</div>

	<script src="js/skinview3d.js"></script>
	<script>
		const skinParts = ["head", "body", "rightArm", "leftArm", "rightLeg", "leftLeg"];
		const skinLayers = ["innerLayer", "outerLayer"];
		const availableAnimations = {
			idle: new skinview3d.IdleAnimation(),
			walk: new skinview3d.WalkingAnimation(),
			run: new skinview3d.RunningAnimation(),
		};

		let skinViewer;

		function reloadSkin() {
			var skin;
			if ("<?php echo $UUID; ?>" == "Null") {
				skin = "img/steve.png"
			} else {
				skin = "<?php echo Skin($UUID); ?>"
			}
			skinViewer.loadSkin(skin, {
				model: document.querySelector('input[name="skin_model"]:checked').value
			})
		}

		function initializeControls() {
			document.getElementById("animation_pause_resume").addEventListener("click", () => skinViewer.animation.paused = !skinViewer.animation.paused);
			document.getElementById("auto_rotate").addEventListener("change", e => skinViewer.autoRotate = e.target.checked);
			for (const el of document.querySelectorAll('input[type="radio"][name="animation"]')) {
				el.addEventListener("change", e => {
					if (e.target.value === "") {
						skinViewer.animation = null;
					} else {
						skinViewer.animation = availableAnimations[e.target.value];
						skinViewer.animation.speed = 1;
					}
				});
			}
			for (const part of skinParts) {
				for (const layer of skinLayers) {
					document.querySelector(`#layers_table input[type="checkbox"][data-part="${part}"][data-layer="${layer}"]`)
						.addEventListener("change", e => skinViewer.playerObject.skin[part][layer].visible = e.target.checked);
				}
			}

			const initializeUploadButton = (id, callback) => {
				const urlInput = document.getElementById(id);
				const fileInput = document.getElementById(id + "_upload");
				const unsetButton = document.getElementById(id + "_unset");
				const unsetAction = () => {
					urlInput.readOnly = false;
					urlInput.value = "";
					fileInput.value = fileInput.defaultValue;
					callback();
				};
				fileInput.addEventListener("change", e => callback());
				urlInput.addEventListener("keydown", e => {
					if (e.key === "Backspace" && urlInput.readOnly) {
						unsetAction();
					}
				});
				unsetButton.addEventListener("click", e => unsetAction());
			};
			document.getElementById("skin_model1").addEventListener("click", () => reloadSkin());
			document.getElementById("skin_model2").addEventListener("click", () => reloadSkin());
		}

		function initializeViewer() {
			skinViewer = new skinview3d.SkinViewer({
				canvas: document.getElementById("skin_container")
			});

			// 画布宽度
			skinViewer.width = 300;
			// 画布高度
			skinViewer.height = 300;
			// 视场角
			skinViewer.fov = 70;
			// 缩放
			skinViewer.zoom = 0.90;
			// 整体光照
			skinViewer.globalLight.intensity = 0.40;
			// 摄影光照
			skinViewer.cameraLight.intensity = 0.60;
			skinViewer.autoRotate = document.getElementById("auto_rotate").checked;
			// 旋转速度
			skinViewer.autoRotateSpeed = 1;
			// 运动速度
			const animationName = document.querySelector('input[type="radio"][name="animation"]:checked').value;
			if (animationName !== "") {
				skinViewer.animation = availableAnimations[animationName];
				skinViewer.animation.speed = 1;
			}
			// 鼠标移动(左键)
			skinViewer.controls.enableRotate = true
			// 鼠标缩放(滚轮)
			skinViewer.controls.enableZoom = true
			// 鼠标平移(右键)
			skinViewer.controls.enablePan = false
			for (const part of skinParts) {
				for (const layer of skinLayers) {
					skinViewer.playerObject.skin[part][layer].visible =
						document.querySelector(`#layers_table input[type="checkbox"][data-part="${part}"][data-layer="${layer}"]`).checked;
				}
			}
			// 加载皮肤
			reloadSkin();
		}

		initializeControls();
		initializeViewer();
	</script>
    <script src="js/Main.js"></script>
</body>

</html>