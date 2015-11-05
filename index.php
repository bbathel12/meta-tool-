<html>
<?php
ini_set('display_errors',1);
//phpinfo();
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
function do_stuff($stuff_to_work_on, $urls,$counter){
            $H1Pattern = '/[.\b\r\n]?\<h1.*\>(.*)\<\/h1\>/i';
            $TitlePattern = '/[.\b\r\n]?\<title[^\>]*\>(.*?)\<\/title\>/im';
            $DescriptionPattern = '/<meta.*?name=["|\']description["|\'].*?content=["|\'](.*?)["|\']/im';
            preg_match($H1Pattern, $stuff_to_work_on, $h1s);
            preg_match($TitlePattern,$stuff_to_work_on,$titles);
            preg_match($DescriptionPattern,$stuff_to_work_on,$descriptions);
            echo "URL: ".$urls[$counter]."<br>";
            if(isset($h1s[1])){
                echo "H1:".$h1s[1]."<br>";
            }else{
                echo "H1: <span style=\"color:red\">NONE</span><br>";
            }
            if(isset($titles[1])){
                echo "Title: ".$titles[1]."<br>";
            }else{
                echo "Title: <span style=\"color:red\">NONE</span><br>";
            }
            if(isset($descriptions[1])){
            echo "Description: ".$descriptions[1]."<br>";
            }
            else{
                echo "Description: <span style=\"color:red\">NONE</span><br>";
            }
            echo "<hr>";
            //print_r($stuff_to_work_on);
           
} 
 
?>
<?php if(!isset($_POST['urls'])) {?>

<h1>This will give you the 1st <strong>H1</strong>, <strong>Title</strong>, and <strong>Description</strong> of all the URLs you enter.</h1>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="urls"> URLS:(endline seperated list of URLS)</label>
            <textarea name="urls"></textarea>
        
        <input type="submit">
    </form>
<?php

}

else{
    //$proxy = array('66.187.68.69:8888','167.114.24.220:7808','23.95.49.103:7808','162.208.49.45:7808','162.213.31.27:3128','108.59.84.116:8000','52.68.6.46:3128','199.200.120.37:7808','107.182.17.9:7808','72.52.96.31:8080','23.19.33.231:8080','173.237.197.139:8888','23.94.47.176:3128','199.200.120.36:7808','107.150.96.210:80','54.93.77.63:3128','66.146.193.31:8118','67.207.131.25:3128','66.23.233.90:3128','216.189.161.18:8080');
    $urls = explode("\n", $_POST['urls']);
    #var_dump($urls);
    #echo "<br>";
    for($count = 0; $count < count($urls)-1;$count++){
    # $url = preg_replace('/[^.]*/','',$url);  
      if(!(preg_match('/[\w\/]/',substr($urls[$count], -1)))){ 
	$urls[$count] = substr($urls[$count], 0, -1); 
     } #echo $urls[$count]."<br>";
    }
    
    #var_dump($urls);
    /*$urls = array(
                    'https://plus.google.com/118122064633722815492',
                    'http://google.com',
                    'http://hackthissite.org',
                    'http://roothlaw.com');
    */
    //var_dump($urls);
    $result = multiRequest($urls);

    $i=0;
    foreach($result as $r){
        do_stuff($r,$urls,$i);
        $i++;
    }
    
    /*$mh = curl_multi_init();
    $i = 0;
    foreach($urls as $url){
        $ch[$i] = curl_init();
        curl_setopt($ch[$i], CURLOPT_USERAGENT,'Mozilla/5.0 (iPhone; CPU iPhone OS 5_0 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9A334 Safari/7534.48.3');
        curl_setopt($ch[$i], CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch[$i], CURLOPT_URL, $url);
        curl_setopt($ch[$i], CURLOPT_HEADER, 1);
        curl_setopt($ch[$i], CURLOPT_VERBOSE, 1);
        curl_setopt($ch[$i], CURLOPT_USERAGENT,'Mozilla/5.0 (iPhone; CPU iPhone OS 5_0 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9A334 Safari/7534.48.3');
        curl_setopt($ch[$i], CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch[$i], CURLOPT_NOBODY,0);
        curl_setopt($ch[$i], CURLOPT_VERBOSE, 1);
        curl_setopt($ch[$i], CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch[$i],CURLOPT_FOLLOWLOCATION,1);
        //curl_setopt($ch[$i], CURLOPT_PROXY, $proxy[$i%count($proxy)]);
        curl_multi_add_handle($mh,$ch[$i]);
        $i++;
        
    }
    
    $active = null;
    do {
    $mrc = curl_multi_exec($mh, $active);
    }while ($mrc == CURLM_CALL_MULTI_PERFORM);


    // Get content and remove handles.
    $results = array();
    while ($active && $mrc == CURLM_OK) {
        if (curl_multi_select($mh) != -1) {
            do {
                $mrc = curl_multi_exec($mh, $active);
            } while ($mrc == CURLM_CALL_MULTI_PERFORM);
        }
    }
    $i=0;
    while(isset($ch[$i])){
        $r[$i] = curl_multi_getcontent($ch[$i]);
        do_stuff($r[$i],$urls,$i);
        $i++;
    }
    curl_multi_close($mh);
*/
}
?>
<style>
    form{
        background-color:#345678;
        display:block;
        margin:auto;
        width:50%;
        padding:2%;
        
    }
    label{
        color:#987654;
        font-size:20px;
        display:block;
        margin:auto;
        width:100%;
        text-align:center;
    }
    input[type='submit']{
        display:block;
        margin:auto;
        width:50%;
        font-size:20px;
    }
    textarea{
        width:90%;
        display:block;
        height:400px;
        font-size:16px;
        margin:auto;
    }
    h1{
        text-align:center;
        color:orange;
        font-weight:300;
        
    }
    strong{
        color:black;
    }
</style>
</html>


