<?php
class tareasController extends AppController

{

    public function __construct(){

    parent::__construct();

    }

    public function index(){

    $tareas = $this->loadModel("tarea");

    $this->_view->tareas = $tareas->getTareas();

    $this->_view->titulo = "Listado de tareas";

    $this->_view->renderizar("index");

    }

    public function agregar(){
        if ($_POST) {

        	if (empty($_POST['nombre']) || $_POST['nombre'] == "") {
                $this->_messages->warning(
                    'La tarea no tiene nombre', 
                    $this->redirect(array("controller"=>"tareas", "action" => "agregar"))
                );
                return;
            }
            $tareas = $this->loadModel("tarea");
            if ($tareas->guardar($_POST)) {
                $this->_messages->success(
                    'Tarea guardada correctamente', 
                    $this->redirect(array("controller"=>"tareas"))
                );
            }
            
        }

        $categorias=$this->loadModel("categoria");
        $this->_view->categorias=$categorias->listarTodo();
        

        $this->_view->titulo="Agregar tarea";
        $this->_view->renderizar("agregar");
    }

    public function editar($id=null){
        if ($_POST) {
            $tarea = $this->loadModel("tarea");
            if ($tarea->actualizar($_POST)) {
                $this->_messages->success(
                    'Tarea editada correctamente', 
                    $this->redirect(array("controller"=>"tareas"))
                );
            } else {
               $this->_view->flashMessage = "Los datos no se guardaron";
               $this->redirect(array(
                    "controller"=>"tareas",
                    "action"=>"editar/".$id)
                );
            }

            $this->redirect(array("controller"=>"tareas"));
        }
        /*Buscar tarea por ID*/
        $tarea = $this->loadModel("tarea");
        $this->_view->tarea=$tarea->buscarPorId($id);


        $categorias=$this->loadModel("categoria");
        $this->_view->categorias=$categorias->listarTodo();

        $this->_view->titulo="Editar tarea";
        $this->_view->renderizar("editar");
    }
    
    public function eliminar($id){
        $tarea = $this->loadModel("tarea");
        $registro = $tarea->buscarPorId($id);

        if (!empty($registro)) {
            $tarea->eliminarPorId($id);
            $this->_messages->success(
                    'Tarea eliminada correctamente', 
                    $this->redirect(array("controller"=>"tareas"))
                );
        }
    }

    public function cambiarEstado($id, $status){
        $tarea = $this->loadModel("tarea");
        if ($status=="off") {
            $status=0;
        }elseif($status=="on"){
            $status=1;
        }
        $tarea->status($id, $status);
        $this->_messages->success(
                    'Estado cambiado correctamente', 
                    $this->redirect(array("controller"=>"tareas"))
                );

        
    }
}