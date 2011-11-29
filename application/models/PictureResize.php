<?php
    class Application_Model_PictureResize 
    {
    	private $image;
		private $width;
		private $height;
		private $imageResized;
		
		function __construct($fileName)
		{
			$this->image = $this->openImage($fileName);
			
			$this->width	= 	imagesx($this->image);
			$this->height 	=	imagesy($this->image);
		}
		
		private function openImage($file)
		{
			$extension 		=	strtolower(strrchr($file, '.'));
			
			switch($extension)
			{
				case '.jpg':
				case '.jpeg':
					$img = @imagecreatefromjpeg($file);
					break;
				case '.gif':
					$img = @imagecreatefromgif(($file));
					break;
				case '.png':
					$img = @imagecreatefrompng($file);
					break;
				default:
					$img = false;
					break;
			}
			return $img;
		}
		
		public function resizeImage($newWidth, $newHeight, $option="auto")
		{
			/* Sinnvolle Bildgrößen ermitteln
			 * Optionen:
			 * exact: Ratio beibehalten
			 * portrait: Höhe gegeben, breite wird angepasst
			 * landscape: Breite gegeben, Höhe wird angepasst
			 * auto: skriptbestimmt
			 * crop: Größe Ändern, rest wegschneiden
			 */
			
			$optionArray 	= 	$this->getDimensions($newWidth, $newHeight, strtolower(($option)));
			$optimalWidth 	=	$optionArray['optimalWidth'];
			$optimalHeight 	=	$optionArray['optimalHeight'];
			
			$this->imageResized	= imagecreatetruecolor($optimalWidth, $optimalHeight);
			imagecopyresampled($this->imageResized, $this->image, 0, 0, 0, 0, $optimalWidth, $optimalHeight, $this->width, $this->height);
			
			if ($option == 'crop') {
				$this->crop($optimalWidth, $optimalHeight, $newWidth, $newHeight);
			}
		}
		
		private function getDimensions($newWidth, $newHeight, $option)
		{
			switch ($option)
			{
				case 'exact':
					$optimalWidth	= $newWidth;
					$optimalHeight 	= $newHeight;
					break;
				case 'portrait':
					$optimalWidth	= $this->getSizeByFixedHeight($newHeight);
					$optimalHeight	= $newHeight;
					break;
				case 'landscape':
					$optimalWidth	= $newWidth;
					$optimalHeight	= $this->getSizeByFixedWidth($newWidth);
					break;
				case 'auto':
					$optionArray	= $this->getSizeByAuto($newWidth, $newHeight);
					$optimalWidth	= $optionArray['optimalWidth'];
					$optimalHeight	= $optionArray['optimalHeight'];
					break;
				case 'crop':
					$optionArray	= $this->getOptimalCrop($newWidth, $newHeight);
					$optimalWidth	= $optionArray['optimalWidth'];
					$optimalHeight	= $optionArray['optimalHeight'];
					break;
			}
			return array(
				'optimalWidth' 	=> $optimalWidth,
				'optimalHeight'	=> $optimalHeight
				);
				
		}
		
		private function crop($optimalWidth, $optimalHeight, $newWidth, $newHeight)						// Uuuuuuuuuuuuuuund: SCHNITT!!!
		{
			// Bildmitte finden
			$cropStartX	= ($optimalWidth  / 2) - ($newWidth  / 2);
			$cropStartY = ($optimalHeight / 2) - ($newHeight / 2);
			
			$crop = $this->imageResized;
			
			// Von der Bildmitte bis zur richtigen größe Croppen
			$this->imageResized = imagecreatetruecolor($newWidth, $newHeight);
			imagecopyresampled($this->imageResized, $crop, 0, 0, $cropStartX, $cropStartY, $newWidth, $newHeight, $newWidth, $newHeight);
			
		}
		
		public function saveImage($savePath, $imageQuality="100")
		{
			// Dateiendung
			$extension = strrchr($savePath, '.');
			$extension = strtolower($extension);
			
			switch ($extension)
			{
				case '.jpg':
				case '.jpeg':
					if (imagetypes() & IMG_JPG){
						imagejpeg($this->imageResized, $savePath, $imageQuality);
					}
					break;
					
				case '.gif':
					if (imagetypes() & IMG_GIF){
						imagegif($this->imageResized, $savePath);
					}
					break;
				case '.png':
					// Bildqualität von 0-100 auf 0-9 umrechnen
					$scaleQuality = round(($imageQuality / 100) * 9);
					
					// Quality invertieren
					$invertScaleQuality = 9 - $scaleQuality;
					
					if (imagetypes() & IMG_PNG){
						imagepng($this->imageResized, $savePath, $invertScaleQuality);
					}
					break;
				default:
					break;
			}
			imagedestroy($this->imageResized);
		}
		
		private function getSizeByFixedHeight($newHeight)
		{
			$ratio = $this->width / $this->height;
			$newWidth = $newHeight * $ratio;
			return $newWidth;
		}
		
		private function getSizeByFixedWidth($newWidth)
		{
			$ratio = $this->height / $this->width;
			$newHeight = $newWidth * $ratio;
			return $newHeight;
		}
		
		private function getSizeByAuto($newWidth, $newHeight)
		{
			if ($this->height < $this->width)
			// Bild im Querformat
			{
				$optimalWidth = $newWidth;
				$optimalHeight = $this->getSizeByFixedWidth($newWidth);
			}
			elseif ($this->height > $this->width)
			// Bild im Hochformat
			{
				$optimalWidth = $this->getSizeByFixedHeight($newHeight);
				$optimalHeight = $newHeight;
			}
			else
				// Bild ist quadratisch
			{
				if ($newHeight < $newWidth){
					$optimalWidth = $newWidth;
					$optimalHeight = $this->getSizeByFixedWidth($newWidth);
				} else if ($newHeight > $newWidth) {
					$optimalWidth = $this->getSizeByFixedHeight($newHeight);
					$optimalHeight = $newHeight;
				} else {
					// Fall: Quadrat bleibt Quadrat
					$optimalWidth = $newWidth;
					$optimalHeight = $newHeight;
				}
				
			}
			return array(
				'optimalWidth'	=>	$optimalWidth,
				'optimalHeight'	=>	$optimalHeight
				);	
		}
		
		private function getOptimalCrop ($newWidth, $newHeight)
		{
			$heightRatio = $this->height / $newHeight;
			$widthRatio = $this->width / $newWidth;
			
			if ($heightRatio < $widthRatio) {
				$optimalRatio = $heightRatio;
			} else {
				$optimalRatio = $widthRatio;
			}
			
			$optimalHeight = $this->height / $optimalRatio;
			$optimalWidth = $this->width / $optimalRatio;
			
			return array(
				'optimalWidth'	=> $optimalWidth,
				'optimalHeight' => $optimalHeight
				);
		}
    }






?>