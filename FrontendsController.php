<?php

class FrontendsController extends  AppController{

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('view', 'built_in');
    }

    Public function home(){
        $this->layout='home_layout';
        $this->loadModel('Category');
        $this->get_menu();
        $categories= $this->Category->find('all', array(
            'order'=> 'Category.position'
            )
        );
        $this->set(array(
            'categories'=>$categories,
        ));

    }

    Public function index(){
        $this->get_menu();
        $users_infos = array();
        $this->layout='front';
        $this->loadModel('Product');
        $this->loadModel('Category');
        $categories = $this->Category->find('all');
        $session = $this->Session->read();
        if (isset($session['Auth']['User'][0]['User']['id'])){
            $users_infos['firstname']=$session['Auth']['User'][0]['User']['firstname'];
            $users_infos['lastname']=$session['Auth']['User'][0]['User']['lastname'];
            $users_infos['mail']=$session['Auth']['User'][0]['User']['mail'];
            $this->set(array(
                'users_infos'=>$users_infos
            ));
        }

        $menus = $this->get_menu();
        $products = $this->Product->find('all');
        $this->set(array(
            'categories'=>$categories,
            'products'=>$products,
            'current_page'=>'nos-gomallettes',
        ));
    }

    Public function index_categories($id){
        $users_infos = array();
        $this->layout='front';
        $this->loadModel('Product');
        $this->loadModel('Category');
        $categories = $this->Category->find('all');

        $session = $this->Session->read();
        $users_infos['firstname'] = false;
        if (isset($session['Auth'])){
            $users_infos['firstname']=$session['login_user']['User']['firstname'];
        }
        $category = $this->Category->cat_name($id);

        if(empty($id))
            $products = $this->Product->products_category_where_categories_id($id);

        $products = $this->Product->products_category_where_categories_id($id);
        $this->set(array(
            'categories'=>$categories,
            'category_current'=>$category,
            'products'=>$products,
            'current_page'=>'cat_view',
            'users_infos'=>$users_infos
        ));
    }

    Public function index_categories2($cat_selected){
        $users_infos = array();
        $this->layout='front';
        $this->loadModel('Product');
        $this->loadModel('Category');
        $this->loadModel('Menu');

        $session = $this->Session->read();
        $users_infos['firstname'] = false;
        if (isset($session['Auth']['User'][0]['User']['id'])){
            $users_infos['firstname']=$session['Auth']['User'][0]['User']['firstname'];
            $this->set(array(
                'users_infos'=>$users_infos,
                'users_id'=>$session['Auth']['User'][0]['User']['id']
            ));
        }
        $accessories = $this->Menu->find('all', array(
            'conditions'=> array('Menu.type'=>'accessories')
        ));
        $good_deal = $this->Menu->find('all', array(
            'conditions'=> array('Menu.type'=>'Bonnes affaires')
        ));
        $products = $this->Product->find('all',array(
            'conditions'=>array(
                'Product.'.$cat_selected =>1
            ),
        ));
        $current_page='';
        switch ($cat_selected):
            case 'all_terrain':
                $current_page="Les mallettes tout terrains";
                break;
            case 'small_cases':
                $current_page="Les  petites mallettes";
                break;
            case  'drones_cases':
                $current_page="Les mallettes Pour drones";
                break;
            default:
        endswitch;
        $this->set(array(
            'products'=>$products,
            'current_page'=>$current_page,
            'cat_selected'=>$cat_selected
        ));
    }

    Public function display_products($id){
        $this->get_menu();
        $this->layout='front';
        $this->loadModel('Menu');
        $this->loadModel('Product');
        $products = $this->Product->get_products_submenus($id);
        $categories = $this->Menu->find('all', array(
            'conditions'=>array(
                'parent'=>$id
            ),
        ));
        $this->set(array(
            'products'=>$products,
            'categories'=>$categories,
        ));
    }

    Public function display_products_by_menu_id($id,$parent){
        $this->get_menu();
        $this->layout='front';
        $this->loadModel('Menu');
        $this->loadModel('Product');
        $products = $this->Product->get_products_of_submenu($id);
        $categories = $this->Menu->find('all', array(
            'conditions'=>array(
                'parent'=>$parent
            ),
        ));
        $this->set(array(
            'products'=>$products,
            'categories'=>$categories,
            'parent'=>$parent
        ));
    }

    Public function services(){
        $users_infos = array();
        $this->layout='front';
        $this->get_menu();
        $session = $this->Session->read();
        $users_infos['firstname'] = false;
        if (isset($session['Auth']['User'][0]['User']['id'])){
            $users_infos['firstname']=$session['Auth']['User'][0]['User']['firstname'];
            $this->set(array(
                'users_infos'=>$users_infos
            ));
        }

        $this->set(array(
            'users_infos'=>$users_infos
        ));
    }

    Public function contacts(){

    }

    Public function basket($product_id =  null ){

        if(empty($product_id)){
            $basket = array();
            $this->loadModel('Order');
            $this->layout='front';
            $session = $this->Session->read();
            $users_id =$session['Auth']['User'][0]['User']['id'];
            $data = $this->Order->get_basket($users_id , 'panier');
            foreach ($data as $item) {
                $array =  array();
                foreach($item as $key => $values){
                    foreach($values as $k => $value){
                        $array[$k] = $value;
                    }
                }
                $basket[] = $array;
            }
            $this->set(array(
                'basket'=>$basket
            ));
        }

        if(!empty($product_id)){
            $this->loadModel('Order');
            $session = $this->Session->read();
            $users_id =$session['Auth']['User'][0]['User']['id'];
            $data = $this->Order->get_basket(1);
            debug($data);
        }
    }

    Public function built_in(){
        $this->layout='messenger';
    }
}

