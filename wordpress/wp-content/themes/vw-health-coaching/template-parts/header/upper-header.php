<?php
/**
 * The template part for topbar
 *
 * @package VW Health Coaching 
 * @subpackage vw_health_coaching
 * @since VW Health Coaching 1.0
 */
?>
<?php if( get_theme_mod( 'vw_health_coaching_topbar_hide_show', false) == 1 || get_theme_mod( 'vw_health_coaching_resp_topbar_hide_show', false) == 1) { ?>
    <div id="topbar">
        <div class="container">
        	<div class="row">
                <div class="col-lg-8 col-md-8">
                    <div class="row">
                    	<div class="col-lg-3 col-md-3">
                    		<?php if(get_theme_mod('vw_health_coaching_phone') != ''){ ?>
                                <i class="<?php echo esc_attr(get_theme_mod('vw_health_coaching_phone_icon','fas fa-phone')); ?>"></i><span><a href="tel:<?php echo esc_attr( get_theme_mod('vw_health_coaching_phone','') ); ?>"><?php echo esc_html(get_theme_mod('vw_health_coaching_phone',''));?></a></span>
                            <?php }?>
                	    </div>
                    	<div class="col-lg-4 col-md-4">
                    		<?php if(get_theme_mod('vw_health_coaching_email_address') != ''){ ?>
                    			<i class="<?php echo esc_attr(get_theme_mod('vw_health_coaching_email_icon','fas fa-envelope')); ?>"></i><span><a href="mailto:<?php echo esc_attr(get_theme_mod('vw_health_coaching_email_address',''));?>"><?php echo esc_html(get_theme_mod('vw_health_coaching_email_address',''));?></a></span>
                    		<?php }?>
                    	</div>
                    	<div class="col-lg-5 col-md-5">
                            <?php if(get_theme_mod('vw_health_coaching_timing') != ''){ ?>
                                <i class="<?php echo esc_attr(get_theme_mod('vw_health_coaching_timing_icon','fas fa-clock')); ?>"></i><span><?php echo esc_html(get_theme_mod('vw_health_coaching_timing',''));?></span>
                            <?php }?>
                    	</div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <?php dynamic_sidebar('social-widget'); ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>