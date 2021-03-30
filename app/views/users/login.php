<?php
require APPROOT.'/views/includes/header.php';

?>
<div class="navbar" >
    <?php
    require APPROOT.'/views/includes/navigation.php';
    ?>
</div>

  <div class="container-login">
      <div class="wrapper-login">
          <h2>Login in</h2>
          <form action="<?php echo URLROOT; ?>/users/login" method="post">
              <input type="text" placeholder="Username *" name="username" >
              <span class="invalidFeedback">
                 <?php  echo $data['usernameError'];?>
              </span>
              <input type="password" placeholder="Password *" name="password" >
              <span class="invalidFeedback">
                 <?php  echo $data['passwordError'];?>
              </span>

              <button id="submit" type="submit" value="Login">Submit</button>
              <p class="option"> Not registered yet? <a href="<?php echo URLROOT; ?>/users/register">Create an account</a></p>
          </form>

      </div>


  </div>