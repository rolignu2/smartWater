<?php


class Webservices extends CI_Controller
{


    protected  $version         = "1.0.1";

    protected  $api             = "v1";

    protected  $key             = "";


    public function __construct()
    {
        parent::__construct();
        $this->load->library(["meta" , "operator"]);
        $this->key = $this->meta->get_meta_value("api_key");
        $this->load->model("services/services" );
    }


    public function index(){

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array(
                "status"        => "ok",
                "version"       => $this->version,
                "server"        => json_encode($_SERVER['HTTP_ACCEPT'])
            )));
    }


    public function put (){


        //llave del servicio
        $key        = $this->input->get("key") ?? null ;

        //data obtenida
        $data       = htmlspecialchars_decode($this->input->get("data")) ?? null ;

        if(!is_null($data)){
            $data = str_replace(",]", "]", $data);
        }

        //id core del photon
        $core       = $this->input->get("coreid") ?? null;

        //evento donde se ejecuta
        $event      = $this->input->get("event") ?? "NO_EVENT";

        // fecha de publicacion
        $date       = new DateTime("now");
        $date_at    = $date->format("Y-m-d H:i:s");


        //web services verificamos la llave maestra
       if(!$this->verify_key($key))
       {
           $this->operator->create_operator([
                "query"         => "intento de acceder al web services sin llave principal",
                "protocols"     => [
                    "origin"        => $this->input->server(["SERVER_ADDR" , "REMOTE_ADDR"]),
                    "agent"         => $this->input->user_agent()
                ]
           ]);
           return ;
       }


       //se verifica la transaccion
       if(!$this->services->set_new_request([
           "data"       => $data ,
           "core"       => $core,
           "date"       => $date_at,
           "key"        => $key,
           "event"      => $event
       ]))
       {
           $this->operator->create_operator([
               "query"         => "hubo un error al momento de agregar la data del servicio 'PUT' ",
               "protocols"     => [
                   "origin"     => "Particle",
                   "agent"         => $this->input->user_agent()
               ]
           ]);
           return ;
       }



        //envia la data ... de estado OK
        $encode = json_encode([
            "status"  => "OK" ,
            "date"    => $date->format("y-M-d h:m:s") ?? null
        ]);


        $this->output
            ->set_content_type('application/json')
            ->set_output($encode);


        return ;

    }


    private function verify_key($key ) : bool {

        if( ($this->key <=> $key) !== 0 || $key == null  ){

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    "status"        => false ,
                    "msj"           => "Llave del servidor es incorrecta "
                ]));

            return false;

        }

        return true ;

    }

}