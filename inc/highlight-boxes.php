<?php
/**
 * Highlight Boxes for the homepage.
 *
 *
 * @package MM4 You
 */


function mm4_you_highlight_boxes() {
    if(is_page_template('frontpage-a.php') || is_page_template('frontpage-b.php') ) {

        if( function_exists('get_field') ) {

            $rows          = get_field('highlights');
            $rowCount      = count($rows);
            $addHighlights = get_field('add_highlight_boxes');

            if( $addHighlights == 'Yes' && have_rows('highlights') ): ?>

                <div id="home-highlight-wrapper" class="highlight-<?php echo $rowCount; ?>">
                    <div id="home-highlight-inner-wrapper">

                        <?php while( have_rows('highlights') ): the_row();

                            $title   = get_sub_field('highlight_title');
                            $desc    = get_sub_field('highlight_description');
                            $linkTxt = get_sub_field('highlight_link_text');
                            $url     = get_sub_field('highlight_url'); ?>

                            <div class="home-highlight">

                                <?php if($title): ?>
                                    <span class="highlight-title"><?php echo $title; ?></span>
                                <?php endif; echo "\n";

                                if($desc): ?>
                                    <span class="highlight-desc"><?php echo $desc; ?></span>
                                <?php endif; echo "\n";

                                if($url): ?>
                                    <span class="highlight-url"><a href="<?php echo $url; ?>"><?php if($linkTxt): echo $linkTxt . ' &raquo;'; else: ?>Learn More &raquo;<?php endif; ?></a></span>
                                <?php endif; echo "\n"; ?>

                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            <?php endif;
        }
    }
}