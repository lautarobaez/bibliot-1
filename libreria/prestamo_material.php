<?php
include_once("libro_impreso.php");

class Prestamo_material extends Libro_impreso{
    protected static $tablaPrestamos = 'prestamos_material';

    public $id_prestamo;
    public $id_libro_impreso;
    public $id_persona;
    public $fecha_prestamo;
    public $fecha_vencimiento;
    public $fecha_devolucion;
    public $estado = 'prestado';
    public $observaciones;

    private static function tablaPrestamos(){
        return self::$tablaPrestamos;
    }

    private function limpiar($conn, $valor){
        if ($valor === null){
            return '';
        }
        return mysqli_real_escape_string($conn, trim($valor));
    }

    public function registrar($conn){
        $libro = self::traer_datos($conn, $this->id_libro_impreso);
        if (!$libro || (int)$libro['stock_disponible'] <= 0){
            return false;
        }

        $idLibro = (int)$this->id_libro_impreso;
        $idPersona = (int)$this->id_persona;
        $fechaPrestamo = $this->fecha_prestamo ?: date('Y-m-d');
        $fechaVencimiento = $this->fecha_vencimiento ?: date('Y-m-d', strtotime('+7 day'));
        $estado = $this->limpiar($conn, $this->estado);
        $observaciones = $this->limpiar($conn, $this->observaciones);

        $sql = "INSERT INTO ".self::tablaPrestamos()."(id_libro_impreso,id_persona,fecha_prestamo,fecha_vencimiento,estado,observaciones)
                VALUES($idLibro,$idPersona,'$fechaPrestamo','$fechaVencimiento','$estado','$observaciones')";
        mysqli_query($conn, $sql);
        $this->id_prestamo = mysqli_insert_id($conn);

        self::ajustar_stock($conn, $idLibro, -1);

        return $this->id_prestamo;
    }

    public static function devolver($conn, $idPrestamo, $fechaDevolucion = null){
        $prestamo = self::traer_prestamo($conn, $idPrestamo);
        if (!$prestamo || $prestamo['estado'] === 'devuelto'){
            return false;
        }

        $fecha = $fechaDevolucion ?: date('Y-m-d');
        $fecha = mysqli_real_escape_string($conn, $fecha);

        $sql = "UPDATE ".self::tablaPrestamos()." 
                SET estado='devuelto', fecha_devolucion='$fecha', updated_at=NOW()
                WHERE id_prestamo=$idPrestamo";
        mysqli_query($conn, $sql);

        self::ajustar_stock($conn, (int)$prestamo['id_libro_impreso'], 1);
        return true;
    }

    public static function actualizar_estado($conn, $idPrestamo, $nuevoEstado){
        $estado = mysqli_real_escape_string($conn, $nuevoEstado);
        $sql = "UPDATE ".self::tablaPrestamos()." SET estado='$estado', updated_at=NOW() WHERE id_prestamo=$idPrestamo";
        mysqli_query($conn, $sql);
    }

    public static function traer_prestamo($conn, $idPrestamo){
        $sql = "SELECT * FROM ".self::tablaPrestamos()." WHERE id_prestamo=$idPrestamo";
        $rs = mysqli_query($conn, $sql);
        if (!$rs){
            return null;
        }
        return mysqli_fetch_array($rs);
    }

    public static function buscar($conn, $texto = '', $estado = ''){
        $texto = mysqli_real_escape_string($conn, $texto);
        $condiciones = array();
        if ($texto !== ''){
            $condiciones[] = "(li.titulo LIKE '%$texto%' OR li.codigo_interno LIKE '%$texto%' OR pe.apellido LIKE '%$texto%' OR pe.nombre LIKE '%$texto%' OR p.estado LIKE '%$texto%')";
        }
        if ($estado !== ''){
            $estado = mysqli_real_escape_string($conn, $estado);
            $condiciones[] = "p.estado = '$estado'";
        }

        $where = '';
        if (count($condiciones) > 0){
            $where = 'WHERE '.implode(' AND ', $condiciones);
        }

        $sql = "SELECT p.*, li.titulo, li.codigo_interno, li.autor, pe.nombre, pe.apellido
                FROM ".self::tablaPrestamos()." p
                INNER JOIN ".self::tabla()." li ON li.id_impreso = p.id_libro_impreso
                INNER JOIN personas pe ON pe.id = p.id_persona
                $where
                ORDER BY p.fecha_prestamo DESC";
        $rs = mysqli_query($conn, $sql);
        $datos = array();
        while($fila = mysqli_fetch_assoc($rs)){
            $datos[] = $fila;
        }
        return $datos;
    }
}


