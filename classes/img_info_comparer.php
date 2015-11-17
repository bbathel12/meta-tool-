<?php
class img_info_comparer{
  /* creates info_comparer it takes two arrays
   *  input info: parsed data from an input_parser
   *  scraped info: data scraped from urls with info_getter
   */
  function __construct(){
    $this->input_info = func_get_arg(0);
    $this->scraped_info = func_get_arg(1);
  }
  /* this compares input_info and scraped_info and creates an array of the results of comparisons. */
  function compare(){
    $count = 0;
    $input = $this->input_info ;
    $live  = $this->scraped_info ;
    foreach($input as $url => $img){
      foreach($img as $src => $meta){
        $src_ = preg_replace('/\s/','',$src);
        if(isset($live[$url][$src_]))
        {
          $in_alt_no_spaces      = preg_replace('/\s/','',$meta['alt']);           // these are the live and input alt and title text with all spaces removed for easy comparison;
          $in_title_no_spaces    = preg_replace('/\s/','',$meta['title']);;
          $live_alt_no_spaces    = preg_replace('/\s/','',$live[$url][$src]['alt']);
          $live_title_no_spaces  = preg_replace('/\s/','',$live[$url][$src]['title']);; 
          $comparison[$url][$src_]['alt']   = ($in_alt_no_spaces === $live_alt_no_spaces) ;
          $comparison[$url][$src_]['title'] = ($in_title_no_spaces === $live_title_no_spaces) ;
        }
        else
        {
          $comparison[$url][$src_]['alt']   = "Image Not On Page" ;
          $comparison[$url][$src_]['title'] = "Image Not On Page" ;
        }
      }
    }
    $this->comparison = $comparison;
  }
  /* returns the comparison array so that output_info can use it later. */
  function get_comparison(){
    return $this->comparison;
  }
  /* this will return a comparison wrapped in pre tags */
  function test(){
    echo "<h1>Comparison</h1><pre>";
    echo print_r($this->comparison);
    echo "</pre>";
  }
  
}//end class

?>
