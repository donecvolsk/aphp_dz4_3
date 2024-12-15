<?php

function autoloader($class_name): string
{
    // echo $class_name . PHP_EOL;
    // return require_once $class_name . '.php';

    $pathFile = search_file('.', $class_name);    
    return require __DIR__ . "/" . $pathFile[0];

}

function search_file( $folderName, $fileName ){
	$found = array();
	$folderName = rtrim( $folderName, '/' );
	$dir = opendir( $folderName );

	while( ($file = readdir($dir)) !== false ){
		$file_path = "$folderName/$file";
        // echo $file_path . PHP_EOL;

		if( $file == '.' || $file == '..' ) continue;

		if( is_file($file_path) ){
			if( false !== strpos($file, $fileName) ) $found[] = $file_path;
		}
		elseif( is_dir($file_path) ){
			$res = search_file( $file_path, $fileName );
			$found = array_merge( $found, $res );
		}
	}

	closedir($dir);

	return $found;
}