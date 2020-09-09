<header class="alt-header alt-header--top">
  <div class="alt-container alt-header__container">

    <a class="alt-header__logo__link" href="<?php echo esc_attr(get_site_url()); ?>">
      <?php
      // $logo_url = get_template_directory_uri().'/images/alt-logo-6.png';

      if ( has_custom_logo() ) {
        $custom_logo_id = get_theme_mod( 'custom_logo' );
        $logo_url = wp_get_attachment_image_src( $custom_logo_id , 'full' );
        $logo_url = $logo_url[0];
        echo '<img class="alt-header__logo" src="'.esc_attr($logo_url).'" />';
      }else{
        echo get_bloginfo("name");
      }

      ?>
    </a>

  <nav class="alt-header__left">
    <a class="alt-header__left__menu-trigger" href="#" onclick="jQuery('#hamburger-show-menu').trigger('click'); return false;" data-menu-text="<?php _e("Menu", "altminimo"); ?>" data-menu-close="<?php _e("Close", "altminimo"); ?>" role="button" aria-expanded="true"><?php _e("Menu", "altminimo"); ?></a>
    <span class="alt-header__separator alt-separator">/</span>
    <a href="#" data-toggle="modal" data-target="#alt-modal"><i class="fas fa-search"></i></a>
  </nav>
  <div class="alt-header__search__cover" onclick="document.body.classList.remove('search--open'); return false;"></div>
  <nav class="alt-header__right">
    <div class="alt-header__social-icons alt-social-hovers">
      <div class="alt-social-hovers__item"></div>
      <div class="alt-social-hovers__item"></div>
      <div class="alt-social-hovers__item"></div>
    </div>
    <div class="alt-header__donate alt-hide">
      <a href="#"><?php _e("Donate", "altminimo"); ?></a>
      <span class="header__separator alt-separator">/</span>
    </div>
    <?php
    $alt_suscription_url = esc_attr(get_option( "alt_suscription_url" ));
    $alt_subscriptionButtonText = esc_attr(get_option( "alt_subscriptionButtonText" ));
    if (!empty($alt_suscription_url)){
    ?>
      <div class="alt-header__newsletter">
        <a target="_blank" href="<?php echo $alt_suscription_url; ?>">
          <i class="fas fa-paper-plane hide-730"></i>
          <?php
          $buttonText = __("Subscribe", "altminimo");
          if (!empty($alt_subscriptionButtonText)) $buttonText = $alt_subscriptionButtonText;
          echo $buttonText;
          ?>
        </a>
      </div>
    <?php
    }
    ?>
    <span class="alt-header__separator alt-separator alt-hide">/</span>
    <div class="alt-header__user alt-header__user--anonymous alt-hide">
      <div class="alt-user-nav">
        <a class="alt-header__sign-in" href="#" title="Sign In">
          <svg viewBox="0 0 24 24" fill="currentColor"><path fill="none" d="M0 0h24v24H0V0z"></path><g><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v1c0 .55.45 1 1 1h14c.55 0 1-.45 1-1v-1c0-2.66-5.33-4-8-4z"></path></g></svg>
          <span><?php _e("Enter", "altminimo"); ?></span>
        </a>
      </div>
    </div>
  </nav>
  </div>
</header>

<?php $secondary_menu = wp_nav_menu( array( 'theme_location' => 'secondary', 'echo' => false ) );  ?>
<div id="fullscreen-menu">
  <div class="menu-inner">
    <nav class="menu-nav menu-nav-primary">
      <?php
      wp_nav_menu( array( 'theme_location' => 'primary' ) );
      if ( has_nav_menu( "secondary" ) ) {
        echo '<ul><li id="menu-item-more" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-more"><a class="menu-item-button-more" href="#" aria-expanded="true" role="button"><i class="fas fa-plus"></i></a></li></ul>';
      }
      ?>
    </nav>
    <?php

    if ($secondary_menu){
    ?>
      <nav class="menu-nav menu-nav-secondary alt-hide">
        <?php
        echo $secondary_menu;
        echo '<ul><li id="menu-item-more" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-more"><a class="menu-item-button-back" href="#" aria-expanded="true" role="button"><i class="fas fa-reply"></i></a></li></ul>';
        ?>
      </nav>
    <?php
    }

    $alt_whatsapp_url = esc_attr(get_option( "alt_whatsapp_url" ));
    $alt_us_url = esc_attr(get_option( "alt_us_url" ));
    ?>

    <div class="social">
      <div class="social-icons">
        <?php
        if (!empty($alt_whatsapp_url)){
        ?>
          <a href="<?php echo $alt_whatsapp_url; ?>" target="_blank" class="icon">
            <i class="fab fa-whatsapp-square fa-lg"></i>
          </a>
        <?php
        }
        if (!empty($alt_us_url)){
        ?>
          <div class="langs icon">
            <a href="<?php echo $alt_us_url; ?>"><?php _e("US", "altminimo"); ?></a>
          </div>
        <?php
        }
        ?>
      </div>
    </div>
  </div>
</div>
<a href="#" class="back-to-the-future"><i class="fas fa-angle-double-up"></i></a>
