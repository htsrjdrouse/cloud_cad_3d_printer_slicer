<? session_start(); ?>
<?
if (isset($_SESSION['scadview'])) {
?>
it works
<?
    // Access the 'scadview' key here
} else {
	// Handle the case where the 'scadview' key is not set
?>
no
<?
 $_SESSION['scadview'] = "testing";
}
?>
