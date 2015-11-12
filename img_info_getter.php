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
      $current_url =$this->urls[$k];
      for($i = 0; $i< $imgs->length ; $i++){
        $img = $imgs->item($i);
        $this->live_pages[$current_url][$i]['src']   = ($img->getAttribute('src')) ? $img->getAttribute('src') : "none";
        $this->live_pages[$current_url][$i]['alt']   = ($img->getAttribute('alt')) ? $img->getAttribute('alt') : "none";
        $this->live_pages[$current_url][$i]['title'] = ($img->getAttribute('title')) ? $img->getAttribute('title') : "none";
      }
    }
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