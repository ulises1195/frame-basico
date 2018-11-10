<?php
class categoriasController extends AppController

{

    public function __construct(){

    parent::__construct();

    }

    public function index(){

    $categorias = $this->loadModel("categoria");

    $this->_view->categorias = $categorias->listarTodo();

    $this->_view->titulo = "Listado de categorias";

    $this->_view->renderizar("index");

    }

    public function agregar(){
        if ($_POST) {
        	if (empty($_POST['nombre']) || $_POST['nombre'] == "") {
                $this->_messages->warning(
                    'La categoria no tiene nombre', 
                    $this->redirect(array("controller"=>"categorias", "action" => "agregar"))
                );
                return;
            }

            $categorias = $this->loadModel("categoria");
            if ($categorias->guardar($_POST)) {
                $this->_messages->success(
                    'Categoría guardada correctamente', 
                    $this->redirect(array("controller"=>"categorias"))
                );
            }
        } 

        $categorias=$this->loadModel("categoria");
        $this->_view->categorias=$categorias->listarTodo();
        
        $this->_view->titulo="Agregar categoría";
        $this->_view->renderizar("agregar");
    }

    public function editar($id=null){
        if ($_POST) {
            $categoria = $this->loadModel("categoria");

            if (empty($_POST['nombre']) || $_POST['nombre'] == "") {
                $this->_messages->success(
                    'No ha insertado la categoría',
                    $this->redirect(array("controller"=>"categorias", "action" => "editar/".$_POST['id']))
                );
                return;
            }

            if ($categoria->actualizar($_POST)) {
                $this->_messages->success(
                    'Categoría editada correctamente', 
                    $this->redirect(array("controller"=>"categorias"))
                );
            } else {
               $this->_view->flashMessage = "La categoría no se guardó";
               $this->redirect(array(
                    "controller"=>"categorias",
                    "action"=>"editar/".$id)
                );
            }

        }
     

        $categoria = $this->loadModel("categoria");
        $this->_view->categoria=$categoria->buscarPorId($id);


        $categorias=$this->loadModel("categoria");
        $this->_view->categorias=$categorias->listarTodo();

        $this->_view->titulo="Editar categoría";
        $this->_view->renderizar("editar");
    }
    
    public function eliminar($id){
        $categoria = $this->loadModel("categoria");
        $registro = $categoria->buscarPorId($id);
        if (!empty($registro)) {
            if ($categoria->eliminarPorId($id)) {
            	$this->_messages->success(
                    'Categoría eliminada correctamente', 
                    $this->redirect(array("controller"=>"categorias"))
                );
	        } else {
        		$this->_messages->warning(
                    'No se puede elimnar la categoría',
                    $this->redirect(array("controller"=>"categorias"))
                );
	        }
        }
    }
}