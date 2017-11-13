<?php
	//echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";//防止中文乱码
	//取得指定位址的內容，并储存至text
	$urlLink = $_GET['urlLink'];
//	$url = "http://poi.mapbr.com/guangzhou/D60";
	$results=@file_get_contents($urlLink);
	if($results){
		$regexDiv="/<div class=\"sortC\".*?>.*?<\/div>/ism"; 
		$regA="/<a .*?>.*?<\/a>/"; 
		$textArr = []; //这个存放的就是正则匹配出来的所有《a》标签文本数组
		if(preg_match($regexDiv, $results, $matches)){ 
			$string = implode('',$matches);
			//拿出《a》标签中的链接和标签内容
			preg_match_all($regA,$string,$aarray);
			//$hrefarray;//这个存放的是匹配出来的href的链接地址
			$acontent;//存放匹配出来的a标签的内容
			//$regLink="/href=\"([^\"]+)/";
			$regText="/>(.*)<\/a>/";
			for($i=0;$i<count($aarray[0]);$i++){
				//preg_match_all($regLink,$aarray[0][$i],$hrefarray);
				//echo $hrefarray[1][0]."\r\n";//这里输出的就是遍历出来的所有a标签的链接
				//拿出《a》标签的内容
				preg_match_all($regText,$aarray[0][$i],$acontent);
				// 生成一个PHP数组
				$textArr[$i] = $acontent[1][0];
				
			};
			$data = array(  
		    	'code' => 200,  
		    	'result' => $textArr 
		    );
			// 把PHP数组转成JSON字符串
			echo json_encode($data,JSON_UNESCAPED_UNICODE);
		}else{  
			// 无指定类内容
			$data = array(  
		    	'code' => 400
		    );
		    echo json_encode($data,JSON_UNESCAPED_UNICODE); 
		}
	}else{
	    //页面不存在
	    $data = array(  
	    	'code' => 404
	    );
	    echo json_encode($data,JSON_UNESCAPED_UNICODE);
	}
?>