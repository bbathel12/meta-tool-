<?php

class img_input_parser{
  
  private $url_regex         = "/[^\:\n]*(url|URL)+[^\:]*\:([^\n]*)/";
  
  function __construct($text){
    $this->text = $text;
  }
    
  public function parse(){
    $exploded_text = preg_split("/\n/",$this->text);
    $index = 0;
    $row = 0;
    $url_set= false;
    foreach($exploded_text as $k => $line){
      $cells = preg_split("/\t/",$line);
      // if the first cell is not blank
      if(!empty($cells[0])){
        $url =  $cells[0];
        $row =  0;
        $pages[$url][$row]['src']   = $cells[1];
        $pages[$url][$row]['title'] = $cells[2];
        $pages[$url][$row]['alt']   = $cells[3];
      }
      //if first cell is blank then increase row and add the stuff
      elseif(!empty($cells[1])){
        $row += 1;
        $pages[$url][$row]['src']   = $cells[1];
        $pages[$url][$row]['title'] = $cells[2];
        $pages[$url][$row]['alt']   = $cells[3];
      }
    }
    $this->pages = $pages;
  }
  
  /* this will return all urls from the pages array this is used by the info getter to curl all the pages */
  public function get_urls(){
    $urls = array();
    $i = 0;
    foreach($this->pages as $k => $page){
      $urls[$i] = preg_replace( '/\s/','',$k);
      $i++;
    }
    return $urls;
  }
  
  /* returns pages which is an array of all info gathered from parsing */
  function get_pages(){
    return $this->pages;
  }
  
  public function get_the_srcs(){
    
  }
  
  /* test function outputs pages within pre tags */
  function test(){
    echo "<pre>";
    print_r($this->pages);
    echo "</pre>";
  }
  
}

?>
