<section>
    <div class = "jumbotron">
        <?php echo Message::show(); ?>
        <div class="container">
            <h1>Willkommen bei <span>Splendr</span></h1>
            <h5>Suchen. Sammeln. (Wieder-) Finden!</h5>
            <p>
                Kennen Sie das auch?  Sie finden <span>den</span> Gegenstand, 
                den Sie <span>unbedingt</span> (aber nicht jetzt) haben möchten,
                doch die Lesezeichenleiste ist voll und die Festplatte quillt über
                von gesammelten Merklisten? Splendr hilft!
            </p>
            <a href="#" role="button">Erfahren Sie mehr!</a>
        </div>
    </div>
</section>
<section>
    <div class="container">
        <h3>Aufsteigende Produkte</h3>
        <div class="row list-group products">
            <?php
            if (!sizeof($data['products'])) {
                Message::show('Derzeit gibt es keine Produkte!', "info");
            } else {
                foreach ($data['products'] as $product) {
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
        <h3>Aufsteigende Boards</h3>
        <div class="row list-group boards">
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