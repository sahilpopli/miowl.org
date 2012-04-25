<?php print doctype('xhtml1-strict') . "\n"; ?>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US">
<head>

    <!-- Meta Information -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="distribution" content="global" />
    <meta name="robots" content="follow, all" />
    <meta name="language" content="en" />

    <!-- Title -->
    <title>PixlDrop (Drop off &amp; Pick up)</title>

    <!-- Icon -->
    <link rel="Shortcut Icon" href="<?php print site_url('favicon.ico'); ?>" type="image/x-icon" />

    <!-- CSS -->
    <link rel="stylesheet" href="/style.css" type="text/css" media="screen" charset="utf-8" />

    <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
    <script>window.jQuery || document.write('<script src="/js/jquery.min.js"><\/script>\n<script src="/js/jquery-ui.min.js"><\/script>')</script>

    <!-- Javascript -->
    <script type="text/javascript" src="/js/uni-form.jquery.min.js"></script>
    <script type="text/javascript" src="/js/tips.js"></script>
    <script type="text/javascript" src="/js/jquery.countdown.js"></script>
    <script type="text/javascript" src="/js/pixldrop.js"></script>

</head>
<body style="background:none repeat scroll 0 0 #F2F2F2;">

<!-- wrapper -->
<div id="wrapper">

    <!-- page -->
    <div id="page">

        <!-- content -->
        <div id="content">

            <!-- message -->
            <div id="message-page">

                <div>

                <?php if (isset($success)) :     ?><h3 class="success">Success!</h3><p><?php print $msg; ?></p>
                <?php elseif (isset($error)) :     ?><h3 class="error">Error</h3><p><?php print $msg; ?></p>
                <?php else :                     ?><h3 class="info">Information</h3><p><?php print $msg; ?></p>
                <?php endif;                     ?>

                    <p>Please hold as you will be redirected in <b id='textLayout'>3</b> seconds...</p>

                </div>

                <!-- redirect to $location -->
                <script type="text/javascript">
                    setTimeout("location.href='<?php print site_url($redirect); ?>';", 3000);
                </script>

            </div>

        </div>

    </div>

</div>

<script type="text/javascript">
$(function () {
    $('#textLayout').countdown({until: +3, layout: '{sn}'});
});
</script>
</body>
</html>