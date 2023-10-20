<?php
class AbmEvento{
    //Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto

    
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return Tabla
     */
    private function cargarObjeto($param){
        $obj = null;
           
        if( array_key_exists('id',$param) and 
        array_key_exists('title',$param) and 
        array_key_exists('descripcion',$param) and 
        array_key_exists('start',$param) and 
        array_key_exists('end',$param) and 
        array_key_exists('textColor',$param) and 
        array_key_exists('backgroundColor',$param)){
            $obj = new evento();
            $obj->setear($param['id'], 
            $param['title'], 
            $param['descripcion'], 
            $param['start'], 
            $param['end'], 
            $param['textColor'], 
            $param['backgroundColor']);
        }
        return $obj;
    }
    
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return Tabla
     */
    private function cargarObjetoConClave($param){
        $obj = null;
        
        if( isset($param['id']) ){
            $obj = new evento();
            $obj->setear($param['id'], null, null, null, null, null, null);
        }
        return $obj;
    }
    
    
    /**
     * Corrobora que dentro del arreglo asociativo estan seteados los campos claves
     * @param array $param
     * @return boolean
     */
    
    private function seteadosCamposClaves($param){
        $resp = false;
        if (isset($param['id']))
            $resp = true;
        return $resp;
    }
    
    /**
     * 
     * @param array $param
     */
    public function alta($param){
        $resp = false;
        $param['id'] =null;
        $elObjtEvento = $this->cargarObjeto($param);
//        verEstructura($elObjtTabla);
        if ($elObjtEvento!=null and $elObjtEvento->insertar()){
            $resp = true;
        }
        return $resp;
        
    }
    /**
     * permite eliminar un objeto 
     * @param array $param
     * @return boolean
     */
    public function baja($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $elObjtEvento = $this->cargarObjetoConClave($param);
            if ($elObjtEvento!=null and $elObjtEvento->eliminar()){
                $resp = true;
            }
        }
        
        return $resp;
    }
    
    /**
     * permite modificar un objeto
     * @param array $param
     * @return boolean
     */
    public function modificacion($param){
       
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $elObjtEvento = $this->cargarObjeto($param);
            if($elObjtEvento!=null){
              $resp=$elObjtEvento->modificar();
              
               
            }
        }
        return $resp;
    }
    
    /**
     * permite buscar un objeto
     * @param array $param
     * @return boolean
     */
    public function buscar($param){
        $where = " true ";
        if ($param<>NULL){
            if  (isset($param['id']))
                $where.=" and id =".$param['id'];
            if  (isset($param['title']))
                 $where.=" and title ='".$param['title']."'";
            if  (isset($param['descripcion']))
                 $where.=" and descripcion ='".$param['descripcion']."'";
            if  (isset($param['start']))
                 $where.=" and start ='".$param['start']."'";
            if  (isset($param['end']))
                 $where.=" and end ='".$param['end']."'";
            if  (isset($param['textColor']))
                 $where.=" and textColor ='".$param['textColor']."'";
            if  (isset($param['backgrounColor']))
                 $where.=" and backgroundColor ='".$param['backgrounColor']."'";





        }
       /*  $arreglo = evento::listar($where);  */
        $obj = new evento();
        $arreglo = $obj->listar($where); 
        return $arreglo;
    
    }
    public function buscarColInfo($param){

      $colInfo = array();
      $arregloObj = $this->buscar($param);

      if (count($arregloObj) > 0){

          for ($i = 0; $i < count($arregloObj); $i++){
              $colInfo[$i] = $arregloObj[$i]->obtenerInfo();
          }
      }

      return $colInfo;
  }
public function obtenerEventos(){
  $evento = new evento();
  
  $sql= "select id, title, descripcion, start,  end, textColor,  backgroundColor  from eventos";
  $listaEventos = $evento->listarEventos($sql);
 return $listaEventos;
}    
}

?>