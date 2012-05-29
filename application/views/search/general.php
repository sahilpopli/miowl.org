<?php $this->load->view('template/header'); ?>

	<h1>
		<center>
			<?php print $page_title; ?>
		</center>
	</h1>

	<div id="body">
        <div id="owl_nav" class="column left quarter">
            <?php $this->load->view('search/_nav'); ?>
        </div>
        <div id="owl_body" class="column right threequarter">

            <div class="column left third">

                <div>
                    <h2>General Site Search</h2>
                    <div>
                    	<?php if($query) : ?>
                    		<?php print $this->table->generate($query); ?>
                    	<?php else : ?>
                    		FALSE
                    	<?php endif; ?>
                    </div>

                    <!-- pagination -->
                    <div class="pagination">
                        <center><?php print $this->pagination->create_links(); ?></center>
                    </div>
                </div>

            </div>

        </div>
        <div class="clear">&nbsp;</div>
    </div>

<?php $this->load->view('template/footer'); ?>
