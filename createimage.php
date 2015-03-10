<?php

session_start();

create_image(); 

exit();



function create_image() 

{

	header("Content-Type: image/jpeg"); 

	$width = 140;

	$height = 60;

	$num_chars = 4;

	$alphabet = array( 

		'A','B','C','D','E','F','G','H','I','J','K','L','M',

		'N','O','P','Q','R','S','T','U','V','W','X','Y','Z',

		'1','2','3','4','5','6','7','8','9','0' );

		

	$max = sizeof( $alphabet );

	

	// generate random string

	$captcha_str = '';

	for ($i=1;$i<=$num_chars;$i++) // from 1..$num_chars

	{

		// choose randomly a character from alphabet and append it to string

		$chosen = rand( 1, $max );

		$captcha_str .= $alphabet[$chosen-1];

	}

	$char_seq = $captcha_str;

	$_SESSION["security_code"] = $char_seq;

	$num_chars = strlen($char_seq);

			

	$img = imagecreatetruecolor( $width, $height );

	imagealphablending($img, 1);

	imagecolortransparent( $img );

	

	// generate background of randomly built ellipses

	for ($i=1; $i<=200; $i++)

	{

		$r = round( rand( 0, 100 ) );

		$g = round( rand( 0, 100 ) );

		$b = round( rand( 0, 100 ) );

		$color = imagecolorallocate( $img, $r, $g, $b );

		imagefilledellipse( $img,round(rand(0,$width)), round(rand(0,$height)), round(rand(0,$width/16)), round(rand(0,$height/4)), $color );	

	}

	

	$start_x = round($width / $num_chars);

	$max_font_size = $start_x;

	$start_x = round(0.5*$start_x);

	$max_x_ofs = round($max_font_size*0.9);

	

	// set each letter with random angle, size and color

	for ($i=0;$i<=$num_chars;$i++)

	{

		$r = round( rand( 127, 255 ) );

		$g = round( rand( 127, 255 ) );

		$b = round( rand( 127, 255 ) );

		$y_pos = ($height/2)+round( rand( 5, 20 ) );

		

		$fontsize = round( rand( 18, $max_font_size) );

		$color = imagecolorallocate( $img, $r, $g, $b);

		$presign = round( rand( 0, 1 ) );

		$angle = round( rand( 0, 25 ) );

		if ($presign==true) $angle = -1*$angle;

		

		ImageTTFText( $img, $fontsize, $angle, $start_x+$i*$max_x_ofs, $y_pos, $color, 'default.ttf', substr($char_seq,$i,1) );

	}

	

	// create image file

	ImageJpeg($img);

	//flush();

	imagedestroy( $img );

}



?>