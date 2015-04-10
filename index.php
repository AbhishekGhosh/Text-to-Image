<?php

// link to the font file no the server
$fontname = 'font/Capriola-Regular.ttf';
// controls the spacing between text
$i=30;
//JPG image quality 0-100
$quality = 90;

function create_image($user){

		global $fontname;	
		global $quality;
		$file = "covers/".md5($user[0]['name'].$user[1]['name'].$user[2]['name']).".jpg";	
	
	// if the file already exists dont create it again just serve up the original	
	//if (!file_exists($file)) {	
			

			// define the base image that we lay our text on
			$im = imagecreatefromjpeg("pass.jpg");
			
			// setup the text colours
			$color['grey'] = imagecolorallocate($im, 54, 56, 60);
			$color['green'] = imagecolorallocate($im, 55, 189, 102);
			
			// this defines the starting height for the text block
			$y = imagesy($im) - $height - 365;
			 
		// loop through the array and write the text	
		foreach ($user as $value){
			// center the text in our image - returns the x value
			$x = center_text($value['name'], $value['font-size']);	
			imagettftext($im, $value['font-size'], 0, $x, $y+$i, $color[$value['color']], $fontname,$value['name']);
			// add 32px to the line height for the next text block
			$i = $i+32;	
			
		}
			// create the image
			imagejpeg($im, $file, $quality);
			
	//}
						
		return $file;	
}

function center_text($string, $font_size){

			global $fontname;

			$image_width = 800;
			$dimensions = imagettfbbox($font_size, 0, $fontname, $string);
			
			return ceil(($image_width - $dimensions[4]) / 2);				
}



	$user = array(
	
		array(
			'name'=> 'Ashley Ford', 
			'font-size'=>'27',
			'color'=>'grey'),
			
		array(
			'name'=> 'Technical Director',
			'font-size'=>'16',
			'color'=>'grey'),
			
		array(
			'name'=> 'ashley@papermashup.com',
			'font-size'=>'13',
			'color'=>'green'
			)
			
	);
	
	
	if(isset($_POST['submit'])){
	
	$error = array();
	
		if(strlen($_POST['name'])==0){
			$error[] = 'Please enter a name';
		}
		
		if(strlen($_POST['job'])==0){
			$error[] = 'Please enter a job title';
		}		

		if(strlen($_POST['email'])==0){
			$error[] = 'Please enter an email address';
		}
		
	if(count($error)==0){
		
	$user = array(
	
		array(
			'name'=> $_POST['name'], 
			'font-size'=>'27',
			'color'=>'grey'),
			
		array(
			'name'=> $_POST['job'],
			'font-size'=>'16',
			'color'=>'grey'),
			
		array(
			'name'=> $_POST['email'],
			'font-size'=>'13',
			'color'=>'green'
			)
			
	);		
		
	}
		
	}

// run the script to create the image
$filename = create_image($user);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Papermashup.com | PHP GD Image And Text Overlay Tutorial</title>
<link href="../style.css" rel="stylesheet" type="text/css" />

<style>
input{
	border:1px solid #ccc;
	padding:8px;
	font-size:14px;
	width:300px;
	}
	
.submit{
	width:110px;
	background-color:#FF6;
	padding:3px;
	border:1px solid #FC0;
	margin-top:20px;}	

</style>

</head>

<body>

<?php include '../includes/header.php';
        $link = '| <a href="http://papermashup.com/dynamically-add-form-inputs-and-submit-using-jquery/">Back To Tutorial</a>';
?>

<img src="<?=$filename;?>?id=<?=rand(0,1292938);?>" width="800" height="600"/><br/><br/>

<ul>
<?php if(isset($error)){
	
	foreach($error as $errors){
		
		echo '<li>'.$errors.'</li>';
			
	}
	
	
}?>
</ul>

<p>You can edit the image above by typing your details in below. It'll then generate a new image which you can right click on and save to your computer.</p>

<div class="dynamic-form">
<form action="" method="post">
<label>Name</label>
<input type="text" value="<?php if(isset($_POST['name'])){echo $_POST['name'];}?>" name="name" maxlength="15" placeholder="Name"><br/>
<label>Job Title</label>
<input type="text" value="<?php if(isset($_POST['job'])){echo $_POST['job'];}?>" name="job" placeholder="Job Title"><br/>
<label>Email</label>
<input type="text" value="<?php if(isset($_POST['email'])){echo $_POST['email'];}?>" name="email" placeholder="Email"><br/>
<input name="submit" type="submit" class="btn btn-primary" value="Update Image" />
</form>
</div>



<?php include '../includes/footer.php';?>

</body>
</html>
