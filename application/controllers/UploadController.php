<?php

class UploadController extends Zend_Controller_Action
{
	public function init()
	{
		 
	}
	
	 
	public function indexAction()
	{
//		$this->_helper->layout()->disableLayout(); zum testen deaktiviert
	}
	
	public function processAction()
	{
		// HTTP headers for no cache etc
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		
		// Settings
		//$targetDir = ini_get("upload_tmp_dir") . '/' . "plupload";
		$targetDir = 'daten/pics/orig';
		
		//$cleanupTargetDir = false; // Remove old files
		//$maxFileAge = 60 * 60; // Temp file age in seconds
		
		// 5 minutes execution time
		@set_time_limit(5 * 60);
		
		// Uncomment this one to fake upload time
		// usleep(5000);
		
		// Get parameters
		$chunk = isset($_REQUEST["chunk"]) ? $_REQUEST["chunk"] : 0;
		$chunks = isset($_REQUEST["chunks"]) ? $_REQUEST["chunks"] : 0;
		$fileName = isset($_REQUEST["name"]) ? $_REQUEST["name"] : '';
		
		// Clean the fileName for security reasons
		$fileName = preg_replace('/[^\w\._]+/', '', $fileName);
		$ext = strrpos($fileName, '.');
		$fileName_a = substr($fileName, 0, $ext);
		$fileName_b = substr($fileName, $ext);
	
		
		// Make sure the fileName is unique but only if chunking is disabled
/*		if ($chunks < 2 && file_exists($targetDir . '/' . $fileName)) {
		
			$count = 1;
			while (file_exists($targetDir . '/' . $fileName_a . '_' . $count . $fileName_b))
			$count++;
		
			$fileName = $fileName_a . '_' . $count . $fileName_b;
		}*/ 
		
		// Create target dir
		if (!file_exists($targetDir))
		@mkdir($targetDir);
		
		// Remove old temp files
		/* this doesn't really work by now
		
		if (is_dir($targetDir) && ($dir = opendir($targetDir))) {
		while (($file = readdir($dir)) !== false) {
		$filePath = $targetDir . '/' . $file;
		
		// Remove temp files if they are older than the max age
		if (preg_match('/\\.tmp$/', $file) && (filemtime($filePath) < time() - $maxFileAge))
		@unlink($filePath);
		}
		
		closedir($dir);
		} else
		die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
		*/
		
		// Look for the content type header
		if (isset($_SERVER["HTTP_CONTENT_TYPE"]))
		$contentType = $_SERVER["HTTP_CONTENT_TYPE"];
		
		if (isset($_SERVER["CONTENT_TYPE"]))
		$contentType = $_SERVER["CONTENT_TYPE"];
		
		// Handle non multipart uploads older WebKit versions didn't support multipart in HTML5
		$pic_ident = $fileName_a . '_' . md5_file($_FILES['file']['tmp_name']) . $fileName_b;
		if (strpos($contentType, "multipart") !== false) {
			if (isset($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name'])) {
				// Open temp file
				$out = fopen($targetDir . '/' . $pic_ident, $chunk == 0 ? "wb" : "ab"); 						//TODO: '/' verwenden
				if ($out) {
					// Read binary input stream and append it to temp file
					$in = fopen($_FILES['file']['tmp_name'], "rb");
		
					if ($in) {
						while ($buff = fread($in, 4096))
						fwrite($out, $buff);
					} else
					die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
					fclose($in);
					fclose($out);
					@unlink($_FILES['file']['tmp_name']);
				} else
				die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
			} else
			die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
		} else {
			// Open temp file
			$out = fopen($targetDir . '/' . $pic_ident, $chunk == 0 ? "wb" : "ab"); 
			if ($out) {
				// Read binary input stream and append it to temp file
				$in = fopen("php://input", "rb");
		
				if ($in) {
					while ($buff = fread($in, 4096))
					fwrite($out, $buff);
				} else
				die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
		
				fclose($in);
				fclose($out);
			} else
			die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
		}
		
		
		// Exif Daten Sammeln
		$exifArray = exif_read_data($targetDir . '/' . $pic_ident);
		$dateShot = $exifArray['DateTimeOriginal'];
		$gpsLatNS = $exifArray['GPSLatitudeRef']; // N oder S ?
		$gpsLatKoord = Application_Model_gpsTools::toFloat($exifArray['GPSLatitude']);
		
		$gpsLongEW =$exifArray['GPSLongitudeRef']; // E oder W?
		$gpsLongKoord = Application_Model_gpsTools::toFloat($exifArray['GPSLongitude']);	

		
		// eintrag in die datenbank
		$obPictures = new Application_Model_PictureMapper();		
		$obPictures ->create($pic_ident, $gpsLatKoord, $gpsLongKoord, date('Y-m-d H:i:s'), $dateShot);
		// formular ausblenden
		$this->view->success = true;
		
		
		// Return JSON-RPC response
		die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');
	}
}