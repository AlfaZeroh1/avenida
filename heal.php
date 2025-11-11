<?php
$di = new DirectoryIterator("modules");
$search='").autocomplete("';
$search2 = '").result(function(event, data, formatted) {';

foreach(new RecursiveDirectoryIterator("reports") as $filename => $file){
//   echo $filename."\n";
  if(is_dir($filename)){
    foreach(new RecursiveDirectoryIterator($filename) as $filenames => $files){
//       echo $filenames."\n";
      if(is_dir($filenames)){
	foreach(new RecursiveDirectoryIterator($filenames) as $filenamess => $filess){
	  $fl = pathinfo($filenamess);
	  if($fl['extension']=="php" and strpos($filenamess,"../")==false){
	  $pos = strpos(file_get_contents($filenamess),$search);
	  $lines = file($filenamess);
	  $i=0;
	  $str="";
	  $nstr="";
	  $nstr2="";
	  $bool=false;
	  $it=false;
	  $bl = false;
	  $x=0;
	  
	  while($i<count($lines)){
	    if($ps=strpos($lines[$i],$search) || $ps2=strpos($lines[$i],$search2)){
	      if(empty($ps2)){
		//read substr
		$nstr='  $("#'.getStringbtn($lines[$i],'$("#','").autocomplete("')."\").autocomplete({\n	source:\"".getStringbtn($lines[$i],'").autocomplete("','", {')."\",\n";
		$nstr.="	focus: function(event, ui) {\n";
		$nstr.="		event.preventDefault();\n";
		$nstr.="		$(this).val(ui.item.label);\n";
		$nstr.="      	},\n";
		$nstr.="      	select: function(event, ui) {\n";
		$nstr.="		event.preventDefault();\n";
		$nstr.="		$(this).val(ui.item.label);\n";
		
		
	      }else{
		$bl=true;
	      }
	      $str=$lines[$i];
	      $nstr2.=$str;
	      
	      $bool=true;
	      $it=true;
	    }else{
	      $it=false;
	    }
	    
	    if($bool and $it==false){
	      $str.=$lines[$i];
	      $nstr2.=$str;
	      
	      if(strpos($lines[$i],'document.getElementById("')){
			$x++;
			if($x==1){
// 			  $nstr.="		$(\"#". getStringbtn($lines[$i],'document.getElementById("','").value') ."\").val(ui.item.name);\n";
			}elseif($x==2){
			  $nstr.="		$(\"#". getStringbtn($lines[$i],'document.getElementById("','").value') ."\").val(ui.item.id);\n";
			}else{
			  $nstr.="		$(\"#". getStringbtn($lines[$i],'document.getElementById("','").value') ."\").val(ui.item.".getStringbtn($lines[$i],'document.getElementById("','").value').");\n";
			}
		
	      }else{
		$x=0;
	      }
	    }
	    
	    if(strpos($lines[$i],"});")){
	      $bool=false;
	      if($bl){
		$nstr.="	}\n";
		$nstr.="  });\n\n";
	      }
	      $bl=false;
	      
// 	      echo $str;
	      echo $filenamess."\n";
// 	      echo $str."\n";
// 	      echo $nstr."\n";
	      //open file and replace
	      if(!empty($str))
		replace_string_in_file($filenamess, $str, $nstr);
	      	      
	      $it=0;
	      $nstr="";
	      $ps="";
	      $ps2="";
	      $str="";
	    }
	    
	    
	    
	    $i++;
	  }
	  
	  }
	}
      }
    }
  }
}

function getStringbtn($str,$from,$to){
  $sub = substr($str,strpos($str,$from)+strlen($from),strlen($str));
  
  return substr($sub,0,strpos($sub,$to));
}

function replace_string_in_file($filename, $string_to_replace, $replace_with){
    $content=file_get_contents($filename);
    $content_chunks=explode($string_to_replace, $content);
    $content=implode($replace_with, $content_chunks);
    file_put_contents($filename, $content);
}
?>