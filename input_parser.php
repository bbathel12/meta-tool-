<?php


class input_parser{
  
  private $url_regex         = "/[^\:\n]*(url|URL)+[^\:]*\:([^\n]*)/";
  private $title_regex       = "/[^\:\n]*(T|title)+[^\:]*\:([^\n]*)/";
  private $description_regex = "/[^\:\n]*(Meta|meta)+[^\:]*\:([^\n]*)/";
  private $h1_regex          = "/[^\:\n]*(h1|H1)+[^\:]\:([^\n]*)/";
  private $pages             = array();

  
  
  function __construct(){
    $this->text = func_get_arg(0);
  }
  
  public function is_url($line){
    return preg_match($this->url_regex, $line);
  }
  
  public function is_title($line){
    return preg_match($this->title_regex, $line);
  }
  
  public function is_description($line){
    return preg_match($this->description_regex, $line);
  }
  
  public function is_h1($line){
    return preg_match($this->h1_regex, $line);
  }

  public function parse(){
    $exploded_text = preg_split("/\n/",$this->text);
    $index = 0;
    foreach($exploded_text as $line){
      if(!isset($pages[$index]['url']) || !isset($pages[$index]['title']) || !isset($pages[$index]['description']) || !isset($pages[$index]['h1'])){
        if($this->is_url($line)){
          $url = preg_split('/http\:/', $line);
          $pages[$index]['url'] = 'http:'.$url[1];
        }
        elseif($this->is_title($line)){
          $title = preg_split('/\:/', $line);
          $pages[$index]['title'] = $title[1];
        }
        elseif($this->is_description($line)){
          $description = preg_split('/\:/', $line);
          $pages[$index]['description'] = $description[1];
        }
        elseif($this->is_h1($line)){
          $h1 = preg_split('/\:/', $line);
          $pages[$index]['h1'] = $h1[1];
        }
      }
      else{
        $index += 1;
      }
    }
    $this->pages = $pages;
  }
  public function get_text(){
    echo $this->$text;
  }
  
  public function get_urls(){
    $urls = array();
    $i = 0;
    foreach($this->pages as $page){
      $urls[$i] = preg_replace( '/\n/','', $page['url']);
      $i++;
    }
    return $urls;
  }
  
  public function get_pages(){
    return $this->pages;
  }
  
  public function test(){
    echo "<h1>INput</h1><pre>";
    echo $this->parse($this->text);
    echo "</pre>";
  }
  
}
?>