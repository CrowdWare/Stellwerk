<!DOCTYPE html>
<html>
<head>
  <title>Stellwerk</title>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="./slick/slick.css">
  <link rel="stylesheet" type="text/css" href="./slick/slick-theme.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
  <link rel="stylesheet" type="text/css" href="./assets/css/style.css">
</head>
 <body>
    <h1>Stellwerk</h1>
    
<?php
function endsWith( $haystack, $needle ) {
    $length = strlen( $needle );
    if( !$length ) {
        return true;
    }
    return substr( $haystack, -$length ) === $needle;
}

$path = "./Categories";
$entries = scandir($path);
$hiddenDialogs = "";
$dialogId = 1;
foreach($entries as $entry)
{
    if(is_dir($path."/".$entry) && $entry != "." && $entry != "..")
    {
        $catName = str_replace(' ', '_', $entry);
        echo '<h2 class="categorie">'.substr($entry, 4).'</h2>'.PHP_EOL;
        echo '<div class="slick-buttons">'.PHP_EOL;
        //echo '<a href="javascript:void(0)" class="button filter-btn'.$catName.' active" data-attribute="all">All Slides</a>'.PHP_EOL;

        $subcategories = $path."/".$entry;
        $subs = scandir($subcategories);
        foreach($subs as $sentry)
        {
          if(is_dir($subcategories."/".$sentry) && $sentry != "." && $sentry != "..")
          {
            echo '<a href="javascript:void(0)" class="button filter-btn'.$catName.'" data-attribute="'.$sentry.'">'.$sentry.'</a>'.PHP_EOL;
          }
        }
        echo '</div>'.PHP_EOL;
        echo '<section class="'.$catName.' slider">'.PHP_EOL;
        foreach($subs as $sentry)
        {
            if(is_dir($subcategories."/".$sentry) && $sentry != "." && $sentry != "..")
            {
                
                $filespath = $path."/".$entry."/".$sentry;
                $files = scandir($filespath);
                foreach($files as $file)
                {
                    if(!is_dir($filespath."/".$file) && endsWith($file, ".ini"))
                    {
                        $description = parse_ini_file($filespath."/".$file);
                        $type = $description["type"];
                        if($type == "image")
                        {
                          $image = $description["image"];
                          $thumbnail = $description["thumbnail"];
                          $width = $description["width"];
                          $height = $description["height"];
                          $headline = $description["headline"];
                          
                          echo '<div class="'.$sentry.'">'.PHP_EOL;
                          echo '<h4>'.$headline.'</h4>'.PHP_EOL;
                          echo '<a class="d-block mb-4" data-fancybox="images" href="'.$image.'" data-width="'.$width.'" data-height="'.$height.'">'.PHP_EOL;
                          echo '<img class="img-fluid" src="'.$thumbnail.'">'.PHP_EOL;
                          echo '</a>'.PHP_EOL;
                          echo '</div>'.PHP_EOL;  
                      }
                      elseif($type == "video")
                      {
                          $video = $description["video"];
                          $thumbnail = $description["thumbnail"];
                          $width = $description["width"];
                          $height = $description["height"];
                          $headline = $description["headline"];
                          
                          echo '<div class="'.$sentry.'">'.PHP_EOL;
                          echo '<h4>'.$headline.'</h4>'.PHP_EOL;
                          echo '<a class="d-block mb-4" data-fancybox data-ratio="2" href="'.$video.'" data-width="'.$width.'" data-height="'.$height.'">'.PHP_EOL;
                          echo '<img class="img-fluid" src="'.$thumbnail.'">'.PHP_EOL;
                          echo '</a>'.PHP_EOL;
                          echo '</div>'.PHP_EOL;  
                      }
                      elseif($type == "html")
                      {
                        $preview = $description["preview"];
                        $html = $description["html"];
                        
                        echo '<div class="'.$sentry.'">'.PHP_EOL;
                        echo '  <div class="card-body">'.PHP_EOL;
                        echo '    <p class="card-text">'.PHP_EOL;
                        echo $preview.PHP_EOL;
                        echo '    </p>'.PHP_EOL;
                        echo '    <p class="mb-0">'.PHP_EOL;
                        echo '      <a data-fancybox data-src="#trueModal" data-modal="true" href="javascript:;" class="btn btn-primary">Open demo</a>'.PHP_EOL;
                        echo '    </p>'.PHP_EOL;
                        echo '  </div>'.PHP_EOL;
                        echo '</div>'.PHP_EOL;
                        $hiddenDialogs = $hiddenDialogs.'<div id="trueModal" class="p-5" style="display: none;max-width:600px;">'.PHP_EOL;
                        $hiddenDialogs = $hiddenDialogs.$html.PHP_EOL;
                        $hiddenDialogs = $hiddenDialogs.'</div>'.PHP_EOL;
                        $dialogId += 1;
                      }
                    }
                }
                
            }
        }
        echo '</section>'.PHP_EOL;
    }
}
// to be rendered outside of the slides section
echo $hiddenDialogs.PHP_EOL;
?>
    
<script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
<script src="./slick/slick.js" type="text/javascript" charset="utf-8"></script>
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>

<script type="text/javascript">
$(document).on('ready', function() 
{  
<?php
foreach($entries as $entry)
{
  $catName = str_replace(' ', '_', $entry);
  if(is_dir($path."/".$entry) && $entry != "." && $entry != "..")
  {
    echo '  $(".'.$catName.'").slick({'.PHP_EOL;
    echo '    dots: true,'.PHP_EOL;
    echo '    centerMode: true,'.PHP_EOL;
    echo "    centerPadding: '30px',".PHP_EOL;
    echo '    slidesToShow: 3,'.PHP_EOL;
    echo '    infinite: true,'.PHP_EOL;
    echo '    slidesToScroll: 1,'.PHP_EOL;
    echo '    arrows: false,'.PHP_EOL;
    echo '    focusOnSelect: false,'.PHP_EOL;
    echo '    responsive: '.PHP_EOL;
    echo '    ['.PHP_EOL;
    echo '      {'.PHP_EOL;
    echo '        breakpoint:769,'.PHP_EOL;
    echo '        settings: {slidesToShow:1}'.PHP_EOL;
    echo '      },'.PHP_EOL;
    echo '      {'.PHP_EOL;
    echo '        breakpoint:993,'.PHP_EOL;
    echo '        settings: {slidesToShow:1}'.PHP_EOL;
    echo '      },'.PHP_EOL;
    echo '      {'.PHP_EOL;
    echo '        breakpoint:1000,'.PHP_EOL;
    echo '        settings: {slidesToShow:3}'.PHP_EOL;
    echo '      },'.PHP_EOL;
    echo '    ]'.PHP_EOL;
    echo '  });'.PHP_EOL;
    echo ''.PHP_EOL;

    echo '  $(".filter-btn'.$catName.'").on("click",function()'.PHP_EOL;
    echo '  {'.PHP_EOL;
    echo '    $(".filter-btn'.$catName.'").removeClass("active");'.PHP_EOL;
    echo '    var filter'.$catName.' = $(this).data("attribute");'.PHP_EOL;
    echo '    if(filter'.$catName.' == "all")'.PHP_EOL;
    echo '    {'.PHP_EOL;
    echo '      $(".'.$catName.'").slick("slickUnfilter");'.PHP_EOL;
    echo '    }'.PHP_EOL;
    echo '    else'.PHP_EOL;
    echo '    {'.PHP_EOL;
    echo '      $(".'.$catName.'").slick("slickUnfilter");'.PHP_EOL;
    echo '      $(".'.$catName.'").slick("slickFilter", function( index )'.PHP_EOL; 
    echo '      {'.PHP_EOL;
    echo '        return $("." + filter'.$catName.', this).length === 1;'.PHP_EOL;
    echo '      });'.PHP_EOL;
    echo '    }'.PHP_EOL;
    echo '    $(this).addClass("active");'.PHP_EOL;
    echo '  });'.PHP_EOL;
    echo ''.PHP_EOL;
  }
}
?>
});

</script>
 </body>
</html>
