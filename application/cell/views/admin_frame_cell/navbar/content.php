<nav>
  <div>
    <!-- <a href='<?php echo base_url ();?>' class='o'><div></div><div><div></div><div></div></div></a> -->
    <a href='<?php echo base_url ();?>' class='o'><div>宙思</div><div><div>設計有限公司</div><div>ZEUS Design</div></div></a>

    <div>
<?php if ($back_link) { ?>
        <a class='icon-arrow-left' href='<?php echo $back_link;?>'></a>
<?php } else { ?>
        <div class='l icon-menu'></div>
<?php }?>
      <!-- <h1></h1> -->
      <h1><?php echo $subtitle;?></h1>
    </div>

    <div>
      <div class='r icon-more'>
        <div class='c'></div>
        <div class='l'>
          <div><svg class="svg" width="65px" height="65px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg"><circle class="path" fill="none" stroke-width="6" stroke-linecap="round" cx="33" cy="33" r="30"></circle></svg></div>
        </div>
      </div>

    </div>
  </div>
</nav>