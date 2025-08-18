<?php
/**
 * Template Name: Custom Home
 */

get_header(); ?>

<main id="maincontent" role="main">
  <?php do_action( 'vw_health_coaching_before_slider' ); ?>

  <?php if( get_theme_mod( 'vw_health_coaching_slider_hide_show', false) == 1 || get_theme_mod( 'vw_health_coaching_resp_slider_hide_show', false) == 1) { ?>

    <section id="slider">
      <?php if(get_theme_mod('vw_health_coaching_slider_type', 'Default slider') == 'Default slider' ){ ?>
      <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel" data-bs-interval="<?php echo esc_attr(get_theme_mod( 'vw_health_coaching_slider_speed',4000)) ?>"> 
        <?php $vw_health_coaching_slider_pages = array();
          for ( $count = 1; $count <= 3; $count++ ) {
            $mod = intval( get_theme_mod( 'vw_health_coaching_slider_page' . $count ));
            if ( 'page-none-selected' != $mod ) {
              $vw_health_coaching_slider_pages[] = $mod;
            }
          }
          if( !empty($vw_health_coaching_slider_pages) ) :
            $args = array(
              'post_type' => 'page',
              'post__in' => $vw_health_coaching_slider_pages,
              'orderby' => 'post__in'
            );
            $query = new WP_Query( $args );
            if ( $query->have_posts() ) :
              $i = 1;
        ?>     
        <div class="carousel-inner" role="listbox">
          <?php  while ( $query->have_posts() ) : $query->the_post(); ?>
            <div <?php if($i == 1){echo 'class="carousel-item active"';} else{ echo 'class="carousel-item"';}?>>
              <?php if(has_post_thumbnail()){
                the_post_thumbnail();
              } else{?>
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/block-patterns/images/banner.png" alt="" />
              <?php } ?>
              <div class="carousel-caption">
                <div class="inner_carousel">
                  <?php if( get_theme_mod('vw_health_coaching_slider_title_hide_show',true) == 1){ ?>
                    <h1 class="wow zoomInUp" data-wow-duration="2s"><a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php echo the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
                  <?php } ?>
                  <?php if( get_theme_mod('vw_health_coaching_slider_content_hide_show',true) == 1){ ?>
                    <p class="wow slideInRight" data-wow-duration="2s"><?php $vw_health_coaching_excerpt = get_the_excerpt(); echo esc_html( vw_health_coaching_string_limit_words( $vw_health_coaching_excerpt, esc_attr(get_theme_mod('vw_health_coaching_slider_excerpt_number','30')))); ?></p>
                  <?php } ?>
                  <?php if( get_theme_mod('vw_health_coaching_slider_button_text','READ MORE') != ''){ ?>
                    <div class="more-btn wow zoomInUp" data-wow-duration="2s">
                      <a class="view-more" href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_html(get_theme_mod('vw_health_coaching_slider_button_text',__('READ MORE','vw-health-coaching')));?><i class="<?php echo esc_attr(get_theme_mod('vw_health_coaching_sliders_button_icon','fa fa-angle-right')); ?>"></i>
                      <span class="screen-reader-text"><?php echo esc_html(get_theme_mod('vw_health_coaching_slider_button_text',__('READ MORE','vw-health-coaching')));?></span></a>
                    </div>
                  <?php } ?>
                </div>
              </div>
            </div>
          <?php $i++; endwhile; 
          wp_reset_postdata();?>
        </div>
        <?php else : ?>
          <div class="no-postfound"></div>
        <?php endif;
        endif;?>
        <?php if(get_theme_mod('vw_health_coaching_slider_arrow_hide_show', true)){?>
          <a class="carousel-control-prev" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev" role="button">
            <span class="carousel-control-prev-icon w-auto h-auto" aria-hidden="true"><i class="<?php echo esc_attr(get_theme_mod('vw_health_coaching_slider_prev_icon','fas fa-chevron-left')); ?>"></i></span>
            <span class="screen-reader-text"><?php esc_html_e( 'Previous','vw-health-coaching' );?></span>
          </a>
          <a class="carousel-control-next" data-bs-target="#carouselExampleCaptions" data-bs-slide="next" role="button">
            <span class="carousel-control-next-icon w-auto h-auto" aria-hidden="true"><i class="<?php echo esc_attr(get_theme_mod('vw_health_coaching_slider_next_icon','fas fa-chevron-right')); ?>"></i></span>
            <span class="screen-reader-text"><?php esc_html_e( 'Next','vw-health-coaching' );?></span>
          </a>
        <?php }?>
      </div>
      <div class="clearfix"></div>
        <?php } else if(get_theme_mod('vw_health_coaching_slider_type', 'Advance slider') == 'Advance slider'){?>
          <?php echo do_shortcode(get_theme_mod('vw_health_coaching_advance_slider_shortcode')); ?>
        <?php } ?>
    </section>

  <?php } ?>

  <?php do_action( 'vw_health_coaching_after_slider' ); ?>

  <?php if(get_theme_mod('vw_health_coaching_services') != ''){ ?>

  <section id="service-sec">
    <div class="row m-0">
      <?php
        $vw_health_coaching_catData =  get_theme_mod('vw_health_coaching_services','');
        if($vw_health_coaching_catData){
        $page_query = new WP_Query(array( 'category_name' => esc_html($vw_health_coaching_catData,'vw-health-coaching'))); ?>
        <?php while( $page_query->have_posts() ) : $page_query->the_post(); ?>
          <div class="col-lg-4 col-md-4 category_main p-0 wow zoomInUp" data-wow-duration="2s">
            <div class="catgory-box">
              <?php the_post_thumbnail(); ?>
              <h2><?php the_title(); ?></h2>
              <p><?php $vw_health_coaching_excerpt = get_the_excerpt(); echo esc_html( vw_health_coaching_string_limit_words( $vw_health_coaching_excerpt, esc_attr(get_theme_mod('vw_health_coaching_services_excerpt_number','30')))); ?></p>
              <?php if( get_theme_mod('vw_health_coaching_services_button_text','READ MORE') != ''){ ?>
                <div class="more-btn">
                  <a class="view-more" href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_html(get_theme_mod('vw_health_coaching_services_button_text',__('READ MORE','vw-health-coaching')));?><i class="<?php echo esc_attr(get_theme_mod('vw_health_coaching_services_button_icon','fa fa-angle-right')); ?>"></i>
                  <span class="screen-reader-text"><?php echo esc_html(get_theme_mod('vw_health_coaching_services_button_text',__('READ MORE','vw-health-coaching')));?></span></a>
                </div>
              <?php } ?>
            </div>
          </div>
        <?php endwhile;
        wp_reset_postdata();
      } ?>
    </div>
  </section>

  <?php }?>

  <?php do_action( 'vw_health_coaching_after_services' ); ?>

  <div class="content-vw">
    <div class="container">
      <?php while ( have_posts() ) : the_post(); ?>
        <?php the_content(); ?>
      <?php endwhile; // end of the loop. ?>
    </div>
  </div>
</main>

<?php get_footer(); ?>