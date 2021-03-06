<?php 

//1.宽、高、数字、字母、混合、干扰线、干扰点、背景色、字体颜色
verify();

function verify($width = 100 , $height = 40 , $num = 5 , $type = 3) {
	/*
	type = 1	纯数字验证码
	type = 2	纯字母验证码
	type = 3	混合验证码
	*/
	//1.准备画布
	$image = imagecreatetruecolor($width , $height);

	//2.生成颜色


	//3.需要生成的字符
	$string = '';
	switch ($type) {
		case 1:
			$str = '0123456789'; 
			$string = substr(str_shuffle($str), mt_rand(0,5) , $num); //随机打乱字符串，并且从第一个截取5个
			break;
		case 2:
			$arr = range('a' , 'z'); // 生成a-z的数组
			shuffle($arr); // 随机打乱数组 
			$tmp = array_slice($arr,mt_rand(0,20),5); // 切割
			$string = join('' , $tmp); // arr --> string
			break;
		case 3:
			$str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$string = substr(str_shuffle($str), mt_rand(0,57) , $num);
			break;
	}
	// 背景颜色填充浅色
	imagefilledrectangle($image, 0, 0, $width, $height, lightColor($image));

	//4.开始写字
	for ($i = 0; $i < $num ; $i++) {
		$x = floor($width / $num) * $i + 5; //加5是为了控制每个字符绘画的位置尽量居中
		$y = mt_rand(10 , $height - 20);
		$font = 5; // 字体大小 1-5 数字越大，字体越大
		imagechar($image , $font , $x , $y , $string[$i] , deepColor($image));
	}

	//5.画干扰线、点
	for ($i = 0; $i < $num; $i++) { 
		imagearc($image , mt_rand(10 , $width) , mt_rand(10 , $height) , mt_rand(10 , $width) , mt_rand(10 , $height) , mt_rand(0 , 10) , mt_rand(0 , 270) , deepColor($image));
	}
	for ($i = 0; $i < 50; $i++) { 
		imagesetpixel($image , mt_rand(0 , $width) , mt_rand(0 , $height) , deepColor($image));
	}

	//6.指定输出的类型
	header('Content-type:image/png');

	//7.输出图片
	imagepng($image);

	//8.销毁资源
	imagedestroy($image);

	return($string);
	// echo $string;
}

// 浅色
function lightColor($image){
	return imagecolorallocate($image , mt_rand(130,255) , mt_rand(130,255) , mt_rand(130,255));
}

// 深色
function deepColor($image){
	return imagecolorallocate($image , mt_rand(0,120) , mt_rand(0,120) , mt_rand(0,120));
}


 ?>