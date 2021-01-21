<?php
ob_start();
session_start();
$pageTitle = 'add new ad';

if(isset($_SESSION['anyUser'])){
include "init.php";

/////////////////////////////////////////////est3lam//////////////////////////////////////////////////////////////


/////////////////////////////////////////////////////////////////////////////////////////////////
/*
$stmt3 = $con->prepare("SELECT * FROM categories");



$stmt3->execute();
$news = $stmt3->fetchAll();
*/
$news = getAll('*' , 'categories' , "where parent = 0 " , "" , 'id',"ASC"); //  /* button*/ est3lam is used to make the select tag which of
                                                          //the categories only
/////////////////////////////////////////////est3lam//////////////////////////////////////////////////////////////
 




?>
<br>

<div class='container'>
<div class='row'>



<div class='col-12'>


<div class='panel'>


<div class='panel-head text-center'>
<h2 class='mt-3 mb-3'>New Item</h2>
</div><!--  panel-head  -->



<div class='panel-body'>
<div class='row'>


<div class='col-sm-7 ad'>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" class='form-horizontal pt-5 pl-2 adForm' enctype='multipart/form-data'>
<input type='text' value='' name='itemName' class='namePut mt-3 pl-3' placeholder='Item Name' style='width:100%; background-color: rgba(13, 13, 137, 0.1);'/>


<label class='mt-3 pl-3 ppp' for="price"> <strong>Price : </strong></label>
<input type='text' name='price' value='' id='price' class='mt-3 pl-3 pricePut' />


<!-- ---------------------------------------------- -->

<div>
<label  class='mt-3 pl-3 statusPut ppp'>
<strong> Date : </strong>
</label>
<input  class='mt-3 datePut' type='date'  name='date' value='' style='background-color: rgba(13, 13, 137, 0.1);'/>
</div>
<input  class='mt-3 pl-3 countryPut' type='text'  name='country' value='' placeholder='Country' style='width:100%; background-color: rgba(13, 13, 137, 0.1);'/>
<!--<input  class='mt-3 pl-3 statusPut' type='text' value='' placeholder='Status' style='width:100%; background-color:transparent'/>-->
<label  class='mt-3 pl-3 statusPut ppp'>
<strong> Status : </strong>
</label>
<select class='mt-3 pl-3 statusPut'  name='status' style=' background-color: rgba(13, 13, 137, 0.1); '>
<option>.....</option>
<option name='status' value='1'>New</option>
<option name='status' value='2'>Light Used</option>
<option name='status' value='3'>Used</option>
<option name='status' value='4'>hard Used</option>
</select>
<div style='display:flex;' class='ppp' >
<label for='image' style='word-break: keep-all width:200px;' class='mt-3 pl-3 pr-1'><strong>Image : </strong></label>
<input  id='image'  name='image' class='mt-3 pl-3 imagePut' type='file' value='' style='background-color: rgba(13, 13, 137, 0.1);'/>
</div>

<?php

/////////////////////////////////////////////est3lam//////////////////////////////////////////////////////////////


  




/////////////////////////////////////////////est3lam//////////////////////////////////////////////////////////////
?>

<div>
<label  class='mt-3 pl-3 ppp'>
<strong> Category : </strong>
</label>
<select class='mt-3 pl-3 catPut'  name='category' style=' background-color: rgba(13, 13, 137, 0.1); '>
<option>.....</option>
<!--------------------hena ---------------------------------->
<?php  
foreach ($news as $new){

echo "<option value='". $new['id'] ."'>". $new['name'] ."</option>";

$category2 = $new['name'];

$children = getAll("*" , "categories" , "WHERE parent = {$new['id']}" , "" , "id" ,"ASC");

      foreach($children as $child){

        echo "<option style=' color:green; font-size:15px; font-weight:bold;' value='". $child['id'] ."'> &nbsp;  &nbsp; &nbsp;" . $child['name'] . "</option>";

      }

}


?>


</select>


</div>

<!-- ---------------------------------------------- -->

<label for='tag' style='word-break: keep-all width:200px;' class='mt-3 pl-3 pr-1 ppp'><strong>Tag : </strong></label>
<input type="text" value="" name="tag" class="mt-3 pl-3 tagPut" style="width:86%;" placeholder="Insert tag or more like the pattern ..... , ..... , ....." />
<!-- ---------------------------------------------- -->


<div>
<textarea  class='mt-3 pl-3 descriptionPut'  name='desc' type='text' value=''  placeholder='Put item description' style='background-color: rgba(13, 13, 137, 0.1); width:100%;'></textarea>
</div>


<input type='submit' value='submit' class='btn btn-primary'/>



</form>
</div> <!-- col-sm-6 -->
<!--  hena -->
<div class='col-sm-4'>






<!--///////////////////////////////////////////////////////////////////////////////////////////// -->

<div class='item-box'> 
<span class='price priceAdd' style='font-size:25px;'> ....... $ </span> 
       <div class='thumbnail' style='border:2px;'>
       <div class='upper text-center'>
      
       <div style='width:100%;'>
       <img style='width:80%; 
       object-fit:cover;'
        class='img-responsive text-center imageAdd' src='layout/images/img3.png'/>
</div>   
    </div>

       <div class='caption foh pt-4'>
     <div> <span><strong>Name : </strong> </span><span class='nameAdd' style='font-size:25px;'> ..............................</span> .</div>
     <div> <span><strong>Date : </strong></span><span class='dateAdd'style='font-size:25px;'> ..............................</span> .</div>
        <div> <span><strong>Country : </strong></span><span class='countryAdd'style='font-size:25px;'> ..............................</span> .</div>

        <div> <span><strong>Tags : </strong></span><span class='tagAdd'style='font-size:25px;'> ..............................</span> .</div>


            <div class='pt-3'> <span><strong>Description : </strong></span><span class='descriptionAdd'> ....................................................................</span> .</div>
       
            
       
       </div>
       </div>
      </div>

<!--///////////////////////////////////////////////////////////////////////////////////////////// -->





</div> <!-- col-sm-3 -->
<!-- end hena -->



</div> <!-- row -->

</div><!-- panel-body  -->

</div><!-- end panel -->

</div> <!--  col-12  -->



</div> <!-- row -->

</div> <!-- container -->


<?php   


if($_SERVER['REQUEST_METHOD']=='POST'){


  $name = filter_var($_POST['itemName'],FILTER_SANITIZE_STRING);

  $date = $_POST['date'];
  $country =filter_var( $_POST['country'],FILTER_SANITIZE_STRING);
  $status = filter_var($_POST['status'],FILTER_SANITIZE_NUMBER_INT);
  $description = filter_var($_POST['desc'],FILTER_SANITIZE_STRING);
  $price = filter_var($_POST['price'],FILTER_SANITIZE_NUMBER_INT);
  $id = $_SESSION['user_id'];
  $cat = filter_var($_POST['category'],FILTER_SANITIZE_NUMBER_INT);
  $tagPost = filter_var($_POST['tag'],FILTER_SANITIZE_STRING);
  


  $image = $_FILES['image'];
  $iName = $_FILES['image']['name'];
  $iTmp = $_FILES['image']['tmp_name'];
  $iSize = $_FILES['image']['size'];
  $iType = $_FILES['image']['type'];

  $imageExtAccepted = array("jpeg" , "jpg" , "png" , "gif");

  $xx = explode('.' , $iName);

  $myExt = strtolower(end($xx));
////////////////////////////////////////////////////////////////////////////////////////////////


  $errors = array();


/////////////////////////////////////////////////////////////////////////////////////  
  if(!empty($iName) && !in_array($myExt , $imageExtAccepted)){

    $errors[] = "your file is not supported , you must insert (jpeg , jpg , png , gif)";
  }
  
////////////////////////////////////////////////////////////////////////////////////

    if(empty($iName)){
      $errors[] = 'You must put a photo to the item';
    }
///////////////////////////////////////////////////////////////////////////////////////////////

    if(!isset($iName)){

      $errors[] = "You must put a photo";
    }
///////////////////////////////////////////////////////////////////////////////////////////////
    if(isset($iName) && strlen($iName) > 400000 ){

      $errors[] = "your photo size must not excced 4 MG";
    }


///////////////////////////////////////////////////////////////////////////////////////////////
    if(empty($name)){

      $errors[] = 'You must fill the name input ,please';
    }elseif(strlen($name) < 2){

      $errors[] = "You must enter a name of 2 characters or more";
    }//strlen($name)<2)
/////////////////////////////////////////////////////////////////////////////////////////////
    
    if(empty($date)){

      $errors[] = 'You must insert the date ,please';

    }

    ////////////////////////////////////////////////////////////////////////////////////
    
    if(empty($country)){


      $errors[] = 'You must insert the country ,please';

    }elseif(isset($country) && strlen($country) < 3){

      $errors[] = "you must put a name of a real country";

       }
    /////////////////////////////////////////////////////////////////////////////
    
    if(empty($status)){
      $errors[] = 'You must insert the status ,please';

    }
  ////////////////////////////////////////////////////////////////////////////////  
    if(empty($description)){
      $errors[] = 'You must insert the description of the item ,please';


    }elseif(isset($description)){

      filter_var($description,FILTER_SANITIZE_STRING);

    }

  ///////////////////////////////////////////////////////////  
    if(empty($price)){
      $errors[] = 'You must insert the price ,please';


    }else{

        
      $min = 1;
      $max = 100000;

          if (filter_var($price, FILTER_VALIDATE_INT, array("options" => array("min_range"=>$min, "max_range"=>$max))) === false) {
             $errors[] = "Put a real price between 1 and 100000";
          } 


    }
 ////////////////////////////////////////////////////////////////////////////////////////   
    
    if(empty($cat)){
      $errors[] = 'You must insert the category which the item is related to ,please';

    }

                  /*/////////////////////////////////////////////////////*/


   if(isset($tagPost)){



      $stripped = preg_replace('/\s/', '', $tagPost);     //mal7oza trick of remove all white spaces from a text of the tag
      $stripped = strtolower($stripped);
      $tag = $stripped;
        
    }
        
  
/////////////////////////////////////////////////////////////////////////////////////


/////////////////////////////////////////////est3lam//////////////////////////////////////////////////////////////

         
////////////////////////////////////////////////////////////////////////////////////////////////
      

if(empty($errors)){

$image = rand(0,1000000000) . "_" . $iName;
move_uploaded_file($iTmp , "admin\uploads\photos\\" . $iName  );

            


/////////////////////////////////////////////////////////////////////////////////////////////////////
$stmt = $con->prepare("INSERT INTO items(name,price,add_date,country_made,status,describtion,member_id,cat_id,tag,itemPhoto)
                       VALUES (:zname,:zprice,:zadd_date,:zcountry_made,:zstatus,:zdescribtion,:zmember,:zcat,:ztag,:zitemPhoto)");
 
$stmt->execute(array(
  'zname' => $name ,
  'zprice' => $price,
  'zadd_date' => $date,
  'zcountry_made' => $country,
  'zstatus' => $status,

  'zdescribtion' => $description ,
  'zmember' => $id,
  'zcat' => $cat,
  'ztag' => $tagPost,
  'zitemPhoto' => $iName

)); 

$count = $stmt->rowCount();
if($count > 0){

echo "<div class='alert alert-success'>You Have Inserted a new item</div>";

}//if($count > 0

}else{  //empty($errors  

  echo "<div class='container mt-3'>";
  foreach($errors as $error){

    echo " <div class='alert alert-danger'>". $error ."</div>";

  }
  
  echo "</div>";

}//else

}// $_SERVER['REQUEST_METHOD']=='POST'





?>








<?php
include $tpl . "footer.php";
}


ob_end_flush();
?>





 <!--///////////////////////////////malhoza/////////////////////////////

we notice that the est3lam of the muti query which has inner join

we can't ftech the member_id here of the user but we only can fetch by the foreach() function  




/////////////////////////////////malhoza///////////////////////////////// -->

<!--

      





