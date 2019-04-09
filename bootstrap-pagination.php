<?php

function bootstrap_pagination(\WP_Query $wp_query = null)
{
    if (!$wp_query) {
        global $wp_query;
    }

    /**
     * Reference: https://codex.wordpress.org/Function_Reference/paginate_links
     */
    $pages = paginate_links([
        'base'    => str_replace(999999999, '%#%', esc_url(get_pagenum_link($big))),
        'format'  => '?paged=%#%',
        'total'   => $wp_query->max_num_pages,
        'current' => max(1, get_query_var('paged')),
        'type'    => 'array',
    ]);

    if (is_array($pages)) {
        $pagination = [];

        foreach ($pages as $page) {
            if (false !== strpos($page, 'current')) {
                $state = 'active';
            } elseif (false !== strpos($page, 'dots')) {
                $state = 'disabled';
            } else {
                $state = '';
            }

            $page_link = str_replace('page-numbers', 'page-link', $page);

            $page_item = sprintf(
                '<li class="page-item %s">%s</li>'
                , $state
                , $page_link
            );

            $pagination[] = $page_item;
        }

        $pagination = implode('', $pagination);

        return '<ul class="pagination justify-content-center">'.$pagination.'</ul>';
    }
}
