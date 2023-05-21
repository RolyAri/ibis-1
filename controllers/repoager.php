<?php
    class Repoager extends Controller{
        function __construct()
        {
            parent::__construct();
        }

        function render(){
            $this->view->listaCostos = "";
            $this->view->clases = $this->model->listarClasesReporte();
            $this->view->tipos = $this->model->listarTipos(43);
            $this->view->familias = $this->model->tablaFamilias(43,118);
            $this->view->render('repoager/index');
        }
        
        function tipos(){
            echo $this->model->listarTipos($_POST['id']);
        }

        function clases(){
            echo $this->model->tablaFamilias($_POST['grupo'],$_POST['clase']);
        }
    }
?>