<?php
$content = getpage("www.ssau.ru","/");
$contents = explode("\n",$content);
foreach ($contents as $cc) {
 $cr = ereg_replace("<","&lt;",$cc);
 echo $cr."<br>\n";
}
function getpage($host,$path) {

 $nn="\r\n"; $data="";
 $request = "GET $path HTTP/1.0".$nn. 
 "Referer: $host".$nn.
 "Content-Type: application/x-www-formurlencoded".$nn.
 "Host: $host".$nn.$nn;
 flush();
 $fp = fsockopen("$host", 80, &$errno,
&$errstr, 30);
 if(!$fp) {echo "$errstr ($errno)<br>\n";
exit;}
 fputs($fp,$request);
 while(!feof($fp)) {
 $data.= fgets($fp,4096);
 }
 fclose($fp);
 return $data;
}
?>