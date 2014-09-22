$(document).ready(function(){

    (function( categories, $) {

        /*
         @Name              -> treeElement
         @visibility        -> Private
         @Type              -> Property
         @Descripción       -> Dom element where tree is going be placed.
         @implemented by    -> categories.main(), displayJqTreeData(), replaceWholeTree(), treeMove(), treeSelect();
         */
        var treeElement;

        /*
         @Name              -> initEstate
         @visibility        -> Private
         @Type              -> Property
         @Descripción       -> Is use to determine if is necessary create new tree or replace all tree; new tree is necessary when at first load of the web there is no category or node; replace all tree is necessary when after delete all current nodes, is starting create new node.
         @implemented by    -> categories.main(), newCategory();
         */
        var initEstate;

        /*
         @Name              -> displayJqTreeData
         @visibility        -> Private
         @Type              -> Method
         @Descripción       -> display initially JqTree Data.
         @parameters        -> treeData: JqTree data.
         @returns           -> null
         @implemented by    -> categories.main(), newCategory();
         */
        var displayJqTreeData = function(treeData){
            var options = {
                dragAndDrop: true,
                selectable: true,
                autoEscape: false,
                autoOpen: true,
                data: treeData
            };

            treeElement.tree(options);
        };

        /*
         @Name              -> replaceWholeTree
         @visibility        -> Private
         @Type              -> Method
         @Descripción       -> Replace whole Tree.
         @parameters        -> treeData: JqTree data.
         @returns           -> null
         @implemented by    -> treeMove(), newCategory(), editCategoryName(), deleteCategory();
         */
        var replaceWholeTree = function(treeData){
            treeElement.tree('loadData', treeData);
        };

        /*
         @Name              -> moveTo
         @visibility        -> Private
         @Type              -> Method
         @implemented by    -> treeMove()
         */
        var moveTo = function(moved_node,target_node,position){
            var request = {};

            var a = parseInt(moved_node['lft']);
            var b = parseInt(target_node['lft']);

            if(a < b){
                //console.log('bajar');
                request.move_to = 'moveDown';
                request.min = parseInt(moved_node['rght'])+1;
                request.max = parseInt(target_node['rght']);
                return request;
            }
            if(a > b){
                //console.log('subir');
                request.move_to = 'moveUp';
                if(position == "before"){
                    request.min = parseInt(target_node['lft']);
                    request.max = parseInt(moved_node['lft'])-1;
                }
                if(position == "inside"){
                    request.min = parseInt(target_node['lft'])+1;
                    request.max = parseInt(moved_node['lft'])-1;
                }
                if(position == "after"){
                    request.min = parseInt(target_node['rght'])+1;
                    request.max = parseInt(moved_node['lft'])-1;
                }
                return request;
            }
        };

        /*
         @Name              -> treeMove
         @visibility        -> Private
         @Type              -> Event
         @Descripción       -> Update tree after move one o more node's. Change left and right values and if is necessary parent_id too.
         @parameters        -> null
         @returns           -> null
         @implemented by    -> categories.main()
         */
        var treeMove = function(){

            var notification;

            var request_parameters = {
                "requestType":"custom",
                "type":"post",
                "url":"/edit-category-position",
                "data":{},
                "callbacks":{
                    "beforeSend":function(){
                        notification = ajax.notification("beforeSend");
                    },
                    "success":function(response){
                        $('#debug').text(JSON.stringify(response));

                        if(response['expired_session']){
                            window.location = "/entrar";
                        }

                        if(response['countCategories'] > 0){
                            ajax.notification("success",notification);
                            var treeData = response['categories'];
                            replaceWholeTree(treeData);
                        }else{
                            ajax.notification("error",notification);
                            $('#tree').css({"display":"none"});
                            $('#no-tree').show();
                        }


                    },
                    "error":function(){
                        ajax.notification("error",notification);
                    },
                    "complete":function(response){}
                }
            };

            treeElement.bind(
                'tree.move',
                function(event) {

                    var moved_node 			= event.move_info.moved_node;
                    var target_node 		= event.move_info.target_node;
                    var position			= event.move_info.position;

                    /*
                     console.log('moved_node',moved_node);				//-> Objeto movido.
                     console.log('target_node',target_node);				//-> sobre, luego o internamente sobre este objeto.
                     console.log('position',position);					//-> posición: sobre, luego, internamente.
                     console.log(' ');
                    */

                    var request_this = {};

                    if(position =="before"){
                        if(moved_node.parent_id == null){
                            //console.log('solo mover');

                            request_this 			= moveTo(moved_node,target_node,position);
                            request_this.id			= parseInt(moved_node.id);
                            request_this.parent_id  = moved_node.parent_id;
                            request_this.type		= 'only_move';

                       }else{
                            //console.log('set_parent_and_move');

                            request_this.new_parent_id			= 0;
                            request_this.moved_node_id			= parseInt(moved_node.id);
                            request_this.target_node_id			= parseInt(target_node.id);
                            request_this.position				= position;
                            request_this.type					= 'set_parent_and_move';

                        }
                    }
                    if(position =="after"){
                        if(moved_node.parent_id == target_node.parent_id){
                            //console.log('solo mover');

                            request_this 			= moveTo(moved_node,target_node,position);
                            request_this.id			= parseInt(moved_node.id);
                            request_this.parent_id  = moved_node.parent_id;
                            request_this.type		= 'only_move';

                        }else{
                            //console.log('set_parent_and_move');

                            request_this.new_parent_id			= parseInt(target_node.parent_id);
                            request_this.moved_node_id			= parseInt(moved_node.id);
                            request_this.target_node_id			= parseInt(target_node.id);
                            request_this.position				= position;
                            request_this.type					= 'set_parent_and_move';

                        }
                    }
                    if(position =="inside"){
                        if(moved_node.parent_id == target_node.id){
                            //console.log('solo mover');

                            request_this 			= moveTo(moved_node,target_node,position);
                            request_this.id			= parseInt(moved_node.id);
                            request_this.parent_id  = moved_node.parent_id;
                            request_this.type		= 'only_move';

                        }else{
                            //console.log('set_parent_and_move');

                            request_this.new_parent_id			= parseInt(target_node.id);
                            request_this.moved_node_id			= parseInt(moved_node.id);
                            request_this.target_node_id			= parseInt(target_node.id);
                            request_this.position				= position;
                            request_this.type					= 'set_parent_and_move';

                        }
                    }

                    request_parameters['data'] = request_this;
                    ajax.request(request_parameters);

                }
            );
        };

        /*
         @Name              -> treeSelect
         @visibility        -> Private
         @Type              -> Event
         @Descripción       -> Event firing after selecting a category.
         @parameters        -> null
         @returns           -> null
         @implemented by    -> categories.main()
         */
        var treeSelect = function(){
            treeElement.bind(
                'tree.select',
                function(event) {

                    var adminCategory = $("#admin-category");

                    if (event.node) {
                        //  EDIT
                        $("#edit-category-id").val(event['node']['id']);
                        $("#edit-category-name").val(event['node']['name']);

                        //  Delete
                        $("#delete-category-id").val(event['node']['id']);
                        $("#delete-category-name").text(event['node']['name']);

                        if(event['node']['children'].length > 0){
                            $("#delete-category-branch").parents(".form-group").show();
                        }else{
                            $("#delete-category-branch").parents(".form-group").hide();
                        }

                        // Habilita los botones.
                        adminCategory.find("button").each(function(k,element){
                            $(element).removeClass("disabled");
                        });
                    }else {
                        // inhabilita los botones.
                        adminCategory.find("button").each(function(k,element){
                            $(element).addClass("disabled");
                        });
                    }

                }
            );
        };

        /*
         @Name              -> deleteCategory
         @visibility        -> Private
         @Type              -> Method
         @Descripción       -> Delete a category.
         @parameters        -> null
         @returns           -> null
         @implemented by    -> categories.main()
         */
        var deleteCategory = function(){
            $("#delete-category").on('click',function(event){
                event.preventDefault();
                if(!$(this).hasClass("disabled")){
                    // Activamos el modal
                    $('#delete-category-modal').modal({"backdrop":false,"keyboard":true,"show":true,"remote":false}).on('hide.bs.modal',function(){
                        validate.removeValidationStates('category-delete-form');
                    });
                }
            });

            var notification;

            var request_parameters = {
                "requestType":"custom",
                "type":"post",
                "url":"/delete-category",
                "data":{},
                "callbacks":{
                    "beforeSend":function(){
                        notification = ajax.notification("beforeSend");
                    },
                    "success":function(response){
                        $('#debug').text(JSON.stringify(response));

                        // Si la sesión ha expirado
                        if(response['expired_session']){
                            window.location = "/entrar";
                        }

                        var alert = $("#category-delete-form");

                        if(response['delete']){
                            ajax.notification("success",notification);

                            if(response['countCategories'] > 0){
                                var treeData = response['categories'];
                                replaceWholeTree(treeData);
                            }else{
                                $('#tree').css({"display":"none"});
                                $('#no-tree').show();
                            }

                            validate.removeValidationStates('category-delete-form');
                            $('#delete-category-modal').modal('hide');
                        }else{
                            ajax.notification("error",notification);

                            alert.find(".alert-danger").fadeIn();
                            setTimeout(function(){ $("#category-delete-form").find(".alert-danger").fadeOut()},7000);
                        }

                        var adminCategory = $("#admin-category");
                        adminCategory.find("button").each(function(k,element){
                            $(element).addClass("disabled");
                        });


                    },
                    "error":function(){
                        ajax.notification("error",notification);
                    },
                    "complete":function(response){}
                }
            };

            // validación:
            var validateObj = {
                "submitHandler": function(){

                    request_parameters['data']['id'] = $("#delete-category-id").val();
                    request_parameters['data']['theWholeBranch'] = $("#delete-category-branch").prop('checked');;

                    ajax.request(request_parameters);
                }
            };

            validate.form("category-delete-form",validateObj);
        };

        /*
         @Name              -> editCategoryName
         @visibility        -> Private
         @Type              -> Method
         @Descripción       -> Rename a category.
         @parameters        -> null
         @returns           -> null
         @implemented by    -> categories.main()
         */
        var editCategoryName = function(){
            $("#edit-category").on('click',function(event){
                event.preventDefault();
                if(!$(this).hasClass("disabled")){
                    // Activamos el modal
                    $('#edit-category-modal').modal({"backdrop":false,"keyboard":true,"show":true,"remote":false}).on('hide.bs.modal',function(){
                    });
                }
            });

            var notification;

            var request_parameters = {
                "requestType":"form",
                "type":"post",
                "url":"/edit-category",
                "data":{},
                "form":{
                    "id":"category-edit-form",
                    "inputs":[
                        {'id':'edit-category-id', 'name':'id'},
                        {'id':'edit-category-name', 'name':'name'}
                    ]
                },
                "callbacks":{
                    "beforeSend":function(){
                        notification = ajax.notification("beforeSend");
                    },
                    "success":function(response){
                        $('#debug').text(JSON.stringify(response));

                        // Si la sesión ha expirado
                        if(response['expired_session']){
                            window.location = "/entrar";
                        }

                        var categoryEditForm = $("#category-edit-form");

                        if(response['Edit']){
                            ajax.notification("success",notification);

                            categoryEditForm.find(".alert-success").fadeIn();

                            // update input in category-edit-form
                            $("#edit-category-name").attr({"value":response['Edit']['Category']['name']});

                            setTimeout(function(){
                                $("#category-edit-form").find(".alert-success").fadeOut();
                            },2000);

                        }else{
                            ajax.notification("error",notification);

                            categoryEditForm.find(".alert-danger").fadeIn();
                            categoryEditForm.find(".modal-body").find(".form-group").hide();
                            categoryEditForm.find(".modal-footer").hide();

                            setTimeout(function(){
                                $('#edit-category-modal').modal('hide');
                                validate.removeValidationStates('category-edit-form');

                                var categoryEditForm = $("#category-edit-form");
                                categoryEditForm.find(".alert-danger").fadeOut();
                                categoryEditForm.find(".modal-body").find(".form-group").show();
                                categoryEditForm.find(".modal-footer").show();

                            },3000);
                        }



                        if(response['countCategories'] > 0){
                            var treeData = response['categories'];
                            replaceWholeTree(treeData);
                        }else{
                            $('#tree').css({"display":"none"});
                            $('#no-tree').show();
                        }

                        var adminCategory = $("#admin-category");
                        adminCategory.find("button").each(function(k,element){
                            $(element).addClass("disabled");
                        });

                    },
                    "error":function(){
                        ajax.notification("error",notification);
                    },
                    "complete":function(response){}
                }
            };

            // validación:
            var validateObj = {
                "submitHandler": function(){
                    ajax.request(request_parameters);
                },
                "rules":{
                    "edit-category-name":{
                        "required":true,
                        "maxlength":20
                    }
                },
                "messages":{
                    "edit-category-name":{
                        "required":"El campo nombre es obligatorio.",
                        "maxlength":"El nombre de la categoría no debe tener mas de 20 caracteres."
                    }
                }
            };

            validate.form("category-edit-form",validateObj);

        };

        /*
         @Name              -> newCategory
         @visibility        -> Private
         @Type              -> Method
         @Descripción       -> Add a new category.
         @parameters        -> null
         @returns           -> null
         @implemented by    -> categories.main()
         */
        var newCategory = function(){
            $(".new-category").on('click',function(event){
                event.preventDefault();
                $('#new-category-modal').modal({"backdrop":false,"keyboard":true,"show":true,"remote":false}).on('hide.bs.modal',function(){
                    validate.removeValidationStates('category-add-form');
                });
            });

            var notification;

            var request_parameters = {
                "requestType":"form",
                "type":"post",
                "url":"/new-category",
                "data":{},
                "form":{
                    "id":"category-add-form",
                    "inputs":[
                        {'id':'category-name', 'name':'name'}
                    ]
                },
                "callbacks":{
                    "beforeSend":function(){
                        notification = ajax.notification("beforeSend");
                    },
                    "success":function(response){
                        $('#debug').text(JSON.stringify(response));

                        // Si la sesión ha expirado
                        if(response['expired_session']){
                            window.location = "/entrar";
                        }

                        var categoryAddForm = $("#category-add-form");

                        if(response['Add']){
                            ajax.notification("success",notification);

                            categoryAddForm.find(".alert-success").fadeIn();
                            validate.removeValidationStates('category-add-form');

                            setTimeout(function(){
                                $("#category-add-form").find(".alert-success").fadeOut();
                            },2000);

                        }else{
                            ajax.notification("error",notification);

                            categoryAddForm.find(".alert-danger").fadeIn();
                            categoryAddForm.find(".modal-body").find(".form-group").hide();
                            categoryAddForm.find(".modal-footer").hide();

                            setTimeout(function(){
                                $('#new-category-modal').modal('hide');
                                validate.removeValidationStates('category-add-form');

                                var categoryAddForm = $("#category-add-form");
                                categoryAddForm.find(".alert-danger").fadeOut();
                                categoryAddForm.find(".modal-body").find(".form-group").show();
                                categoryAddForm.find(".modal-footer").show();

                            },3000);
                        }

                        if(response['countCategories'] > 0){

                            var jqTreeData = response['categories'];

                            $('#no-tree').hide();
                            $('#tree').show();

                            if(initEstate == 0){
                                displayJqTreeData(jqTreeData);
                                initEstate = 1;
                            }else{
                                replaceWholeTree(jqTreeData);
                            }

                        }else{
                            $('#no-tree').show();
                            $('#tree').hide();
                        }



                    },
                    "error":function(){
                        ajax.notification("error",notification);
                    },
                    "complete":function(response){}
                }
            };

            // validación:
            var validateObj = {
                "submitHandler": function(){
                    ajax.request(request_parameters);
                },
                "rules":{
                    "category-name":{
                        "required":true,
                        "maxlength":50
                    }
                },
                "messages":{
                    "category-name":{
                        "required":"El campo nombre es obligatorio.",
                        "maxlength":"El nombre de la categoría no debe tener mas de 50 caracteres."
                    }
                }
            };

            validate.form("category-add-form",validateObj);
        };

        /*
         @Name              -> main
         @visibility        -> Public
         @Type              -> Method
         @Descripción       -> Main, Like Java Main Method.
         @parameters        -> null
         @returns           -> null
         @implemented by    -> CLIENT
         */
        categories.main = function(){

            treeElement = $('#display-tree');

            var jsonTree = $('#json_tree').html();

            if(jsonTree != ''){
                var treeData = $.parseJSON(jsonTree);

                $('#tree').show();
                displayJqTreeData(treeData);

            }else{
                initEstate = 0;
                $('#no-tree').show();
            }

            treeSelect();   // event
            treeMove();     // event

            newCategory();
            editCategoryName();
            deleteCategory();


        };

    }( window.categories = window.categories || {}, jQuery ));

    categories.main();
});


