<section>
     <div class="container margintop marginbottom">
        <div class="panel panel-default">

            <div class="panel-heading">
                <h3 class="panel-title"><?= $data['form_header'] ?></h3>
            </div>

            <div class="panel-body">

                <?php echo Message::show(); ?>

                <?php
                $product = $data['product'];
                if (isset($product['id'])) :
                    ?>

                    <form role="form" action="<?= DIR ?>products/insert/<?=$product['id']?>" method="POST">
                        <input class="form-control" type="text" name="i_name" placeholder="Produkt-Name" value="<?= $product['name'] ?>">
                        <input class="form-control" type="url" name="i_url" placeholder="Produkt-URL" value="<?= $product['source'] ?>">
                        <input class="form-control" type="url" name="i_picture" placeholder="Produkt-Bild" value="<?= $product['picture'] ?>">
                        <input class="form-control" type="text" name="i_productcat" placeholder="Kategorie" value="<?= $product['category'] ?>">
                        <div class="row">
                            <div class="col-xs-6 input-group">
                                <input type="number" step="any" min="0" class="form-control" name="i_price" placeholder="Preis" value="<?= $product['price'] ?>">
                                <span class="input-group-addon">€</span>
                            </div>
                            <div class="col-xs-6">
                                <button type="submit" class="btn btn-primary btn-block">Aktualisieren</button>
                            </div>
                        </div>
                    </form>

                <?php else : ?>

                    <form role="form" action="<?= DIR ?>products/add" method="POST">
                        <input class="form-control" type="text" name="i_name" placeholder="Produkt-Name">
                        <input class="form-control" type="url" name="i_url" placeholder="Produkt-URL">
                        <input class="form-control" type="url" name="i_picture" placeholder="Produkt-Bild">
                        <input class="form-control" type="text" name="i_productcat" placeholder="Kategorie">
                        <div class="row">
                            <div class="col-xs-6 input-group">
                                <input type="number" class="form-control" name="i_price" placeholder="Preis">
                                <span class="input-group-addon">€</span>
                            </div>
                            <div class="col-xs-6">
                                <button type="submit" class="btn btn-primary btn-block">Anlegen</button>
                            </div>
                        </div>
                    </form>

                <?php endif; ?>

            </div> <!-- / .panel-body -->
        </div> <!-- / .panel -->
    </div>
</section>