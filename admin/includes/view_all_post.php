<?php
if(isset($_POST['checkBoxArray'])){
    foreach($_POST['checkBoxArray'] as $postValueId){
        
       $bulk_options=$_POST['bulk_options'];
       switch($bulk_options){
        case 'published' :
            $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id= '{$postValueId}'  ";
            $update_to_publishes_status= mysqli_query($connection,$query);

            break;

        case 'draft' :
            $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id= '{$postValueId}'  ";
            $update_to_draft_status= mysqli_query($connection,$query);

            break;
        
        case 'delete' :
             $query = "DELETE FROM posts  WHERE post_id= '{$postValueId}'  ";
             $update_to_delete_status= mysqli_query($connection,$query);
    
             break;

        case 'clone' :
            
            $query= "Select * from posts WHERE post_id='{$postValueId}'";
            $select_post_query=mysqli_query($connection,$query); 
           
            while($row=mysqli_fetch_array($select_post_query)){  
            $post_id=$row['post_id'];
            $post_author=$row['post_author'];
            $post_title=$row['post_title'];
            $post_category_id=$row['post_category_id'];
            $post_status=$row['post_status'];
            $post_image=$row['post_image'];
            $post_tags=$row['post_tags'];
            $post_content=$row['post_content'];
            $post_date=$row['post_date'];
            }
            $query= "INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_status, post_image,  post_tags, post_content )";
            $query.="VALUES( '{$post_category_id}','{$post_title}','{$post_author}',now(),'{$post_status}','{$post_image}','{$post_tags}' , '{$post_content}' )";
              $copy_query=mysqli_query($connection, $query);
            if(!$copy_query){
                die("QUERY FAILED" . mysqli_error($connection));
            }
            break;


       }


    }
}



?>


<form action="" method="post">
<table class="table table-bordered table-hover">

 <div id="bulkOptionsContainer" class="col-xs-4">
 <select class="form-control" name="bulk_options" id="">

<option value="">Select Options</option>
<option value="published">Publish</option>
<option value="draft">Draft</option>
<option value="delete">Delete</option>
<option value="clone">Clone</option>
 </select>


 </div>
 <div class="col-xs-4">
    <input type="submit" name="submit" class="btn btn-success" value="Apply">
    <a class="btn btn-primary" href="posts.php?source=add_post">Add New</a>
 </div>
    <thead>
        <tr>
            <th><input id="selectAllBoxes" type="checkbox"></th>
            <th>ID</th>
            <th>Author</th>
            <th>Title</th>
            <th>Category</th>
            <th>Status</th>
            <th>Image</th>
            <th>Tags</th>
            <th>Comments</th>
            <th>Date</th>
            <th>View Post</th>
            <th>Edit</th>
            <th>Delete</th>
            <th>View Count</th>
        </tr>
    </thead>

<tbody>


<?php
 $query= "Select * from posts ORDER BY post_id DESC";
 $select_posts=mysqli_query($connection,$query); 

 while($row=mysqli_fetch_assoc($select_posts)){  
 $post_id=$row['post_id'];
 $post_author=$row['post_author'];
 $post_title=$row['post_title'];
 $post_category_id=$row['post_category_id'];
 $post_status=$row['post_status'];
 $post_image=$row['post_image'];
 $post_tags=$row['post_tags'];
 $post_comment_count=$row['post_comment_count'];
 $post_date=$row['post_date'];
 $post_views_count=$row['post_views_count'];

 echo "<tr>";
 ?>
 <td><input class="checkBoxes" type="checkbox" name="checkBoxArray[]" value="<?php echo $post_id; ?>"></td>
 <?php
 echo "<td>$post_id</td>";
 echo "<td> $post_author</td>";
 echo "<td> $post_title</td>";

 //For the category id displayed in the view all posts
 $query="SELECT * FROM categories WHERE cat_id={$post_category_id}";
 $select_category_id=mysqli_query($connection,$query);
 while($row=mysqli_fetch_assoc($select_category_id)){
     $cat_id=$row['cat_id'];
     $cat_title=$row['cat_title'];
 
     echo"<td>{$cat_title}</td>";
 }

 echo "<td> $post_status</td>";
 echo "<td><img width='100' src='../images/$post_image'></td>";
 echo"<td>$post_tags</td>";
 echo "<td> $post_comment_count</td>";
 echo "<td>$post_date</td>";
 echo "<td><a href='../post.php?p_id={$post_id}' >View Post</a></td>";
 echo "<td><a href='posts.php?source=edit_post&p_id={$post_id}' >Edit</a></td>";
 echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete');\"href='posts.php?delete={$post_id}' >Delete</a></td>";
 echo "<td>{$post_views_count}</td>";
 echo "</tr>";


 }



?>
    
    
</tbody>
</table>
</form>

<?php
if(isset($_GET['delete'])){

    $the_post_id=$_GET['delete'];
    $query="DELETE FROM posts where post_id={$the_post_id}";
    $delete_query=mysqli_query($connection,$query);
    header("Location: posts.php ");
    
}



?>