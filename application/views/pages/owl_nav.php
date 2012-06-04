<?php $uri = $this->uri->segment(1); ?>
	<ul>

		<li>
			MiOwl
			<ul>
				<li><a class="owl_nav_button" href="<?php print site_url(); ?>">details</a></li>
<?php if ($uri === 'owl' && $this->session->userdata('admin')) : ?>
				<li><a class="owl_nav_button" href="<?php print site_url('owl/edit_details'); ?>">edit details</a></li>
<?php endif; ?>
				<li style="list-style-type: none">&nbsp;</li>
			</ul>
		</li>

		<li>
			members
			<ul>
				<li>
					<a class="owl_nav_button" href="<?php print site_url($uri . '/members'); ?>">list</a>
					<ul>
						<li><a class="owl_nav_button" href="<?php print site_url($uri . '/members/admin'); ?>">admins</a></li>
						<li><a class="owl_nav_button" href="<?php print site_url($uri . '/members/editor'); ?>">editors</a></li>
						<li><a class="owl_nav_button" href="<?php print site_url($uri . '/members/user'); ?>">users</a></li>
					</ul>
				</li>
<?php if($uri === 'owl') : if ($this->session->userdata('admin')) : ?>
				<li><a class="owl_nav_button" href="<?php print site_url('owl/members/requests'); ?>">requests</a></li>
<?php endif; ?>
				<li><a class="owl_nav_button" href="<?php print site_url('owl/members/invite'); ?>">invite</a></li>
<?php endif; ?>
				<li style="list-style-type: none">&nbsp;</li>
			</ul>
		</li>

		<li>
			categories
			<ul>
				<li><a class="owl_nav_button" href="<?php print site_url($uri . '/categories'); ?>">list</a></li>
<?php if ($uri === 'owl' && $this->session->userdata('admin')) : ?>
				<li><a class="owl_nav_button" href="<?php print site_url('owl/categories/organize'); ?>">organize</a></li>
				<li><a class="owl_nav_button" href="<?php print site_url('owl/categories/create'); ?>">create</a></li>
<?php endif; ?>
				<li style="list-style-type: none">&nbsp;</li>
			</ul>
		</li>

		<li>
			uploads
			<ul>
				<li><a class="owl_nav_button" href="<?php print site_url($uri . '/uploads'); ?>">browse</a></li>
<?php if($uri === 'owl') : if ($this->session->userdata('editor')) : ?>
				<li><a class="owl_nav_button" href="<?php print site_url('owl/uploads/upload'); ?>">upload</a></li>
<?php endif; if ($this->session->userdata('admin')) : ?>
				<li><a class="owl_nav_button" href="<?php print site_url('owl/uploads/bin'); ?>">recycle bin</a></li>
<?php endif; endif; ?>
				<li style="list-style-type: none">&nbsp;</li>
			</ul>
		</li>

	</ul>