
<?php 


class View_scada extends CI_Model implements CoreInterface{



    public function __construct()
    {
        parent::__construct();


        $this->load->model("photon/tools_devices" );
        //obtenemos la instancia de la base de datos
        $this->load->database();
        //model en cual se llama las funciones de data en las variables
        $this->load->model("variables/vartools");
    }


    public function save_scada() : string {

        $params = (object) $this->input->post() ?? null ;

        $id_device  = $params->device ?? 0  ;
        $data       = $params->data ?? null;
        $name       = $params->name ?? null ;
        $id_scada   = $params->scada ?? 0;

        return $this->tools_devices
                    ->add_scada_proyect($id_device,$data,$name,$id_scada);

    }


    public function delete_scada() : string {

        $id_scada = (object) $this->input->post() ?? null ;
        return $this->tools_devices->delete_scada_proyect($id_scada->id ?? null );
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


        //obtenemos el id del dispositivo
        $device = $this->input->get("device") ?? null ;

        $deviceInfo     = "{}";
        $variablesInfo  = "{}";
        $scadaInfo      = "{}";
        $scadaData      = "";

        if(!is_null($device)){
            $deviceInfo         = $this->tools_devices->get_all_device($device);
            $variablesInfo      = $this->tools_devices->get_variables($device);
            $scadaInfo          = $this->tools_devices->get_scada_proyect($device);
            $scadaData          = $this->tools_devices->get_scada_data_proyect($device);
            $scadaWS            = $this->vartools->Get_ScadaWsData($device);
        }



        return $this->load->view("scada/show_scada" , [
            "url"           => site_url(),              //url podria deprecarse y usar la url generada
            "deviceInfo"    => $deviceInfo,             // informacion del dispositivo en json
            "variablesInfo" => $variablesInfo,          // informacion de las variables creadas por el usuario en json
            "scadaInfo"     => $scadaInfo,              // informacion del scada en json
            "scadaData"     => json_decode($scadaData), //informacion de los datos scada en object
            "scadaws"       => json_encode($scadaWS ,  JSON_HEX_TAG | JSON_HEX_APOS )    //informacion de las variables en json
        ] , true );
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
        return print_css([
            "/content/assets/apps/scada/codemirror/lib/codemirror.css",
            "/content/assets/apps/scada/generic.css",
            "/content/assets/global/plugins/jquery-ui/jquery-ui.min.css",
            "/content/assets/global/plugins/select2/css/select2.min.css",
            "/content/assets/global/plugins/select2/css/select2-bootstrap.min.css"
        ]);
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
        // TODO: Implement _javascript() method.


        return [

            array(
                "type"          => "text/javascript" ,
                "location"      => "header" ,
                "script"        => site_url() . "content/assets/apps/scada/go.min.js" ,
                "systemjs"      => false
            ),
            array(
                "type"          => "text/javascript" ,
                "location"      => "header" ,
                "script"        => site_url() . "content/assets/apps/scada/core.js" ,
                "systemjs"      => false
            )
            ,
            array(
                "type"          => "text/javascript" ,
                "location"      => "header" ,
                "script"        => site_url() . "content/assets/apps/scada/GuideLines.js" ,
                "systemjs"      => false
            ),
            array(
                "type"          => "text/javascript" ,
                "location"      => "header" ,
                "script"        => site_url() . "content/assets/apps/scada/codemirror/lib/codemirror.js" ,
                "systemjs"      => false
            ),
            array(
                "type"          => "text/javascript" ,
                "location"      => "header" ,
                "script"        => site_url() . "content/assets/apps/scada/codemirror/mode/xml/xml.js" ,
                "systemjs"      => false
            ),
            array(
                "type"          => "text/javascript" ,
                "location"      => "header" ,
                "script"        => site_url() . "content/assets/apps/scada/codemirror/mode/javascript/javascript.js" ,
                "systemjs"      => false
            ),
            array(
                "type"          => "text/javascript" ,
                "location"      => "header" ,
                "script"        => site_url() . "content/assets/apps/scada/codemirror/mode/htmlmixed/htmlmixed.js" ,
                "systemjs"      => false
            )
           ,
           array(
                "type"          => "text/javascript" ,
                "location"      => "header" ,
                "script"        => site_url() . "content/assets/global/plugins/jquery-ui/jquery-ui.min.js" ,
                "systemjs"      => false
            ),
            array(
                "type"          => "text/javascript" ,
                "location"      => "footer" ,
                "script"        => site_url() . 'content/assets/apps/projects/project_loader.js',
                "systemjs"      => false
            ),
            array(
                "type"          => "text/javascript" ,
                "location"      => "footer" ,
                "script"        => site_url() . 'content/assets/global/plugins/select2/js/select2.full.min.js',
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
        return "Sistema SCADA";
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
}}