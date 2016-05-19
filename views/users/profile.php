<!--From http://www.bootply.com/WzHaQfbX9g-->
        <div class="jumbotron noimage">
            <div class="container">
                <div class="row">
                    <div class="col-md-9">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12 lead">User Profile<hr></div>
                                </div>
                                <form class="form-horizontal" method="post" action ="<?= DIR ?>users/edit">
                                 <?= Message::show()?>
                                <div class="row">
                                    <div class="col-md-4 text-center">
                                        <img class="img-circle avatar avatar-original" style="-webkit-user-select:none; 
                                             display:block; margin:auto;" src="http://robohash.org/sitsequiquia.png?size=120x120">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h1><?=$data['name'] ?></h1>
                                                <h2 class="only-bottom-margin">as <?=$data['role'] ?></h2>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <span class="text-muted">Email: </span> <?=$data['email'] ?> <br>
                                                <span class="text-muted">Real Name: </span>
                                                <div class="form-group">
                                                    <label hidden for="i_name">Echter Name</label>
                                                    <input type="text" class="form-control" id="i_name" name="i_name" value="<?=$data['realname']?>">
                                                </div>
                                                <span class="text-muted">Wohnort:</span> 
                                                <div class="form-group">
                                                    <label hidden for="i_loc">Wohnort</label>
                                                    <input type="text" class="form-control" id="i_loc" name ="i_loc" value="<?=$data['city']?>">
                                                </div>
                                                <br><br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <hr><button class="btn btn-default pull-right" type = "submit"><i class="glyphicon glyphicon-pencil"></i> Update</button>
                                    </div>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>          
	</div>    
</div>
<iframe width="640" height="480" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.it/maps?q=<?php echo $data['city']; ?>&output=embed"></iframe> 
