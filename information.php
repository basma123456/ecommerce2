<?php
ob_start();
session_start();
if(isset($_SESSION['anyUser'])){



    include 'init.php';
    



        if($_SERVER['REQUEST_METHOD']=='POST'){



                $errors = array();
                $name = filter_var($_POST['fname'],FILTER_SANITIZE_STRING);
                $full = filter_var($_POST['lname'],FILTER_SANITIZE_STRING);
                $email = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
                
                $hashedPass = sha1(filter_var($_POST['pass2'],FILTER_SANITIZE_STRING));
                if(empty($hashedPass)){
                    $hashedPass = $_POST['pass1'];

                }


                $date = $_POST['date'];
                
              
                $id = $_SESSION['user_id'];
/////////////////////////////////////////////////////////////////////////////////////////////////////

                    /*the validation of empty errors */
                if(empty($name)){
                    $errors[] = "Please, insert a name";
                }elseif(empty($email)){
                    $errors[] = "Please, insert your email";
                }elseif(empty($date)){
                    $errors[] = "Date , musn't be empty";
                }
                    /*The end of validation of empty errors */




                /*the validation of the other errors */

                    if(strlen($name) < 3){

                        $errors[] = "Insert a real name";

                    }elseif(strlen($name) > 30){

                        $errors[] = "You name should be less than 30 characters";
                    }
                    

                    

                /*the end of validation of the other errors */


 //////////////////////////////////////////////////////////////////////////////////////////////////////////               

                if(empty($errors)){


                $check = checkItem('user_name','users',$name);
                $alls1 = getAll("*" , "users" , "WHERE user_id = {$id}" ,"", "user_id");



                foreach($alls1 as $firstAll){
                if($check === 1 && $name != $firstAll['user_name']){

                    $nError ="<h2>Please insert another name, the name is already existed</h2>";
                    
                    echo $nError;
                    if(empty($errors)){

                    $info = $con->prepare("UPDATE users SET full_name=? , password=?, email=? WHERE user_id=?");
                    $info -> execute(array($full , $hashedPass,$email,$id));
                    $countt = $info->rowCount();
                    if($countt > 0){
                        echo "<h3 class='alert alert-success'>Congratulations, You have changed your information successfully except the name</h3>";
                    }// if($countt>0){      first
                            }//the end of empty($errors)
                
                }else{
                    
                        $_SESSION['anyUser'] = $name;
                        $info = $con->prepare("UPDATE users SET user_name=?,password=? , full_name=?, email=? WHERE user_id = ?");
                        $info->execute(array($_SESSION['anyUser'], $hashedPass ,$full,$email,$id));
                        $countt = $info->rowCount();
                        if($countt>0){
                        echo "<h3 class='alert alert-success'>Congratulations, You have changed your information successfully</h3>";
                        }// if($countt>0){      second
                            
                    }// end of if of $check === 1


                    }//foreach

                }else{//the end empty($errors)   
                        foreach($errors as $error){

                            echo $error . "<br>";
                        }//foreach($errors as $error){
                }//end of else
        }//the $_SERVER['REQUEST_METHOD]

?>
   
    <h2 class='text-center our-h'>Basic Information
    
    <?php echo $_SESSION['user_id']; ?>
    </h2>

        <?php 
        $id = $_SESSION['user_id'];  
        
                
        ?>
    <div class='container'>
       
        <form class='f-login information' action="<?php echo $_SERVER ['PHP_SELF'] ?>" method='post'>

        <?php  
                        $alls = getAll("*" , "users" , "WHERE user_id = {$id}" ,"", "user_id");

        
        ?>


       <?php foreach($alls as $all){ ?> 

       <!--------------------------------------------------------------------------------------------------->
        <div class='row'>
            <div class='col-2'>
  <label class='control-label' for="fname">Name:</label>
            </div>
            <div class='col-10'>
  <input class='form-control'
         type="text" id="fname" 
         name="fname" 
         value="<?php echo $all['user_name'];  ?>"/>
            </div>
        </div>
        <br>
  <!--------------------------------------------------------------------------------------------------->


        <div class='row'>
            <div class='col-2'>
  <label class='control-label' for="email">Password:</label>
            </div>
            <div class='col-10'>
  <input class='form-control' 
        type="password" 
        id="pass" 
        name="pass2" 
        value="" />

        
  <input type="hidden" value="<?php  echo $all['password']; ?>" name="pass1" />
            </div>
    </div>

        <br>
  <!--------------------------------------------------------------------------------------------------->


    <div class='row'>
            <div class='col-2'>
  <label class='control-label' for="lname">Full name:</label>
            </div>
            <div class='col-10'>
  <input class='form-control' type="text" id="lname" name="lname" value="<?php echo $all['full_name'];  ?>"/>
            </div>
    </div>
    <br>
      <!--------------------------------------------------------------------------------------------------->

    <div class='row'>
            <div class='col-2'>
  <label class='control-label' for="email">Email:</label>
            </div>
            <div class='col-10'>
  <input class='form-control' type="text" id="email" name="email" value="<?php echo $all['email'];  ?>"/>
            </div>
    </div>
    <br>

      <!--------------------------------------------------------------------------------------------------->

    <div class='row'>
            <div class='col-2'>
  <label class='control-label' for="date">Starting Date:</label>
            </div>
            <div class='col-10'>
  <input class='form-control' type="text" id="date" name="date" value="<?php echo $all['date'];  ?>"/>
            </div>
    </div>
    <br>

  <!--------------------------------------------------------------------------------------------------->


  <div class='row'>
    <div class='offset-sm-2 col-sm-10'>
    <div class='hundred'>
  <input type="submit" class='btn btn-primary info-button' value="Submit" />
    </div>
  </div>
  </div>
       <?php  } ?>
</form> 

       


    
    </div>



<?php


    include $tpl . 'footer.php';
}




/////////////////////////////////////////////////////est3lam//////////////////////////////////////////////////


/////////////////////////////////////////////////////est3lam//////////////////////////////////////////////////





ob_end_flush();

/* ///////////////////malhoza///////////////////////////////////////

just when we edit the user and change the user_name so we must change the value of the $_SESSION['anyUser']
by the new value 


*/
?>


