<?php
require APPROOT.'/views/includes/header.php';
?>

<div class="navbar dark" >
    <?php
    require APPROOT.'/views/includes/navigation.php';
    ?>
</div>

<div class="container center">
    <h1>
        Edit Post
    </h1>
    <form action="<?php  echo URLROOT; ?>/posts/update/<?php  echo $data['posts']->id; ?>" method="post">
        <div class="form-item">
            <input type="text" placeholder="Title *" name="title" value="<?php  echo $data['posts']->title;?>">
            <span class="invalidFeedback">
                 <?php  echo $data['titleError'];?>
             </span>
        </div>
        <div class="form-item">
            <textarea  placeholder="Enter u post.... *" name="body" ><?php  echo $data['posts']->body;?></textarea>
            <span class="invalidFeedback">
                 <?php  echo $data['bodyError'];?>
             </span>
        </div>

        <br>
        <button id="submit" type="submit" >Submit</button>
        </form>


</div>

