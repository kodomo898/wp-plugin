<?php


/*** delete bom ***/
function delete_bom($str)
{
        if (ord($str{0}) == 0xef && ord($str{1}) == 0xbb && ord($str{2}) == 0xbf) {
                $str = substr($str, 3);
        }
        return $str;
}

/*** PUSH DRY ***/
function push_deploy_dry() {
            global $WPDE_lib;
            require $WPDE_lib.'cfg.php';

            echo "[テスト]本番をステージと同期しています....[テスト]";
            echo '<br>';
            echo '<br>';
            $cmd = 'rsync -avn --delete --exclude=\'/index.php\' --exclude=\'/plugins/wp-deploy\' /var/www/html/stg/wp-content/ /var/www/html/wp-content/';
            $output = shell_exec($cmd);
            echo "<div class=\"wrap2\"><pre>$output</pre></div>";
            echo '<br>';
            echo "<form action=\"admin.php?page=wp-deploy\" method=\"post\">";
            echo "<input type=\"submit\" name=\"push\" value=\"同期実行\" />";
            echo "</form>";
            echo "<input type=\"button\"  value=\"閉じる\" onclick=\"history.back()\">";
}


/*** PULL DRY ***/
function pull_deploy_dry() {
            global $WPDE_lib;
            require $WPDE_lib.'cfg.php';

            echo "[テスト]ステージを本番と同期しています....[テスト]";
            echo '<br>';
            echo '<br>';
            $cmd = 'rsync -avn --delete --exclude=\'/index.php\' --exclude=\'/plugins/wp-deploy\' /var/www/html/wp-content/ /var/www/html/stg/wp-content/';
            $output = shell_exec($cmd);
            echo "<div class=\"wrap2\"><pre>$output</pre></div>";
            echo '<br>';
            echo "<form action=\"admin.php?page=wp-deploy\" method=\"post\">";
            echo "<input type=\"submit\" name=\"pull\" value=\"同期実行\" />";
            echo "</form>";
            echo "<input type=\"button\" value=\"閉じる\" onclick=\"history.back()\">";
}


/*** PUSH real ***/
function push_deploy() {
            global $WPDE_lib;
            require $WPDE_lib.'cfg.php';

            echo "Push Start....";
            $cmd = 'rsync -av --delete --exclude=\'/index.php\' --exclude=\'/plugins/wp-deploy\' /var/www/html/stg/wp-content/ /var/www/html/wp-content/';
            $cmd_db = "mysqldump -u$db_user -p$db_pass -h$db_host $stg_db_name > ./stg.sql && echo DumpComplete";
            $cmd_db_int = "mysql -u$db_user -p$db_pass -h$db_host $prd_db_name < ./stg.sql && echo ImportComplete";
            $output = shell_exec($cmd);
            $output_db = shell_exec($cmd_db);
            $output_db_int = shell_exec($cmd_db_int);
            echo "<div class=\"wrap2\"><pre>$output $output_db $output_db_int</pre></div>";
            echo '<br>';
            echo "push complete!!!";
            echo '<br>';
            echo "<input type=\"button\"  value=\"close\" onclick=\"history.back()\">";
}


/*** PULL real ***/
function pull_deploy() {
            global $WPDE_lib;
            require $WPDE_lib.'cfg.php';

            echo "pull Start....";
            echo '<br>';
            echo '<br>';
            $cmd = 'rsync -av --delete --exclude=\'/index.php\' --exclude=\'/plugins/wp-deploy\' /var/www/html/wp-content/ /var/www/html/stg/wp-content/';
            $cmd_db = "mysqldump -u$db_user -p$db_pass -h$db_host $prd_db_name > ./prd.sql && echo DumpComplete";
            $cmd_db_int = "mysql -u$db_user -p$db_pass -h$db_host $stg_db_name < ./prd.sql && echo ImportComplete";
            $output = shell_exec($cmd);
            $output_db = shell_exec($cmd_db);
            $output_db_int = shell_exec($cmd_db_int);
            echo "<div class=\"wrap2\"><pre>$output $output_db $output_db_int</pre></div>";
            echo '<br>';
            echo "pull complete!!!";
            echo "<input type=\"button\" value=\"close\" onclick=\"history.back()\">";
}
