 <div class="container margintop marginbottom">
    <div class="row list-group">

        <?php echo Message::show(); ?>

        <form method="post" action="<?= DIR ?>boards/" class="form-inline">
            <div class="form-group">
                <select class="form-control" id="i_user" name="i_user">
                    <option value="all">Alle Boards</option>
                    <option value="me" <?php
                    if (isset($data['set_me'])) {
                        echo "selected";
                    }
                    ?>>Nur meine Boards</option>
                </select>
            </div>
            <div class="form-group">
                <select class="form-control" id="i_category" name="i_category">
                    <?php
                    if ($data['set_catid'] == 0) {
                        echo '<option value="0" selected> Alle Kategorien </option>';
                    } else {
                        echo '<option value="0"> Alle Kategorien </option>';
                    }
                    foreach ($data['categories'] as $id => $name) {
                        if ($data['set_catid'] == $id) {
                            echo '<option value="' . $id . '" selected>' . $name . '</option>';
                        } else {
                            echo '<option value="' . $id . '">' . $name . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-default">Aktualisieren</button>
        </form>

        <?php
        if (!sizeof($data['boards'])) {
            echo Message::show("Keine Boards zu sehen :(", "info");
        } else {
            foreach ($data['boards'] as $board) {
                echo
                '<div class="item col-xs-4">
               <div class="thumbnail">
                  <a href="' . DIR . 'boards/details/' . $board['id'] . '" title="' . $board['name'] . '"><img src="' . $board['picture'] . '" alt="' . $board['name'] . '"></a>
                  <div class="buttons-edit">'; 
                    if(Session::get('UserID') == $board['ownerid']) {
                        echo'
                        <a class="btn btn-default btn-sm" href="' . DIR . 'boards/details/' . $board['id'] . '">Edit</a>
                        <a class="btn btn-default btn-sm" href="' . DIR . 'boards/delete/' . $board['id'] . '">Delete</a>';
                    } else {
                        echo '<a class="btn btn-default btn-sm formattingreasons" href="' . DIR . 'boards/details/' . $board['id'] . '">Pointless Button</a>';
                    }
           echo '</div>
                  <div class="caption">
                     <h4><a href="' . DIR . 'boards/details/' . $board['id'] . '" title="' . $board['name'] . '">' . $board['name'] . '</a></h4>
                  </div>
               </div>
            </div>';
            }
        }
        ?>

    </div> <!-- / .boards -->
</div>  <!-- / .container -->