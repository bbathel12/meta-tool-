<?php

class img_output_info {
  
  /* Creates an output object takes three arrays
   *  input_data is an array of parsed input seperated in to url, title, description, and h1
   *  live_data is data scraped for the pages seperated in to url, title, description, and h1
   *  comparison is the output of the info_comparer, it's an array of booleans that tell you if the url, title, description, and h1 of the input and scraped data match
   */
  function __construct($input_data,$live_data,$comparison){
    $this->input_data = $input_data;
    $this->live_data  = $live_data;
    $this->comparison = $comparison;
  }
  
  /* Outputs formatted data collected */  
  function output(){
    $count = 0;
    $in   = $this->input_data;
    $live = $this->live_data;
    $comp = $this->comparison;
    foreach($in as $url => $img){                          //loop through input data and scraped data to compare
      echo "<h2>Page ".($count+1)." <a href='$url' target='_blank'>". $url ."</a></h2>";
      echo "<hr>";
      foreach($img as $src => $meta ){
        $url_ = preg_replace('/\s/','',$url);
        $src_ = preg_replace('/\s/','',$src);
        echo "<h2><a href='".$meta['src']."' target='_blank'>".$meta['src']."</a></h2>";
        if(!strstr($comp[$url_][$src_]['alt'], "Image Not On Page") ){
          echo "<div class='row'>";
          echo "<img class='img-responsive col-xs-10 col-xs-offset-1 col-md-2 col-md-offset-0' src='$src'>";
          $message_alt   = ( $comp[$url_][$src_]['alt'] ? "text-success" :  "text-danger" );
          $message_title = ( $comp[$url_][$src_]['title'] ? "text-success" :  "text-danger" );
          echo "<div class='col-xs-10 col-xs-offset-1 col-md-10 col-md-offset-0'>";
          echo "<div class='row'>";
          
          try{
            echo "<div class='row'><h3 class='col-md-2'>Alt: </h3><h3 class='col-md-10 $message_alt'>".$meta['alt']."</h3></div>";
          } catch(Exception $e)
          { echo 'error';}
          try{
            echo "<div class='row'><h3 class='col-md-2'>Live Alt: </h3><h3 class='col-md-10 $message_alt'>".$live[$url_][$src_]['alt']."</h3></div>";
          } catch(Exception $e)
          { echo 'error';}
          try{
            echo "<div class='row'><h3 class='col-md-2'>Title: </h3><h3 class='col-md-10 $message_title'>".$meta['title']."</h3></div>";
          } catch(Exception $e)
          { echo 'error';}
          try{
            echo "<div class='row'><h3 class='col-md-2'>Live Title: </h3><h3 class='col-md-10 $message_title'>".$live[$url_][$src_]['title']."</h3></div>";
          } catch(Exception $e)
          { echo 'error';}
          echo "</div></div></div>";
          ?>
          <div class='row'>
          </div>
        <?php

        }
        else{ ?>
          <div class="row">
            <img class='img-responsive col-xs-10 col-xs-offset-1 col-md-2 col-md-offset-0' src='<?php echo $src; ?>'>
            <h1 class="col-xs-10 col-xs-offset-1 col-md-10 col-md-offset-0">Image Not Found On Page</h1>
          </div>
        <?php
        }
      }// end of inner foreach
      echo "<hr>";
      $count += 1;
    }
  }
  
}



?>