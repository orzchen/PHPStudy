<?php 

	// var_dump($_FILES['name']);
	
	//判断是否有错误号
	if ($_FILES['file']['error']) {
		switch ($_FILES['file']['error']) {

			case 1:
				$str = '上传的文件超过了 php.ini 中 upload_max_filesize 选项限制的值。 ';
				break;
			case 2: 
				$str = '上传文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值。 ';
				break;
			case 3:
				$str = '文件只有部分被上传。 ';
				break;
			case 4:
				$str = '没有文件被上传。 ';
				break;
			case 6:
				$str = '找不到临时文件夹。PHP 4.3.10 和 PHP 5.0.3 引进。 ';
				break;
			case 7:
				$str = '文件写入失败。PHP 5.1.0 引进。 ';
				break;
		}
		echo $str;
		exit;
	
	}

	//判断准许的文件大小
	if ($_FILES['file']['size'] > (pow(1024 , 2) * 2)) {
		exit('文件大小超过了准许的文件大小');
	}

	//判断准许的mime类型 文件后缀
	$allowMime = ['image/png' , 'image/jpeg' , 'image/gif' , 'image/jpg'];
	$allowSubFix = ['png','jpg','jpeg','gif'];

	$info = pathinfo($_FILES['file']['name']);
	$subFix = $info['extension'];//获取后缀
	
	if (!in_array($subFix , $allowSubFix)) {
		echo $subFix;
		exit('不准许的文件后缀');
	}

	if (!in_array($_FILES['file']['type'] , $allowMime)) {
		exit('不准许的mime类型');
	}
	//拼接上传路径
	$path = 'upload/';

	if (!file_exists($path)) {
		mkdir($path);
	}

	//文件名随机
	$name = uniqid().'.'.$subFix;
	echo $name;
	//判断是否是上传文件
	if (is_uploaded_file($_FILES['file']['tmp_name'])) {
			if (move_uploaded_file($_FILES['file']['tmp_name'] , $path.$name)) {
				echo '上传成功';
			} else {
				echo '文件移动失败';
			}

		} else {
			echo '不是上传文件';
			exit;
		}



 ?>