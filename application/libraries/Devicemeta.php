<?php

get_instance()->load->required_library("Meta");

class Devicemeta extends Meta
{

    protected $tables_meta = [];

    public function __construct()
    {
        parent::__construct();

        $this->querys["meta_dev_"] = "select
	                                      META.key 	as 'key' ,
                                          META.value 	as 'value',
                                          META.label  as 'label'
                                      from
	                                    [META_TABLE] META
                                        inner join [DEVICE_TABLE] GD on GD.id_device=META.id_device
                                        inner join [DEVICE_PACKAGE] GP on GP.id = GD.id_package
	                                  where
		                                  META.key = ?
	                                  and
		                                  GD.id_device = ?
	                                  and
		                                  GP.id_project = ? ";



        $this->querys["meta_dev_1"] = "select
	                                      META.key 	as 'key' ,
                                          META.value 	as 'value',
                                          META.label  as 'label'
                                      from
	                                    [META_TABLE] META
                                        inner join [DEVICE_TABLE] GD on GD.id_device=META.id_device
	                                  where
		                                  META.key = ?
	                                  and
		                                  GD.id_device = ? 
	                                ";

        $this->tables_meta["[DEVICE_TABLE]"]      = $this->class->db->dbprefix("device");
        $this->tables_meta["[META_TABLE]"]        = $this->class->db->dbprefix("metadata");
        $this->tables_meta["[DEVICE_PACKAGE]"]    = $this->class->db->dbprefix("package");
    }

    public function get_variables($device , $project = null ){

        $query = null;

        if(is_null($project))
            $query = $this->querys["meta_dev_1"];
        else
            $query = $this->querys["meta_dev_"];

        foreach($this->tables_meta as $key=>$value)
        {
            $query = str_replace($key , $value , $query);
        }

        if(!is_null($project))
        {
            return $this->class
                    ->db
                    ->query($query , ["var_" , $device , $project])
                    ->result()[0] ?? NULL ;
        }
        else{
            return $this->class
                    ->db
                    ->query($query , ["var_" , $device ])
                    ->result()[0] ?? NULL ;
        }

    }


}