<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">

    <!-- Title -->
    <title><?php if(isset($page_title)) print $page_title . ' | ' ?>MiOWL (Something else here!)</title>

    <!-- Icon -->
    <link rel="Shortcut Icon" href="<?php print site_url('favicon.ico'); ?>" type="image/x-icon" />

    <!-- CSS -->
    <link rel="stylesheet" href="<?php print site_url('/style.css'); ?>" type="text/css" media="screen" charset="utf-8" />

</head>
<body>

<div id="container">

<?php $this->load->view('template/nav'); ?>

	<h1>
		<img 
			src="<?php print site_url('images/miowl_red_black_small.png');?>"
			alt="MiOWL Logo"
			title="MiOWL Logo"
			width="500"
			height="205"
		>
	</h1>
