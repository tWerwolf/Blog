<?php

    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

    $captchaCode = "";
    $captchaImageHeight = 100;
    $captchaImageWidth = 260;
    $captchaCharactersOnImage = 6;

    $captchaLetters = "bcdfghjkmnpqrstvwxyz23456789";
    $captchaFont = "assets/font/RockSalt-Regular.ttf";

    $captchaDots = 50;
    $captchaLines = 25;
    $captchaTextColor = "0x142864";
    $captchaNoiseColor = "0x142864";

    for($i = 0; $i < $captchaCharactersOnImage; $i++){
        $captchaCode .= substr($captchaLetters, mt_rand(0, strlen($captchaLetters)-1), 1);
    }

    $captchaFontSize = $captchaImageHeight*0.35;
    $captchaImage = @imagecreate(
        $captchaImageWidth,
        $captchaImageHeight
    );

    $backgroundColor = imagecolorallocate(
        $captchaImage,
        255,
        255,
        255
    );

    $arrayTextColor = hexToRGB($captchaTextColor);
    $captchaTextColor = imagecolorallocate(
        $captchaImage,
        $arrayTextColor['red'],
        $arrayTextColor['green'],
        $arrayTextColor['blue']
    );

    $arrayNoiseColor = hexToRGB($captchaNoiseColor);
    $imageNoiseColor = imagecolorallocate(
        $captchaImage,
        $arrayNoiseColor['red'],
        $arrayNoiseColor['green'],
        $arrayNoiseColor['blue']
    );

    for($i = 0; $i<$captchaDots; $i++){
        imagefilledellipse(
            $captchaImage,
            mt_rand(0, $captchaImageWidth),
            mt_rand(0, $captchaImageHeight),
            2,
            3,
            $imageNoiseColor
        );
    }

    for($i = 0; $i<$captchaLines; $i++){
        imageline(
            $captchaImage,
            mt_rand(0, $captchaImageWidth),
            mt_rand(0, $captchaImageHeight),
            mt_rand(0, $captchaImageWidth),
            mt_rand(0, $captchaImageHeight),
            $imageNoiseColor
        );
    }

    $textBox = imagettfbbox(
        $captchaFontSize,
        0,
        $captchaFont,
        $captchaCode
    );

    $x = ($captchaImageWidth-$textBox[4])/2;
    $y = ($captchaImageHeight-$textBox[5])/2;

    imagettftext(
        $captchaImage,
        $captchaFontSize,
        0,
        $x,
        $y,
        $captchaTextColor,
        $captchaFont,
        $captchaCode
    );

    header("Content-Type: image/jpeg");
    imagejpeg($captchaImage);
    imagedestroy($captchaImage);
    $_SESSION["captcha"] = $captchaCode;

    function hexToRGB ($hexString){
        $integar = hexdec($hexString);
        return array("red" => 0xFF & ($integar >> 0x10),
                    "green" => 0xFF & ($integar >> 0x8),
                    "blue" => 0xFF & $integar
                    );
    }

?>