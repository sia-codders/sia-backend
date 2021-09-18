<?php

require_once '../BASE/DataBase.php';
require_once '../Helpers/Helpers.php';

class EstadoCivilSelectController {

    private $referencia_a_buscar;
    private $db = 'condominio';
    private $respuesta;
    private $helper;

    public function __construct($json) {
        $this->helper = new Helpers();
        $data_recibida = json_decode($json);
        $this->referencia_a_buscar = pg_escape_string($data_recibida->referencia_a_buscar);
        $tipo_script = pg_escape_string($data_recibida->tipo_scritp);
        switch ($tipo_script) {
            case 's-t':
                $this->consultar_estado_civil_todos();
                break;
            case 's-r':
                $this->consultar_estado_civil_por_referencia();
                break;
            case 's-i':
                $this->consultar_estado_civil_por_id();
                break;
            case 's-n':
                $this->consultar_estado_civil_por_nombre();
                break;
        }
    }

    private function consultar_estado_civil_todos() {
        //Creado: Santiago Fecha: 2021-09-12 20:10
        $dbName = new DataBase($this->db);
        $sentencia = "select id,nombre,detalle from estado_civil ec;";
        $this->respuesta = $dbName->consultar_todos($sentencia);
    }

    private function consultar_estado_civil_por_referencia() {
        //Creado: Santiago Fecha: 2021-09-12 20:10
        $dbName = new DataBase($this->db);
        $sentencia = "select id,nombre,detalle from estado_civil ec"
                . " where nombre ilike '%$this->referencia_a_buscar%' or "
                . " detalle ilike '%$this->referencia_a_buscar%';";
        $this->respuesta = $dbName->consultar_todos($sentencia);
    }

    private function consultar_estado_civil_por_nombre() {
        //Creado: Santiago Fecha: 2021-09-12 20:10
        $dbName = new DataBase($this->db);
        $sentencia = "select id,nombre,detalle from estado_civil ec"
                . " where nombre ilike '$this->referencia_a_buscar';";
        $this->respuesta = $dbName->consultar_todos($sentencia);
    }

    private function consultar_estado_civil_por_id() {
        //Creado: Santiago Fecha: 2021-09-12 20:10
        if (is_numeric($this->referencia_a_buscar)) {
            $dbName = new DataBase($this->db);
            $id_a_buscar = intval($this->referencia_a_buscar);
            $sentencia = "select id, nombre, detalle from estado_civil ec where id = $id_a_buscar;";
            $this->respuesta = $dbName->consultar_uno($sentencia);     
        } else {
            $this->respuesta = null;
        }
    }

     public function generar_respuesta() {
        PRINT_R($this->respuesta);
        if (isset($this->respuesta)) {
            if (empty($this->respuesta)) {
                 return array(
                    'estado' => 'OK',
                    'datos_base' => $this->respuesta,
                    'filas' => '0'
                );
            } else {
                PRINT_R("ENTRO AQUI");
                return array(
                    'estado' => 'OK',
                    'datos_base' => $this->respuesta,
                    'filas' => count($this->respuesta)
                );
            }
        } else {
            return array(
                'estado' => 'ERROR',
                'datos_base' => 'vacio',
                'filas' => '0'
            );
        }
    }

}
