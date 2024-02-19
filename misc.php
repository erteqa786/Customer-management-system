<!-- the option for admin and subscriber in the profile page -->



<div class="form-group">
<select name="user_role" id="" >
<option value="subscriber"><?php echo $user_role;?></option>
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
<!-- 
the option ends here -->


<div class="form-group">
    <label for="users">Users</label>
<select name="post_category" id="" >
<?php 

$query= "Select * from users ";
$select_users=mysqli_query($connection,$query);  
comfirm($select_users);

while($row=mysqli_fetch_assoc($select_users)){
$user_id=$row['user_id'];
$username=$row['username'];

echo "<option value='$user_id'>{$username}</option>";
}
?>
</select>
</div>'

<!-- end -->

if(isset($_SESSION['user_role']))
{
    if($_SESSION['user_role']!= 'admin'){
        header("Location: ../index.php");
    }else{
        header("Location: admin.php");
    }
     
    
}