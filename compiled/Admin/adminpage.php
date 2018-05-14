<?php 
  session_start();
  include("connection.php");
 // Create database connection
 // $db = mysqli_connect("localhost", "root", "", "housebrew");    
// Initialize message variable
  $msg = "";
  mysql_select_db($dbName);

  if (!isset($_SESSION['ID']))
    {
      header('Location:loginpage.php'); 
     }
  if(isset($_POST['logout']))
    {
      // Unset and destroy the session
      session_unset();
      session_destroy();
      header("Location:loginpage.php");
    }


##############################
// Add post
##############################
  if (isset($_POST['upload'])) 
{
 $title = $_POST['title']; 

  $check = "SELECT title FROM posts WHERE title = $title";
  $querycheck = mysql_query($check);
    if($querycheck>0)
    {
        $msg = "Title already exist";
    }
        else 
          {     
                    // Get image name
                    $image = $_FILES['image']['name'];
                    // Get text
                    $content = $_POST['content'];
                    
                    // image file directory
                    $target = "images/".basename($image);

                    date_default_timezone_set('Asia/Hong_Kong');
                    $timezone = date_default_timezone_get();
                    $date = date('Y-m-d H:i:s');

                    $sql = "INSERT INTO posts (id,image,title,content,timedate) VALUES ('','$image','$title','$content','$date')";
                    
                      mysql_query($sql);  
                        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) 
                          {
                            $msg = "Image uploaded successfully";
                          }
                        else
                          {
                            $msg = "Failed to upload image";
                          }   
          } 
          
}
########################
#   Update Items
########################
if(isset($_POST['updatepost']))
{
    $edit_id = $_POST['editpost'];
    $newtitle = $_POST['title']; 
    $newdesc = $_POST['content'];
    $date = date('Y-m-d H:i:s');

                //title and content from the database
                  $view = "SELECT * FROM posts WHERE id = $edit_id";
                  $sql1 = mysql_query($view);
                  $row = mysql_fetch_array($sql1);
                  $dtitle =$row['title'];
                  $dcontent = $row['content'];

//checking if the title or content from the database is not equal to new input 
     if ($dtitle != $newtitle || $dcontent != $newdesc )
        {
          echo"1";
          //if the image is set
          if(isset($_FILES['image']['name']))
            {
              $newimage =$_FILES['image']['name'];
              echo "2";
              $toedit = "SELECT image FROM posts WHERE id = $edit_id";
              $editquery = mysql_query($toedit);
              //this is to delete or unlink the image from the folder /images
              while ($edit = mysql_fetch_array($editquery))
                  {
                    try
                      {
                        $image = $edit['image'];
                        $file= 'images/'.$image;
                        unlink($file);
                      } catch (Exception $e) { }
                  }

                      //$sql = "DELETE image FROM posts WHERE id = $edit_id  ";

                        $sqlUpdate = "UPDATE posts SET image ='$newimage',
                                                      title='$newtitle',
                                                      content='$newdesc',
                                                      timedate = '$date',
                                                   WHERE id = $edit_id "; 
                        
                       mysql_query($sqlUpdate);  
                        if (move_uploaded_file($_FILES['image']['tmp_name'], "images/".basename($newimage))) 
                         {
                           echo "<script>alert('data update successfully!')</script>";
                          }
                          else
                          {
                            echo "<script>alert('updating failed!')</script>";
                          }
                                       
            }      
       
            else
            {
              echo "3";
               $sqlUpdate = "UPDATE posts SET  title='$newtitle',
                                                      content='$newdesc',
                                                      timedate = '$date',
                                                   WHERE id = $edit_id "; 
                        
                       $sqlresult = mysql_query($sqlUpdate);
                        if ($sqlresult) 
                         {
                           echo "<script>alert('data update successfully!')</script>";
                          }
                          else
                          {
                            echo "<script>alert('updating failed!')</script>";
                          }

            } 
        }
 else{
          echo "you didn't change anything";
        }
  
   

       
       

}
       
########################
#Delete Items
########################
if(isset($_POST['deletepost']))
{
$del_id = $_POST['deleteID'];

$todelete = "SELECT image FROM posts WHERE id = $del_id";
$del = mysql_query($todelete);

while ($delete = mysql_fetch_array($del))
{
    try
    {
        $image = $delete['image'];
        $file= 'images/'.$image;
        unlink($file);
    } catch (Exception $e) {
      }
}

$sql = "DELETE FROM posts WHERE id = $del_id  ";
 $delete = mysql_query($sql);
          if($delete)
          {
           echo "<script>alert('data deleted successfully!')</script>";
          }
          else
          {
            echo "<script>alert('deleting failed!')</script>";
          }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Housebrew-Coffee</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="../css/mdb.min.css" rel="stylesheet">
    <!-- Your custom styles (optional) -->
    <link href="css/style.css" rel="stylesheet">
    <!-- Font -->
    <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Serif:300,400" rel="stylesheet">

    <style type="text/css">
       #content{
        width: 50%;
        margin: 20px auto;
        border: 1px solid #cbcbcb;
       }

       #img_div{
        width: 80%;
        padding: 5px;
        margin: 15px auto;
        border: 1px solid #cbcbcb;
       }
       #img_div:after{
        content: "";
        display: block;
        clear: both;
       }
       img{
        float: left;
        margin: 5px;
        width: 300px;
        height: 200px;
       }
    </style>
</head>

<body>
  <!-- Main Navigation -->
  <header>
    <?php include 'layout/navbarAdmin.php';?>
    <div id="intro" class="view">
     
    </div>

  </header>
  <!-- Main Navigation -->
  <!-- Main Body -->
    <main>
      <div class="container-fluid">
        <div class="row content">
          <div class="col-sm-7 sidenav">
    <table class="table table-bordered table-responsive">
          <tr>
          <td>  
            <h4>Latest Post</h4>
            <?php
               $displayLatest = "SELECT * FROM posts ORDER BY timedate DESC LIMIT 1";
                $query=mysql_query($displayLatest);
                    $recent = mysql_fetch_array($query); 
                    if($recent)
                    {
                      echo "<div id='img_div'>";
                      echo "<img src='images/".$recent['image']."' >";
                      echo "<p>Title:".$recent['title']."</p>";
                      echo "<p>Content:".$recent['content']."</p>";
                      echo "<p>Date & Time:".$recent['timedate']."</p>";
                      echo "</div>";
                    }
                   else
                   {
                    echo "<div><h3>No posts yet</h3></div>";
                   }
            ?>
          </td>
          </tr>
             <form method="POST" action="adminpage.php" enctype="multipart/form-data">
                  <input type="hidden" name="size" value="1000000">
                    
                        <tr>
                          <td><label class="control-label col-sm-2" for="image">Image:</label>
                          <input type="file" name="image" required>
                            <?php if($msg !=""){echo $msg; }?>
                          
                          </td>
                        </tr>

                        <tr>
                          <td> <input placeholder="Title" name="title" type="text" autofocus size="48" required> 
                          </td>

                        </tr>
                          <tr>
                            <td>
                          <textarea 
                          id="text" 
                          cols="40" 
                          rows="4" 
                          name="content" 
                          placeholder="Say something about this image..." required></textarea></td>
                          <td>
                          </tr>
                        <tr>
                        <td colspan="2"> 
                        <button type="submit" name="upload">POST</button>
                        </td>
                        </tr>

                    </table>

                    </div>
             </form>
            </div>
          </div>

          <div class="col-sm-5">
            <?php
                  $sql1 = "SELECT * FROM posts";
                  $result = mysql_query($sql1);
                    while ($row = mysql_fetch_array($result))
                     {
                      echo "<div id='img_div'>";
                      echo "<p>Title:".$row['title']." </p>";
                      $id =$row['id'];
                      $vtitle = $row['title'];
                      $vcontent = $row['content'];
                      $vimage= $row['image'];
                      echo "</div>";
              ?>
                            <a href="#edit<?php echo $id;?>" data-toggle="modal"><button type='button' class='btn btn-warning btn-sm'><span class='glyphicon glyphicon-edit' aria-hidden='true'></span>EDIT</button></a>
                            <a href="#delete<?php echo $id;?>" data-toggle="modal"><button type='button' class='btn btn-danger btn-sm'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span>DELETE</button></a>
               
          </div>
        </div>
      </div>
    </main>
  <!-- Main Body -->

    <!--Edit Item Modal -->
        <div id="edit<?php echo $id; ?>" class="modal fade" role="dialog">
            <form method="post" class="form-horizontal" role="form">
                <div class="modal-dialog modal-lg">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Edit Post</h4>
                        </div>
                        <div class="modal-body">
                                    <table class="table table-bordered table-responsive">
                                    <input type="hidden" name="editpost" value="<?php echo $id; ?>">
                                      <tr>
                                       <td><label class="control-label col-sm-2" for="image">Image:</label></td>
                                          <td> <input type="hidden" name="size" value="1000000"> 
                                            <input type="hidden" name="oldimage" value="<?php echo $vimage;?>">
                                              <img src="images/<?php echo $vimage;?>" >
                                              <input class="input-group" type="file" name="image" >
                                          </td>
                                      </tr>
                                      
                                      <tr>
                                       <td> <label class="control-label col-sm-7" for="title">Title:</label></td>
                                          <td> <input type="text"  class="form-control" id="title" name="title" value='<?php echo $vtitle; ?>'></td>
                                      </tr>
                                      
                                      <tr>
                                       <td> <label class="control-label col-sm-2" for="content">Description:</label></td>
                                          <td> <textarea cclass="form-control" id="content" name="content" style="width: 100%;"><?php echo $vcontent; ?></textarea></td>
                                      </tr>
                                      
                                      <tr>
                                          <td colspan="2"> <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" name="updatepost"><span class="glyphicon glyphicon-edit"></span> Edit</button>
                            <button type="button" class="btn btn-warning" data-dismiss="modal"><span class="glyphicon glyphicon-remove-circle"></span> Cancel</button>
                        </div>
                                          </td>
                                      </tr>
                                      
                                      </table>
                        </div>              
                       
                    </div>
                </div>
        </div>
        </form>
        </div>
        <!--Delete Modal -->
        <div id="delete<?php echo $id; ?>" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <form method="post">
                    <!-- Modal content-->
                    <div class="modal-content">

                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Delete</h4>
                        </div>

                        <div class="modal-body">
                            <input type="hidden" name="deleteID" value="<?php echo $id; ?>">
                            <p>
                                <div class="alert alert-danger">Are you Sure you want Delete <strong><?php echo $vtitle; ?>?</strong>post</p>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="deletepost" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> YES</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove-circle"></span> NO</button>
                            </div>
                        </div>
                </form>
                </div>
            </div>
        </div>
<?php      }
                  ?>
  <!-- SCRIPTS -->

  <!-- JQuery -->
  <script type="text/javascript" src="../js/jquery-3.2.1.min.js"></script>
  <!-- Bootstrap tooltips -->
  <script type="text/javascript" src="../js/popper.min.js"></script>
  <!-- Bootstrap core JavaScript -->
  <script type="text/javascript" src="../js/bootstrap.min.js"></script>
  <!-- MDB core JavaScript -->
  <script type="text/javascript" src="../js/mdb.min.js"></script>
  <!-- Custom Script -->
  <script language="JavaScript" type="text/javascript" src="js/init.js"></script>
</body>

</html>
