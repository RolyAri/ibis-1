<?php
    class Orden extends Controller{
        function __construct()
        {
            parent::__construct();
        }

        function render(){
            $this->view->listaAlmacenes = $this->model->listarAlmacen();
            $this->view->listaTransportes = $this->model->listarParametros("08");
            $this->view->listaOrdenes = $this->model->listarOrdenes($_SESSION['iduser']);
            $this->view->render('orden/index');
        }

        function pedidos(){
            echo $this->model->importarPedidos();
        }

        function datosPedido(){
            echo json_encode($this->model->verDatosCabecera($_POST['pep'],$_POST['prof'],$_POST['ent']));
        }
        
    }
?>