<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        #ques{
            min-height:500px;
        }
        </style>
    <title>Welcome to iDiscuss-Coding Forums</title>
</head>

<body>
    <?php include 'partials/dbconnect.php'?>
    <?php include 'partials/header.php'?>
   
    <?php
     $id=$_GET['threadid'];
     $sql="SELECT * FROM `threads` WHERE thread_id=$id";
     $result=mysqli_query($conn,$sql);
     while($row=mysqli_fetch_assoc($result)){
        $title=$row['thread_title'];
        $desc=$row['thread_desc'];
        $thread_user_id=$row['thread_user_id'];
        
      // query the users tableto find out the name of OP
        $sql2="SELECT user_email FROM  `users` WHERE sno='$thread_user_id'";
        $result2=mysqli_query($conn,$sql2);
        $row2=mysqli_fetch_assoc($result2);
        $posted_by=$row2['user_email'];
                    
     }
     
    ?>


<?php
      $showAlert=false;
      $method=$_SERVER['REQUEST_METHOD'];
       if($method=='POST'){
        // insert comment into db
        $comment=$_POST['comment'];
        $comment=str_replace(">","&gt;",$comment);
        $comment=str_replace("<","&lt;",$comment);
        $sno=$_POST['sno'];
        $sql="INSERT INTO `comments` ( `comment_content`, `thread_id`, `comment_by`, `comment_time`) VALUES ( '$comment', '$id','$sno' , current_timestamp())";
        $result=mysqli_query($conn,$sql);
        $showAlert=true;
        if($showAlert){
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Your comment has been added!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>';
            
        }
       }
     ?>
    <!-- category container starts here -->
    <div class="container my-4">
        <div class="jumbotron">
            <h1 class="display-4"><?php echo $title ;?> forums</h1>
            <p class="lead"><?php echo $desc;?></p>
            <hr class="my-4">
            <p>This is a peer to peer forum.Be respectful, even when there's a disagreement.Avoid foul language or
                discriminatory comments.Avoid spam or self-promotion.
                Avoid links to external websites or companies.
                Avoid NSFW (not safe for work) content.
                Keep discussions civil and constructive.
                Avoid trolling, spamming, harassment, or rumor-mongering.
                Avoid real-life topics as they might cause controversy.
                Avoid personal attacks, profanity, religious, political, or other inappropriate remarks.</p>
            <!-- <a class="btn btn-success btn-lg" href="#" role="button">Learn more</a> -->
             <p>Posted by :<b><?php echo $posted_by ?></b></p>
        </div>
    </div>
    <?php
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
      echo '<div class="container">
        <h1 class="py-2">Post a Comment.</h1>
        <form action="'.$_SERVER["REQUEST_URI"] .'" method="post">
            
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Type your comment.</label>
                <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                <input type="hidden" name="sno" value="'.$_SESSION["sno"].'">
            </div>
            <button type="submit" class="btn btn-success">Post Comment.</button>
        </form>
    </div>';
    }else{
        echo'
        <div class="container">
        <h1 class="py-2">Post a comment.</h1>
           <p class="lead">You are not logged in.Please login to be post a comment.</p>
        </div>
        ';
    }
    ?>
    <div class="container mb-5" id="ques">
            <h1 class="py-2">Discussions</h1>
            <?php
                $id=$_GET['threadid'];
                $sql="SELECT * FROM `comments` WHERE thread_id=$id";
                $result=mysqli_query($conn,$sql);
                $noResult=true;
                while($row=mysqli_fetch_assoc($result)){
                    $noResult=false;
                    $id=$row['comment_id'];
                    $content=$row['comment_content'];
                    $comment_time=$row['comment_time'];
                    $thread_user_id=$row['comment_by'];

                    $sql2="SELECT user_email FROM  `users` WHERE sno='$thread_user_id'";
                    $result2=mysqli_query($conn,$sql2);
                    $row2=mysqli_fetch_assoc($result2);
                    
                    echo '<div class="media my-3">
                        <img src="images/user_default.jpg" width="54px " class="mr-3" alt="...">
                        <div class="media-body">
                            <p class="font-weight-bold my-0">'.$row2['user_email'].' at '.$comment_time.'</p>
                            '.$content.'
                        </div>
                     </div>';
   
      
                }

                if($noResult){
                    echo '<div class="jumbotron jumbotron-fluid">
                            <div class="container">
                                <p class="display-4">No Comments Found</p>
                                <p class="lead">Be the first person to comment.</p>
                            </div>
                    </div>';
                }
            ?>
    </div>

    

       

    <?php include 'partials/footer.php'?>

    

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
            integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
        </script>
</body>

</html>