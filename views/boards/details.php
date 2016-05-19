<section>
    <div class="container boards margintop marginbottom">
        <h3><?= $data['board']['name'] ?></h3>
            <?php
            echo Message::show();
            $board = $data['board'];
            if (Session::get('UserID') == $board['ownerid'] || Session::get('UserRole') == "admin") :
                echo Message::show("You are in edit mode.", "info");
                ?>
                <!--Board-Form-->
                <form method="post" action="<?= DIR ?>boards/insert/<?= $board['id'] ?>" class="form-inline">
                    <a class="btn btn-success" href="<?= DIR ?>products/addtoboard/<?= $board['id'] ?>">Produkt hinzufügen</a>
                    <div class="form-group">
                        <input type="text" class="form-control" id="i_board" name="i_board" placeholder="Board-Name" value="<?= $board['name'] ?>">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="i_boardcat" name="i_boardcat" placeholder="Board-Kategorie" value="<?= $board['category'] ?>">
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="url" name="i_bpicture" placeholder="Board-Bild" value="<?= $board['picture'] ?>">
                    </div>
                    <button type="submit" class="btn btn-default">Board aktualisieren</button>
                </form>
                <?php
                //Products
                if (!sizeof($data['products'])) {
                    echo Message::show("Keine Produkte auf diesem Board", "info");
                } else {
                    foreach ($data['products'] as $product) {
                        echo
                        '<!--Product-Data-->
                          <div class="item col-xs-4">
                                    <div class="thumbnail">
                                        <a href="' . $product['source'] . '" title="' . $product['name'] . '"><img src="' . $product['picture'] . '" alt="' . $product['name'] . '"></a>
                                            <div class="buttons-edit">';
                        if ($product['ownerid'] == Session::get('UserID')) {
                            echo '
                              <a class="btn btn-default btn-sm" href="' . DIR . 'products/edit/' . $product['id'] . '">Bearbeiten</a>
                              <a class="btn btn-default btn-sm" href="' . DIR . 'products/delete/' . $product['id'] . '">Löschen</a>
                              <a class="btn btn-default btn-sm" href="' . DIR . 'boards/addproduct/' . $product['id'] . '">Zu Board hinzufügen</a>
                              <a class="btn btn-default btn-sm" href="' . DIR . 'boards/removeproduct/' . $board['id'] . '/' . $product['id'] . '">Vom Board löschen</a>';
                        } else {
                            echo '
                              <a class="btn btn-default btn-sm" href="' . DIR . 'boards/addproduct/' . $product['id'] . '">Zu Board hinzufügen</a>
                              <a class="btn btn-default btn-sm" href="' . DIR . 'boards/removeproduct/' . $board['id'] . '/' . $product['id'] . '">Vom Board löschen</a>';
                        }
                        echo '</div>
                                    <div class="caption">
                                        <h4><a href="' . $product['source'] . '" title="' . $product['name'] . '">' . $product['name'] . '</a></h4>
                                      <span class="lead">' . $product['price'] . '€</span>
                                    </div>
                              </div>
                          </div>';
                    }
                }
            else :
                //Products
                if (!sizeof($data['products'])) {
                    echo Message::show("Keine Produkte auf diesem Board", "info");
                } else {
                    foreach ($data['products'] as $product) {
                        echo
                        '<!--Product-Data-->
                            <div class="item col-xs-4">
                                    <div class="thumbnail">
                                        <a href="' . $product['source'] . '" title="' . $product['name'] . '"><img src="' . $product['picture'] . '" alt="' . $product['name'] . '"></a>';
                        if (Session::get('UserID')) {
                            echo '
                                         <div class="buttons-edit">
                                            <a class="btn btn-default btn-sm" href="' . DIR . 'boards/addproduct/' . $product['id'] . '">Zu Board hinzufügen</a>
                                         </div>';
                        }
                        echo '    
                                     <div class="caption">
                                      <h4><a href="' . $product['source'] . '" title="' . $product['name'] . '">' . $product['name'] . '</a></h4>
                                      <span class="lead">' . $product['price'] . '€</span>
                                     </div>
                                    </div>
                                </div>';
                    }
                }

            endif;
            ?>
    </div><!--container-->
</section>




