<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>

  <div class="content clearfix"<?php print $content_attributes; ?>>
    <?php
      // We hide the comments and links now so that we can render them later.
      hide($content['comments']);
      hide($content['links']);
      print '<div class="pre-blog-image">'.render($content['field_blog_image']).render($content['field_video']).'</div>';
    ?>
 
    <?php if($title_prefix || $title_suffix || $title): ?>
      <header>
        <?php print render($title_prefix); ?>
          <h2<?php print $title_attributes; ?>>
            <a href="<?php print $node_url; ?>"><?php print $title; ?></a>
          </h2>
        <?php print render($title_suffix); ?>
      </header>
    <?php endif; ?>

      <?php if ($display_submitted): ?>
        <div class="meta submitted">
	      <?php print $user_picture; ?>
	      <?php print $submitted; ?>
	    </div>
	  <?php endif; ?>
  
     <?php print render($content);
    ?>
  </div>

  <?php
    // Remove the "Add new comment" link on the teaser page or if the comment
    // form is being displayed on the same page.
    if ($teaser || !empty($content['comments']['comment_form'])) {
      //unset($content['links']['comment']['#links']);
      $links = render($content['links']['node']);
    }
    else {
      $links = render($content['links']['comment']);
    }
  ?>
  
    <?php if ($links):  ?>
      <div class="link-wrapper">
        <?php print $links; ?>
      </div>
    <?php endif; ?>

  <?php print render($content['comments']); ?>

</div>
