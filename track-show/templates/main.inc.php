<?php if (!$include_flag){exit();} ?>
<!-- CPA Tracker, http://www.cpatracker.ru -->
<!DOCTYPE html>
<html lang="en">
    <head>
        <? include ('head.inc.php'); ?>
    </head>

    <body>
        <div id="wrap">
            <?php include "menu-top.inc.php"; ?>
            <div class="container">
                <div class="row">
                    <?php 
                        if (in_array($page_sidebar, $page_sidebar_allowed))
                        {
                            include ($page_sidebar);
                        }
                        else
                        {
                            include ('sidebar-left.inc.php');
                        }

                        if ($bHideLeftSidebar!==true){$main_container_class='col-sm-9';} else{$main_container_class='col-sm-12';}
                    ?>
                    <div class="<?=$main_container_class?>">
                        <?php
                            if (in_array($page_content, $page_content_allowed))
                            {
                                include (dirname (__FILE__).'/../'.$page_content);
                            }
                        ?>
                    </div>
                </div> <!-- /row -->
            </div> <!-- /container -->
        </div> <!-- /wrap -->

        <div id="footer">
            <?php include "footer.inc.php"; ?>
        </div>
    </body>
</html>