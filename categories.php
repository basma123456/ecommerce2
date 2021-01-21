<?php

session_start();

include 'init.php';




echo "<h2 class='text-center our-h'>". $_GET['pageName'] ."</h2><br>";
/*
$approve1 = "AND approve = 1";
$items = getItem($_GET['pageId'], $approve1);
*/


/*background-image:url("admin\uploads\photos\girl-828607__340.jpg");*/

$items = getAll("*", "items" ,"WHERE cat_id = {$_GET['pageId']}" , "AND approve = 1" , "item_id");   
 ?>
 <div class="container categories" style='height:1000px; width:1000px;'>
 <div class='row d-flex justify-content-center'>
   <?php




if(!empty($items)){
foreach ($items as $item){

       

       echo "
       
       <div class='col-lg-6 col-md-6 col-sm-12 item-box ads'> 
       <span class='price'>". $item['price'] . " $" ."</span>
       <div class='thumbnail adSquare'>
       <div class='upper text-center'>
    
       <img style='object-fit:cover;'  class='img-responsive text-center photo' src='admin/uploads/photos/". $item['itemPhoto'] ."'/>
       <span class='adDate'>". $item['add_date'] ."</span>
       </div>
       <div class='caption'>
      <a  href='showAd.php?itemId=". $item['item_id'] ."'> <h4>". $item['name'] ."</h4> </a>
     
    
       </div>
       </div>
      </div>";
}//foreach ($items as $item){
       




       }else{                                                   // if(!empty($items))
       


                     $categories = getAll("*" , "categories" , "WHERE parent = {$_GET['pageId']}" , "" , "id" );

                     foreach($categories as $category){

                     $children = getAll("*", "items" ,"WHERE cat_id={$category['id']}" , " AND approve = 1" , "item_id"); 
                     foreach($children as $child){


              echo "
       
       <div class='col-lg-6 col-md-6 col-sm-12 item-box ads'> 
       <span class='price'>". $child['price'] . " $" ."</span>
       <div class='thumbnail adSquare'>
       <div class='upper text-center'>
    
       <img style='object-fit:cover;'  class='img-responsive text-center photo' src='admin/uploads/photos/". $child['itemPhoto'] ."'/>
       <span class='adDate'>". $child['add_date'] ."</span>
       </div>
       <div class='caption'>
      <a  href='showAd.php?itemId=". $child['item_id'] ."'> <h4>". $child['name'] ."</h4> </a>
     
    
       </div>
       </div>
      </div>"; 
                     }// foreach($children as $child
                     }//foreach($category as $category)
          


}//else of (!empty($items))
?>  </div> 
</div>

 <?php





include $tpl . 'footer.php';

?>