<?php 

require_once ('config.php');

if(isset($_GET['search'])){     $search=$_GET['search'];    } else { $search = "";}
if(isset($_GET['cat'])){        $cat=$_GET['cat'];          } else { $cat = "";}
if(isset($_GET['page'])){       $page=$_GET['page'];        } else { $page = 1;}



function create_ebay_api_call ($query="test", $ebay_site="EBAY-IE", $country="IE",$cat="",$page=1,$count=20,$min=0,$max=100000) {
    
$apicall = "http://svcs.ebay.com/services/search/FindingService/v1?OPERATION-NAME=findItemsAdvanced"
         . "&SERVICE-VERSION=1.0.0";        
if ($ebay_site == "") {     
//$apicall .= "&GLOBAL-ID=EBAY-US"; 
} else {
$apicall .= "&GLOBAL-ID=$ebay_site"; 
}        
$apicall .= "&SECURITY-APPNAME=".APP_ID
         . "&keywords=".urlencode (utf8_encode($query))
         . "&paginationInput.entriesPerPage=$count";
         
if ($page != "") {
$apicall .= "&paginationInput.pageNumber=$page";
}

$apicall .="&sortOrder=BestMcreaatch"
         . "&itemFilter(0).name=ListingType"
         . "&itemFilter(0).value=FixedPrice"
         . "&itemFilter(1).name=MinPrice"
         . "&itemFilter(1).value=$min"
         . "&itemFilter(2).name=MaxPrice"
         . "&itemFilter(2).value=$max";
         
if ($country != "") {
    $apicall .=
           "&itemFilter(3).name=LocatedIn"
         . "&itemFilter(3).value=$country";
}
         
$apicall .=          
           "&affiliate.networkId=".AFFILIATE_NETWORK_ID 
         . "&affiliate.trackingId=" . AFFILIATE_TRACKING_ID 
         . "&affiliate.customId=456"
         . "&RESPONSE-DATA-FORMAT=XML";
if ($cat != "") {
        $apicall .=
            "&categoryId=$cat"; }
         
         return $apicall;
    
    
}



function options($categories,$cat) {

$html="";

foreach ($categories as $category) {

$html .= '<option ';
if (isset($cat)) {if ($category[1] == $categories[array_search($cat,array_column($categories, 1))][1]) {$html .= ' selected ';}}
$html .= 'value="'.$category[1].'"">'.ucfirst($category[0]).'</option>';


} 

return $html;



}


function results($search, $simplexml) {




if (isset($simplexml->searchResult->item)) {

foreach ($simplexml->searchResult->item as $i){

    echo "<div style='border:1px solid black; padding:20px; margin:20px;'>";

    echo "<a href='".$i->viewItemURL."' target='_blank'>".$i->title."</a><br>";
    //echo $i->location."<br>";
    //echo $i->globalId."<br>";
    //echo $i->primaryCategory->categoryName."<br>";
    echo $i->sellingStatus->sellingState."<br>";
    echo "USD ".$i->sellingStatus->convertedCurrentPrice."<br>";
    echo "<a href='".$i->viewItemURL."' target='_blank'>"."<img src='".$i->galleryURL."' target='_blank'></a></div>";
}

}

else { echo "<br><br>Sorry, no results found";}


}



function nav ($search, $page, $cat, $simplexml) {

    $page_add = $page+1;
    $page_minus = $page-1;



     $string =
    ' <nav aria-label="..."><ul class="pager"><li ';

    if ($page == 1) { $string .= 'class="disabled" ';}

    $string .= '><a href=" '.
    '?search=' . $search . '&page=' . $page_minus . '&cat=' . $cat .
    '">Previous</a></li><li ';

    if ($simplexml->paginationOutput->pageNumber-1 == $simplexml->paginationOutput->totalPages-1 ) { $string .= 'class="disabled" ';}


    $string .= '><a href="'.
    '?search=' . $search . '&page=' . $page_add . '&cat=' . $cat .
    '">Next</a></li></ul></nav>';

    return $string;


}


$call = create_ebay_api_call($search,"","",$cat,$page);
$simplexml = simplexml_load_file($call);


$categories = Array(
Array ('all categories',""),
Array ('cars',9801),
Array ('commercial',9800),
Array ('motorbikes',422),
Array ('parts',6030),
Array ('appliances',20710),
Array ('beauty',26395),
Array ('books + dvds',11232),
Array ('clothing + jewelry',11450),
Array ('visual + audio',293),
Array ('furniture',3197),
Array ('gamers',1249),
Array ('home living',11700),
Array ('kids + baby',171146),
Array ('mob. phones',9355),
Array ('musical instru.',619),
Array ('office',25298),
Array ('other',172008),
Array ('pets',1281),
Array ('power tools',631),
Array ('rare items',20081),
Array ('sports + fitness',888),
);
