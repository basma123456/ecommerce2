<?php 
ob_start();
session_start();

$pageTitle = 'edit';

if(isset($_SESSION['anyUser'])){

    include "init.php";


        $itemId = isset($_GET['itemId']) && is_numeric($_GET['itemId']) ? intval($_GET['itemId']) :0;



$nameErr = $dateErr = $countryErr = $statusErr= $descErr = $imageErr = $categoryErr = "";


if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $name   = filter_var($_POST['itemName'] , FILTER_SANITIZE_STRING);
    $date       = $_POST['date'];
    $country    = filter_var($_POST['country'] , FILTER_SANITIZE_STRING);
    $status     = filter_var($_POST['status'] , FILTER_SANITIZE_NUMBER_INT);
    $category   = filter_var($_POST['category'] , FILTER_SANITIZE_NUMBER_INT);
    $desc       = filter_var($_POST['desc'] , FILTER_SANITIZE_STRING);
    $tag        = filter_var($_POST['tag'] , FILTER_SANITIZE_STRING);

    ///////////////////////////variables of photo///////////////////////////////////////////////
    $itemPhoto = $_FILES['photo'];                         
    
    $pName = $_FILES['photo']['name'];
    $pSize = $_FILES['photo']['size'];
    $pType = $_FILES['photo']['type'];
    $pTmp = $_FILES['photo']['tmp_name'];

    $allowedExtensions = array("jpeg" , "jpg" , "png" , "gif");

    $ext = explode("." , $pName);

    $myExt = strtolower(end($ext));

////////////////////////////////////////////////////////////////////////////////




    if(isset($_POST['tag']) && !empty($_POST['tag'])){
    $tag1       = preg_replace('/\s/', '', $tag);     //mal7oza trick of remove all white spaces from a text of the tag
    $theTag       = strtoupper($tag1);
}else { $theTag = "";}
////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////////////

    if(empty($_POST['itemName'])){
     //   $nameErr= "You must fill the name pattern";
       $nameErr = "You must fill the name pattern";
      
    }elseif(!empty($_POST['itemName']) && strlen($_POST['itemName']) < 3){
        $nameErr = "You must fill your real name and must more than 3 letters";
    }

//////////////////////////////////////////////////////////////////////////

    if(empty($_POST['date'])){

        $dateErr = "You must fill the date pattern";
    }
//////////////////////////////////////////////////////////////////////////
    if(empty($_POST['country'])){
        $countryErr = "You must fill the country pattern";
    }elseif(!empty($_POST['country']) && strlen($_POST['country']) < 3){
        $countryErr = "You must put a name of a real country";

    }
//////////////////////////////////////////////////////////////////////////
    if(empty($_POST['desc'])){
        $descErr = "You must fill in the description pattern";
    }
/////////////////////////////////////////////////////////////////////////
                    ////imageErr//// !isset and !empty is have no imageErr in edit page

    if(!in_array($myExt , $allowedExtensions) && !empty($pName)){
        $imageErr = "Our site does not support that type of files , please insert a file of jpeg , jpg , png or gif only ";
    }
/////////////////////////////////////////////////////////////////////////
$rs = getAll("itemPhoto" , "items" , "where item_id = {$itemId}" , '' , "item_id" ); //important important trick of edit image

foreach($rs as $r){   //est3lam $rs because the case of not chosing a new image in edit page to preserve the original image

if(empty($nameErr) && empty($dateErr) && empty($countryErr) && empty($statusErr) && empty($categoryErr) && empty($imageErr)){


//////////////////////////////////////////////////////////
    if(!empty($pName)){

        $photo = rand(0,100000000) . "_" . $pName;  
    
    }else{
        $photo = $r['itemPhoto'];  // the original name of image if we didnt chose a new image
    }
  ////////////////////////////////////////////////////////  
    move_uploaded_file($pTmp, "admin\uploads\photos\\" . $photo);


    $stmt = $con->prepare("UPDATE items SET name=? , add_date = ? , country_made=? , status = ? , cat_id = ? , tag = ? , describtion = ? , itemPhoto = ? WHERE item_id = ?");
     $stmt->execute(array($name , $date , $country , $status , $category , $theTag , $desc , $photo  , $itemId));
     $count = $stmt->rowCount();
     if($count > 0){
 
         echo "Yoy have updated one item successfully ";
 
     }else{echo "it does not go to the data base";}//($count > 0)
    
 
 } //if(empty($nameErr) && empty($dateErr) && empty($countryErr) && empty($statusEr
} //foreach($rs as $r){



}//$_SERVER['REQUEST_METHOD'] == 'POST'



//////////////////////////////////////////////////////est3lam /////////////////////////////////////////////////////////
        $stmt = $con->prepare("SELECT 
                                items.* ,
                                categories.name AS catName , 
                                users.user_name
                                FROM 
                                items 
                                INNER JOIN 
                                categories 
                                ON 
                                categories.id = items.cat_id
                                INNER JOIN
                                users 
                                ON 
                                users.user_id = items.member_id
                                WHERE item_id = ?
                                ");

        $stmt->execute(array($itemId));
        $count = $stmt->rowCount();
            if($count > 0){
                $ads = $stmt->fetchAll();
//////////////////////////////////////////////////////est3lam /////////////////////////////////////////////////////////
            foreach($ads as $ad){  ?>
                    <br>
                <div class='container'>
                    <div class='outer-frame p-3'> 
                    <form action="<?php echo $_SERVER ['PHP_SELF'] ?>?itemId=<?php echo $itemId;  ?>" method='POST' enctype="multipart/form-data">
                      <h2 class='our-h text-center'>Edit for <?php echo $ad['name']; ?></h2>   

                        <div class='row'>
                            <div class='col-sm-8'>
 <!--//////////////////////////////////////////////////////////////////////////////////////////////////-->                           
                                <div class='row p-2'>
                                        <div class='col-sm-2'>
                                            <label class='control-label text-right'>
                                            <b>Item Name</b>
                                        </div>

                                        <div class='col-sm-10'>    
                                           <input name='itemName' type='text' value='<?php echo $ad['name']; ?>' class='form-control' />
                                                  <?php  echo "<h6 style='color:red; font-weight:bold;'>" . $nameErr . "</h6>";   ?>
                                        </div>    
                                </div> <!-- second row -->
 <!--//////////////////////////////////////////////////////////////////////////////////////////////////-->                          
  <!--//////////////////////////////////////////////////////////////////////////////////////////////////-->                           
                                <div class='row p-2'>
                                        <div class='col-sm-2'>
                                            <label class='control-label'>
                                            <b>Date</b>
                                        </div>

                                        <div class='col-sm-10'>    
                                            <input name='date' type='date' value='<?php echo $ad['add_date']; ?>' class='form-control' />
                                            <?php  echo "<h6 style='color:red; font-weight:bold;'>" . $dateErr . "</h6>";   ?>

                                       
                                        </div>    
                                </div> <!-- second row -->
 <!--//////////////////////////////////////////////////////////////////////////////////////////////////-->                          
 <!--//////////////////////////////////////////////////////////////////////////////////////////////////-->                           
                                <div class='row p-2'>
                                        <div class='col-sm-2'>
                                            <label class='control-label'>
                                            <b>Country</b>
                                        </div>

                                        <div class='col-sm-10'>    
                                            <input name='country' type='text' value='<?php echo $ad['country_made']; ?>' class='form-control' />
                                            <?php  echo "<h6 style='color:red; font-weight:bold;'>" . $countryErr . "</h6>";   ?>
                                          
                                        </div>    
                                </div> <!-- second row -->
 <!--//////////////////////////////////////////////////////////////////////////////////////////////////-->                           
 <!--//////////////////////////////////////////////////////////////////////////////////////////////////-->                           
                                <div class='row p-2'>
                                        <div class='col-sm-2'>
                                            <label class='control-label'>
                                            <b>Status </b>
                                        </div>

                                        <div class='col-sm-10'>
                                            <select name='status' class='form-control'>    
                                                <option 
                                                 value='1'
                                                 <?php if($ad['status'] == 1 ) { echo "selected";} ?>
                                                 class='form-control'>
                                                 New
                                                </option>

                                                <option 
                                                 value='2'
                                                 <?php if($ad['status'] == 2) { echo "selected";} ?>
                                                 class='form-control'>
                                                 Light Used
                                                </option>

                                                <option 
                                                 value='3'
                                                 <?php if($ad['status'] ==3) { echo "selected";} ?>
                                                 class='form-control'>
                                                 Used
                                                </option>

                                                <option 
                                                 value='4'
                                                 <?php if($ad['status'] ==4) { echo "selected";} ?>
                                                 class='form-control'>
                                                 Hard Used
                                                </option>



                                            </select>   
                                            <?php  echo "<h6 style='color:red; font-weight:bold;'>" . $statusErr . "</h6>";   ?>
                                            
                                        </div>
                                </div> <!-- second row -->
 <!--//////////////////////////////////////////////////////////////////////////////////////////////////-->
  <!--//////////////////////////////////////////////////////////////////////////////////////////////////-->                           
                                <div class='row p-2'>
                                        <div class='col-sm-2'>
                                            <label class='control-label'>
                                            <b>Category </b>
                                        </div>
                                        <!--
                                        <div class='col-sm-10'>    
                                            <input type='text' value='' class='form-control' />
                                        </div>
                                        -->  
                                        <div class='col-sm-10'>        
                                        <select name='category' class='form-control'>
                                           

                                       
                                        <?php 
                                        
                                ////////est3lam/////////
     $news = getAll('*' , 'categories' , "where parent = 0 " , "" , 'id',"ASC"); //  /* button*/ est3lam is used to make the select tag which of
                                                                                //the categories only
                                //////est3lam///////////


                                        foreach($news as $new) {?>
                                            
                                           <option <?php if($ad['catName'] == $new['name']){echo "selected";} ?> value=' <?php
                                                            
                                                            
                                                            echo $new['id'];  ?>' > <?php echo $new['name'];  ?> </option> 

            <?php  $children1 = getAll('*' , 'categories' , "WHERE parent = {$new['id']}" , '' , 'id' , 'ASC'); 
                
                            foreach($children1 as $child){ ?>
                            <option
                            style='color:green; font-size:13px;'
                             <?php if($ad['catName'] == $child['name']){echo "selected";} ?>
                              value='<?php echo $child['id'] ?>'>
                              &nbsp; &nbsp; &nbsp;
                                <?php  echo $child['name']; ?>
                            </option>

                           <?php }
    
?>

                                                           


                                      <?php  }  ?>
                                      </select> 
                                      <?php  echo "<h6 style='color:red; font-weight:bold;'>" . $categoryErr . "</h6>";   ?>
                                    
                                        </div><!--<div class='col-sm-10'>    -->
                                </div> <!-- second row -->
 <!--//////////////////////////////////////////////////////////////////////////////////////////////////-->                           
                           
 <!--//////////////////////////////////////////////////////////////////////////////////////////////////-->                           
                                <div class='row p-2'>
                                        <div class='col-sm-2'>
                                            <label class='control-label'>
                                            <b>Image </b>
                                        </div>

                                        <div class='col-sm-10'>    
                                            <input name='photo' type='file' class='form-control' />
                                        
                                            <?php  echo "<h6 style='color:red; font-weight:bold;'>" . $imageErr . "</h6>";   ?>
                                       </div>    
                                </div> <!-- second row -->
 <!--//////////////////////////////////////////////////////////////////////////////////////////////////-->                           
 <!--//////////////////////////////////////////////////////////////////////////////////////////////////-->                           
                                <div class='row p-2'>
                                        <div class='col-sm-2'>
                                            <label class='control-label'>
                                            <b>Tag </b>
                                        </div>

                                        <div class='col-sm-10'>    
                                            <input 
                                            type='text' 
                                            name='tag' 
                                            value='<?php
                                            if(!empty($ad['tag'])){
                                            echo $ad['tag'];}else
                                            {
                                                echo "'  value=''  placeholder='Insert tag or more like the pattern ..... , ..... , .....";
                                            } 
                                            ?>' 
                                            class='form-control' />

                                        </div>    
                                </div> <!-- second row -->
 <!--//////////////////////////////////////////////////////////////////////////////////////////////////-->                           
 <!--//////////////////////////////////////////////////////////////////////////////////////////////////-->                           
                                <div class='row p-2'>
                                        <div class='col-sm-2'>
                                            <label class='control-label'>
                                            <b>Description </b>
                                        </div>

                                        <div class='col-sm-10'>    
                                            <input type='text' name='desc' value='<?php echo $ad['describtion']; ?>' class='form-control' />
                                            <?php  echo "<h6 style='color:red; font-weight:bold;'>" . $descErr . "</h6>";   ?>
                                      
                                        </div>    
                                </div> <!-- second row -->
 <!--//////////////////////////////////////////////////////////////////////////////////////////////////-->   
                                              
                            <div class='row p-2'>
                                <div class='offset-sm-2 col-sm-4 pl-3'>
                                    <input  class='btn btn-primary' type='submit' value='Edit Item' />
                                </div>
                            </div>
                        </div> <!-- col-sm-8 -->
    <!--//////////////////////////////////////////////////////////////////////////////////////////////////-->                           
                     
                         <div class='col-sm-4'>
                            
                            <img 
                            style='object-fit:cover;'
                            class='itemImage' src='admin\uploads\photos\\<?php echo $ad['itemPhoto']; ?>' alt='item image' />
            
            
                         </div><!--col-sm-4-->

                          
    <!--//////////////////////////////////////////////////////////////////////////////////////////////////-->                           
    <!--////////////////////////////////////the image part//////////////////////////////////-->                           
    <!--//////////////////////////////////////////////////////////////////////////////////////////////////-->                           


                          




                        </div>  <!-- first row -->
                        </form>
                    </div> <!-- outer-frame -->
                </div> <!-- container   -->

<?php  

}//foreach($ads as $ad){






            }//if($count > 0){











?>

            <?php 



                

    include $tpl . "footer.php";
}

ob_end_flush();
?>
