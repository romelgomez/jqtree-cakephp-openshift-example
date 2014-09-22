<?php
class Category extends AppModel {

    public $displayField = 'name';
    public $actsAs = array('Tree','Containable');

    // label ha sido sustituido por name, para mayor compatibilidad y mejor manejo con la librería jqTree.

    var $validate = array(
        'name' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'El campo nombre es obligatorio.'
            )
        )
    );

}