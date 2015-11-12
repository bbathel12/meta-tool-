<?php


class input_parser{
  
  private $url_regex         = "/[^\:\n]*(url|URL)+[^\:]*\:([^\n]*)/";
  private $title_regex       = "/[^\:\n]*(T|title)+[^\:]*\:([^\n]*)/";
  private $description_regex = "/[^\:\n]*(Meta|meta)+[^\:]*\:([^\n]*)/";
  private $h1_regex          = "/[^\:\n]*(h1|H1)+[^\:]\:([^\n]*)/";
  private $pages             = array();

  
  /* takes a string of text to parse*/
  function __construct(){
    $this->text = func_get_arg(0);
  }
  
  /* returns true if the $line matches the url_regex */
  public function is_url($line){
    return preg_match($this->url_regex, $line);
  }
  /* returns true if the $line matches the title_regex */  
  public function is_title($line){
    return preg_match($this->title_regex, $line);
  }
  /* returns true if the $line matches the description_regex */  
  public function is_description($line){
    return preg_match($this->description_regex, $line);
  }
  /* returns true if the $line matches the h1_regex */  
  public function is_h1($line){
    return preg_match($this->h1_regex, $line);
  }
  
  /* parses the input string by spliting it on new lines into individual lines */
  public function parse(){
    $exploded_text = preg_split("/\n/",$this->text);
    $index = 0;
    foreach($exploded_text as $line){
      // do this if the page doesn't have all of the necessary info set (title,description,url,and h1);
      if(!isset($pages[$index]['url']) || !isset($pages[$index]['title']) || !isset($pages[$index]['description']) || !isset($pages[$index]['h1'])){
        if($this->is_url($line)){                            // if the line is a url add it to the page as the url
          $url = preg_split('/http\:/', $line);              // get all info after the colon
          $pages[$index]['url'] = 'http:'.$url[1];
        }
        elseif($this->is_title($line)){                      // if the line is a title add it to the page as the title
          $title = preg_split('/\:/', $line);                // get all info after the colon
          $pages[$index]['title'] = $title[1];
        }
        elseif($this->is_description($line)){                // if the line is a description add it to the page as the description
          $description = preg_split('/\:/', $line);          // get all info after the colon
          $pages[$index]['description'] = $description[1];
        }
        elseif($this->is_h1($line)){                         // if the line is a h1 add it to the page as the h1
          $h1 = preg_split('/\:/', $line);                   // get all info after the colon
          $pages[$index]['h1'] = $h1[1];
        }
      }
      else{
        $index += 1;                                         // if all the correct info is set go on to the next page.
      }
    }
    $this->pages = $pages;                                   // set pages property equal to the $pages array 
  }
  
  /* this will return the pre parsed text if you want it for some reason. */
  public function get_text(){
    echo $this->$text;
  }
  
  /* this will return all urls from the pages array this is used by the info getter to curl all the pages */
  public function get_urls(){
    $urls = array();
    $i = 0;
    foreach($this->pages as $page){
      $urls[$i] = preg_replace( '/\n/','', $page['url']);
      $i++;
    }
    return $urls;
  }
  
  /* returns pages property this is used for info_comparer later */
  public function get_pages(){
    return $this->pages;
  }
  
  /* parses and outputs preformatted text to see if everything is working ok */
  public function test(){
    echo "<h1>INput</h1><pre>";
    echo $this->parse($this->text);
    echo "</pre>";
  }

}
?>
