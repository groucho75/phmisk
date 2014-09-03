<?php include __DIR__.'/header.php' ?>

	<?php // You can insert here page js/css ?>

    </head>
    <body>

		<?php include __DIR__.'/top_navbar.php' ?>
	
		<div class="container">
			<div class="page-header">
				<h1><span class="glyphicon <?php echo ( isset($glyphicon) ) ? $glyphicon: 'glyphicon-asterisk'?> "></span> <?=$title?></h1>
			</div>
			
			<?php echo $html ?>
			
		</div>


<?php include __DIR__.'/footer.php' ?>
