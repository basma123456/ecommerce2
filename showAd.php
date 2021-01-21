<?php   
ob_start();
session_start();
$pageTitle = 'Ads';

include "init.php";


$itemId = isset($_GET['itemId']) && is_numeric($_GET['itemId'])? intval($_GET['itemId']) : 0;



/////////////////////////////////est3lam///////////////////////////////////////////////////

$stmt = $con->prepare("SELECT

                        items.*,
                        users.user_name,
                        categories.name AS cat_name
                        FROM 
                        items
                        INNER JOIN
                        users
                        ON
                        users.user_id = items.member_id
                        INNER JOIN
                        categories
                        ON
                        categories.id = items.cat_id
                        WHERE
                        item_id=?
                       
                        
                        ");
$stmt->execute(array($itemId));
$count = $stmt->rowCount();
if($count > 0){
$ads = $stmt->fetchAll();

/////////////////////////////////est3lam///////////////////////////////////////////////////


foreach($ads as $ad){
?>
<div class='container adInfoContainer'>
<h2 class='text-center our-h'><?php echo $ad['name'];  ?></h2>
    <div class='row'>
       
        <div class='col-lg-5 col-sm-12 col-md-9'>
            <div class='text-center' style='margin-top:20px;'>


            <?php 
            
            /////////////////////////////////////////////////////////////////////////
            if(isset($ad['itemPhoto']) && !empty($ad['itemPhoto'])){ ?>
            <a target="_blank" href="<?php echo 'admin\uploads\photos\\' . $ad['itemPhoto']; ?>" >
            <img class="showPhoto"
            style='object-fit:cover;'
             src="<?php echo 'admin\uploads\photos\\' . $ad['itemPhoto'];  ?>" alt="Forest" />
            </a> 
            <?php 
          
          }else{ ?>



              <a target="_blank" href="layout/images/img3.png" >
            <img 
            style='object-fit:cover;'
             src='layout/images/img3.png' alt="Forest" />
            </a> 
              
            <?php 
             /////////////////////////////////////////////////////////////////////////////
             } ?>


            <p><b><?php echo $ad['name']; ?></b></p>
            </div>
        </div>
        <div class='col-lg-7 col-sm-12 col-md-12'>
            <div class='panel' style='margin-top:20px;'>
                <div class='panel-head'>
                                    <h2 class='text-center'>
                                    Item Information                        
                                    </h2>
  
                </div>

                <div class='panel-body adInfo'>
                    <ul>

                  <li> <h4><span><b>Price  </b></span> : <?php echo $ad['price'];  ?> $</h4></li>
                 <li>  <h4><span><b>Date  </b></span> : <?php echo $ad['add_date'];  ?></h4> </li>
                <li>   <h4><span><b>Country  </b></span> : <?php echo $ad['country_made'];  ?></h4> </li>


                   <?php 
                   //the trick of status
                   $arr = array("New","Light Used","Used","Hard Used");
                   ?>
                    
                   <li> <h4><span><b>Status  </b></span> :<?php  echo $arr[$ad['status']-1];  ?></h4> </li>
                   <li> <h4><span><b>Member  </b></span> : <?php echo $ad['user_name'];  ?></h4> </li>
                 <li>   <h4><span><b>Category  </b></span> : <?php echo $ad['cat_name'];  ?></h4> </li>
<!-- ///////////////////////////////////////////////////////////////////////////////////////-->

                  <li>  <h4><span><b>Rate  </b></span> :  <i class="<?php if($ad['rating'] > 0){echo 'green';} ?> fas fa-star"></i>
                
                  <i class="<?php if($ad['rating'] > 1){echo 'green';} ?> fas fa-star"></i>
                  <i class="<?php if($ad['rating'] > 2){echo 'green';} ?> fas fa-star"></i>
                  <i class="<?php if($ad['rating'] > 3){echo 'green';} ?> fas fa-star"></i>
                  <i class="<?php if($ad['rating'] > 4){echo 'green';} ?> fas fa-star"></i>


                
                
                </h4> </li>

<!-- ///////////////////////////////////////////////////////////////////////////////////////-->

                <li>   <h4><span><b>Tags  </b></span> : <?php $tags = explode("," , $ad['tag']);
                                foreach($tags as $tag){
                                        echo "<b> <a class='tag' href='bag.php?tagName=". $tag ."'>" . $tag . "</a> </b>" . " &nbsp; ";

                                }
                                                            
                                                        
                                                        
                                ?></h4> </li>

<!-- ///////////////////////////////////////////////////////////////////////////////////////-->



                  <li>  <h4><span><b>Description  </b> </span> : <span style='font-size:17px;'> <?php echo $ad['describtion']; ?></span></h4> </li>
                    </ul>
                </div>
            </div>
        </div>



        






    </div>

    <?php  if(isset($_SESSION['anyUser'])){ ?>
    <hr class='our-hr'>

                <form action="<?php echo $_SERVER ['PHP_SELF'] ?>?itemId=<?php echo $itemId;  ?>" method='POST'>
                    <div class='offset-lg-5 col-lg-7 col-sm-12 offset-md-1 col-md-10 '>
                
                            <textarea class='showAd-comment form-control' name='comment' placeholder="please type here your comment"></textarea>
                            <input type='submit' class='btn btn-primary btn-sm' value='Insert comment' name='submit' />

                    </div>

                </form>


          <?php  if($_SERVER['REQUEST_METHOD']=='POST'){

              $stmt2 = $con->prepare("INSERT INTO comments(comment, status, comment_date,item_id ,member_id)
              VALUES(:zcomment, 0, now(), :zitem_id, :zmember_id)
              ");

              $stmt2->execute(array(






                'zcomment' => $_POST['comment'],
                'zitem_id' => $itemId,
                'zmember_id' => $_SESSION['user_id'] 
              ));

              $count2 = $stmt2->rowCount();


              if($count2 > 0){

                echo "<div class='container mt-2'><div class='alert alert-info'>You have inserted new comment but, please wait for approval to be showed</div></div>";

              } //$count2 > 0

          }// if($_SERVER['REQUEST_METHOD']=='POST')  ?>




    <hr class='our-hr'> <!-- second hr that above the user and user comments  --> 

                <?php 

                /////////////////////////////////est3lam///////////////////////////////////////////////////////
                $itemId = isset($_GET['itemId']) && is_numeric($_GET['itemId'])? intval($_GET['itemId']) : 0;

                $stmt3 = $con->prepare("SELECT comments.*, users.user_name
                                        FROM
                                        comments
                                        INNER JOIN
                                        users
                                        ON
                                        users.user_id = comments.member_id
                                        WHERE
                                        comments.status=1
                                        AND
                                        item_id=?
                                        ORDER BY
                                        c_id
                                        DESC
                                        ");


                $stmt3->execute(array($itemId));
                $coms = $stmt3->fetchAll();
                /////////////////////////////////est3lam///////////////////////////////////////////////////////

                ?>

      <div class='row'>
      <?php if(!empty($coms)){?>
        <table class='commentsTable mb-3' style='width:100%;'>
          <tr style='width:100%;'>
            <th>Username</th>
            <th>
              
            Comments</th>
            <th></th>
            
          </tr>
          <?php  foreach($coms as $com){  ?>
          <tr>
            <td><b><?php echo $com['user_name']; ?></b></td>
            <td style='width:70%;'><?php echo $com['comment'];  ?></td>
            <td style='width:15%; '><b><?php echo $com['comment_date']; ?></b></td>
          </tr>
          <?php  } ?>
        

        </table>
        <?php }else{echo "<div class='container text-center'><div class='alert alert-primary'>There is no comments founded</div></div>";}?> 
     
      </div>




    <?php  }else{echo "<div class='registerD'> Please <a class='registerA' href='login.php'>register or login</a> to put insert a comment </div>";}  ?>



</div>


<?php
}

}//if($count > 0)




include $tpl . "footer.php";
//mal7oza 
// where we use the query in sql the statement which is come after the word WHERE contains such as that example WHERE user_id = ?
// or like that example WHERE user_id = ? and item_id =? so concenctarte that it isnot user_id = ? , item_id =?
ob_end_flush();

?>