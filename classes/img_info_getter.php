<?php

class img_info_getter{
  
  private $live_pages = array();
  /* creates new info getter needs a list of urls to curl */
  function __construct(){
    $this->urls = func_get_arg(0);
    $this->imgs = func_get_arg(1);
  }
  /* this goes through an array of img tags to see if any of them match the src's listed */
  
  
  function run(){
    $result = multiRequest($this->urls);
    foreach($result as $k => $page){
      $dom = new DOMDocument();                                                            // creates new DOMdocument object
      @$dom->loadHTML($page);                                                              // parses html and loads it into the DOMdocument
      $imgs = $dom->getElementsByTagName('img');                                           // gets all meta tags
      $current_url =$this->urls[$k];                                                       // get the url of the current page we're going to iterate through
      $matches = preg_split('/\//',$current_url);
      $domain =  $matches[0]."//".$matches[2];
      for($i = 0; $i< $imgs->length ; $i++){                                               // iterate through every image on the current page
        $img = $imgs->item($i);                                                            // since we're using dom node lists you have to use the item() function to get the img you want
        foreach($this->imgs[$current_url] as $input){                                      // this gets the input imgs from the input stuff
          if(strstr($input['src'],$img->getAttribute('src'))){                             // if the src from the page is contained within the src from the gdoc
            $src = trim($img->getAttribute('src'));                                        // trims the src from the image.
            $src = preg_replace('/\s/','',$src);                                           // replace any spaces because there shouldn't be spaces in a src or url probably doesn't do anything
            if(!strstr($src,'//')){                                                        // if the string doesn't contain // then it's a relative src and stuff needs to be done.
              if(preg_match('/\/$/',$current_url) && preg_match('/^\//',$src)){            // if the url ends in / and the src begins in /
                $matches = preg_split('/\//',$current_url);                                // split the url on /'s and only add the protocol and domain
                $src = $matches[0]."//".$matches[2].$src;            
              }
              elseif(preg_match('/^\//',$src)){                                            // the the src begins with a slash but the url doesn't end in one
                $matches = preg_split('/\//',$current_url);                                // split the url on /'s and add the protocol and domain
                $src = $matches[0]."//".$matches[2].$src;
              }
              else{
                $matches = preg_split('/\//',$current_url);
                $src = $matches[0]."//".$matches[2]."/".$src;                              // or if neither of url doesn't have a trailing slash and the src doesn't have a preceding slash 
              }                                                                            // just put them together
            }
            elseif(preg_match('/^\/+/',$src)){                                             // if the src begins with more than one / just add the protocol from the url
                $matches = preg_split('/\//',$current_url); 
                $src = "$matches[0]".$src;
            }
            // the next three lines set temp pages with a index of current_url then current_src then just the string src, alt, and title 
            $temp_pages[$current_url][$src]['src']   = ($img->getAttribute('src'))   ?   $src : "none";
            $temp_pages[$current_url][$src]['alt']   = ($img->getAttribute('alt'))   ?   $img->getAttribute('alt')     : "none";
            $temp_pages[$current_url][$src]['title'] = ($img->getAttribute('title')) ?   $img->getAttribute('title')   : "none";
            
          }
        }
      }
    }
    $this->live_pages = $temp_pages;                                                       // after all the iterating and setting is finally done it move the temp_pages array to the live_pages array.
  }
  
  
  /* this returns all the scraped info used by info_comparer */
  function get_info(){
    return $this->live_pages;
  }
  
  /* runs info_getter and outputs the scraped data for testing */
  function test(){
    $this->run();
    echo "<h1>Live Data</h1><pre>";
    print_r($this->live_pages);
    echo "</pre>";
  }
  
}
?>