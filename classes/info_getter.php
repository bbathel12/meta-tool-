<?php

class info_getter{
  private $live_pages = array();
  /* creates new info getter needs a list of urls to curl */
  function __construct(){
    $this->urls = func_get_arg(0);
  }
  /* this goes through an array of meta tags to see if one of them is the description and then returns its' content */
  public function get_the_description($metas){
    $description_found = false;
    $description ="";
    
    foreach($metas as $meta){
      if(strstr($meta->getAttribute('name'),'escription') ){                              // checks for a name with escription beause this is an easy way to avoid case sensitivity
        $description = $meta->getAttribute('content') ;
        $description_found = true;
      }
      if(!$description_found){
        $description = "No Description Found";                                            // if no description meta tag is found it sets description to "No Description Found"
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
      $this->live_pages[$i]['title'] =  get_the_first($dom->getElementsByTagName('title')) ; // gets the title
      $this->live_pages[$i]['description'] =  $this->get_the_description($metas) ;           // sets description
      $this->live_pages[$i]['h1'] =  get_the_first($dom->getElementsByTagName('h1'));       // gets h1
      $this->live_pages[$i]['other_h1s'] = array();
      $other_h1s = $dom->getElementsByTagName('h1');
      for($count = 1 ; $count <  $other_h1s->length ; $count++){
        array_push($this->live_pages[$i]['other_h1s'],htmlspecialchars( $other_h1s->item($count)->textContent));
      }
      $i += 1;
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