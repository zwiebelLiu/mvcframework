<nav class="top-nav">
    <ul>
        <li>
            <a href="<?php echo URLROOT;?>/pages/index">Home</a>
        </li>
        <li>
            <a href="<?php echo URLROOT;?>/pages/about">About</a>
        </li>
        <li>
            <a href="<?php echo URLROOT;?>/pages/project">Project</a>
        </li>
        <li>
            <a href="<?php echo URLROOT;?>/pages/blog">Blog</a>
        </li>
        <li>
            <a href="<?php echo URLROOT;?>/pages/contact">Contact</a>
        </li>
        <li class="btn-login">
            <?php
                if(isset($_SESSION['user_id'])) {
                  echo "<a href=\"". URLROOT."/users/logout\">LOGOUT</a>";
                }else
                 {
                     echo "<a href=\"". URLROOT."/users/login\">LOGIN</a>";
                 }
             ?>

        </li>
    </ul>

</nav>
