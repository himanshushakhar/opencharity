<div id="page-wrapper"><div id="page">

  <?php if ($secondary_menu): ?>
      <div id="secondary-menu" class="navigation"><div class="container">
        <?php print theme('links__system_secondary_menu', array(
          'links' => $secondary_menu,
          'attributes' => array(
            'id' => 'secondary-menu-links',
            'class' => array('links', 'inline', 'clearfix'),
          ),
          'heading' => array(
            'text' => t('Secondary menu'),
            'level' => 'h2',
            'class' => array('element-invisible'),
          ),
        )); ?>
      </div></div> <!-- /.container, /#secondary-menu -->
  <?php endif; ?>

  <div id="header" class="header"><div class="container">

    <div class="navbar-header">
      <?php if ($logo): ?>
        <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home" class="logo">
          <img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" class="img-responsive" />
        </a>
      <?php endif; ?>

      <?php if ($site_name || $site_slogan): ?>
        <div id="name-and-slogan"<?php if ($hide_site_name && $hide_site_slogan) { print ' class="element-invisible"'; } ?>>

          <?php if ($site_name): ?>
            <?php if ($title): ?>
              <div id="site-name"<?php if ($hide_site_name) { print ' class="element-invisible"'; } ?>>
                <strong>
                  <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home"><span><?php print $site_name; ?></span></a>
                </strong>
              </div>
            <?php else: /* Use h1 when the content title is empty */ ?>
              <h1 id="site-name"<?php if ($hide_site_name) { print ' class="element-invisible"'; } ?>>
                <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home"><span><?php print $site_name; ?></span></a>
              </h1>
            <?php endif; ?>
          <?php endif; ?>

          <?php if ($site_slogan): ?>
            <div id="site-slogan"<?php if ($hide_site_slogan) { print ' class="element-invisible"'; } ?>>
              <?php print $site_slogan; ?>
            </div>
          <?php endif; ?>

        </div> <!-- /#name-and-slogan -->
      <?php endif; ?>

      <?php if (!empty($main_menu) || !empty($page['navigation'])): ?>
        <button type="button" class="navbar-toggle">
          <span class="sr-only"><?php print t('Toggle navigation'); ?></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
      <?php endif; ?>
    </div>

    <?php if (!empty($main_menu) || !empty($page['navigation'])): ?>
      <div class="navbar-collapse" id="navbar-collapse">
        <?php if ($main_menu): ?>
          <div id="main-menu" class="navigation">
            <?php print theme('links__system_main_menu', array(
              'links' => $main_menu,
              'attributes' => array(
                'id' => 'main-menu-links',
                'class' => array('links', 'clearfix'),
              ),
              'heading' => array(
                'text' => t('Main menu'),
                'level' => 'h2',
                'class' => array('element-invisible'),
              ),
            )); ?>
          </div> <!-- /#main-menu -->
        <?php endif; ?>

        <?php if (!empty($page['navigation'])): ?>
          <?php print render($page['navigation']); ?>
        <?php endif; ?>
      </div>
    <?php endif; ?>

  </div></div> <!-- /.container, /#header -->

  <?php if ($page['banner_area']): ?>
    <div id="banner-area" class="banner-area clearfix">
      <?php print render($page['banner_area']); ?>
    </div><!-- /#banner-area -->
  <?php endif; ?>
  
  <?php if ($title && !$page['banner_area']): ?>
    <div id="page-title-wrapper"><div class="container">
      <h1 class="title" id="page-title">
        <?php print $title; ?>
      </h1>
      <?php if ($breadcrumb): ?>
        <div id="breadcrumb"><?php print $breadcrumb; ?></div>
      <?php endif; ?>
    </div></div> <!-- /.container /#page-title-wrapper -->
  <?php endif; ?>

  <?php if ($page['featured']): ?>
    <div id="featured" class="featured"><div class="container">
      <?php print render($page['featured']); ?>
    </div></div> <!-- /.container, /#featured -->
  <?php endif; ?>

  <?php if ($messages): ?>
    <div id="messages"><div class="container">
      <?php print $messages; ?>
    </div></div> <!-- /.container, /#messages -->
  <?php endif; ?>

  <?php if ($page['postscript_bottom']): ?>
    <div id="postscript-bottom" class="postscript-bottom">
      <?php print render($page['postscript_bottom']); ?>
    </div></div> <!-- /#postscript-bottom -->
  <?php endif; ?>

  <?php if ($page['footer']): ?>
    <div id="footer" class="footer clearfix"><div class="container">
      <?php print render($page['footer']); ?>
    </div></div> <!-- /.container, #footer -->
  <?php endif; ?>

</div></div> <!-- /#page, /#page-wrapper -->