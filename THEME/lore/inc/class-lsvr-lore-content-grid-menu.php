<?php
/**
 * Content Grid menu walker
 */
if ( ! class_exists( 'Lsvr_Lore_Content_Grid_Menu_Walker' ) ) {
    class Lsvr_Lore_Content_Grid_Menu_Walker extends Walker_Nav_Menu {

        function start_lvl( &$output, $depth = 1, $args = [] ) {
            $output .= '<ul class="folder-links">';
        }

        function end_lvl( &$output, $depth = 0, $args = [] ) {
            $output .= '</ul>';
        }

        function start_el( &$output, $item, $depth = 0, $args = [], $id = 0 ) {

            ob_start(); ?>

            <?php if ( 0 === $depth ) : ?>

                <li class="brick-item">
                    <div class="brick-item-inner">

                        <!-- FOLDER : begin -->
                        <div class="c-folder">

                            <!-- FOLDER HEADER : begin -->
                            <header class="folder-header">

                                <?php // FOLDER ICON
                                if ( ! empty( $item->description ) ) : ?>
                                    <i class="folder-icon <?php echo esc_attr( $item->description ); ?>"></i>
                                <?php endif; ?>
                                <h3 class="folder-title"><a href="<?php echo esc_url( $item->url ); ?>"<?php echo ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) . '"' : ''; ?>>
                                    <?php echo esc_attr( $item->title ); ?></a>
                                </h3>

                            </header>
                            <!-- FOLDER HEADER : end -->

            <?php else : ?>

                <li class="folder-link">

                    <a href="<?php echo esc_url( $item->url ); ?>"<?php echo ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) . '"' : ''; ?>>
                        <?php echo esc_attr( $item->title ); ?>
                    </a>

            <?php endif; ?>

            <?php $output .= ob_get_clean();

        }

        function end_el( &$output, $item, $depth = 0, $args = [] ) {

            ob_start(); ?>

            <?php if ( 0 === $depth ) : ?>

                        </div>
                        <!-- FOLDER : end -->

                    </div>
                </li>

            <?php else : ?>

                </li>

            <?php endif; ?>

            <?php $output .= ob_get_clean();

        }

    }
} ?>