<?php

if(isset($_POST['submit']))
{
 if(getimagesize($_FILES['image']['tmp_name'])==FALSE)
 {
    echo " error ";
 }
 else
 {
    $image = $_FILES['image']['tmp_name'];
    $image = addslashes(file_get_contents($image));
    saveimage($image);
 }
}
function saveimage($image)
{
    $dbcon=mysqli_connect('localhost','root','Lostsaga135','fatechid_account');
    $qry="insert into photo (name) values ('$image')";
    $result=mysqli_query($dbcon,$qry);
    if($result)
    {
        echo " <br/>Image uploaded.";
        header('location:urlofpage.php');
    }
    else
    {
        echo " error ";
    }
}
?>