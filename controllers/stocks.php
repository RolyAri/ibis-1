<?php
    class Stocks extends Controller{
        function __construct()
        {
            parent::__construct();
        }

        function render(){
            $this->view->listaItems = $this->model->listarItems();
            $this->view->listaRecepciona = $this->model->listarPersonalRol(4);
            $this->view->listaCostos = $this->model->costosPorUsuario($_SESSION['iduser']);
            $this->view->listaAlmacen = $this->model->listarAlmacenGuia();
            $this->view->listaMovimiento = $this->model->listarParametros(12);
            $this->view->render('stocks/index');
        }

        function nuevoRegistro(){
            echo json_encode($this->model->nuevoRegistro());
        }

        function grabaRegisto() {
            echo json_encode($this->model->grabarRegistro($_POST['cabecera'],$_POST['detalles']));
        }

        function importarItems(){
            echo json_encode($this->model->importFromXsl($_FILES['fileUpload']));
        }

        function resumen() {
            echo json_encode($this->model->obtenerResumen($_POST['codigo']));
        }

        function exporta() {
            echo json_encode($this->model->exportarExcel($_POST['detalles']));
        }
        
    }
?>