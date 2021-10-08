<?php

require_once '../MasterCrud/MasterCrudSelect.php';

class UsuarioSelectController {

    private $referencia_a_buscar;
    private $respuesta;
    private $obj_master_select;

    public function __construct($json) {
        $data_recibida = json_decode($json);
        $this->referencia_a_buscar = pg_escape_string($data_recibida->referencia_a_buscar);
        $tipo_script = pg_escape_string($data_recibida->tipo_script);        

        $this->obj_master_select = new MasterCrudSelect();
        $this->decidir_metodo_a_ejecutar($tipo_script);
    }

    private function decidir_metodo_a_ejecutar($tipo_script) {
        switch ($tipo_script) {
            case 's-t':
                $this->consultar_usuario_todos();
                break;
            case 's-c':
                $this->consultar_usuario_por_correo();
                break;
            case 's-i':
                $this->consultar_usuario_por_id();
                break;
            case 's-n':
                $this->consultar_usuario_por_nombre();
                break;
            default:
                $this->respuesta = null;
                break;
        }
    }

    private function consultar_usuario_todos() {
        //Creado: Santiago          Fecha: 2021-09-26 16:05
        $sentencia = "select id,nombrecompleto ,correo,token from usuario u;";
        $this->respuesta = $this->obj_master_select->consultar_base($sentencia);
    }

    private function consultar_usuario_por_correo() {
        /*  Creado: Santiago       Fecha: 2021-09-26 16:05
          Detalle: El correo tiene que ser exacto */
        $sentencia = "select id,nombrecompleto ,correo,token "
                . "from usuario u where u.correo ='{$this->referencia_a_buscar}'; ";
        $this->respuesta = $this->obj_master_select->consultar_base($sentencia);
    }

    private function consultar_usuario_por_nombre() {
        /* Creado: Santiago          Fecha: 2021-09-26 16:05
          Detalle: El nombre se busca por referencia */
        $sentencia = "select id,nombrecompleto ,correo,token "
                . "from usuario u where u.nombrecompleto ilike '%{$this->referencia_a_buscar}%'; ";
        $this->respuesta = $this->obj_master_select->consultar_base($sentencia);
    }

    private function consultar_usuario_por_id() {
        //Creado: Santiago      Fecha: 2021-09-26 16:05

        if (is_numeric($this->referencia_a_buscar)) {
            $id_a_buscar = intval($this->referencia_a_buscar);
            $sentencia = "select id,nombrecompleto ,correo,token from usuario u where u.id= {$id_a_buscar};";
            $this->respuesta = $this->obj_master_select->consultar_base($sentencia);
        } else {
            $this->respuesta = null;
        }
    }

    public function generar_respuesta() {
        return $this->obj_master_select->genera_respuesta($this->respuesta);
    }

}
