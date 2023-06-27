<?php
include 'datosConexion.php';
    class Conexion {
        
        public static function get_connection(){
            $host = SERVIDOR;
            $bd = BD;
            $dsn = 'mysql:host='.$host.';port=3306;dbname='.$bd;
            $username = USUARIO;
            $password = PASS;
            $opciones = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');			
            try{
                $conexion = new PDO($dsn, $username, $password, $opciones);
                return $conexion;                    
            }catch (Exception $e){
                die("El error de Conexión es: ". $e->getMessage());
            }
        }
    }
?>
