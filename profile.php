
<?php

ob_start();
session_start();
$pageTitle = 'profile';

if(isset($_SESSION['anyUser'])){


include 'init.php';

print_r($_SESSION);



$stmt = $con->prepare("SELECT * FROM users WHERE user_name=?");
$stmt->execute(array($_SESSION['anyUser']));
$infos = $stmt->fetch();

//////////////////////////////////////////////////////////////////////////////
$limit ='LIMIT 4';

if(isset($_GET['show'])&& $_GET['show']=='all'){
$limit = '';

}elseif(isset($_GET['show'])&& $_GET['show']=='less'){
$limit = 'LIMIT 4';

}
$adStmt = $con->prepare("SELECT items.* , users.user_name
                          FROM 
                          items
                          INNER JOIN
                          users
                          ON
                          users.user_id = items.member_id
                          WHERE user_name = ?
                         
                          ORDER BY
                          item_id
                          DESC
                         $limit
                           
                          ");

$adStmt->execute(array($_SESSION['anyUser']));

$ads = $adStmt->fetchAll();  //   notice that fetch dont work here   
//////////////////////////////////////////////////////////////////////////////////

$limitCom = 'LIMIT 4';

if(isset($_GET['com'])&& $_GET['com']=='all'){

    $limitCom = '';

}else{ $limitCom = 'LIMIT 4'; }


$comStmt = $con->prepare("SELECT comments.*, users.user_name, items.name AS item_name
                          FROM 
                          comments
                          INNER JOIN
                          users
                          ON
                          users.user_id = comments.member_id
                          INNER JOIN
                          items
                          ON
                          items.item_id = comments.item_id
                          WHERE
                          comments.status = 1
                          AND
                          user_name = ?
                           
                          ORDER BY
                          c_id
                          DESC
                          $limitCom;

                          ");
   
$comStmt->execute(array($_SESSION['anyUser'])); 

$coms=$comStmt->fetchAll();




///////////////////////////////////////////////////////////////////////////////////

echo "<div class='profile'>";

echo "<div class='container'>";

echo "<h2 class='text-center our-h'>Welcome In " .$_SESSION['anyUser'] . " Profile</h2>";
?>
<br>

<div class="panel info">
      <div class="panel-heading"> <?php echo $_SESSION['anyUser']; ?> Basic Informations</div><!-- panel-head -->
      <div class="panel-body">

        <ul>
        <li> Name : <?php echo $infos['user_name']; ?></li>
        <li> Fullname : <?php echo $infos['full_name']; ?></li>

        <li> Email : <?php echo $infos['email']; ?></li>
        <li> Starting Date : <?php echo $infos['date']; ?></li>

        </ul>
   
        <a href='information.php'>
        <span class='btn btn-primary btn-sm float-right span-info'>Edit Information</span>
        </a>

      </div> <!--  panel body  -->
    </div>
    <br><br>

<!-- /////////////////////////////////////////////////////////////////////////////////////////// -->

<div class="panel ads">
      <div class="panel-heading up">  <?php echo $_SESSION['anyUser']; ?> Latest Ads</div>
      <div class="panel-body down">


      <?php if(!empty($ads)){ ?>


      <div class='row d-flex justify-content-center'>

          <?php
          
          
          foreach($ads as $ad){
            if($ad['approve'] == 0){$approve1 = '<div class="wait">Wait for approval</div>'; }else{

              $approve1 = '';
            }

  

               echo "
               <div class='col-lg-3 col-md-6 col-sm-6 item-box ads'> 

               <span class='price'>". $ad['price'] . " $" ."</span>
              
               <div class='thumbnail adSquare specialThumb'>
               <div class='upper text-center'> 
               <img style='object-fit:cover;' class='img-responsive text-center profilePhoto'  src='admin\uploads\photos\\" . $ad['itemPhoto'] . "'/>
               
               </div>

             
               <div class='caption text-center'>
               <a  href='showAd.php?itemId=".$ad['item_id']."'><h4>".  $ad['name'] ."</h4></a>
              
          
               <div class='workBtns text-center'>
              
               <a href='editItem.php?itemId=". $ad['item_id'] ."'>
               <span class='btn btn-info btn-sm'>Edit</span>
               </a>
               <span class='btn btn-danger btn-sm'>Delete</span>
               
               </div>
               </div>
               </div>
               ".$approve1."
              </div>
              
               ";            

          }  ?>

          </div> <!-- end of row -->

                  
<div class='box'>
     <a href='?show=all' ><span id='showPro' class='btn btn-primary btn-sm pro <?php if(isset($_GET['show'])&& $_GET['show']=='all'){echo 'hide';} ?>'>Show all ads</span></a>
        <a href='?show=less'> <span id='lessPro' class='btn btn-primary btn-sm pro <?php if(isset($_GET['show']) && $_GET['show']=='less'){echo 'hide';}elseif(!isset($_GET['show'])){echo 'hide';} ?>'>Show less</span></a>
</div>   


<?php
}else{echo "<div><h6>there is no Ads here !!</h6></div>";}  
?>

<a href='addAd.php'><span class='addBtn btn btn-primary btn-sm'>Add New Ad</span></a>

      </div>
      
    </div>

    









<!-- /////////////////////////////////////////////////////////////////////////////////////////// -->

<br><br>

<div class="panel comments">
      <div class="panel-heading">  <?php echo $_SESSION['anyUser']; ?> Latest Comments</div>
      <div class="panel-body">

      <?php if(!empty($coms)){ ?>
          <ul>
<?php  
foreach($coms as $com){
?>
  
  <li class="lisAll">  <div class='com' style='float:right;'> <span><?php echo $com['comment_date'];  ?></span> <span>  <?php echo $com['item_name'];  ?> </span>  </div>  <p> <?php echo $com['comment']; ?> </p> </li>

<?php
}// the end of foreach

/////////////////////////////////////////////////////the trick of my self of the show more comments button and show less button
?>


<?php if(isset($_GET['com'])&& $_GET['com']== 'less') {?>

<a href='?com=all'><span class='btn btn-primary btn-sm showAll-less'>Show all comments</span> </a>

<?php  }elseif(isset($_GET['com'])&& $_GET['com']=='all'){  ?>
<a href='?com=less'><span class='btn btn-primary btn-sm showAll-less'>Show less</span></a>

<?php }else{ echo "<a href='?com=all'><span class='btn btn-primary btn-sm showAll-less'>Show all comments</span> </a>"; } // the end of elseif(isset($_GET['com'])&& $_GET['com']=='all')

/////////////////////////////////////////////////////the end trick of my self of the show more comments button and show less button

?>



</ul>

<?php  }else{


echo "<div><h6>There is no comments here !!</h6></div>";

}   ?>


<a href='addComment.php'><span class='addBtn btn btn-primary btn-sm'>Add New Comment</span></a>

      </div>
    </div>



</div> <!-- the end of the container  -->

</div> <!-- the end of the profile div  -->







<?php












//////////////////////////////////////////expirement////////////////////////////////////////////////////////////////

?>

<span class='button1'>button</span>

<div class='pic'>hhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh</div>





<?php
//////////////////////////////////////////////////////////////////////////////////////////////////////////









include $tpl . 'footer.php';

}else{

  header("Location: login.php");
  exit();
}



ob_end_flush();
?>