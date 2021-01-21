
<?php    

ob_start();

session_start();


if(isset($_SESSION['anyUser'])){

    header('Location:index.php');
}





include 'init.php';



//////////////////////////////////////////expirement////////////////////////////////////////////////////////////////

?>

<span class='button1'>button</span>

<div class='pic'>hhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh</div>










<?php
if($_SERVER['REQUEST_METHOD']=='POST'){

if(isset($_POST['login'])){

        $user = $_POST['user'];
        $pass = $_POST['pass'];
        $hashedPass = sha1($pass);
       
    


        $stmt = $con->prepare("SELECT user_name , password , user_id FROM users WHERE user_name=? AND password=?");
        $stmt->execute(array($user, $hashedPass));
        $infos = $stmt->fetch();
        $count = $stmt->rowCount();


        if($count > 0){

            $_SESSION['anyUser'] = $user;
            $_SESSION['user_id'] = $infos['user_id'];
            header("Location:index.php");
            exit();
}//end of ($count > 0)
}else{//the end of if(isset($_POST['login']))  and the start of the ////signup case////////////////////


    
        $formErrors = array();
        ///////////////////////////////////////the user validation///////////////////////////////////////////////////////

            if(empty($_POST['user'])){

                $formErrors[] = "The user name must be filled";


        
           }elseif(isset($_POST['user'])){

            $filteredUser = filter_var($_POST['user'],FILTER_SANITIZE_STRING);
            if(strlen($filteredUser) < 4){

                $formErrors[] = "The user name must contain more than four characters";

            }//(strlen($filteredUser
        } // if of isset($_POST['user'])
////////////////////////////////////////////////password validation//////////////////////////////////////////////////////////

        if(isset($_POST['pass']) && isset($_POST['pass2'])){


            if(empty($_POST['pass'])){

                   $formErrors[] = "You Must Fill the input of password";

            }

           
          

           if( sha1($_POST['pass']) !== sha1($_POST['pass2'])){

                $formErrors[] = "the password is not equal";

           }

        }

/////////////////////////////////////////////////email validation//////////////////////////////////////////////////////////
            if(isset($_POST['email'])){


                if(empty($_POST['email'])){

                    $formErrors[] = "please fill the email input";

                }else{

                    $filteredEmail = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);

                    if(filter_var($filteredEmail,FILTER_VALIDATE_EMAIL) != true){

                        $formErrors[] = "You must put a valid email";

                    }

                }// the end of else

            }

        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(empty($formErrors)){
    

    

   $check = checkItem('user_name', 'users', $_POST['user']);

    if($check > 0){

        $formErrors[] = "Sorry, this name is existed";

    }else{


        $stmtUser = $con->prepare("INSERT INTO users(user_name, email,password,reg_status,date)
            VALUES(:zuser,:zemail,:zpass,0,now())");

        $stmtUser->execute(array(

            'zuser'=> $_POST['user'],
          'zemail'=> $_POST['email'],

           'zpass'=>sha1($_POST['pass'])
        ));

        $count = $stmtUser->rowCount();
        if($count > 0){

            $addSuccess = "Congratulations, You have created a new account";

        }
    }

}//if(empty($formErrors



////////////////////////////////////////////////////////////////////////////////////////////////////////////


}//the end of else of the if of login form
}// the end of $_SERVER[REQUEST_METHOD]






///////////////////////////////////////////////// login /////////////////////////////////////////////////

?>

<div class='container login-container'>
    <br>
<h2 class='text-center our-h'><span data-class='f-login' class='f-selected'>Log In</span> | <span data-class='f-signup'>Sign Up</span></h2>
        <div class='row'>
            <div class='offset-sm-4 col-sm-4 offset-sm-4 front-login'>
                    <form class='f-login' action="<?php echo $_SERVER ['PHP_SELF'] ?>" method="POST">
                    <div>
                        <input class='form-control' type='text' name='user' placeholder='Please Inser Your User Name' autocomplete='off' required=required />
                    </div>  
                    <div>
                        <input class='form-control' type='password'name='pass' placeholder='Please Inser Your Password' autocomplete='new-password' required=required/>
                    </div>
                    <div>
                        <input class='btn btn-block btn-primary' value='Login' type='submit' name='login'/>
                    </div>                
                    </form>
            </div>
        </div> <!-- row -->
        <!--////////////////////////////////////      signup    /////////////////////////////////////////////-->


    <div class='row'>
        <div class='offset-sm-4 col-sm-4 offset-sm-4 front-login'>

            <form class='f-signup' action="<?php echo $_SERVER ['PHP_SELF'] ?>" method="POST">
            <div>
                <input class='form-control' type='text' name='user' placeholder='Please Inser Your User Name' autocomplete='off'/>
            </div>
            <div>
                <input class='form-control' type='text' name='email' placeholder='Please Insert A Real Email' autocomplete='off'/>
            </div>
            <div>
                <input class='form-control' type='password'name='pass' placeholder='Please Inser Your Password' autocomplete='new-password' />
            </div>

            <div>
                <input class='form-control' type='password'name='pass2' placeholder='Please Inser Your Password again' autocomplete='new-password' />
            </div>


            <div>
                <input class='btn btn-block btn-success' value='Signup' type='submit' name='signUp'/>
            </div>
            </form>
        </div>   
    </div> <!-- row -->

    <div class='the-errors text-center'>


    
    <?php 
    
if(!empty($formErrors)){


    foreach($formErrors as $error){


        echo "<p style='color:red; font-size:20px;'>" . $error . "</p>" ;

    } //foreach

}//if(!empty($formErrors))

if(isset($addSuccess)){
    echo "<p style='color:green; font-size:20px;'>". $addSuccess ."</p>";

}
    
    ?>


    </div>

</div>
<?php  

include $tpl .'footer.php';

ob_end_flush();

?>