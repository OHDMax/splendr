<?php
echo
            '<div class="container thumbnail">
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
                    if ($product['ownerid'] == Session::get('UserID')) {
                        echo '<a class="btn btn-default btn-sm" href="' . DIR . 'products/edit/' . $product['id'] . '">Edit</a>
                        <a class="btn btn-default btn-sm" href="' . DIR . 'products/delete/' . $data['id'] . '/' . $product['id'] . '">Delete</a>';
                    } else {
                         echo '<div class="alert alert-info" role="alert">Das ist nicht dein Produkt, du kannst es nur kopieren!</div>';
                         echo '<a class="btn btn-default btn-sm" href="' . DIR . 'products/copytoboard/' . $product['id'] . '">Zu Board hinzufügen</a>';
                    } 
                    echo '</div>
            </div>';