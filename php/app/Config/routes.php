<?php

/* Sort alphabetically by the name of the controller. That is what is repeated. */

//	C
Router::connect('/',                                array('controller' => 'categories', 'action' => 'index'));                      // Acción Get - Interfaz administrar las categorías de productos y servicios
Router::connect('/new-category',                    array('controller' => 'categories', 'action' => 'new_category'));               // Acción Ajax - Para registrar una categoría
Router::connect('/delete-category',                 array('controller' => 'categories', 'action' => 'deleteCategory'));             // Acción Ajax - Para borrar una categoría
Router::connect('/edit-category',                   array('controller' => 'categories', 'action' => 'edit_category_name'));         // Acción Ajax - Para editar el nombre una categoría
Router::connect('/edit-category-position',          array('controller' => 'categories', 'action' => 'edit_category_position'));     // Acción Ajax - Para editar la posición de una categoría
