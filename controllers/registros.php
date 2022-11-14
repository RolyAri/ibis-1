<?php
    class Registros extends Controller{
        function __construct()
        {
            parent::__construct();
        }

        function render(){
            $this->view->listaCostosSelect = $this->model->costosPorUsuarioSelect($_SESSION['iduser']);
            $this->view->listaRecepciona = $this->model->listarPersonalRol(4);
            $this->view->listaGuias = $this->model->listarGuias();
            $this->view->render('registros/index');
        }

        function despachosID(){
            echo json_encode($this->model->importarDespacho($_POST['id']));
        }
        
        function ingresoAlmacen(){
            echo json_encode($this->model->insertarIngreso($_POST['detalles'],
                                                            $_POST['almacen'],
                                                            $_POST['pedido'],
                                                            $_POST['orden'],
                                                            $_POST['recepciona'],
                                                            $_POST['salida'],
                                                            $_POST['cabecera']));
        }

        function actualizarDespachos(){
            echo $this->model->listarGuias();
        }
    }
?>