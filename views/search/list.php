<section>
    <div class="container">
        <form method="post" action="<?= DIR ?>search/" class="form-inline">
            <div class="form-group">
                <select class="form-control" id="i_type" name="i_type">
                    <option value="all">Alles</option>
                    <option value="boards" <?php
                    if (isset($data['set_boards'])) {
                        echo "selected";
                    }
                    ?>>Nur Boards</option>
                    <option value="Produkte" <?php
                    if (isset($data['set_products'])) {
                        echo "selected";
                    }
                    ?>>Nur Produkte</option>
                </select>
            </div>
            <div class="form-group">
                <select class="form-control" id="i_user" name="i_user">
                    <option value="all">Von allen User</option>
                    <option value="me" <?php
                    if (isset($data['set_me'])) {
                        echo "selected";
                    }
                    ?>>Nur von mir</option>
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
            <input type="text" name="term" hidden value="<?=$data['term']?>">
            <button type="submit" class="btn btn-default">Aktualisieren</button>
        </form>
        <h3>Gefundene Produkte</h3>
        <div class="row list-group">
            <?php
            if (!sizeof($data['stuff']['products'])) {
                Message::show('Produkte nicht ausgewählt, oder keine gefunden!', "info");
            } else {
                //$data -> 'boards' -> 0 -> producte
                foreach ($data['stuff']['products'] as $product) {
                    echo
                    '<div class="item col-xs-4">
               <div class="thumbnail">
                  <a href="' . $product['source'] . '" title="' . $product['name'] . '"><img src="' . $product['picture'] . '" alt="' . $product['name'] . '"></a>
                  <div class="buttons-edit">';
                    if (Session::get('UserID') == $product['ownerid']) {
                        echo'
                        <a class="btn btn-default btn-sm" href="' . DIR . 'products/edit/' . $product['id'] . '">Bearbeiten</a>
                        <a class="btn btn-default btn-sm" href="' . DIR . 'products/delete/' . $product['id'] . '">Löschen</a>
                        <a class="btn btn-default btn-sm" href="' . DIR . 'boards/addproduct/' . $product['id'] . '">Zu Board hinzufügen</a>';
                    } else if (Session::get('UserID')) {
                        echo ' 
                        <a class="btn btn-default btn-sm" href="' . DIR . 'boards/addproduct/' . $product['id'] . '">Zu Board hinzufügen</a>';
                    } else {
                        echo '<a class="btn btn-default btn-sm formattingreasons" href="' . $product['source'] . '">Pointless Button</a>';
                    }
                    echo '
                  </div>
                  <div class="caption">
                     <h4><a href="' . $product['source'] . '" title="' . $product['name'] . '">' . $product['name'] . '</a></h4>
                     <span class="lead">' . $product['price'] . '€</span>
                  </div>
               </div>
            </div>';
                }
            }
            ?>

        </div> <!-- / .products -->
    </div>
</section>
<section>
    <div class="container">
        <h3>Gefundene Boards</h3>
        <div class="row list-group">
            <?php
            if (!sizeof($data['stuff']['boards'])) {
                echo Message::show("Boards nicht ausgewählt, oder keine gefunden :(", "info");
            } else {
                foreach ($data['stuff']['boards'] as $board) {
                    echo
                    '<div class="item col-xs-4">
               <div class="thumbnail">
                  <a href="' . DIR . 'boards/details/' . $board['id'] . '" title="' . $board['name'] . '"><img src="' . $board['picture'] . '" alt="' . $board['name'] . '"></a>
                  <div class="buttons-edit">';
                    if (Session::get('UserID') == $board['ownerid']) {
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
    </div>
</section>