<?php

require_once '../BASE/DataBase.php';

class EstadoCivilSelectController {

    private $referencia_a_buscar;
    private $db = 'condominio';
    private $respuesta;
    private $helper;

    public function __construct($json) {
        $data_recibida = json_decode($json);
        $this->referencia_a_buscar = pg_escape_string($data_recibida->referencia_a_buscar);
        $tipo_script = pg_escape_string($data_recibida->tipo_scritp);
        $this->decidir_metodo_a_ejecutar($tipo_script);
    }

    private function decidir_metodo_a_ejecutar($tipo_script) {
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
            default :
                $this->respuesta = null;
                break;
        }
    }

    private function consultar_estado_civil_todos() {
        //Creado: Santiago Fecha: 2021-09-12 20:10
        $dbName = new DataBase($this->db);
        $sentencia = "select id,nombre,detalle from estado_civil ec;";
        $this->respuesta = $dbName->consultar_script($sentencia);
    }

    private function consultar_estado_civil_por_referencia() {
        //Creado: Santiago Fecha: 2021-09-12 20:10
        $dbName = new DataBase($this->db);
        $sentencia = "select id,nombre,detalle from estado_civil ec"
                . " where nombre ilike '%$this->referencia_a_buscar%' or "
                . " detalle ilike '%$this->referencia_a_buscar%';";
        $this->respuesta = $dbName->consultar_script($sentencia);
    }

    private function consultar_estado_civil_por_nombre() {
        //Creado: Santiago Fecha: 2021-09-12 20:10
        $dbName = new DataBase($this->db);
        $sentencia = "select id,nombre,detalle from estado_civil ec"
                . " where nombre ilike '$this->referencia_a_buscar';";
        $this->respuesta = $dbName->consultar_script($sentencia);
    }

    private function consultar_estado_civil_por_id() {
        //Creado: Santiago Fecha: 2021-09-12 20:10
        if (is_numeric($this->referencia_a_buscar)) {
            $dbName = new DataBase($this->db);
            $id_a_buscar = intval($this->referencia_a_buscar);
            $sentencia = "select id, nombre, detalle from estado_civil ec where id = $id_a_buscar;";
            $this->respuesta = $dbName->consultar_script($sentencia);
        } else {
            $this->respuesta = null;
        }
    }

    public function generar_respuesta() {
        if (isset($this->respuesta)) {
            if (empty($this->respuesta)) {
                return array(
                    'estado' => 'OK',
                    'datos_base' => $this->respuesta,
                    'filas' => '0'
                );
            } else {
                return array(
                    'estado' => 'OK',
                    'datos_base' => $this->respuesta,
                    'filas' => count($this->respuesta)
                );
            }
        } else {
            return array(
                'estado' => 'ERROR',
                'datos_base' => null,
                'filas' => '0'
            );
        }
    }

}
