<?php
/*
 * Reads the EXIF data from images.
 * 
 * To use:
 * Put this script somewhere in your document web root.
 * In the same directory, create a new directory called 'images'.
 * Inside this 'images' directory place the image files you would like to read the exif data from.
 * 
 * Go to the url of this script and run, eg. put url in browser and press return.
 * 
 * Nothing is changed on the images by using the script; you may run it as many times as you like and change the images as you like.
 * 
 * 
 * Further uses:
 * - I have a version that creates drupal nodes with the images, using the exif data to populate node fields.
 * There would be no reason not to do something like spread the images into different directories and add some text files into each that might contain additional info for the nodes eg. tags.
 *
 *
 *
 * LisaH
 */

//the path to where the images are stored.
define('SOURCE_IMAGES_DIRECTORY', 'images');


//get a list of the files in the images directory
$files = read_files_directory(SOURCE_IMAGES_DIRECTORY);
print "<p><b>Listing images found... </b></p>";
print "<p><i>Format: ([file] => [path]) </i></p>";
//Simple print-out of the files that the script has found.
print '<pre>';
print_r($files);
print '</pre>';
//set a counter: not used at the moment
$n=1;
print "<p><b>Now outputting exif metadata... </b></p>";
foreach($files as $file)  {
  print '<p><b>Metadata for file: ' . $file . '</b></p>';
  //This is all there is to it!
  $metadata = exif_read_data($file);
  print '<pre>';
  print_r($metadata);
  print '</pre>';
}


/*
 * Takes a directory and builds a list of all the files in it.
 * Stops the script if the directory could not be found or cannot be read.
 * 
 * @param  string  the directory to search
 * @return array  an associative array. key: filename  value: full path to file
 */
function read_files_directory($dir)  {
  $files = array();
  if($handler = opendir($dir)) {
    while (($file = readdir($handler)) !== FALSE) {
      if ($file != "." && $file != ".." ) {
        if(is_file($dir."/".$file)){
          $files[$file] = $dir."/".$file;
        }
      }
    }
    closedir($handler);
  }
  else {
    print "Error: could not open dir $dir";
    exit();
  }
  return $files;
}
?>