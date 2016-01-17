<div class='_t'>
  <span><a href='<?php echo base_url ('works');?>'>設計作品</a> » <?php echo $work->title;?></span>
</div>

<div class='b1'>
  <article>
    <section><p><?php echo $work->content;?></p></section>
    <div>
<?php foreach ($work->blocks as $block) { ?>
        <section>
          <h3><?php echo $block->title;?></h3>
    <?php foreach ($block->items as $item) { ?>
            <p>
        <?php if ($item->link) { ?>
                <a href='<?php echo $item->link;?>' target='_blank'><?php echo $item->title;?></a>
                <i><?php echo $item->link;?></i>  
        <?php } else { ?>
                <?php echo $item->title;?>
        <?php }?>
            </p>
    <?php } ?>
        </section>
<?php } ?>
    </div>
  </article>
  <article>
    <?php 
    foreach ($work->pictures as $picture) { ?>
      <figure>
        <a>
          <img src='<?php echo $picture->name->url ('800w');?>' alt='<?php echo $work->title;?>'>
        </a>
        <figcaption>
        </figcaption>
      </figure>
    <?php 
    } ?>
  </article>
</div>