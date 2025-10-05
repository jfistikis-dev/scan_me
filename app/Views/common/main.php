<!DOCTYPE html>
<html lang="en">
<head>

	<meta charset="UTF-8">
	<title>Welcome to CodeIgniter 4!</title>
	<meta name="description" content="The small framework with powerful features">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" type="image/png" href="/favicon.ico"/>
	
	<link rel="stylesheet" href='<?php echo base_url("css/retail.css"); ?>'>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="<?php echo base_url("js/jquery-3.6.0.min.js") ?>"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" ></script>

    <!-- Include the plugin's CSS and JS: -->
    <script type="text/javascript" src="<?php echo base_url("js/bootstrap-multiselect.js") ?>" ></script>
    <link rel="stylesheet" href="<?php echo base_url("css/bootstrap-multiselect.css" ) ?>" type="text/css"/>

    <!-- custom JS scripts -->
    <script type="text/javascript" src="<?php echo base_url("js/retail.js") ?>" ></script>
    <script type="text/javascript" src="<?php echo base_url("js/onScan.js") ?>" ></script>

    <!-- autocomplete JS script -->
    <script type="text/javascript" src="<?php echo base_url("js/autocomplete.js") ?>" ></script>

    <!-- Jquery UI for sortable items -->
 <!--   <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css"> -->
 <!--   <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script> -->
<!-- -->
    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>

    <!-- Dymo printing software -->
    <!-- <script type="text/javascript" src="<?php echo base_url("public/js/dymo.connect.framework.js") ?>" ></script> -->

</head>
 
 
<!-- BODY & CONTENTS -->
<body >
    
	<div class="container-fluid h-100" >
		<?= $this->renderSection("content"); ?>
	</div>
</body>


 
<!-- FOOTER: DEBUG INFO + COPYRIGHTS -->
<!--
<footer class="text-center  bg-light text-muted fixed-bottom p-2">
	
    Page rendered in <b>{elapsed_time}</b> seconds in <b><?= strtoupper( ENVIRONMENT ) ?></b> environment!<br/>
    &copy; <?= date('Y') ?> CodeIgniter Foundation. CodeIgniter is open source project released under the MIT
			open source licence. 

</footer>
-->
<!-- SCRIPTS -->

    <!-- React Script -->
    <script src="https://unpkg.com/react@17/umd/react.development.js" crossorigin></script>
    <script src="https://unpkg.com/react-dom@17/umd/react-dom.development.js" crossorigin></script>


<!-- -->

</body>
</html>