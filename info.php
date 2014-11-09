<?php include('header.php');?>
<div class="row">
    <div class="col-md-12">
        <div class="control-group">
            <div class="controls">
                <p>Currently selected event: <b>
                    <?php
                    $userid = $a->getUid();

                    if (isset($_POST["no_ev"]))
                    $a->unsetEvent();

                    if (isset($_POST["ev"])) {
                        $evento = $a->setEvent($userid, $_POST["ev"]);
                        echo $evento;
                    }
                    else {
                        if  (isset( $_SESSION['event_name']))
                        echo  $_SESSION['event_name'];
                        else
                        echo "nessuno";
                    }
                    ?>
                </b></p>
                <?php if(isset($_POST["ev"]) || isset( $_SESSION['event_name'])): ?>
                    <form  class="form-horizontal" id="form_u" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <fieldset>
                            <input type="hidden" name="no_ev" value="null">
                            <input  class="btn btn-default" type="submit" value="Leave event">
                        </fieldset>
                    </form>
                <?php endif; ?>
                Seleziona evento:<br/>
                <form  class="form-horizontal" id="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <fieldset>
                        <select name="ev" class="form-control">
                            <?php
                            $result = $a->getEventsByUser($userid);
                            foreach ($result as $entry)
                            echo "<option value=\"".$entry['id']."\">". $entry['name']."</option>\n";
                            ?>
                        </select>
                        <input  class="btn btn-default" type="submit" value="Submit">

                    </fieldset>
                </form>
            </div>
        </div>

    </div>
</div>
<?php include('footer.php');?>
