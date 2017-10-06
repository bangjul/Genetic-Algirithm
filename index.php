

<!DOCTYPE HTML>
<html>
<head>
	
</head>

<body>

	<div id= "kiri" style="width: 50%; height: 600px; float: left; overflow-y: auto;">
	<?php include('ga.php'); ?>
	</div>
	<div id= "kanan" style="width: 50%; height: 50%; float: right;">
		<div id="chartContainer" ></div>
	</div>
	
		
</body>

<script type="text/javascript">
		window.onload = function () {
			var chart = new CanvasJS.Chart("chartContainer", {
				title: {
					text: "Hasil Centroid"
				},

				data: [{
					type: "scatter",
					markerType: "circle",

              toolTipContent: "<span style='\"'color: {color};'\"'><strong>{name}</strong><br>{x}:{y}<br>{x}:{y}",
              
				name: "Data class 1",
				showInLegend: true,  
					dataPoints: [
					<?php 
						
						foreach($dataset as $x){
							if($x['class']==1)
							echo "{ x: ".$x['x'].", y: ".$x['y']."},";
						}

					?>
					
					]
				},
				{
					type: "scatter",
					markerType: "circle", 
              toolTipContent: "<span style='\"'color: {color};'\"'><strong>{name}</strong><br>{x}:{y}",
              
				name: "Data class 2",
				showInLegend: true,  
					dataPoints: [
					<?php 
						
						foreach($dataset as $x){
							if($x['class']==2)
							echo "{ x: ".$x['x'].", y: ".$x['y']."},";
						}

					?>
					
					]
				},
				{
					type: "scatter",
					markerType: "circle", 
              toolTipContent: "<span style='\"'color: {color};'\"'><strong>{name}</strong><br>{x}:{y}",
              
				name: "Data class 3",
				showInLegend: true,  
					dataPoints: [
					<?php 
						
						foreach($dataset as $x){
							if($x['class']==3)
							echo "{ x: ".$x['x'].", y: ".$x['y']."},";
						}

					?>
					
					]
				},
				{
					type: "scatter",
					markerType: "circle", 
              toolTipContent: "<span style='\"'color: {color};'\"'><strong>{name}</strong><br>{x}:{y}",
              
				name: "Data class 4",
				showInLegend: true,  
					dataPoints: [
					<?php 
						
						foreach($dataset as $x){
							if($x['class']==4)
							echo "{ x: ".$x['x'].", y: ".$x['y']."},";
						}

					?>
					
					]
				},
				// {
				// 	type: "scatter",
				// 	markerType: "square", 
    //           toolTipContent: "<span style='\"'color: {color};'\"'><strong>{name}</strong><br>{x}:{y}",
              
				// name: "Populasi Awal",
				// showInLegend: true,  
				// 	dataPoints: [
				// 	<?php 
				// 		for ($x=0; $x < $n; $x++) {
				// 			for ($i=0; $i < 4; $i++) {
				// 				echo "{ x: ".$populasi_awal[$x][$i*2].", y: ".$populasi_awal[$x][$i*2+1]."},";
				// 			}
				// 		}

				// 	?>
					
				// 	]
				// },
				{
					type: "scatter",
					markerType: "square", 
              toolTipContent: "<span style='\"'color: {color};'\"'><strong>{name}</strong><br>{x}:{y}",
              
				name: "Hasil Centroid",
				markerColor: "#000000",
				markerSize: 10,
				showInLegend: true,  
					dataPoints: [
					<?php 
						
						for ($i=0; $i < 4; $i++) {
							echo "{ x: ".$answer[$i*2].", y: ".$answer[$i*2+1]."},";
						}

					?>
					
					]
				}
				]
			});
			chart.render();
		}
	</script>
	<script src="canvasjs.min.js"></script>
	<title>Genetic Algorithm</title>

</html>