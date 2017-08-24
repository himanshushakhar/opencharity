<?php

/**
 * Add body classes if certain regions have content.
 */
function opencharity_preprocess_html(&$variables) {

  if (!empty($variables['page']['featured'])) {
    $variables['classes_array'][] = 'featured';
  }
  if (!empty($variables['page']['banner_area'])) {
    $variables['classes_array'][] = 'banner-area';
  }
  if (!empty($variables['page']['postscript_bottom'])) {
    $variables['classes_array'][] = 'postscript-bottom';
  }

  // Add conditional stylesheets for IE
  drupal_add_css(path_to_theme() . '/css/ie.css', array('group' => CSS_THEME, 'browsers' => array('IE' => 'lte IE 7', '!IE' => FALSE), 'preprocess' => FALSE));
  drupal_add_css(path_to_theme() . '/css/ie6.css', array('group' => CSS_THEME, 'browsers' => array('IE' => 'IE 6', '!IE' => FALSE), 'preprocess' => FALSE));
}

/**
 * Override or insert variables into the page template for HTML output.
 */
function opencharity_process_html(&$variables) {
}

/**
 * Override or insert variables into the page template.
 */
function opencharity_process_page(&$variables) {

  // create variable for content width.
  if (!empty($variables['page']['sidebar_first']) && !empty($variables['page']['sidebar_second'])) {
    $variables['content_col_class'] = ' class="col-sm-6"';
  }
  elseif (!empty($variables['page']['sidebar_first'])) {
    $variables['content_col_class'] = ' class="col-sm-9"';
  }
  elseif (!empty($variables['page']['sidebar_second'])) {
  	$variables['content_col_class'] = ' class="col-sm-9"';
  }
  else {
    $variables['content_col_class'] = ' class="col-sm-12"';
  }

  // Always print the site name and slogan, but if they are toggled off, we'll
  // just hide them visually.
  $variables['hide_site_name']   = theme_get_setting('toggle_name') ? FALSE : TRUE;
  $variables['hide_site_slogan'] = theme_get_setting('toggle_slogan') ? FALSE : TRUE;
  if ($variables['hide_site_name']) {
    // If toggle_name is FALSE, the site_name will be empty, so we rebuild it.
    $variables['site_name'] = filter_xss_admin(variable_get('site_name', 'Drupal'));
  }
  if ($variables['hide_site_slogan']) {
    // If toggle_site_slogan is FALSE, the site_slogan will be empty, so we rebuild it.
    $variables['site_slogan'] = filter_xss_admin(variable_get('site_slogan', ''));
  }
  // Since the title and the shortcut link are both block level elements,
  // positioning them next to each other is much simpler with a wrapper div.
  if (!empty($variables['title_suffix']['add_or_remove_shortcut']) && $variables['title']) {
    // Add a wrapper div using the title_prefix and title_suffix render elements.
    $variables['title_prefix']['shortcut_wrapper'] = array(
      '#markup' => '<div class="shortcut-wrapper clearfix">',
      '#weight' => 100,
    );
    $variables['title_suffix']['shortcut_wrapper'] = array(
      '#markup' => '</div>',
      '#weight' => -99,
    );
    // Make sure the shortcut link is the first item in title_suffix.
    $variables['title_suffix']['add_or_remove_shortcut']['#weight'] = -100;
  }
}

/**
 * Implements hook_page_alter().
 */
function opencharity_page_alter($page) {

  // Look in each visible region for blocks.
  foreach (system_region_list($GLOBALS['theme'], REGIONS_VISIBLE) as $region => $name) {
    if (!empty($page[$region])) {
      // Find the last block in the region.
      $blocks = array_reverse(element_children($page[$region]));
      while ($blocks && !isset($page[$region][$blocks[0]]['#block'])) {
        array_shift($blocks);
      }
      if ($blocks) {
        $page[$region][$blocks[0]]['#block']->last_in_region = TRUE;
      }
    }
  }
}

/**
 * Implements hook_preprocess_maintenance_page().
 */
function opencharity_preprocess_maintenance_page(&$variables) {
  // By default, site_name is set to Drupal if no db connection is available
  // or during site installation. Setting site_name to an empty string makes
  // the site and update pages look cleaner.
  // @see template_preprocess_maintenance_page
  if (!$variables['db_is_active']) {
    $variables['site_name'] = '';
  }
  drupal_add_css(drupal_get_path('theme', 'opencharity') . '/css/maintenance-page.css');
}

/**
 * Override or insert variables into the maintenance page template.
 */
function opencharity_process_maintenance_page(&$variables) {
  // Always print the site name and slogan, but if they are toggled off, we'll
  // just hide them visually.
  $variables['hide_site_name']   = theme_get_setting('toggle_name') ? FALSE : TRUE;
  $variables['hide_site_slogan'] = theme_get_setting('toggle_slogan') ? FALSE : TRUE;
  if ($variables['hide_site_name']) {
    // If toggle_name is FALSE, the site_name will be empty, so we rebuild it.
    $variables['site_name'] = filter_xss_admin(variable_get('site_name', 'Drupal'));
  }
  if ($variables['hide_site_slogan']) {
    // If toggle_site_slogan is FALSE, the site_slogan will be empty, so we rebuild it.
    $variables['site_slogan'] = filter_xss_admin(variable_get('site_slogan', ''));
  }
}

/**
 * Override or insert variables into the node template.
 */
function opencharity_preprocess_node(&$variables) {
  if ($variables['view_mode'] == 'full' && node_is_page($variables['node'])) {
    $variables['classes_array'][] = 'node-full';
  }
}

/**
 * Override or insert variables into the block template.
 */
function opencharity_preprocess_block(&$variables) {

  // Classes describing the position of the block within the region.
  if ($variables['block_id'] == 1) {
    $variables['classes_array'][] = 'first';
  }
  // The last_in_region property is set in opencharity_page_alter().
  if (isset($variables['block']->last_in_region)) {
    $variables['classes_array'][] = 'last';
  }

  $variables['classes_array'][] = $variables['block_zebra'];

  $variables['title_attributes_array']['class'][] = 'block__title';

    // In the navigation region visually hide block titles.
  if ($variables['block']->region == 'navigation') {
    $variables['title_attributes_array']['class'][] = 'element-invisible';
  }
}

/**
 * Implements theme_menu_tree().
 */
function opencharity_menu_tree($variables) {
  return '<ul class="menu clearfix">' . $variables['tree'] . '</ul>';
}

/**
 * Implements theme_field__field_type().
 */
function opencharity_field__taxonomy_term_reference($variables) {
  $output = '';

  // Render the label, if it's not hidden.
  if (!$variables['label_hidden']) {
    $output .= '<h3 class="field-label">' . $variables['label'] . ': </h3>';
  }

  // Render the items.
  $output .= ($variables['element']['#label_display'] == 'inline') ? '<ul class="links inline">' : '<ul class="links">';
  foreach ($variables['items'] as $delta => $item) {
    $output .= '<li class="taxonomy-term-reference-' . $delta . '"' . $variables['item_attributes'][$delta] . '>' . drupal_render($item) . '</li>';
  }
  $output .= '</ul>';

  // Render the top-level DIV.
  $output = '<div class="' . $variables['classes'] . (!in_array('clearfix', $variables['classes_array']) ? ' clearfix' : '') . '"' . $variables['attributes'] .'>' . $output . '</div>';

  return $output;
}

/**
 * Return a themed breadcrumb trail.
 *
 * @param $breadcrumb
 *   An array containing the breadcrumb links.
 * @return a string containing the breadcrumb output.
 */
function opencharity_breadcrumb($variables) {
  $breadcrumb = $variables['breadcrumb'];
  if (!empty($breadcrumb)) {
    // Adding the title of the current page to the breadcrumb.
    $breadcrumb[] = drupal_get_title();
    
    // Use CSS to hide titile .element-invisible.
    $output = '<h3 class="element-invisible">' . t('You are here') . '</h3>';

    $output .= '<div class="breadcrumb">' . implode(' » ', $breadcrumb) . '</div>';
    return $output;
  }
}

/**
 *
 */
function opencharity_preprocess_image(&$variables) {
  $variables['attributes']['class'][] = 'img-responsive';
}

/**
 *
 */
function opencharity_preprocess_button(&$variables) {
  $element = &$variables['element'];

  $element['#attributes']['type'] = 'submit';

  // Add the btn class.
  $element['#attributes']['class'][] = 'btn';
}

