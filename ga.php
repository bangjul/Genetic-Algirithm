<html>
<body>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"><br>
  Jumlah Individu : <input type="text" name="n" style="width: 50%">
  <br><br>
    <input type="submit" name="submit" value="Submit" >
    <br><br>  
</form>
</body>
</html>

<?php
if(isset($_POST['n'])){
	$txt_file = file_get_contents('ruspini.txt');
	$rows = explode("\n", $txt_file);
	$dataset = array(array());
	$i=0;
	foreach($rows as $row => $data){
	    //get row data
	    
	    $row_data = explode(',', $data);
	    $dataset[$i]['x'] = $row_data[0];
	    $dataset[$i]['y'] = $row_data[1];
	    $dataset[$i]['class'] = $row_data[2];
	    $i++;
	}

	$n = $_POST['n'];
	//echo "$n";
	for ($i=0; $i < $n; $i++) { 
		 $populasi[$i] = array(rand(0,120),rand(0,160),rand(0,120),rand(0,160),rand(0,120),rand(0,160),rand(0,120),rand(0,160));
		 //$populasi[$i] = array(rand(0,120),rand(0,160));
		//$populasi[$i] = array(rand(0,40),rand(40,100),rand(70,120),rand(80,140),rand(20,70),rand(120,160),rand(50,90),rand(0,40));
	}
	
	// print_r($populasi);
	$populasi_awal = $populasi;
	$populasi_baru= array();
	$answer=array();

	echo "Populasi Awal : <br><br>";
	for ($x=0; $x < $n; $x++) {
		echo "Individu ".($x+1) ;
		echo "<br>"; 
	 	for ($j=0; $j < 4; $j++) { 
	 		echo "x : ".$populasi_awal[$x][$j*2]."| y : ".$populasi_awal[$x][$j*2+1]."<br>";
	 	}
	 	echo "<br>";
	}

	echo "Proses GA :<br><br>";
	for ($i=0; $i < 100; $i++) { 
		$jumFit=0;
		$fitValue=array();
		for ($j=0; $j <sizeof($populasi) ; $j++) { 
			$fitValue[$j]=fitness($populasi[$j]);
			$jumFit+=fitness($populasi[$j]);
		}
		$selected=roullete($jumFit,$fitValue,$n);
		$populasi=selection($selected,$populasi,$n);
		//print_r($populasi);
		//echo "<br>";
		$populasi_baru=crossover($populasi,$n);
		// print_r($populasi_baru);
		//echo "<br>";
		$populasi_baru=mutasi($populasi_baru,$n);
		// print_r($populasi_baru);
		// echo "<br>";

		if($i<99){
			echo "Generasi-".($i+1)."<br>";
		 	$populasi=elitism($populasi,$populasi_baru,$n);
		 	for ($x=0; $x < $n; $x++) { 
			 	for ($j=0; $j < 4; $j++) { 
			 		echo "x : ".$populasi[$x][$j*2]."| y : ".$populasi[$x][$j*2+1]."<br>";
			 	}
			 	echo "<br>";
		 	}
		 	echo "<br>";
		}
		else {
			echo "Solusi :<br>";
		 	$answer=best($populasi,$populasi_baru);
		 	for ($j=0; $j < 4; $j++) { 
		 		echo "x : ".$answer[$j*2]." | y : ".$answer[$j*2+1]."<br>";
		 	}
		}

		
	}
}

	function best(array $old, array $new){
		$combine=array_merge($old, $new);
		$fitValue=array();
		$ans=0;
		$tmp=0;
		for ($i=0; $i < sizeof($combine) ; $i++) { 
			$fitValue[$i]=fitness($combine[$i]);
		}

		for ($i=0; $i < sizeof($fitValue); $i++) { 
			if($fitValue[$i]>$tmp){
				$tmp=$fitValue[$i];
				$ans=$i;
			}
		}
		// print_r($combine[$ans]);
		return $combine[$ans];
	}


	function fitness(array $individu){
		global $dataset;
		$fitValue=0;
	

		foreach ($dataset as $data) {
			$min=999;
				for ($i=0; $i < 4 ; $i++) { 
				$min_d=pow(($data['x']-$individu[$i*2]), 2)+pow(($data['y']-$individu[$i*2+1]), 2);
				$ans=sqrt($min_d);
				if($ans<$min){
					$min=$ans;
				}
			}$fitValue+=$min;
		}
		//echo $fitValue;
		//echo "<br>";
		//echo number_format(1/$fitValue*100, 2) ."<br>";
		return number_format(1/$fitValue*100, 2);
	}

	function roullete($maxVal,array $fitValue, $n){
		 $maxVal=$maxVal*10000;
		//$maxVal=1;
		$selected=array();
		for ($i=0; $i <$n ; $i++) { 
			$tmp=rand(0,$maxVal);
			$gotIt=false;
			$count=0;
			$th=0;
			while (!$gotIt) {
				$th+=$fitValue[$count]*10000;
				if($tmp<=$th){
					$gotIt=true;
				}else
					$count++;
			}
			$selected[$i]=$count;
		}
		//print_r($selected);
		echo "<br>";
		return $selected;
	}

	function selection(array $selected,array $populasi, $n){
		$populasi_baru=array();
		for ($i=0; $i < $n; $i++) { 
			array_push($populasi_baru, $populasi[$selected[$i]]);
			//$populasi_baru[$i]=$populasi[$selected[$i]];
			//print_r($populasi[$selected[$i]]); echo "<br>";
			//print_r($populasi_baru[$i]); echo "<br>";
		}
		return $populasi_baru;
	}

	function crossover(array $populasi, $n){
		for ($i=0; $i < ($n/2); $i++) { 
			if(rand(1,10)<9){
				$min=rand(0,6);
				$max=rand($min,7);
				//echo $min."-".$max."<br>";
				for ($j=$min; $j <=$max ; $j++) { 
					$tmp=$populasi[$i*2][$j];
					$populasi[$i*2][$j]=$populasi[$i*2+1][$j];
					$populasi[$i*2+1][$j]=$tmp;
				}
			}
			//print_r($populasi[$i]);
		}
		return $populasi;
	}

	function mutasi(array $populasi, $n){
		foreach ($populasi as $p) {
			if(rand(1,10)<3){
				$r=rand(0,7);
				// echo "r = ".$r."<br>";
				if(rand(1,10)<$n){
					if($p[$r]==0)
						$p[$r]++;
					else
						$p[$r]--;
				}else{
					if($p[$r]==160)
						$p[$r]--;
					else
						$p[$r]--;
				}
			}
		}
		return $populasi;
	}

	function elitism(array $old, array $new, $n){
		$combine=array_merge($old,$new);
		$fitValue=array();
		for ($i=0; $i < sizeof($combine); $i++) { 
			$fitValue[$i]=fitness($combine[$i]);
		}

		for ($i=0; $i < sizeof($combine); $i++) { 
			for ($j=0; $j < sizeof($combine)-1; $j++) { 
				if($fitValue[$j]<$fitValue[$j+1]){
					$tmp=$fitValue[$j];
					$fitValue[$j]=$fitValue[$j+1];
					$fitValue[$j+1]=$tmp;

					$tmpC=$combine[$j];
					$combine[$j]=$combine[$j+1];
					$combine[$j+1]=$tmpC;
				}
			}
		}
		$selected=array();
		for ($i=0; $i < sizeof($combine)/2; $i++) { 
			array_push($selected, $combine[$i]);
		}
		// print_r($selected);
		return $selected;
	}


?>