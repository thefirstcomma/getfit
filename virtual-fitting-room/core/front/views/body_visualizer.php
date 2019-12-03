<canvas id="canvas">
	
</canvas>

<script type="text/javascript">
	var images = {};

loadImage("arm-left");
loadImage("arm-right");
loadImage("chest");
loadImage("hips");
loadImage("legs");
loadImage("waist");

function loadImage(name) {
	images[name] = new Image();
	images[name].onload = function() { 
		resourceLoaded();
	}
	images[name].src = "<?= plugin_dir_url( dirname( __FILE__ ) ) . 'assets/img/' ?>" + name + ".png";
}

var totalResources = 6;
var numResourcesLoaded = 0;
var fps = 30;

function resourceLoaded() {
	numResourcesLoaded += 1;
	if(numResourcesLoaded === totalResources) {
		setInterval(redraw, 1000 / fps);
	}
}

var context = document.getElementById('canvas').getContext("2d");

var charX = 245;
var charY = 185;

function redraw() {
	var x = charX;
	var y = charY;

	canvas.width = 431; // clears the canvas 
	canvas.height = 789;

	// console.log(images["waist"].height);
						
	context.drawImage(images["arm-left"], 0, 0);
	context.drawImage(images["arm-right"], x, 0);
	context.drawImage(images["chest"], x / 2, 30);
	context.drawImage(images["waist"], x / 2 + 30, y * 2 - 180, 138, 69);
	context.drawImage(images["hips"], x / 2 + 7, y * 2 - 115);
	context.drawImage(images["legs"], x / 2, y * 2);
}
</script>