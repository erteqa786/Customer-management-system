<?php
if(isset($_GET['edit_user'])){
    $the_user_id=$_GET['edit_user'];
    $query= "Select * from users WHERE user_id=$the_user_id";
 $select_users_query=mysqli_query($connection,$query);             
 while($row=mysqli_fetch_assoc( $select_users_query)){
    
 $user_id=$row['user_id'];
 $username=$row['username'];
 $user_password=$row['user_password'];
 $user_firstname=$row['user_firstname'];
 $user_lastname=$row['user_lastname'];
 $user_email=$row['user_email'];
 $user_image=$row['user_image'];
 $user_role=$row['user_role'];
 }
}






if(isset($_POST['edit_user'])){

$user_firstname=$_POST['user_firstname'];
$user_lastname=$_POST['user_lastname'];
$user_role=$_POST['user_role'];

// $post_image=$_FILES['image']['name'];
// $post_image_temp=$_FILES['image']['tmp_name'];

$username=$_POST['username'];
$user_email=$_POST['user_email'];
$user_password=$_POST['user_password'];
// $user_date=date('d-m-y');
// $post_comment_count=4;


// move_uploaded_file($post_image_temp,"../images/$post_image");

// this is having some issue the encrytion is showing in the edit page instead of actual password

// $query="SELECT randSalt FROM users";
// $select_randsalt_query=mysqli_query($connection, $query);
// if(!$select_randsalt_query){
//     die("Query FAILED!" . mysqli_error($connection));
// }
// while($row=mysqli_fetch_array($select_randsalt_query)){
// // $row=mysqli_fetch_array($select_randsalt_query);
// $salt=$row['randSalt'];
// $hashed_password=crypt($user_password, $salt);
// }
if(!empty($user_password)){
    $query_password = "SELECT user_password FROM users WHERE user_id=$the_user_id "  ;
    $get_user=mysqli_query($connection,$query_password );
    comfirm($get_user);
    $row =mysqli_fetch_array($get_user);
    $db_user_password=$row['user_password'];

    if($db_user_password != $user_password){
        $hashed_password= password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12) );
    
    }
 $query="UPDATE users SET ";
$query .="user_firstname= '{$user_firstname}', ";
$query .="user_lastname= '{$user_lastname}', ";
$query .="user_role= '{$user_role}', ";
$query .="username= '{$username}', ";
$query .="user_email= '{$user_email}', ";
$query .="user_password= '{$hashed_password}' ";
$query .="WHERE user_id= {$the_user_id} ";

$edit_user_query= mysqli_query($connection,$query);
comfirm($edit_user_query);
echo "USER UPDATED " . "<a href='users.php'>View Users</a>"; 

}







}



?>



<form action="" method="post" enctype="multipart/form-data">
<div class="form-group">
    <label for="title">Firstname</label>
    <input type="text" value="<?php echo $user_firstname;  ?>" class="form-control" name="user_firstname">
</div>
<div class="form-group">
    <label for="title">Lastname</label>
    <input type="text" value="<?php echo $user_lastname;  ?>" class="form-control" name="user_lastname">
</div>
<div class="form-group">
<select name="user_role" id="" >
<option value="<?php echo $user_role;?>"><?php echo $user_role;?></option>
<?php
if($user_role =='admin'){
   echo "<option value='subscriber'>subscriber</option>";
}
else{
    echo "<option value='admin'>admin</option>";
}


?>
</select>
</div>

<div class="form-group">
    <label for="post_status">Username</label>
    <input type="text" value="<?php echo $username;  ?>" class="form-control" name="username">
</div>
<!-- <div class="form-group">
    <label for="post_image">Post Image</label>
    <input type="file" name="image">
</div> -->
<div class="form-group">
    <label for="post_tags">Email</label>
    <input type="text" value="<?php echo $user_email;  ?>" class="form-control" name="user_email">
</div>
<div class="form-group">
    <label for="post_tags">Password</label>
    <input autocomplete="off" type="password"  class="form-control" name="user_password">
</div>


<div class="form-group">
<input class="btn btn-primary" type="submit" name="edit_user" value="Update User">

</div>


</form>