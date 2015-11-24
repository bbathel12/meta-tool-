<?php

 /* autoloads all classes that you use */
 function __autoload($class_name) {
    include 'classes/' . $class_name . '.php';
 }
 
 function multiRequest($data, $options = array()) {
 
  // array of curl handles
  $curly = array();
  // data to be returned
  $result = array();
 
  // multi handle
  $mh = curl_multi_init();
 
  // loop through $data and create curl handles
  // then add them to the multi-handle
  foreach ($data as $id => $d) {
    $d = preg_replace( '/\s/','', $d);
    $curly[$id] = curl_init();
   // $proxy = array('66.187.68.69:8888','167.114.24.220:7808','23.95.49.103:7808','162.208.49.45:7808','162.213.31.27:3128','108.59.84.116:8000','52.68.6.46:3128','199.200.120.37:7808','107.182.17.9:7808','72.52.96.31:8080','23.19.33.231:8080','173.237.197.139:8888','23.94.47.176:3128','199.200.120.36:7808','107.150.96.210:80','54.93.77.63:3128','66.146.193.31:8118','67.207.131.25:3128','66.23.233.90:3128','216.189.161.18:8080');

    $url = (is_array($d) && !empty($d['url'])) ? $d['url'] : $d;
    curl_setopt($curly[$id], CURLOPT_URL,            $url);
    curl_setopt($curly[$id], CURLOPT_HEADER,         0);
    curl_setopt($curly[$id], CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curly[$id], CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($curly[$id], CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X x.y; rv:10.0) Gecko/20100101 Firefox/10.0');
    //curl_setopt($curly[$id], CURLOPT_PROXY,$proxy[rand(0,count($proxy))]);
 
    // post?
    if (is_array($d)) {
      if (!empty($d['post'])) {
        curl_setopt($curly[$id], CURLOPT_POST,       1);
        curl_setopt($curly[$id], CURLOPT_POSTFIELDS, $d['post']);
      }
    }
 
    // extra options?
    if (!empty($options)) {
      curl_setopt_array($curly[$id], $options);
    }
 
    curl_multi_add_handle($mh, $curly[$id]);
  }
 
  // execute the handles
  $running = null;
  do {
    curl_multi_exec($mh, $running);
  } while($running > 0);
 
 
  // get content and remove handles
  foreach($curly as $id => $c) {
    $result[$id] = curl_multi_getcontent($c);
    curl_multi_remove_handle($mh, $c);
  }
 
  // all done
  curl_multi_close($mh);
  return $result;
}


function get_the_first($domNodeList){
  if($domNodeList->item(0)){
    return $domNodeList->item(0)->textContent;
  }else{
    return "none";
  }
}


function output_meta($url, $title, $metas, $h1){
    echo "<div class='row output'>";
    echo "<div class='col-xs-10 col-xs-offset-1'>";
    echo "<div class='row'><a href='//$url'><h3>$url</h3></a></div>";
    echo "<div class='row'><strong>Title:</strong> ".$title."</div>";
    $description_found = false;
    $description = '';
    foreach($metas as $meta){
      if($meta->getAttribute('name') === 'description'){
        $description = $meta->getAttribute('content');
        $description_found = true;
      }
      if(!$description_found){
        $description = "No Description Found";
      }
    }
    echo"<div class='row'><strong>Description:</strong> $description</div>";
    echo "<div class='row'><strong>H1</strong>: $h1</div>";
    echo "<hr class='row'>";
    echo "</div></div>";
  
}





function do_stuff($stuff_to_work_on, $urls,$counter){
    $dom = new DOMDocument();                                    // creates new DOMdocument object
    @$dom->loadHTML($stuff_to_work_on);                          // parses html and loads it into the DOMdocument
    $title = get_the_first($dom->getElementsByTagName('title')); // gets the title
    $metas = $dom->getElementsByTagName('meta');                 // gets all meta tags
    $h1 = get_the_first($dom->getElementsByTagName('h1'));       // gets h1
    output_meta($urls[$counter],$title, $metas, $h1);
} 
 
function replace_smart_quotes($text)
{ 
    $search = array(chr(145), 
                    chr(146), 
                    chr(147), 
                    chr(148), 
                    chr(151),
                    'Ð',
                    'Õ',
                    '‰Û"',
                    '‰Ûª');
 
    $replace = array(htmlspecialchars("'"), 
                     htmlspecialchars("'"), 
                     htmlspecialchars('"'), 
                     htmlspecialchars('"'), 
                     htmlspecialchars('_'),
                     htmlspecialchars('-'),
                     htmlspecialchars('\''),
                     htmlspecialchars('-'),
                     htmlspecialchars("'"));
    $text = str_replace($search, $replace, $text); 

    return $text; 
} 
 


?>