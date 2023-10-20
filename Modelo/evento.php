<?php
class evento {
    private $id;
    private $titulo;
    private $descripcion;
    private $inicio;
    private $fin;
    private $colortexto;
    private $colorfondo;
    private $mensajeoperacion;


    public function setId($id){
        $this->id = $id;
    }
    public function setTitulo($titulo){
        $this->titulo = $titulo;
    }
    public function setDescripcion($descripcion){
        $this->descripcion = $descripcion;
    }
    public function setInicio($inicio){
        $this->inicio = $inicio;
    }
    public function setFin($fin){
        $this->fin = $fin;
    }
    public function setColorTexto($colortexto){
        $this->colortexto = $colortexto;
    }
    public function setColorFondo($colorfondo){
        $this->colorfondo = $colorfondo;
    }
    public function setMensajeOperacion($mensajeoperacion){
      $this->mensajeoperacion = $mensajeoperacion;
  }



    public function getId(){
        return $this->id;
    }
    public function getTitulo(){
        return $this->titulo;
    }
    public function getDescripcion(){
        return $this->descripcion;
    }
    public function getInicio(){
        return $this->inicio;
    }
    public function getFin(){
        return $this->fin;
    }
    public function getColorTexto(){
        return $this->colortexto;
    }
    public function getColorFondo(){
      return $this->colorfondo;
  }
    public function getMensajeOperacion(){
        return $this->mensajeoperacion;
    }

    public function __construct(){
        $this->id = "";
        $this->titulo = "";
        $this->descripcion = "";
        $this->inicio = "";
        $this->fin = "";
        $this->colortexto = "";
        $this->colorfondo = "";
        $this->mensajeoperacion;
    }
    
    public function setear($id, $titulo, $descripcion, $inicio, $fin, $colortexto, $colorfondo){
        $this->setId($id);
        $this->setTitulo($titulo);
        $this->setDescripcion($descripcion);
        $this->setInicio($inicio);
        $this->setFin($fin);
        $this->setColorTexto($colortexto);
        $this->setColorFondo($colorfondo);

    }

    public function insertar(){
		$base= new BaseDatos();
		$resp= false;
		$consulta= "INSERT INTO eventos (title, descripcion, start, end, textColor, backgroundColor) VALUES (
        '".$this->getTitulo()."',
		'".$this->getDescripcion()."',
        '".$this->getInicio()."',
        '".$this->getFin()."', 
        '".$this->getColorTexto()."', 
        '".$this->getColorFondo()."')"; 
		if($base->Iniciar()){
			    if($base->Ejecutar($consulta)){
			        $resp=  true;
			    }	
                else {
				    $this->setMensajeOperacion($base->getError());		
			    }
		    } 
            else {
				$this->setMensajeOperacion($base->getError());
		    }
		return $resp;
	}
    
    public function modificar(){
	    $resultado = false; 
	    $base = new BaseDatos();
		$consulta =" UPDATE eventos
        SET title = '".$this->getTitulo()."',
        descripcion= '".$this->getDescripcion()."',
        start = '".$this->getInicio()."', 
        end = '".$this->getFin()."',
        textColor = '".$this->getColorTexto()."',
        backgroundColor = '".$this->getColorFondo()."'
        WHERE id = {$this->getId()}";
     echo $consulta;  
		if($base->Iniciar()){
			$resultado = $base->ejecutarUpdate($consulta);
      
			
    }	
		return $resultado;
	}
  

  public function listarEventos($sql) {
    $base = new BaseDatos();
    $eventos = $base->devolverEventos($sql);
    return $eventos;

  }

    public function listar($parametro){
    $arregloEvento = array();
		$base = new BaseDatos();
		$consultaEvento = "SELECT * FROM eventos ";
		if ($parametro != ""){
		    $consultaEvento .=' WHERE '.$parametro;
		}
		$res=$base->Ejecutar($consultaEvento);
		
			if($res>-1){
        if($res>0){				
				
				while($row=$base->Registro()){
					
          $obj= new evento();
          $obj->setear($row['id'], $row['title'] , $row['descripcion'], $row['start'], $row['end'], $row['textColor'], $row['backgroundColor']);
          array_push($arregloEvento, $obj);
				}
		 	}
            else{
		 		$this->setMensajeOperacion($base->getError());	
			}
		}
        else{
		 	$this->setMensajeOperacion($base->getError());
		}	
		return $arregloEvento;
	}	

    public function eliminar(){
		$base=new BaseDatos();
		$resp=false;
		if($base->Iniciar()){
				$consulta = "DELETE FROM eventos WHERE id = ".$this->getId();
				if($base->Ejecutar($consulta)){
				    $resp=  true;
				}
                else{
					$this->setMensajeOperacion($base->getError());	
				}
		}
        else{
			$this->setMensajeOperacion($base->getError());	
		}
		return $resp; 
	}

    public function __toString(){
	    return( 
        "Titulo: " . $this->getTitulo() . 
        "\n Fecha de Inicio: ". $this->getInicio() . 
        "\n Fecha de finalizacion: ". $this->getFin() .
        "\n Descripcion: ". $this->getDescripcion() . "\n");
	}
  public function obtenerInfo(){

    $info = [];
    $info['title'] = $this->getTitulo();
    $info['descripcion'] = $this->getDescripcion();
    $info['start'] = $this->getInicio();
    $info['end'] = $this->getFin();
    $info['textColor'] = $this->getColorTexto();
    $info['backgroundColor'] = $this->getColorFondo();

    

    return $info;
}
}

?>