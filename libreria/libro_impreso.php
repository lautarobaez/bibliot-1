<?php
include_once("libro_d.php");

class Libro_impreso extends Libro_d{
    protected static $tabla = 'libros_impresos';

    public $codigo_interno;
    public $ubicacion;
    public $stock_total = 0;
    public $stock_disponible = 0;
    public $estado = 'activo';

    protected static function tabla(){
        return self::$tabla;
    }

    private function limpiar($conn, $valor){
        if ($valor === null){
            return '';
        }
        return mysqli_real_escape_string($conn, trim($valor));
    }

    public function guardar($objConexion){
        $codigo = $this->codigo_interno !== '' ? $this->codigo_interno : uniqid('IMP-');
        $codigo = $this->limpiar($objConexion, $codigo);
        $autor = $this->limpiar($objConexion, $this->autor);
        $titulo = $this->limpiar($objConexion, $this->titulo);
        $edicion = $this->limpiar($objConexion, $this->edicion);
        $anio = $this->limpiar($objConexion, $this->anio);
        $origen = $this->limpiar($objConexion, $this->origen);
        $tipo = $this->limpiar($objConexion, $this->tipo);
        $area = $this->limpiar($objConexion, $this->area);
        $materia = $this->limpiar($objConexion, $this->materia);
        $comentario = $this->limpiar($objConexion, $this->comentario);
        $ubicacion = $this->limpiar($objConexion, $this->ubicacion);
        $estado = $this->limpiar($objConexion, $this->estado);

        $stockTotal = (int)$this->stock_total;
        $stockDisponible = $this->stock_disponible === '' ? $stockTotal : (int)$this->stock_disponible;
        $stockDisponible = max(0, min($stockDisponible, $stockTotal));

        $sql = "INSERT INTO ".self::tabla()."(codigo_interno, autor, titulo, edicion, anio_publicacion, origen, tipo, area, materia, comentario, ubicacion, stock_total, stock_disponible, estado)
                VALUES ('$codigo','$autor','$titulo','$edicion','$anio','$origen','$tipo','$area','$materia','$comentario','$ubicacion',$stockTotal,$stockDisponible,'$estado')";
        mysqli_query($objConexion, $sql);
    }

    public function actualizar($objConexion, $nro=0){
        $codigo = $this->limpiar($objConexion, $this->codigo_interno);
        $autor = $this->limpiar($objConexion, $this->autor);
        $titulo = $this->limpiar($objConexion, $this->titulo);
        $edicion = $this->limpiar($objConexion, $this->edicion);
        $anio = $this->limpiar($objConexion, $this->anio);
        $origen = $this->limpiar($objConexion, $this->origen);
        $tipo = $this->limpiar($objConexion, $this->tipo);
        $area = $this->limpiar($objConexion, $this->area);
        $materia = $this->limpiar($objConexion, $this->materia);
        $comentario = $this->limpiar($objConexion, $this->comentario);
        $ubicacion = $this->limpiar($objConexion, $this->ubicacion);
        $estado = $this->limpiar($objConexion, $this->estado);

        $stockTotal = (int)$this->stock_total;
        $stockDisponible = (int)$this->stock_disponible;
        $stockDisponible = max(0, min($stockDisponible, $stockTotal));

        $sql = "UPDATE ".self::tabla()." SET 
                codigo_interno='$codigo',
                autor='$autor',
                titulo='$titulo',
                edicion='$edicion',
                anio_publicacion='$anio',
                origen='$origen',
                tipo='$tipo',
                area='$area',
                materia='$materia',
                comentario='$comentario',
                ubicacion='$ubicacion',
                stock_total=$stockTotal,
                stock_disponible=$stockDisponible,
                estado='$estado',
                updated_at=NOW()
                WHERE id_impreso=$nro";
        mysqli_query($objConexion, $sql);
    }

    public function borrar($objConexion, $nro=0){
        $sql = "DELETE FROM ".self::tabla()." WHERE id_impreso=$nro";
        mysqli_query($objConexion, $sql);
    }

    public static function traer_datos($objConexion, $nro=0){
        if ($nro==0){
            return null;
        }
        $sql="SELECT * FROM ".self::tabla()." WHERE id_impreso = $nro";
        $result=mysqli_query($objConexion,$sql);
        if (!$result){
            return null;
        }
        return mysqli_fetch_array($result);
    }

    public static function buscar($objConexion, $str='', $soloDisponibles=false){
        $str = mysqli_real_escape_string($objConexion, $str);
        $where = "autor LIKE '%$str%' OR titulo LIKE '%$str%' OR codigo_interno LIKE '%$str%' OR area LIKE '%$str%' OR materia LIKE '%$str%'";
        $sql="SELECT * FROM ".self::tabla()." WHERE ($where)";
        if ($soloDisponibles){
            $sql .= " AND stock_disponible > 0 AND estado='activo'";
        }
        $sql .= " ORDER BY titulo";
        $rs=mysqli_query($objConexion,$sql);
        $lib=array();
        while($fila=mysqli_fetch_assoc($rs)){
            $lib[]=$fila;
        }
        return $lib;
    }

    public static function mostrar_disponibles($objConexion){
        return self::buscar($objConexion, '', true);
    }

    public static function ajustar_stock($objConexion, $idLibro, $delta){
        $delta = (int)$delta;
        $sql = "UPDATE ".self::tabla()." SET stock_disponible = GREATEST(0, LEAST(stock_total, stock_disponible + ($delta))), updated_at=NOW() WHERE id_impreso=$idLibro";
        mysqli_query($objConexion, $sql);
    }
}

