<?php
  	$dir = $_SERVER['DOCUMENT_ROOT'] . "/" . SITE . "/smilies";
    $relLinkPath = "smilies";
    $cnt = 0;
    
	if (is_dir($dir) && $handle = opendir($dir)) 
	{	
      while (($file = readdir($handle)) !== false) 
          {			
            $cnt++;
            if ($file != "." && $file != "..") {
              $filelength = strlen($file);
              if ($filelength > 4){
                // images only. images MUST have 1 '.' only and NO spaces!			
                $pieces = explode(".", $file);

                    if ($pieces[1] == "gif" || $pieces[1] == "jpg" || $pieces[1] == "png")
                    {   
                      
                      $lazyclass ="src='$relLinkPath/$file'";
                      if ($cnt > 15) 
                        $lazyclass=" class='lazy' data-original='$relLinkPath/$file' ";
                      ?>
                      <img data-bind="click: function(smileItem) { insertIntoText('<?php echo $file; ?>')}" style='padding:5px;' with="33" height="33" <?php echo $lazyclass; ?> />       	
                      <?php
                    }
                }	
            }
      }
		
		closedir($handle);								
	}
?>