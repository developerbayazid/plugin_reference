<div class="shortcode-wrapper form-<?php echo $args['id']; ?>">
    <h2><?php echo  esc_html( $args['title'] ); ?></h2>
</div>

<style>
    .shortcode-wrapper {
        padding: 20px;
        border-radius: 6px;
    }
    .form-<?php echo $args['id']; ?> {
        border: 1px solid <?php echo $args['color']; ?>;
    }
</style>