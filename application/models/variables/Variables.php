<?php


class Variables extends CI_Model implements CoreInterface
{


    public  $variable_table = "";


    public function __construct()
    {
        parent::__construct();
        //creamos una instancia al tool devices
        $this->load->model("photon/tools_devices" );
        //obtenemos la tabla con su prefijo
        $this->variable_table = $this->tools_devices->tables->variables;
        //instancia del usuario
        $this->load->library("user");
        //database
        $this->load->database();

    }


    public function save_variables(){

        $data = $this->input->post() ?? NULL;

        if($data == NULL) {
            return json_encode([
                "error"  => true  ,
                "msj"    => "La informacion procesada es erronea"
            ]);
        }

        //{"cod":"40169","name":"var1","pin":"7",
        //"type":"AO",
        //"format":"d",
        //"active":"1",
        //"actions":{"in_device":"-1",
        //"delete":"false","update":"false"},
        //"device":"3"}

        $data = (object) $data;
        $date = new DateTime("now");


        //verificamos si existe la variable por medio de su codigo
        $exist = json_decode($this->tools_devices->get_variablesWithCode($data->cod));


        if(count($exist) >= 1){

            $this->db->where('code', $data->cod);
            $this->db->update($this->variable_table ,[

                "id_device"     => $data->device,
                "id_user"       => $this->user->get()->id(),
                "name"          => $data->name ,
                "type"          => $data->type,
                "pin"           => $data->pin,
                "state"         => $data->active,
                "enabled"       => 0,
                "create_date"   => $date->format("Y-m-d h:M:s"),
                "format"        => $data->format
            ] );


            return json_encode([
                "error"   => false ,
                "msj"     => "Variable actualizada con exito  ->" . $data->cod ,
                "code"    => $data->cod,
                "id"      => null,
                "type"    => "update"
            ]);

        }



        $this->db->insert($this->variable_table , [

            "id_device"     => $data->device,
            "id_user"       => $this->user->get()->id(),
            "name"          => $data->name ,
            "type"          => $data->type,
            "pin"           => $data->pin,
            "state"         => $data->active,
            "enabled"       => 0,
            "create_date"   => $date->format("Y-m-d h:M:s"),
            "format"        => $data->format,
            "code"          => $data->cod
        ]);


        return json_encode([
            "error"   => false ,
            "msj"     => "Variables guardadas con exito ",
            "code"    => $data->cod,
            "id"      => $this->db->insert_id(),
            "type"    => "insert"
        ]);

    }

    /**
     * @todo inicia todos los componentes necesarios
     *       esto pueden ser librerias , helpers y las vistas
     * @return null no debe de retornar un valor ya que no se tomara en cuenta
     *
     * @example  to load view
     *
     *          return $this->load->view('view file' , $params , TRUE);
     *
     *          OR
     *
     *          return $this->load->view('view file' , '' , TRUE);
     *
     * Don´t forget the return  and the boolean TRUE
     *
     */
    public function _render($params = NULL)
    {

        $id_device = $this->input->get("device") ?? NULL;

        if(is_null($id_device))
            return $this->load->view('variables/error' , '' , TRUE );




        $device = $this->tools_devices->get_all_device($id_device);

        if(is_null($device) || empty($device))
            return $this->load->view('variables/error' , '' , TRUE );


        $variables          = $this->tools_devices->get_variables($id_device);
        $particle_url       = $this->tools_devices->get_particle_url();
        $photon_url         = $this->tools_devices->get_photon_url() ;
        $war                = $this->tools_devices->get_war();

        return $this->load->view('variables/show' , [

            "dev"           =>  $device,
            "variables"     =>  $variables,
            "purl"          =>  $particle_url,
            "phurl"         =>  $photon_url,
            "war"           =>  $war

        ] , TRUE );


    }

    /**
     * @todo establece todas las dependencias css dentro del header
     * @example
     *
     *  <code>
     *
     *          format 1 :
     *
     *              return array(
     * 'http://hello.css',
     *                  'http://hello2.css'
     *              );
     *
     *          format 2 :
     *
     *              return array(
     * 'http://hello.css',
     *                  '<style>p { color: red; }</style>',
     *                  'http://hello2.css'
     *              );
     *
     *          format 3 :mixed array
     *
     *          return array(
     * 'http://hello.css',
     *                  '<style>p { color: red; }</style>',
     *                  'http://hello2.css',
     *                  array('http://hello3.css','http://hello4.css'),
     *                  array(
     * array('http://hello3.css','http://hello4.css'),
     *                          array(
     *                                 '<style>p { color: red; }</style>',
     *                                  array()
     *                          )
     *                  )
     *          );
     *
     *   Ok , is AWESOME write code into array mixed ! CODE IS FUN ¡
     *
     * </code>
     *
     * @return array , devuelve un arreglo con los css
     *
     */
    public function _css()
    {
        // TODO: Implement _css() method.
    }

    /**
     * @todo establece todas las dependencias js dentro del footer
     *
     * como un solo ejemplo tenemos la siguiente devolucion
     *
     *  return array(
     * "<script>console.log('hola babyes');</script>",
     * array("type" => "text/javascript" , "location" => "header" , "script" => "<script>alert('hello');</script>"),
     * "http://hola.js",
     * [
     * "http://hola2.js",
     * "http://hola3.js"
     * ]
     *
     *
     *     <code>
     *             como parametros especificos dentro de un arreglo tenemos :
     *
     *         array("type" => "text/javascript" , "location" => "header" , "script" => "<script>alert('hello');</script>")
     *
     *         type        = tipo de documento de javascript , puede ser babel
     *         location    = en donde se colocara el script en el "header" o "footer"
     *         script      = lo que uno quiera puede ser url o script puro.
     *
     *     </code>
     *
     *
     * @return array , devuelve un arreglo con las direcciones de los js
     *
     */
    public function _javascript()
    {
        return [
            array(
                "type"          => "text/javascript" ,
                "location"      => "footer" ,
                "script"        => site_url() . 'content/assets/apps/projects/project_loader.js',
                "systemjs"      => false
            ),
            array(
                "type"          => "text/babel" ,
                "location"      => "header" ,
                "script"        => site_url() . 'content/assets/apps/variables/VarRender.jsx',
                "systemjs"      => false
            )
        ];
    }

    /**
     *
     * @deprecated 1.5
     * @todo establece funciones javascript dentro de DOM init o document.ready
     * @return array , devuelve un array donde iran las funciones
     * @example  arra("funcion1();" , "var func = function(){}" , ...);
     *
     */
    public function _actionScript()
    {
        // TODO: Implement _actionScript() method.
    }

    /**
     * @todo establece el titulo dentro del header
     * @return string , solo devuelve una cadena ...
     *
     */
    public function _title()
    {
        // TODO: Implement _title() method.
    }

    /**
     * @todo funcion que requiere el nivel de seguridad de acuerdo a los roles
     *
     * <code>
     *
     *  ok privileges funciona para darle un nivel mas de seguridad y que no utilicen
     *  alguna back-door
     *
     *  puedes agregar privilegios estaticos o con algun algoritmo de seguridad que retorne
     *  el rol que se desea analizar o computar
     *
     *  esta funcion retorna valores mixtos
     *
     *  puede retornar un string de esta forma
     *
     *      return '1,2,3,4'
     *      return 'admin,user'
     *
     *      acepta estos tokens
     *
     *          [, | & % &]
     *
     *      entonces return '1%2%3' es aceptable
     *
     *      tambien puedes devolver un arreglo no asociado
     *
     *          return array('admin' , 'user' );
     *          return array(1,2,3);
     *
     * </code>
     *
     * @return string/null/array , retorna un nivel , ninguno  o varios
     */
    public function _privileges()
    {
        // TODO: Implement _privileges() method.
    }

    /**
     * aca se carga todo lo que iniciara eventualmente en el dashboard
     * por medio de un proceso en segundo plano js
     */
    public function _actionScriptDashboard()
    {
        // TODO: Implement _actionScriptDashboard() method.
    }

    /**
     * actions es una funcion interfaz en cual verifica todas la acciones del sistema
     */
    public function _actions()
    {
        // TODO: Implement _actions() method.
    }


}