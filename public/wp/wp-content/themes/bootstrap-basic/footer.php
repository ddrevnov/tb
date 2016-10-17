<?php
/**
 * The theme footer
 * 
 * @package bootstrap-basic
 */
?>

			</div><!--.site-content-->
</div>	
<?php if (is_active_sidebar('jetzt')) { ?> 
<div class="jetzt">
 <?php dynamic_sidebar('jetzt'); ?>
</div>
<?php } ?> 
<div class="foot">
   
		<div class="container page-container">	
			<footer id="site-footer" role="contentinfo">
				<div id="footer-row" class="row site-footer">
					<div class="col-md-6 footer-left">
						<?php 
						if (!dynamic_sidebar('footer-left')) {
							printf(__('Powered by %s', 'bootstrap-basic'), 'WordPress');
							echo ' | ';
							printf(__('Theme: %s', 'bootstrap-basic'), '<a href="http://okvee.net">Bootstrap Basic</a>');
						} 
						?> 
					</div>
					
				</div>
			</footer>
		</div><!--.container page-container-->
		
</div>
<div class="foot-copy">
    <div class=" foot-copytight">
	<?php dynamic_sidebar('footer-right'); ?> 
    </div>
</div>
		<!--wordpress footer-->
		<?php wp_footer(); ?> 
	</body>
</html>