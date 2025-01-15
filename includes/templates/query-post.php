<div class="wrap">
    <h2>Query Posts</h2>
    <form action="<?php echo admin_url() . '/admin.php?page=wd_query_post'; ?>" method="GET">
        <input type="hidden" name="page" value="wd_query_post">
        <div class="tablenav top">
            <div class="alignleft actions">
                <select name="filter_cat" id="cat" class="postform">
                    <option value="0">All Categories</option>
                    <?php foreach ( $terms as $term): ?>
                        <option value="<?php echo $term->term_id; ?>" <?php echo $term->term_id == $filter_cat ? 'selected' : ''; ?> ><?php echo $term->name; ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="submit" id="post-query-submit" class="button" value="Filter">
            </div>
        </div>
    </form>
    <table class="wp-list-table widefat fixed striped table-view-list posts">
        <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Categories</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($posts as $post): ?>
            <tr data-id="<?php echo $post->ID; ?>">
                <td><?php echo $post->post_title; ?></td>
                <td>
                    <?php 
                        $user = get_user_by( 'id', $post->post_author );
                        echo $user->display_name;
                    ?>
                </td>
                <td>
                    <?php 
                        // $terms = wp_get_post_terms( $post->ID, 'category' );
                        // $term_name = array_map( function( $term ) {
                        //     return $term->name;
                        // }, $terms );
                        // echo implode( ', ', $term_name );

                        $t = get_the_terms( $post, 'category' );
                        $t = array_map( function( $t ) {
                            return $t->name;
                        } , $t );
                        echo implode( ', ', $t );
                    ?>
                </td>
                <td><?php echo human_time_diff( strtotime( $post->post_date ) ); ?> ago</td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>