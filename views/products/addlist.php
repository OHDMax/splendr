<section>
     <div class="container margintop marginbottom">
        <div class="row list-group products">
            <div class="panel-heading">
                <h3 class="panel-title"><?= $data['main_heading'] ?></h3>
            </div>
            <a href="<?= DIR ?>boards/"><span class="glyphicon glyphicon-chevron-left"></span> Hinzufügen beenden</a>
            <?php echo Message::show(); ?>
            <form method="post" action="<?= DIR ?>products/addtoboard/<?= $data['boardid'] ?>" class="form-inline">
                <div class="form-group">
                    <select class="form-control" id="i_user" name="i_user">
                        <option value="all">Alle Produkte</option>
                        <option value="me" <?php
                        if (isset($data['set_me'])) {
                            echo "selected";
                        }
                        ?>>Nur meine Produkte</option>
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
            if (!sizeof($data['products'])) {
                Message::show('Derzeit gibt es keine Produkte!', "info");
            } else {
                foreach ($data['products'] as $product) {
                    echo
                    '<div class="item col-xs-4">
                       <div class="thumbnail">
                          <a href="' . $product['source'] . '" title="' . $product['name'] . '"><img src="' . $product['picture'] . '" alt="' . $product['name'] . '"></a>
                          <div class="buttons-edit"> 
                            <a class="btn btn-default btn-sm" href="' . DIR . 'boards/addproduct/' . $product['id']. '/'. $data['boardid'] . '">Zu Board hinzufügen</a>
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