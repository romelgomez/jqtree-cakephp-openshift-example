<?php class CategoriesController extends AppController{

    /* Descripción: 		Función recursiva interna, Para personalizar el árbol.
     * tipo de solicitud: 	interna de la clase CategoriesController
     * tipo de acceso: 		administrativo
     * Recibe: 				un array anidado de categorías.
     * Retorna: 			un JSON  anidado de categorías, compatible con la librería tree.jquery.js
     *******************/
    private function recursive_tree($tree){
        $data = array();
        foreach($tree as $key => $val){

            // para efecto de corregir errores
            // $data[$key]['label'] 	= 'name: '.$val['Category']['name'].', id: '. $val['Category']['id'].', lft: '.$val['Category']['lft'].', rght: '.$val['Category']['rght'];

            $data[$key]['label'] 		= $val['Category']['name'];

            $data[$key]['id'] 			= $val['Category']['id'];
            $data[$key]['parent_id']	= $val['Category']['parent_id'];
            $data[$key]['lft']			= $val['Category']['lft'];
            $data[$key]['rght']			= $val['Category']['rght'];

            if($val['children']){
                $data[$key]['children'] 	=  $this->recursive_tree($val['children']);
            }else{
                $data[$key]['children'] 	= array();
            }
        }
        return $data;
    }

    /* Descripción: Función permite obtener el árbol listo para enviar a la vista.
     * tipo de solicitud: 	internar
     * tipo de acceso: 		administrativo
     * Recibe: 				null
     * Retorna: 			un array
     *******************/
    private function categories(){
        $return['countCategories'] = $this->{'Category'}->find('count');
        if($return['countCategories']){
            $categories = $this->{'Category'}->find('threaded', array(
                'order' => 'Category.lft',
                'contain' => false
            ));
            $return['categories'] = $this->recursive_tree($categories);
        }
        return $return;
    }


    /* Descripción: Función principal , permite visualizar las categorías, entre otras acciones administrativas realacionadas.
     * Recibe: 				NULL
     * Retorna: 			un array
     *******************/
    public function index(){

        $return['total'] = $this->{'Category'}->find('count');

        if($return['total'] > 0){
            $categories = $this->{'Category'}->find('threaded', array(
                'order' => 'Category.lft',
                'contain' => false
            ));
            $return['categories'] = json_encode($this->recursive_tree($categories));
        }

        $this->{'set'}('categories',$return);

    }

    /* Descripción: Función para crear nuevas categorías.
     * Recibe:			 	JSON
     * Retorna: 			un array, el cual sera transformado en un objeto JSON en la vista ajax_view.
     *******************/
    public function new_category(){
        $request = $this->{'request'}->input('json_decode',true);

        $category =	array(
            'Category'=>Array
            (
                'name'	=>	$request['name']
            )
        );

        $return = array();

        $this->{'Category'}->set($category);
        if($this->{'Category'}->validates()){
            $return['Add'] = $this->{'Category'}->save($category);
        }else{
            $return['Add'] = false;
        }

        $return += $this->categories();

        $this->{'set'}('return',$return);
        $this->{'render'}('ajax_view','ajax');
    }

    /* Descripción: Función para editar el nombre de la categoría.
     * Recibe:			 	JSON
     * Retorna: 			un array, el cual sera transformado en un objeto JSON en la vista ajax_view.
     *******************/
    public function edit_category_name(){
        $request = $this->{'request'}->input('json_decode',true);

        $category = array(
            'Category'=>array(
                'id'	=>$request['id'],
                'name'	=>$request['name']
            )
        );

        $return = array();

        $this->{'Category'}->set($category);
        if($this->{'Category'}->validates()){
            $return['Edit'] = $this->{'Category'}->save($category);
        }else{
            $return['Edit'] = false;
        }

        $return += $this->categories();

        $this->{'set'}('return',$return);
        $this->{'render'}('ajax_view','ajax');
    }

    /* Descripción: Función para borra una categoría y sus categorías hijas si es requerido. Actualiza todo el árbol cada vez que es llamada.
     * Recibe:			 	JSON
     * Retorna: 			un array, el cual sera transformado en un objeto JSON en la vista ajax_view.
    *******************/
    public function deleteCategory(){
        $request = $this->{'request'}->input('json_decode',true);

        $theWholeBranch 	= $request['theWholeBranch'];
        $id					= $request['id'];

        $category = $this->{'Category'}->find('first', array(
            'conditions' => array('Category.id' => $id),
            'contain' => false
        ));

        $return = array();


        if($category){
            if($theWholeBranch){
                $return['delete'] = $this->{'Category'}->delete($category['Category']['id']);
            }else{
                $return['delete'] = $this->{'Category'}->removeFromTree($id, true);
            }
        }

        $return += $this->categories();

        $this->{'set'}('return',$return);
        $this->{'render'}('ajax_view','ajax');
    }

    /* Descripción: Función para cambiar la posición de la categoría en el árbol, principalmente tiene dos secciones 1) solo mover de arriba a abajo y viceversa 2) primero establecer el parent_id y luego mover de arriba a abajo y viceversa
     * Recibe:              JSON
     * Retorna:             un array, el cual sera transformado en un objeto JSON en la vista ajax_view.
    *******************/

    public function edit_category_position(){
        $request = $this->{'request'}->input('json_decode',true);

        $return = array();

        if($request['type'] == 'only_move'){
            $category = $this->{'Category'}->find('first', array(
                'conditions' => array('Category.id' => $request['id']),
                'contain' => false
            ));
            if($category){
                $positions = $this->{'Category'}->find('count', array(
                    'conditions' => array('Category.lft >=' => $request['min'],'Category.rght <=' => $request['max'],'Category.parent_id' => $request['parent_id'])
                ));
                if($positions > 0){
                    if($request['move_to'] == 'moveDown'){
                        $this->{'Category'}->moveDown($request['id'], $positions);
                    }
                    if($request['move_to'] == 'moveUp'){
                        $this->{'Category'}->moveUp($request['id'], $positions);
                    }
                }
            }
        }
        if($request['type'] == 'set_parent_and_move'){

            $category = array(
                'Category'=>array(
                    'id'		=>$request['moved_node_id'],
                    'parent_id'	=>$request['new_parent_id']
                )
            );

            if($request['position'] == 'inside'){
                /*  Descripción:
                 *  antes de insertar la categoría observamos cuantos hijos tiene la categoría que sera populada, es decir cuantos hijos tiene target_node_id,
                 *  si no tiene ninguno la categoría simplemente se insert,  si tiene hijos el valor que arroje sera el numero de posiciones que la categoría tendrá que subir para estar de primera.
                 *  es importante recordar que la categoría al ser insertada o a establecerle un nuevo parent_id es ordenada de ultima.
                */

                // childCount
                $position_length = $this->{'Category'}->childCount($request['target_node_id'], true);

                // new_parent_id
                $this->{'Category'}->save($category);

                // move
                if($position_length > 0){
                    $this->{'Category'}->moveUp($request['moved_node_id'], $position_length);
                }
            }

            if($request['position'] == 'before'){
                /* Descripción:
                 * Antes de establecer el parent_id se cuenta cuantas categorías existen con parent_id == null tal valor
                 * representa el numero de posiciones que la categoría sera subida para posicionarse de primera.
                 * es importante recordar que posición es before solo cuando la categoría es posicionada de primera sin padres es decir es un caso único.
                */

                $position_length = $this->{'Category'}->find('count',array(
                    'conditions' => array('Category.parent_id' => null)
                ));

                // new_parent_id
                $this->{'Category'}->save($category);

                // move
                $this->{'Category'}->moveUp($request['moved_node_id'], $position_length);
            }

            if($request['position'] == 'after'){
                /* Descripción:
                 * La categoría tiene dos opciones mantenerse o subir, si la categoría es sucesiva se ha de suponer que el admin la coloco de ultima por lo tanto no es necesario subir la categoría
                 * se calcula el mínimo y maximo junto con el parent_id de la categoría movida permitirá consulta cuantas categoría directas (directChildren) existen entre la categoría movida y la sucesiva o target.
                 */

                // new_parent_id
                $this->{'Category'}->save($category);

                $moved_node = $this->{'Category'}->find('first', array(
                    'conditions' => array('Category.id' => $request['moved_node_id']),
                    'contain' => false
                ));

                $target_node = $this->{'Category'}->find('first', array(
                    'conditions' => array('Category.id' => $request['target_node_id']),
                    'contain' => false
                ));

                $max		= $moved_node['Category']['lft']-1;
                $min 		= $target_node['Category']['rght']+1;
                $parent_id	= $moved_node['Category']['parent_id'];

                $position_length = $this->{'Category'}->find('count', array(
                    'conditions' => array('Category.lft >=' => $min,'Category.rght <=' => $max,'Category.parent_id' => $parent_id)
                ));

                if($position_length > 0){
                    $this->{'Category'}->moveUp($request['moved_node_id'], $position_length);
                }

            }

        }


        $return += $this->categories();

        $this->{'set'}('return',$return);
        $this->{'render'}('ajax_view','ajax');
    }


}