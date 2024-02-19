<?php
// function redirect(){
//     return header(header: "Location:" , $location);
// }

function insert_categories(){
    global $connection;
    if(isset($_POST['submit'])){
        $cat_title=$_POST['cat_title'];
        if($cat_title== "" || empty($cat_title)){
        echo "this field is not necessary";
        }
        else{
            $query="INSERT INTO categories(cat_title)";
            $query.="VALUE('{$cat_title}')";

            $create_category_query=mysqli_query($connection,$query);
            if(!$create_category_query){
                die('Query failed'.mysqli_error($connection));
            }
        }
    }
}

function findAllCategories(){
    global $connection;
    $query= "Select * from categories";
    $select_categories=mysqli_query($connection,$query);             
    while($row=mysqli_fetch_assoc($select_categories)){
    $cat_title=$row['cat_title'];
    $cat_id=$row['cat_id'];
    echo"<tr>";
    echo "<td>{$cat_id}</td>";
    echo "<td>{$cat_title}</td>";
    echo "<td><a href='categories.php?delete={$cat_id}'>Delete</a></td>";
    echo "<td><a href='categories.php?edit={$cat_id}'>Edit</a></td>";
    echo"</tr>";
}
}


function deleteCategories(){
    global $connection;
    if(isset($_GET['delete'])){
        $the_cat_id= $_GET['delete'];
        $query="Delete from categories where cat_id={$the_cat_id}";
        $delete_query=mysqli_query($connection,$query);
        header("location: categories.php");
    }
}

function comfirm($result){
    global $connection;
    if(!$result){
        die("Query failed.".mysqli_error($connection));
    }
   
}

function escape($string){
    global $connection;
   return mysqli_real_escape_string($connection, trim($string));

}

?>