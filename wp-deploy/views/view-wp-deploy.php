<meta charset="utf-8n">
<div class="wrap">
<h2>WP-Deploy</h2>
	<p>Wordpressのstg環境とprd環境を同期することができます。</p>
<?php
    if(isset($_POST['push_dry'])) {
            push_deploy_dry();
    }
    else if(isset($_POST['push'])) {
            push_deploy();
    }
    else if(isset($_POST['pull_dry'])) {
            pull_deploy_dry();
    }
    else if(isset($_POST['pull'])) {
            pull_deploy();
    }else{   
?>

<form action="admin.php?page=wp-deploy" method="post">
    <p>ステージ -> 本番</p>
    <input type="submit" name="push_dry" value="push" /> 
	<br>
    <p>本番 -> ステージ</p>
    <input type="submit" name="pull_dry" value="pull" />
</form>
</div>


<?php
    }
?>
