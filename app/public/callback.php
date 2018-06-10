<div id="access_token"><?= $_GET['access_token'] ?></div>

<script type="text/javascript">
	window.opener.NN.recieve_token(document.getElementById('access_token').innerHTML, <?= ($_GET['callback'] == TRUE ? 'true' : 'false') ?>);
</script>