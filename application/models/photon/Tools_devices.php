<?php

get_instance()->load->interfaces("Generic");

class Tools_devices extends CI_Model implements Generic
{

    public $tables                      = null ;

    protected $url_particle             = null ;

    protected $url_photon               = null ;

    protected $war_photon               = null ;

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
                                  "
        ],

        "variables" => [

            "get"           => "SELECT * FROM [table] g where g.id_device = ? " ,
            "get_code"      => "SELECT * FROM [table] g where g.code = ?"

        ]
    ];

    public function __construct()
    {
        parent::__construct();
        $this->Load_();
    }

    public function get_war(){
        return $this->war_photon;
    }

    public function Load_($objects = null)
    {
        // TODO: Implement Load_() method.
        $this->load->database();
        $this->load->helper(["database"]);
        $this->load->library("meta");
        $this->tables = new stdClass();
        $this->tables->meta         = $this->db->dbprefix("metadata");
        $this->tables->apk          = $this->db->dbprefix("package");
        $this->tables->device       = $this->db->dbprefix("device");
        $this->tables->variables    = $this->db->dbprefix("variables");
        $this->url_particle         = $this->meta->get_meta_value("particle_url");
        $this->url_photon           = $this->meta->get_meta_value("particle_photon_get");
        $this->war_photon           = $this->meta->get_meta_value("war");


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

    public function get_variables($id_device = 0){

       if($id_device === 0 ) return json_encode([]);

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

    public function  get_particle_url () { return $this->url_particle; }

    public function  get_photon_url() { return $this->url_photon; }

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




}