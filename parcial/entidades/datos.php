<?php

    class datos
    {
        public $archivo;

        public static function guardar($archivo, $instancia)
        {
            $file = fopen($archivo, "a");
            $rta = fwrite($file, serialize($instancia). PHP_EOL);
            fclose($file);

            return $rta;
        }

        public static function leer($archivo)
        {
            $file = fopen($archivo, "a+"); //antes era r el modo de lectura
            $array = array();

            while(!feof($file))
            {
                $linea = fgets($file);
                if($linea != "")
                {
                    array_push($array, unserialize($linea));
                }
                
            }

            fclose($file);
            return $array;
        }

        public static function leerID($archivo)
        {
            $file = fopen($archivo, "a+");
            $lista;
            $id = 0;
            while(!feof($file))
            {
                $lista = fgets($file);
                $id++;
            }
            fclose($file);
            return $id;
        }

        /*public static function leerArchivos()
        {
            $datosMaterias = datos::leer("materias.json");
            $datosProfesores = datos::leer("profesores.json");
            $datosMateriasProfesores = datos::leer("materias-profesores.json");
            $array = array();
            $linea = "";

           if($datosMaterias != "" && $datosProfesores != "" && $datosMateriasProfesores != "")
           {
               foreach($datosMaterias as $materia)
               {
                    foreach($datosMateriasProfesores as $asignacion)
                   {
                        foreach($datosProfesores as $profesor)
                        {
                            if($materia->id == $asignacion->idMateria && $asignacion->legajo == $profesor->legajo)
                            {
                                $linea = "La materia {$materia->nombre} es dada por {$profesor->nombre}";
                                array_push($array, $linea);
                            }
                        }
                        
                   }
               }
           }

            return $array;

        }*/
        

    }


?>