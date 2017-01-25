<?php
	// $input1 = '{3,3}';
	// //$input2 = '{1#0#0,0#0#1,1#0#1}';
	// //$input2 = '{0#1#0,0#0#1,1#1#1}';
	// $input2 = '{0#1#0,0#0#1,1#1#1}';
	// encoded_msg($input1, $input2);
	
	function encoded_msg($input1, $input2) {		
		$arrInput2Data = array();
		foreach ($input2 as $arrRow) {
			$arrInput2Data[] = explode('#', $arrRow);
		}

		$intTotalPossible = 0;
		
		$intN = $intM = 0;
		if (true == isset($input1[0])) {
			$intN = $input1[0];
		} else {
			return $intTotalPossible;
		}
		
		if (true == isset($input1[1])) {
			$intM = $input1[1];
		} else {
			return $intTotalPossible;
		}
		
		if (count($arrInput2Data) != $intM) {
			return $intTotalPossible;
		}
		
		$intTotalPossible = 0;
		for ($i = 0; $i < $intN; $i++) {
			for ($j = 0; $j < $intM; $j++) {
				if ($arrInput2Data[$i][$j] == 0) {
					$intTotalPossible++;
					if (($intM-1) != $j && $arrInput2Data[$i][$j+1] == 0) {
						break;
					}
				}
			}
		}
		
		echo $intTotalPossible;
	}
	
	// function display($strData) {
		// echo '<pre>';
		// print_r($strData);
		// echo '</pre>';
	// }
?>