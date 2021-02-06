<?php
class ImageUtil {

	public static function convertImage($originalImage, $outputImage, $quality) {
		// jpg, png, gif or bmp?
		$exploded = explode('.', $originalImage);
		$ext = $exploded[count($exploded) - 1];
		
		if (preg_match('/jpg|jpeg/i', $ext))
			$imageTmp = imagecreatefromjpeg($originalImage);
		else if (preg_match('/png/i', $ext))
			$imageTmp = imagecreatefrompng($originalImage);
		else if (preg_match('/gif/i', $ext))
			$imageTmp = imagecreatefromgif($originalImage);
		else if (preg_match('/bmp/i', $ext))
			$imageTmp = imagecreatefrombmp($originalImage);
		else
			return 0;
			
			// quality is a value from 0 (worst) to 100 (best)
		imagejpeg($imageTmp, $outputImage, $quality);
		imagedestroy($imageTmp);
		
		return true;
	
	}

	public static function fixOrientation($filename) {

		$image = imagecreatefromjpeg($filename);
		$exif = exif_read_data($filename);
		if (! empty($exif['Orientation'])) {
			switch ($exif['Orientation']) {
				case 3 :
					$image = imagerotate($image, 180, 0);
					break;
				case 6 :
					$image = imagerotate($image, - 90, 0);
					break;
				case 8 :
					$image = imagerotate($image, 90, 0);
					break;
			}
		}
		imagejpeg($image, $filename);
		
		if (array_key_exists('Orientation', $exif)) {
			return $exif['Orientation'];
		}
	
	}

	/**
	 * resize and maintain its original ratio
	 * 
	 * @param string $image_name
	 * @param int $new_width
	 * @param int $new_height
	 * @param int $qualityRate
	 * @param string $uploadDir
	 * @param string $moveToDir
	 * @return boolean - if successful or not
	 */
	public static function resizeImage($image_name, $new_width, $new_height, $qualityRate, $uploadDir, $moveToDir) {

		$path = $uploadDir . '/' . $image_name;
		
		$mime = getimagesize($path);
		
		if ($mime['mime'] == 'image/png') {
			$src_img = imagecreatefrompng($path);
		}
		if ($mime['mime'] == 'image/jpg' || $mime['mime'] == 'image/jpeg' || $mime['mime'] == 'image/pjpeg') {
			$src_img = imagecreatefromjpeg($path);
		}
		
		$old_x = imageSX($src_img);
		$old_y = imageSY($src_img);
		
		if ($old_x > $old_y) {
			$thumb_w = $new_width;
			$thumb_h = $old_y * ($new_height / $old_x);
		}
		
		if ($old_x < $old_y) {
			$thumb_w = $old_x * ($new_width / $old_y);
			$thumb_h = $new_height;
		}
		
		if ($old_x == $old_y) {
			$thumb_w = $new_width;
			$thumb_h = $new_height;
		}
		
		$dst_img = ImageCreateTrueColor($thumb_w, $thumb_h);
		
		imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $thumb_w, $thumb_h, $old_x, $old_y);
		
		// New save location
		$new_thumb_loc = $moveToDir . $image_name;
		
		if ($mime['mime'] == 'image/png') {
			$compressionLevel = 0;
			if (isset($qualityRate) && is_numeric($qualityRate)) {
				$compressionLevel = 9 - (9 * $qualityRate / 100);
			}
			$result = imagepng($dst_img, $new_thumb_loc, $compressionLevel);
		}
		if ($mime['mime'] == 'image/jpg' || $mime['mime'] == 'image/jpeg' || $mime['mime'] == 'image/pjpeg') {
			
			$qualitRate2 = 100;
			if (isset($qualityRate) && is_numeric($qualityRate)) {
				$qualitRate2 = $qualityRate;
			}
			
			$result = imagejpeg($dst_img, $new_thumb_loc, $qualitRate2);
		}
		
		imagedestroy($dst_img);
		imagedestroy($src_img);
		
		return $result;
	
	}

}