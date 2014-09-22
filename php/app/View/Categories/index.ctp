<div id="json_tree" style="display:none;"><?php if(isset($categories['categories'])){ echo $categories['categories']; } ?></div>


<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12">

<!--            <hr style="margin-bottom: 0">-->

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Main technologies implemented:</h3>
                </div>
                <div class="panel-body">
                    <ul>
                        <li>jqTree <a href="http://mbraak.github.io/jqTree/">http://mbraak.github.io/jqTree/</a></li>
                        <li>CakePHP <a href="http://cakephp.org/">http://cakephp.org/</a></li>
                        <li>OpenShift <a href="https://www.openshift.com/quickstarts/cakephp">https://www.openshift.com/quickstarts/cakephp</a></li>
                    </ul>
                </div>
            </div>

            <!-- Tree -->
            <div id="tree" style="display:none;" >

                <!-- controles -->
                <div class="row">
                    <div class="col-xs-12">


                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Categories:</h3>
                            </div>
                            <div class="panel-body">

                                <div class="btn-toolbar" role="toolbar">
                                    <div id="admin-category" class="btn-group">
                                        <button id="edit-category" type="button" class="btn btn-default disabled">Edit</button>
                                        <button id="delete-category"  type="button" class="btn btn-default disabled">Delete</button>
                                    </div>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary new-category">Add a new category!</button>
                                    </div>
                                </div>

                                <h4 class="page-header">Instructions:</h4>

                                <strong>To change the position: </strong> Drag and drop category or node.<br>
                                <strong>To edit or delete:</strong> Select the category and then select the action.

                                <h4 class="page-header">Categories:</h4>

                                <div id="display-tree"></div>

                            </div>
                        </div>

                    </div>
                </div>



            </div>
            <!-- no Tree -->
            <div id="no-tree" style="display:none;">
                <div class="alert alert-info" role="alert">
                    <strong>Warning!</strong> no categories loaded yet. <a class="new-category" href="#">Add a new category!</a>
                </div>
            </div>


        </div>
    </div>
</div>


<!-- Modal New Category -->
<div class="modal fade" id="new-category-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" id="category-add-form" action="#" method="post" accept-charset="utf-8">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                    <h4 class="modal-title">New Category</h4>
                </div>

                <div class="modal-body">

                    <!-- Mensajes post ajax request -->
                    <div class="alert alert-success alert-dismissible" style="display: none;" role="alert">
                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        You have registered the category!
                    </div>
                    <div class="alert alert-danger alert-dismissible" style="display: none;" role="alert">
                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        An error has occurred, try again or you can also try reloading the page if the error persists!
                    </div>

                    <div class="form-group">
                        <label for="category-name"><span class="glyphicon glyphicon-folder-close"></span> Name</label>
                        <input type="text" class="form-control" id="category-name" name="category-name" placeholder="Eje: Laptops">
                        <span class="help-block" style="display: none;">Required</span>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Send</button>
                </div>

            </form>
        </div>
    </div>
</div>



<!-- Modal to edit the category name -->
<div class="modal fade" id="edit-category-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" id="category-edit-form" action="#" method="post" accept-charset="utf-8">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Edit the category name</h4>
                </div>

                <div class="modal-body">

                    <!-- Mensajes post ajax request -->
                    <div class="alert alert-success alert-dismissible" style="display: none;" role="alert">
                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        Category has been edited!
                    </div>
                    <div class="alert alert-danger alert-dismissible" style="display: none;" role="alert">
                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        An error has occurred, try again or you can also try reloading the page if the error persists!
                    </div>

                    <input type="hidden" id="edit-category-id" name="edit-category-id">

                    <div class="form-group">
                        <label for="edit-category-name"><span class="glyphicon glyphicon-folder-close"></span> Name</label>
                        <input type="text" class="form-control" id="edit-category-name" name="edit-category-name" placeholder="Eje: Laptops">
                        <span class="help-block" style="display: none;">Requerido</span>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>

            </form>
        </div>
    </div>
</div>



<!-- Modal to delete the category -->
<div class="modal fade" id="delete-category-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" id="category-delete-form" action="#" method="post" accept-charset="utf-8">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Do you really want to delete this category?</h4>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="delete-category-id" name="delete-category-id">

                    <h3 class="text-danger" id="delete-category-name" style="margin-top: 0;"></h3>

                    <div class="form-group">
                        <div class="checkbox">
                            <label>
                                <input id="delete-category-branch" type="checkbox"> And daughters categories also
                            </label>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Confirm</button>
                </div>

            </form>
        </div>
    </div>
</div>

<?php echo $this->Html->script('base.categories',false); ?>
