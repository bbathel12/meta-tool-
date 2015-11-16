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
    <link rel="stylesheet" href="/meta-tool/css/style.css">
  </head>
<body class="container-fluid"></body>
<?php
ini_set('display_errors',1);
include_once('functions.php');
?>
<div class="<?php if(isset($_POST['input']) && !isset($_POST['back_button'])) { echo "hidden"; }//if the form has been filled out?>">
<div class="row ">
<h1 class="text-center text-primary col-xs-10 col-xs-offset-1">Meta Checker 2.0 (Beta)</h1>
<h1 class="text-center text-warning col-xs-10 col-xs-offset-1" >Enter a list of urls, h1, titles, and descriptions.</h1>
</div>
  <div class="row">
    <form method="post" class=" well col-xs-10 col-xs-offset-1 col-md-6 col-md-offset-3" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div class="row">
          <label class="text-center col-xs-10 col-xs-offset-1" for="input"> Input</label>
        </div>
        <div class="row ">
          <label class="col-xs-12 col-xs-offset-0 col-md-6 col-md-offset-3">Meta Checker</label><input class="col-xs-6 col-xs-offset-3 col-md-1 col-md-offset-0" type=radio name=choice value=meta checked=true>
        </div>
        <div class="row">
          <label class="col-xs-12 col-xs-offset-0 col-md-6 col-md-offset-3">Image Optimizations Checker</label><input class="col-xs-6 col-xs-offset-3 col-md-1 col-md-offset-0" type=radio name=choice value=images >
        </div>
        <div class="row">
          <textarea class="col-xs-10 col-xs-offset-1 col-md-8 col-md-offset-2" name="input"><?php if(isset($_POST['input'])) { echo $_POST['input']; }?></textarea>
        </div>
        <div class="row">
          <input class="btn-primary col-xs-10 col-xs-offset-1 col-md-2 col-md-offset-5" type="submit">
        </div>
    
  </div>
</div>
<?php if(isset($_POST['input']) && !isset($_POST['back_button'])){ ?>
  <div class="row text-center fixed top-buttons" style="margin-bottom:5%" >
  <input type="submit" class="btn btn-primary  btn-large resubmit"  name="back_button" value="Back"><br>
  <!--<button class="btn btn-primary" onclick="location.reload()">Test Again</button>-->
  <input type="submit" class="btn btn-primary  btn-large resubmit" value='Re-Test'>
  </div>
  
  
  <div class="row"><div class="col-xs-12 col-md-10 col-md-offset-1 col-xs-offset-0">
  <?php
  
  
  // instantiates input_parser or img_input_parser depending on the radio button
  $input_parser = ($_POST['choice'] == 'meta' ) ? new input_parser($_POST['input']) : new img_input_parser($_POST['input']);              
  $input_parser->parse();                                         // parses all the lines of text and saves usefull info in a multidimensional array
  //$input_parser->test();
  
  // creates a new info_getter or img_info_getter depending on the radio button with the urls from input. Then, gets all the info from the urls.
  $info_getter = ($_POST['choice'] == 'meta' ) ? new info_getter($input_parser->get_urls()) : new img_info_getter($input_parser->get_urls(),$input_parser->get_pages());                 
  $info_getter->run();                                            // runs info getter
  $input_info = $input_parser->get_pages();                       // gets all the info including urls from the input_parser for the info_comparer
  $live_info = $info_getter->get_info();                          // returns all live info for the comparer to use
  //$info_getter->test();
  
  // creates a new comparer with all the info depending on radio buttons
  $info_comparer = ($_POST['choice'] == 'meta' ) ? new info_comparer($input_info, $live_info) : new img_info_comparer($input_info, $live_info);    
  $info_comparer->compare();                                      // compares all the things
  $comparison = $info_comparer->get_comparison();                 // returns an array with all the comparisons
  //$info_comparer->test();
  
  // instantiates output_info with all info gathered this far, depending on the radio buttons
  $outputer = ($_POST['choice'] == 'meta' ) ? new output_info($input_info,$live_info,$comparison) : new img_output_info($input_info,$live_info,$comparison);
  $outputer->output();                                            // outputs all the information that was gathered from input, live pages, and comparison.*/
  
  ?>
 </div></div>
  
  <div class="row text-center" style="margin-bottom:5%" >
  <input type="submit" class="btn btn-primary  btn-large resubmit"  name="back_button" value="Back to Form">
  
  <!--<button class="btn btn-primary" onclick="location.reload()">Test Again</button>-->
  <input type="submit" class="btn btn-primary  btn-large resubmit" value='Test Again'>
  </div>
 
  <?php
  
}
?>
  </form>
  <div class="row text-center <?php if(!isset($_POST['input']) || isset($_POST['back_button'])) { echo "hidden"; }//if the form has been filled out?>">
    <textarea rows="10" class="notes col-xs-8 col-xs-offset-2 hidden" id="all_notes"></textarea>
    <button style="margin-bottom:5%" class="resubmit  btn btn-primary" id="all_notes_button">Get All the Notes!</button>
  </div>
</div>
<script src="js/get_notes.js"></script>
</body>
</html>


