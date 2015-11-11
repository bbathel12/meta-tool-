<?php

class info_getter{
  private $live_pages     = array();
  
  function __construct(){
    $this->urls = func_get_arg(0);
    print_r($this->urls);
  }
  
  public function get_the_description($metas){
    $description_found = false;
    $description ="";
    
    foreach($metas as $meta){
      if(strstr($meta->getAttribute('name'),'escription') ){
        $description = $meta->getAttribute('content');
        $description_found = true;
      }
      if(!$description_found){
        $description = "No Description Found";
      }
    }
    return $description;
   }
  
  function run(){
    $result = multiRequest($this->urls);
    $i = 0;
    foreach($result as $page){
      $dom = new DOMDocument();                                                            // creates new DOMdocument object
      @$dom->loadHTML($page);                                                              // parses html and loads it into the DOMdocument
      $metas = $dom->getElementsByTagName('meta');                                         // gets all meta tags
      $this->live_pages[$i]['url'] = $this->urls[$i];                                      // sets url
      $this->live_pages[$i]['title'] = get_the_first($dom->getElementsByTagName('title')); // gets the title
      $this->live_pages[$i]['description'] = $this->get_the_description($metas);           // sets description
      $this->live_pages[$i]['h1'] = get_the_first($dom->getElementsByTagName('h1'));       // gets h1
      $i += 1;
    }
  }
  
  function test(){
    $this->run();
    echo "<pre>";
    print_r($this->live_pages);
    echo "</pre>";
  }
  
}
?>