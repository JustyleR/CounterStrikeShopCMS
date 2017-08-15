<?php
template('header');
money();
?>

<!--Popular-->
<div class="panel panel-default">
    <div class="panel-heading">
        <p>
            <button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#060">0.60$</button>
            <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#120">1.20$</button>
            <button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#240">2.40$</button>
            <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#480">4.80$</button>
            <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#600">6.00$</button>
        </p>
    </div>
    <div class="panel-body">
        <div class="panel-body">
            <form action="" method="POST">
                <fieldset>
                    <div class="form-group">
                        <input style="width:150px;" class="form-control" placeholder="<?php echo language('others', 'SMS_CODE'); ?>" value="WYSR49" name="code" type="text" autofocus required>
                    </div>
                    <input style="width:150px;" type="submit" name="add" class="btn btn-outline btn-success btn-block" value="<?php echo language('buttons', 'REDEEM_SMS_CODE'); ?>" />
                </fieldset>
                <p>
                    <br />
                    &nbsp;<?php core_message('money'); ?>
                </p>
            </form>
        </div>
    </div>
</div>
</div>
</div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="060">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">0.60$</h4>
            </div>
            <div class="modal-body">
                <p></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="120">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">1.20$</h4>
            </div>
            <div class="modal-body">
                <p></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="240">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">2.40$</h4>
            </div>
            <div class="modal-body">
                <p></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="480">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">4.80$</h4>
            </div>
            <div class="modal-body">
                <p></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="600">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">6.00$</h4>
            </div>
            <div class="modal-body">
                <p></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>
<?php template('footer'); ?>