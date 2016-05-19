 <div class="container boards margintop marginbottom">
    <div class="row list-group boards">
        <div class="panel-heading">
            <h3 class="panel-title"><?= $data['main_heading'] ?></h3>
            <a href="<?= DIR ?>products/"><span class="glyphicon glyphicon-chevron-left"></span> Hinzufügen beenden</a>
        </div>
        <?php echo Message::show(); ?>
        <form method="post" action="<?= DIR ?>boards/addproduct/<?= $data['productid'] ?>" class="form-inline">
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
                if ($board['ownerid'] == Session::get('UserID')) {
                    echo
             '<div class="item col-xs-4">
               <div class="thumbnail">
                  <a href="' . DIR . 'boards/details/' . $board['id'] . '" title="' . $board['name'] . '"><img src="' . $board['picture'] . '" alt="' . $board['name'] . '"></a>
                  <div class="buttons-edit">
                  <a class="btn btn-default btn-sm" href="' . DIR . 'boards/addproduct/' . $data['productid'] . '/' . $board['id'] . '">Produkt hier einfügen</a>
                  </div>
                  <div class="caption">
                     <h4><a href="' . DIR . 'boards/details/' . $board['id'] . '" title="' . $board['name'] . '">' . $board['name'] . '</a></h4>
                  </div>
               </div>
            </div>';
                }
            }
        }
        ?>

    </div> <!-- / .boards -->
</div>  <!-- / .container -->