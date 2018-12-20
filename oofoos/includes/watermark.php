<?php
// Load the stamp and the photo to apply the watermark to
$file = '../images/'.base64_decode($_GET['f']);

$watermark = imagecreatefrompng('../images/watermark.png');
$im = imagecreatefrompng($file);

// Set the margins for the stamp and get the height/width of the stamp image
$percent = 0.6;
$watermarkWidth = imagesx($watermark);
$watermarkHeight = imagesy($watermark);
$imageWidth = imagesx($im);
$imageHeight = imagesy($im);

// scale watermark based on original image's width
$newWatermarkWidth = $imageWidth * $percent;
$newWatermarkHeight = ($newWatermarkWidth / $watermarkWidth) * $watermarkHeight;

// Create new empty image
$newWatermark = imagecreatetruecolor($newWatermarkWidth, $newWatermarkHeight);
imagealphablending($newWatermark, false);
imagesavealpha($newWatermark, true);
// Resize old image into new
imagecopyresampled($newWatermark, $watermark, 0, 0, 0, 0, $newWatermarkWidth, $newWatermarkHeight, $watermarkWidth, $watermarkHeight);


$black = imagecolorallocate($im, 0, 0, 0);
// Make the background transparent
imagecolortransparent($im, $black);

// Copy the stamp image onto our photo using the margin offsets and the photo
// width to calculate positioning of the stamp.

imagecopy($im, $newWatermark, ($imageWidth-$newWatermarkWidth)/2, ($imageHeight-$newWatermarkHeight)*0.65, 0, 0, $newWatermarkWidth, $newWatermarkHeight);

$finalImageHeight = 500;
$finalImageWidth = ($finalImageHeight / $imageHeight) * $imageWidth;
$finalImage = imagecreatetruecolor($finalImageWidth, $finalImageHeight);
imagealphablending($finalImage, false);
imagesavealpha($finalImage, true);
// Resize old image into new
imagecopyresampled($finalImage, $im, 0, 0, 0, 0, $finalImageWidth, $finalImageHeight, $imageWidth, $imageHeight);



// Output and free memory
header('Content-type: image/png');
imagealphablending($finalImage, false);
imagesavealpha($finalImage,true);
imagepng($finalImage);

imagedestroy($im);
imagedestroy($finalImage);
imagedestroy($watermark);
imagedestroy($newWatermark);
?>
