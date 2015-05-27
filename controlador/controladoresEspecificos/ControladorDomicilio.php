<?php
require_once 'ControladorGeneral.php';
require_once '../../modelo/Domicilio.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControladorDomicilio
 *
 * @author Flaco
 */
class ControladorDomicilio extends ControladorGeneral{
    public function agregar($datosCampos) {
        try {
            $paramDomicilio = array("calle"=>$datosCampos['calle'], "numero"=>$datosCampos['numero']);
            $resultadoDomicilio = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::INSERTAR_DOMICLIO, $paramDomicilio);
            if (!$resultadoDomicilio) {
                echo 'ERROR AL INSERTAR DOMICILIO';
            }else{
                echo 'DOMICILIO AGREGADO CORRECTAMENTE';
            }
        } catch (PDOException $excepcionPDO) {
            echo '<br>Error PDO: '.$excepcionPDO->getTraceAsString().'<br>';
        }catch (Exception $excepcionGral) {
            echo '<br>Error: '.$excepcionGral->getTraceAsString().'<br>';
        }
        }

    public function buscar($datosCampos) {
        try {
            echo '<h3>LISTADO DE DOMICILIOS</h3>';
            $resultado = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::BUSCAR_DOMICILIO);
            if (!$resultado) {
                echo '<br>ERROR AL BUSCAR DOMICILIOS!<br>';
            }else{
                $domicilio = $resultado->fetchAll(PDO::FETCH_ASSOC);
                $etiquetas = array_keys($domicilio[0]);
                echo '<br><div id="cont"><table id="tabla"><tr>';
                foreach ($etiquetas as $eti) {
                    echo '<th>'.ucfirst($eti).'</th>';
                }
                echo '</tr>';
                foreach ($domicilio as $filas) {
                    echo '<tr>';
                    foreach ($filas as $valor) {
                        echo '<td>'.$valor.'</td>';
                    }
                    echo '</tr>';
                }
                echo '</table></div>';
            }      
        } catch (PDOException $excepcionPDO) {
            echo '<br>Error PDO: '.$excepcionPDO->getTraceAsString().'<br>';
        }catch (Exception $excepcionGral) {
            echo '<br>Error: '.$excepcionGral->getTraceAsString().'<br>';
        }
    }

    public function eliminar($datosCampos) {
        try {
            echo 'SE BORRAR&Aacute; ARBITRARIAMENTE EL &Uacute;LTIMO DOMICILIO.<br>';
            $resultado = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::ULTIMO_DOMICILIO);
            if (!$resultado) {
                echo 'ERROR AL BUSCAR EL ULTIMO DOMICILIO';
            }else{
                $idUltimoDomicilio = $resultado->fetchColumn();
                $idUltimoDomicilioArray = array("id"=>$idUltimoDomicilio);
                $resultadoUltimo = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::BUSCAR_UN_DOMICILIO, $idUltimoDomicilioArray);
                if (!$resultadoUltimo) {
                    echo 'ERROR AL BUSCAR DOMICILIO';
                }else{
                    $domicilio = $resultadoUltimo->fetch(PDO::FETCH_ASSOC);
                    $idDomi = $domicilio['id'];
                    $idDomiArray = array("id"=>$idDomi);
                    echo 'ID DOMICILIO A BORRAR: '.$idDomi.'<br>';
                    $resultadoBorrarDomicilio = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::ELIMINAR_DOMICILIO, $idDomiArray);
                    if (!$resultadoBorrarDomicilio) {
                        echo 'ERROR AL BORRAR DOMICILIO';
                    }else{
                        echo 'DOMICILIO ELIMINADO<br>';
                    }
                }
            }
        }catch (PDOException $excepcionPDO) {
            echo "<br>Error PDO: ".$excepcionPDO->getTraceAsString().'<br>';
        }catch (Exception $excepcionGral) {
            echo "<br>Error: ".$excepcionGral->getTraceAsString().'<br>';
        }
    }

    public function modificar($datosCampos) {
        try {
            echo 'SE BORRAR&Aacute; ARBITRARIAMENTE EL &Uacute;LTIMO DOMICILIO.<br>';
            $resultado = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::ULTIMO_DOMICILIO);
            if (!$resultado) {
                echo 'ERROR AL BUSCAR EL ULTIMO DOMICILIO';
            }else{
                $idUltimoDomicilio = $resultado->fetchColumn();
                $idUltimoDomicilioArray = array("id"=>$idUltimoDomicilio);
                $resultadoUltimo = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::BUSCAR_UN_DOMICILIO, $idUltimoDomicilioArray);
                if (!$resultadoUltimo) {
                    echo 'ERROR AL BUSCAR DOMICILIO';
                }else{
                    $domicilio = $resultadoUltimo->fetch(PDO::FETCH_ASSOC);
                    $idDomi = $domicilio['id'];
                    $idDomiArray = array("id"=>$idDomi);
                    echo 'ID DOMICILIO A MODIFICAR: '.$idDomi.'<br>';
                    $paramModif = array("calle"=>$datosCampos['calle'], "numero"=>$datosCampos['numero'], "id"=>$idDomi);
                    $resultadoBorrarDomicilio = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::ACTUALIZAR_DOMICILIO, $paramModif);
                    if (!$resultadoBorrarDomicilio) {
                        echo 'ERROR AL MODIFICAR DOMICILIO';
                    }else{
                        echo 'DOMICILIO MODIFICADO<br>';
                    }
                }
            }
        }catch (PDOException $excepcionPDO) {
            echo "<br>Error PDO: ".$excepcionPDO->getTraceAsString().'<br>';
        }catch (Exception $excepcionGral) {
            echo "<br>Error: ".$excepcionGral->getTraceAsString().'<br>';
        }
    }

}
