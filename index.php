
<?php


session_start();
$pageTitle="HomePage";

include 'init.php';




/*
$option1 = "WHERE approve = 1";

$alls = getAll('*' , 'items' , $option1 , "" , 'item_id');
*/

/*$alls = allUnits('items' , 'item_id' , $option1);*/

?>


<div class='face'>
<span class='flowers2'>Flowers

<br>
<p style='font-size:2vw;'>The <span style='font-weight:bold;'>BEST</span> online market</p>
<p style='font-size:4vw;'>The entertainment of <b>shopping</b></p>

</span>

</div>

<!-------------------------------------------------------------------------->



<div class='container'>
    <div class='one' >
    <div style='width:100%; position:relative;'  class="container mt-3">


    <br>
<h2>Carousel</h2>

<div id="myCarousel" style='width:100%; height:auto; position:relative; margin-bottom:400px;'  class="carousel slide" data-ride="carousel" >

  <!-- Indicators -->
  <ul class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#myCarousel" data-slide-to="1"></li>
    <li data-target="#myCarousel" data-slide-to="2"></li>
  </ul>
  
  <!-- The slideshow -->
  <div class="carousel-inner">
    <div class="carousel-item active">
     <img src="admin\layout\css\bgPhotos\pocket-2324242_1280.jpg" alt="Los Angeles" width="1100" height="500">
    </div>
    <div class="carousel-item">
      <img src="admin\layout\css\bgPhotos\clothes-3821869_640.jpg" alt="Chicago" width="1100" height="500">
    </div>
    <div class="carousel-item">
      <img  src="admin\layout\css\bgPhotos\clothes-1834650_1280.jpg" alt="New York" width="1100" height="500">

    </div>
  </div> <!-- ////////////// end of carousel-inner -->
  
  <!-- Left and right controls -->
  <a class="carousel-control-prev" href="#myCarousel" data-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </a>
  <a class="carousel-control-next" href="#myCarousel" data-slide="next">
    <span class="carousel-control-next-icon"></span>
  </a>
</div> 



</div> <!--///////// container  -->


    </div>
</div>

<!-------------------------------------------------------------------------->
<div class='container'> 

      <div class='categories'>
            <h2 class='our-h text-center' style='margin-top:0px !important; margin-bottom:0px;'>All Items</h2> <br>

        <div id='items' class='row'>



            <?php
            $stmtOne = $con->prepare("SELECT item_id FROM items");
            $stmtOne->execute();
            $row = $stmtOne->fetchAll();
            $counts = count($row);
            $counts = $counts/2;
            $pagesNums = ceil($counts);




            if(isset($_GET['pageNumber']) && is_numeric($_GET['pageNumber'])){

              $page = intval($_GET['pageNumber']);

              if($page ==0 || $page==""){

                $page1 = 0;
              }else{
              
                $page1 = (($page-1) * 2);
              }
              

            }else{

              $page1 = 0;
            }




            $stmt10 = $con->prepare("SELECT * FROM items WHERE approve = 1 ORDER BY item_id LIMIT $page1,2");
            $stmt10->execute();
            $alls = $stmt10->fetchAll();


            foreach ($alls as $all){

            /*echo "<span>". $all['name'] ."</span> <br>";*/
            echo "
                  
              <div class='col-lg-6 col-md-6 col-sm-1 item-box ads'> 
                  <span class='price'>". $all['price'] . " $" ."</span>
                      <div class='thumbnail adSquare'>
                          <div class='upper text-center'>

                              <img style='object-fit:cover;' class='img-responsive text-center' src='admin\uploads\photos\\" . $all['itemPhoto'] . "'/>
                              <span class='adDate'>". $all['add_date'] ."</span>
                          </div> <!-- upper -->


                          <div class='caption'>
                              <a  href='showAd.php?itemId=". $all['item_id'] ."'> <h4>". $all['name'] ."</h4> </a>


                          </div> <!-- caption-->
                      </div><!--thumbnail adSquare-->
              </div><!--col-lg-6 col-md-6 col-sm-1 item-box ads-->

        ";


        }
        echo "</div><!--row-->
        ";

        ///////////////////////////////////////////pagination part///////////////////////////////////////////////////////
        ?>
        <div class='row justify-content-center'>
            <div class="center">
                  <div class="pagination">

                <?php


                        ?>
                        <br>
                        <a href="?pageNumber=<?php if($page >= 2 ) {echo $page - 1;}else{echo 1;} ?>#items">&laquo;</a><!-- button of (( before page ))-->
                        <?php
                        for($page=1; $page<=$pagesNums; $page++){
                        ?>
                          <a href="index.php?pageNumber=<?php echo $page; ?>#items"><?php  echo $page; ?></a>
                        <?php
                        }//end of for
                        ?>
                          <a href="index.php?pageNumber=<?php if($page <= $pagesNums) {echo $page+1;}else{echo $pagesNums;} ?>#items">&raquo;</a>  <!-- button of (( next page ))-->

                  </div><!--pagination  -->
            </div><!-- center  -->
        </div> <!-- row -->

        <?php
        echo "
  </div><!-- categories -->
</div><!-- container -->";

include $tpl . 'footer.php';



?>


