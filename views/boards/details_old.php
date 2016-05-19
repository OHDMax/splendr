
<section>
    <div class="container">
        <h3><?= $data['title'] . $data['bname'] ?></h3>
        <div class="well">
            <?php
            echo Message::show();
            echo  '<a class="btn btn-default btn-sm" href="' . DIR . 'products/addtoboard/'.$data['bid'].'">Produkt hinzufügen</a>';
            if (!sizeof($data['products'])) {
                echo Message::show("Keine Produkte auf diesem Board", "info");
            } else {
                foreach ($data['products'] as $pointerto => $product) {
                    echo' <div class="container thumbnail">
                <div class="row">
                    <div class="col-sm-12 image">
                        <img src="' . URL::PRO_IMG($product['picture']) . '" alt="There should be a picture...">
                        <p><span>' . $product['name'] . '</span></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 price">
                        ' . $product['price'] . '
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 source">
                        <a href="' . $product['source'] . '" target="blank" class="btn btn-success">Zum Anbieter!</a>
                    </div>';
                    if ($products['ownerid'] == Session::get('UserID') && $data['boid'] == Session::get('UserID')) {
                        echo '<a class="btn btn-default btn-sm" href="' . DIR . 'products/edit/' . $product['id'] . '">Edit</a>
                        <a class="btn btn-default btn-sm" href="' . DIR . 'boards/removeProduct/' . $data['id'] . '/' . $product['id'] . '">Remove from Board</a>';
                    } else if ($data['boid'] == Session::get('UserID')){
                         echo '<div class="alert alert-info" role="alert">Das ist nicht dein Produkt, du kannst es nur kopieren oder vom Board entfernen!</div>
                         <a class="btn btn-default btn-sm" href="' . DIR . 'products/copytoboard/' . $product['id'] . '">Zu Board hinzufügen</a>
                         <a class="btn btn-default btn-sm" href="' . DIR . 'boards/removeProduct/' . $data['id'] . '/' . $product['id'] . '">Remove from Board</a>';
                    } else {
                        echo '<div class="alert alert-info" role="alert">Das ist nicht dein Produkt und nicht dein Board, du kannst es nur kopieren!</div>
                         <a class="btn btn-default btn-sm" href="' . DIR . 'products/copytoboard/' . $product['id'] . '">Zu Board hinzufügen</a>';
                    }
                    echo '</div>
            </div>';
                }
            }
            ?>
        </div><!--well-->
    </div><!--container-->
</section>




