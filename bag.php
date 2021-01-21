<?php
ob_start();
session_start();
$pageTitle = "tags";

    include "init.php";


    //$tagName = isset($_GET['tagName']) ? $_GET['tagName'] : 0;

    if(isset($_GET['tagName'])){


        $tagName = $_GET['tagName'];





    }


    //////////////////////////////////////////////est3lam/////////////////////////////////////////

    echo "<div class='container'>";
    echo "<h2 class='our-h text-center'>" . $tagName . "</h2>";
    echo "<div class='tagContainer'>";
    echo "<div class='row d-flex justify-content-center'>"; 

    $tags = getAll("*" , "items" , "WHERE tag like '%$tagName%' " , "" , "item_id");

    

          foreach($tags as $tag){


            echo "
       
            <div class='col-lg-3 col-md-4 col-sm-6 item-box ads'> 
            <span class='price'>". $tag['price'] . " $" ."</span>
            <div class='thumbnail adSquare'>
            <div class='upper text-center'>
         
            <img 
            style='object-fit:cover;'
            class='img-responsive text-center' src='layout/images/img3.png'/>
            <span class='adDate'>". 
            $tag['add_date'] ."</span>
            </div>
            <div class='caption'>
           <a  href='showAd.php?itemId=". $tag['item_id'] ."'> <h4>". $tag['name'] ."</h4> </a>
          
         
            </div>
            </div>
           </div>

           
            ";
     


          }//foreach($items as $item

          echo "</div>";
          echo "</div>";
          echo "</div>";

    //////////////////////////////////////////////est3lam/////////////////////////////////////////



    include $tpl . "footer.php";


ob_end_flush();
?>
