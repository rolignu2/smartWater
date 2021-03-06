<?php

get_instance()->load->interfaces("Generic");

class Tools_devices extends CI_Model implements Generic
{

    public $tables                      = null ;

    protected $url_particle             = null ;

    protected $url_photon               = null ;

    protected $war_photon               = null ;

    protected $scada_off_conf           = null ;

    protected $querys = [


        "apks" => [
            "is"   => "SELECT count(*) as 'count' FROM [table] WHERE [table].name = ? "
        ],

        "devices" => [
            "find" =>  "SELECT gd.particle_id as 'particle_id' FROM [table] gd 
                                INNER JOIN ga_package g  ON g.id = gd.id_package
                                INNER JOIN ga_project gp ON gp.id = g.id_project
                                WHERE particle_id = ? AND gp.id = ?",

            "find_no_project"  => "SELECT gd.particle_id as 'particle_id' , gd.name as 'name' FROM [table] gd 
                                      INNER JOIN ga_package g  ON g.id = gd.id_package
                                      WHERE particle_id = ? ",
            "get_device"       => "SELECT 
                                    gd.name ,
                                    gd.global_var ,
                                    gd.id_device ,
                                    gd.token_id,
                                    gd.particle_id ,
                                    gd.id_package,
                                    g.id_project,
                                    g.privs,
                                    g.start_date,
                                    g.end_date
                                    FROM [table] gd 
                                      INNER JOIN ga_package g  ON g.id = gd.id_package
                                    WHERE  gd.id_device  = ?;
                                  ",

            "all"  => "select
                          GD.name,
                          GD.id_device ,
                          GD.particle_id as 'particle_id',
                          GP.active ,
                          GP.name  as 'package',
                          GPP.name as 'project'
                          from [tdevice] GD
                            inner join [tpackage] GP on GP.id = GD.id_package
                            inner join [tproject] GPP on GPP.id = GP.id_project"
        ],

        "variables" => [

            "get"           => "SELECT * FROM [table] g where g.id_device = ? " ,
            "get_code"      => "SELECT * FROM [table] g where g.code = ?"

        ],

        "scada" => [
            "get"           => "SELECT g.id_scada,g.id_device,g.create_date,g.modify_date,g.name,gu.username
                                FROM [table] g
                                INNER JOIN [table_user] gu ON gu.id = g.id_user 
                                WHERE g.id_device = ?",
            "data"          => "SELECT g.data FROM [table] g
                                WHERE g.id_device = ?",
            
            "dataFrom"     => "SELECT SD.data , SD.date , SD.event  FROM [gaData] SD inner join [gaDevice] GD on GD.particle_id= SD.device_id where GD.id_device = ? and SD.date between ? and ?"

        ]
    ];

    public function __construct()
    {
        parent::__construct();

        //configuracion inicial de tools devices , aca se cargan todas la tablas de uso
        //ademas se cargan las librerias y helpers
        $this->Load_();
    }

    public function get_war(){
        return $this->war_photon;
    }

    public function Load_($objects = null)
    {

        $this->load->database();
        $this->load->helper(["database"]);
        $this->load->library("meta");
        $this->load->library("user");
        $this->tables = new stdClass();
        $this->tables->meta         = $this->db->dbprefix("metadata");
        $this->tables->apk          = $this->db->dbprefix("package");
        $this->tables->device       = $this->db->dbprefix("device");
        $this->tables->variables    = $this->db->dbprefix("variables");
        $this->tables->scada        = $this->db->dbprefix("scada");
        $this->tables->user         = $this->db->dbprefix("user");
        $this->tables->data         = $this->db->dbprefix("data");
        $this->tables->data_his     = $this->db->dbprefix("data_his");
        $this->tables->project      = $this->db->dbprefix("project");
        $this->url_particle         = $this->meta->get_meta_value("particle_url");
        $this->url_photon           = $this->meta->get_meta_value("particle_photon_get");
        $this->war_photon           = $this->meta->get_meta_value("war");
        $this->scada_off_conf       = $this->meta->get_meta_value("scada_config");

    }

    public function Push_(... $data)
    {
        // TODO: Implement Push_() method.
    }

    public function Pull_(... $params)
    {
        // TODO: Implement Pull_() method.
    }

    public function Request_(... $params)
    {
        // TODO: Implement Request_() method.
    }

    public function Object($object = null)
    {
        // TODO: Implement Object() method.
    }

    public function getAllDevices(){

        $query  = set_database_query($this->tables->device
            ,"[tdevice]"
            ,$this->querys["devices"]["all"]
        );

        $query  = set_database_query($this->tables->apk
            ,"[tpackage]"
            ,$query
        );

        $query  = set_database_query($this->tables->project
            ,"[tproject]"
            ,$query
        );

        return json_encode($this->db->query($query)->result());

    }


    public function getDataFrom($id= 0 , $from = 0  , $to = 0 , $date = ''  ){

        $device =   $this->input->post("id") ?? $id  ;
        $from   =   $this->input->post("from") ?? $from ;
        $to     =   $this->input->post("to") ?? $to  ;

        if(is_null($device)) 
            return json_encode([]);
        
        $md     =   new DateTime('now');
        $date   =   $this->input->post("date") ?? $date; 

        
        if(empty($date) || $date == null   ) {
            $date = $md->format("Y-m-d"); 
        }


        $query  = set_database_query($this->tables->data
                ,"[gaData]"
                ,$this->querys["scada"]["dataFrom"]
        );

        $query  = set_database_query($this->tables->device
            ,"[gaDevice]"
            ,$query
        );

        $date1      = $date  . " 00:00:00";
        $date2     = $date  . " 23:59:59" ;

        $query .= " limit " . $from . " , " . $to;

       return json_encode($this->db->query($query , [
            $device,
            $date1,
            $date2
        ])->result());


    }

    public function get_variables($id_device = 0){


       if($id_device === 0 ) {

            $postDevice = $this->input->post("id") ?? null ;

            if(is_null($postDevice))
                return json_encode([]);
            else
                $id_device = $postDevice;
       }

        $query  = set_database_query($this->tables->variables
                                            ,"[table]"
                                            ,$this->querys["variables"]["get"]);

        $result = $this->db->query($query , [$id_device])->result() ;

        if( count($result) == 0 ) return json_encode([]);
        else return json_encode($result);

    }

    public function get_variablesWithCode($code){
        $query  = set_database_query($this->tables->variables
                    ,"[table]"
                    ,$this->querys["variables"]["get_code"]);

        $result = $this->db->query($query , [$code])->result() ;

        if( count($result) == 0 ) return json_encode([]);
        else return json_encode($result);
    }

    public function find_devices($device_id = null , $project = null ){


        if(is_null($device_id))
            $device_id = $this->input->post("device_id") ?? '' ;
        if(is_null($project))
            $project   = $this->input->post("project") ?? '';


        if($project == "NO_PROJECT") {
            $query  = set_database_query(
                                        $this->tables->device , "[table]" ,
                                        $this->querys["devices"]["find_no_project"]
            );
            $result = $this->db->query($query ,[$device_id])->result();
        }
        else {
            $query  = set_database_query($this->tables->device ,"[table]" ,$this->querys["devices"]["find"]);
            $result = $this->db->query($query ,[$device_id , $project])->result();
        }


        return json_encode($result);
    }

    public function get_all_device($id_device){

       $query =  set_database_query($this->tables->device ,"[table]" ,$this->querys["devices"]["get_device"]);
       return json_encode($this->db->query($query , [$id_device])->result()[0])?? json_encode([]) ;

    }

    public function get_particle_url () { return $this->url_particle; }

    public function get_photon_url() { return $this->url_photon; }

    public function find_packages($name = null ) : string {
        if($name === null )
            $name = $this->input->post("package");

        $query = set_database_query($this->tables->apk , "[table]" , $this->querys["apks"]["is"]);
        $count_apks = $this->db->query($query , [$name])
                                ->result()[0]
                                ->count ?? 0;

        if($count_apks == 0 )
            return json_encode([
                "status"    => false ,
                "count"     => 0,
                "name"      => $name
            ]);
        else
            return json_encode([
                "status"    => true ,
                "count"     => $count_apks,
                "name"      => $name
            ]);


        return  json_encode([]) ;

    }

    public function set_package ($name , $id_project   , $privs = null )
    {

        $date = new DateTime("now");
       // $this->db->trans_start();
        $this->db->insert($this->tables->apk , [
            "name"              => $name,
            "active"            => 1,
            "privs"             => $privs,
            "id_project"        => $id_project,
            "start_date"        => $date->format("y-m-d h:m:s")
        ]);
        //$this->db->trans_complete();

        return (object) [
            "status"    => $this->db->affected_rows() >= 1 ? true : false ,
            "id"        => $this->db->insert_id() ?? null
        ] ;
    }

    public function delete_package ($id){
        $this->db->trans_start();
        $this->db->where(["id" => $id]);
        $this->db->delete($this->tables->apk );
        $this->db->trans_complete();
    }

    public function get_scada_proyect($id_device = 0){

        if($id_device === 0 ) return "{}";

        $query  = set_database_query(
            $this->tables->scada,
            "[table]",
            $this->querys["scada"]["get"]
        );


        $query  = set_database_query(
            $this->tables->user,
            "[table_user]",
            $query
        );

        $result = $this->db->query($query , [$id_device])->result() ;

        if( count($result) == 0 ) return "{}";
        else return json_encode($result[0], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
    }

    public function get_scada_data_proyect($id_device = 0 ){

        if($id_device === 0 ) return "";

        $query  = set_database_query(
            $this->tables->scada,
            "[table]",
            $this->querys["scada"]["data"]
        );

        $result = $this->db->query($query , [$id_device])->result() ;

        if( count($result) == 0 ) return "";
        else return $result[0]->data;

    }

    public function delete_scada_proyect($id_scada){

        if(is_null($id_scada)){
            return json_encode([
                "status"        => FALSE,
                "msj"           => "Hubo un error al momento de eliminar el proyecto.",
                "id"            => $id_scada
            ]);
        }

        $this->db->delete($this->tables->scada , [
            "id_scada"  => $id_scada
        ]);


        if($this->db->affected_rows() >= 1){
            return json_encode([
                "status"        => TRUE ,
                "msj"           => "Eliminado con exito ...",
                "id"            => $id_scada
            ]);
        }


        return json_encode([
            "status"        => FALSE,
            "msj"           => "No se pudo eliminar directo de la base de datos ... intente mas tarde ",
            "id"            => $id_scada
        ]);

    }

    public function add_scada_proyect($id_device = 0 , $data = null , $name = null , $id_scada = 0){

        $err_message = json_encode([
           "status"  => false ,
            "msj"    => "Error al crear instancia en la base de datos o no exite dispositivo a anidar",
            "id"     => 0
        ]);

        $good_message = json_encode([
            "status" => true ,
            "msj"    => "Cambios guardados con exito ",
            "id"     => 0
        ]);



        if($id_device === 0 ) {
            return  $err_message;
        }



        $current_date = new DateTime("now");


        if($id_scada >= 1){

            $this->db->where('id_scada' , $id_scada);
            $this->db->update($this->tables->scada , [
                "data"              => $data,
                "name"              => $name,
                "modify_date"       => $current_date->format("Y-m-d h:M:s"),
                "id_user"           => $this->user->get()->id()
            ]);

            $good_message = json_encode([
                "status" => true ,
                "msj"    => "Cambios guardados con exito ",
                "id"     => $id_scada
            ]);

        }else{


            $this->db->insert($this->tables->scada , [
                "data"              => $data,
                "name"              => $name,
                "create_date"       => $current_date->format("Y-m-d h:M:s"),
                "modify_date"       => $current_date->format("Y-m-d h:M:s"),
                "id_device"         => $id_device,
                "id_user"           => $this->user->get()->id()
            ]);

            $good_message = json_encode([
                "status" => true ,
                "msj"    => "Cambios guardados con exito ",
                "id"     => $this->db->insert_id()
            ]);


        }


        return $good_message;

    }

    public function get_scada_off_config(){
        return json_decode($this->scada_off_conf) ?? json_decode([]);
    }

    public function get_scada_data( $id_device = 0 ){

        $scada_conf = $this->get_scada_off_config();


        $this->db
                    ->select('gd.*')
                    ->from($this->tables->data .  ' as gd')
                    ->join($this->tables->device . " as gds" , "gds.particle_id = gd.device_id" , "inner")
                    ->where("gds.id_device" ,$id_device);


        if(!$scada_conf->date->all){
            $this->db->where("gd.date between" , $scada_conf->date->before );
            if($scada_conf->date->after == "" || $scada_conf->date->after == "now()"){
                $this->db->where("gd.date" , "now()");
            }else{
                $this->db->where("gd.date" , $scada_conf->date->after );
            }
        }

        if($scada_conf->his){
           $compiled_       =  $this->db->get_compiled_select();
           $compiled_his    =  str_replace( $this->tables->data ,
                                            $this->tables->data_his ,
                                            $compiled_);

           $all_compiled =  $compiled_ . " UNION ALL (" . $compiled_his  . " )";

           return $this->db->query($all_compiled)->result();

        }
        else{
            return $this->db->get()->result();
        }


    }

}