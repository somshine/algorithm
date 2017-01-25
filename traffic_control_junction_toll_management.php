<?php
	//error_reporting(0);
	$arrInput1 = array(
		0 => '6#8',
		1 => '1#2#8',
		2 => '1#4#7',
		3 => '1#5#12',
		4 => '2#3#4',
		5 => '2#4#2',
		6 => '3#6#6',
		7 => '4#6#8',
		//8 => '4#5#6',
		8 => '5#6#10',
	);
	
	optimizedRoute($arrInput1);
	
	function optimizedRoute($input1) {
	
		$arrRoadJun = (true == isset($input1[0])) ? explode('#', $input1[0]) : NULL;
		if (false == is_array($arrRoadJun)) {
			return '{No Solution}';
		}
		
		$intJuncation = (true == isset($arrRoadJun[0])) ? $arrRoadJun[0] : NULL;
		$intRoad = (true == isset($arrRoadJun[1])) ? $arrRoadJun[1] : NULL;
		
		$arrRoutes = $arrRoads = array();
		for ($i = 1; $i <= $intRoad; $i++) {
			$arrData = explode('#', $input1[$i]);
			$intFirst = (true == isset($arrData[0])) ? $arrData[0] : NULL;
			$arrRoutes[$intFirst][$arrData[1]] = $arrData[2];
			
			$strKey = $intFirst . '-' . $arrData[1];
			$arrRoads[$strKey] = $i;
		}
		
		$intMaxRoute = '';
		$intTotalGreate = 0;
		$intCounter = 1;
		$arrResult = array();
		$arrBigRoute = array();
		$arrRouteTotal = $arrRouteKey = array();
		
		foreach ($arrRoutes[1] as $i => $arrRoute) {
			$inti = $intiSo = 1;
			$intTotal = $arrRoutes[$intiSo][$i];
			$arrResult[$intCounter]["$intiSo-$i"] = array('key' => "$intiSo-$i", 'value' => $intTotal);
			//display('i ===== ' . $inti . ' ==== ' . $i . ' ==== ' . $arrRoutes[$inti][$i]);
			foreach ($arrRoutes[$i] as $k => $arrRouteTemp) {
				$arrResult[$intCounter]["$intiSo-$i"] = array('key' => "$intiSo-$i", 'value' => $intTotal);
				
				$intTotalk = $intTotal + $arrRouteTemp;
				$arrResult[$intCounter]["$i-$k"] = array('key' => "$i-$k", 'value' => $arrRouteTemp);
				//display('i ===== ' . $i . ' ==== ' . $k . ' ==== ' . $arrRouteTemp);
				$inti = $k;
				$intMaxToll = 0;
				
				for ($j = $i; $j <= $intRoad; $j++) {
					if(true == isset($arrRoutes[$inti][$j])) {
						$intMaxToll += $arrRoutes[$inti][$j];
						$arrResult[$intCounter]["$inti-$j"] = array('key' => "$inti-$j", 'value' => $arrRoutes[$inti][$j]);
						$arrRouteKey["$inti-$j"] = ((false == isset($arrRouteKey["$inti-$j"])) ? 0 : $arrRouteKey["$inti-$j"]) + 1;
						//display('i ===== ' . $inti . ' ==== ' . $j . ' ==== ' . $arrRoutes[$inti][$j]);
						$inti = $j;
					}
				}
				
				$intTotalAll = $intMaxToll + $intTotalk;
				
				// display($intTotalAll);
				// display('--------------------------------------------------------');
				
				if ($intTotalGreate < $intTotalAll) {
					$intTotalGreate = $intTotalAll;
					$arrBigRoute[$intTotalGreate] = array('route' => $intCounter, 'total_tool' => $intTotalGreate);
					$intMaxRoute = "$intCounter#$intTotalGreate";
				}
				
				$arrRouteTotal[$intCounter] = $intTotalAll;
				
				$intCounter++;
			}
		}
		
		$arrFilterArray = array();
		
		foreach ($arrResult as $i => $arrRoute) {
			$arrRowData = end($arrBigRoute);
			$arrBigData = $arrResult[$arrRowData['route']];
			foreach ($arrRoute as $key => $arrRow) {
				$intTotalToll = $arrRouteTotal[$i];
				if (true == isset($arrFilterArray[$i][$key])) {
					unset($arrFilterArray[$i][$key]);
				} elseif (false == isset($arrBigData[$key])) {
					$arrFilterArray[$i][$key] = $intTotalToll;
					$arrRouteKey[$key] = ((false == isset($arrRouteKey[$key])) ? 0 : $arrRouteKey[$key]) + 1;
				}
			}
		}
		
		$arrNumbers = array();
		foreach ($arrRouteKey as $key => $intCount) {
			if (1 == $intCount && true == isset($arrRoads[$key])) {
				$intRoute = NULL;
				foreach ($arrResult as $i => $arrResultRow) {
					if (true == isset($arrResultRow[$key])) {
						$intRoute = $i;
					}
				}
				$intTotal = $arrRouteTotal[$intRoute];
				$intDiffrence = $intTotalGreate - $intTotal;
				$arrNumbers[$arrRoads[$key]] = array('road' => $arrRoads[$key], 'diff' => $intDiffrence);
			}
			//$arrRoads
		}
		
		asort($arrNumbers);
		
		$intMaxRoute = count($arrNumbers) . '#' . $intTotalGreate;
		foreach ($arrNumbers as $arrRow) {
			$intMaxRoute .= ',' . $arrRow['road'] . '#' . $arrRow['diff'];
		}
		
		return $intMaxRoute;
	}
	
	function display($strData) {
		echo '<pre>';
		print_r($strData);
		echo '</pre>';
	}
	
?>
