<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="row">
        <div class="col-md-4">
            <?php echo get_the_post_thumbnail($page->ID, 'medium'); ?>
        </div>
        <div class="col-md-8">
            <h1 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
            <?php the_excerpt(); ?> 
        </div>
        <div class="col-md-12">
            <?php if ('post' == get_post_type()) { ?> 
		<div class="entry-meta">
			<?php bootstrapBasicPostOn(); ?> 
		</div><!-- .entry-meta -->
		<?php } //endif; ?> 
        </div>
    </div>
</article><!-- #post-## -->
    
    
