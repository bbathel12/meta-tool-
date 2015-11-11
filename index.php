<html>
  <head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    
    
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
    
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css" integrity="sha384-aUGj/X2zp5rLCbBxumKTCw2Z50WgIr1vs/PFN4praOTvYXWlVyh2UtNUU0KAUhAX" crossorigin="anonymous">
    
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/meta-tool/style.css">
  </head>
<body class="container-fluid">
<?php
//ini_set('display_errors',1);
include_once('functions.php');
?>

<?php if(!isset($_POST['input'])) { //if the form has been filled out?>
<div class="row">
<h1 class="text-center text-warning col-xs-10 col-xs-offset-1" >Enter a list of urls, h1, titles, and descriptions.</h1>
</div>
  <div class="row">
    <form method="post" class=" well col-xs-10 col-xs-offset-1 col-md-6 col-md-offset-3" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div class="row">
          <label class="text-center col-xs-10 col-xs-offset-1" for="input"> Input</label>
        </div>
        <div class="row">
          <textarea class="col-xs-10 col-xs-offset-1 col-md-8 col-md-offset-2" name="input"></textarea>
        </div>
        <div class="row">
          <input class="btn-primary col-xs-10 col-xs-offset-1 col-md-2 col-md-offset-5" type="submit">
        </div>
    </form>
  </div>
<?php

}
else{
  echo '<div class="row"><div class="col-xs-12 col-md-10 col-md-offset-1 col-xs-offset-0">';
  $input_parser = new input_parser($_POST['input']);              // instantiates input_parser
  $input_parser->parse();                                         // parses all the lines of text and saves usefull info in a multidimensional array
  $urls = $input_parser->get_urls();                              // input parser returnse the urls for info_getter
  $info_getter = new info_getter($urls);                          // creates a new info_getter with the urls from input. Then, gets all the info from the urls.
  $info_getter->run();                                            // runs info getter
  $input_info = $input_parser->get_pages();                       // gets all the info including urls from the input_parser for the info_comparer
  $live_info = $info_getter->get_info();                          // returns all live info for the comparer to use
  $info_comparer = new info_comparer($input_info, $live_info);    // creates a new comparer with all the info
  $info_comparer->compare();                                      // compares all the things
  $comparison = $info_comparer->get_comparison();                 // returns an array with all the comparisons
  $outputer = new output_info($input_info,$live_info,$comparison);// instantiates output_info with all info gathered this far.
  $outputer->output();                                            // outputs all the information that was gathered from input, live pages, and comparison.
  echo '</div></div>';
  ?>
  <div class="row text-center" style="margin-bottom:5%" >
  <button class="btn btn-primary  btn-large" onclick="window.history.back();">Back To Form</button>
  <button class="btn btn-primary" onclick="location.reload()">Test Again</button>
  </div>
  <?php
}
?>
  
  
</div>
</body>
</html>


