            <p>{username},<br />
                Thank you for registering with us here at pixldrop.com, in order to better serve you we need to verify you're email address.
            </p>
            <p>
                Someone, hopefully you, has registered an account with us supplying this email to be validated. To do this you can use the link below, or if that does not work direct your web browser to <a href="<?php print base_url('user/validate'); ?>/{authcode}" title="PixlDrop User Validation" target="_BLANK"><?php print base_url('user/validate/'); ?></a> and enter the authorization code below.
            </p>
            <br />
            <br />
            <p>
                <strong>Authorization Code: </strong>{authcode}
            </p>