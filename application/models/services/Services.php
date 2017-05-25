<?php

class Services extends  CI_Model
{


    protected  $databases       = null ;

    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->databases = new stdClass();
        $this->databases->db_dataset = $this->db->dbprefix("data");
    }


    public function set_new_request(array $data ) : bool {

        $this->db->trans_begin();


        $this->db->insert($this->databases->db_dataset , [
            "data"           => $data["data"],
            "date"           => $data["date"],
            "device_id"      => $data["core"],
            "key_device"     => $data["key"],
            "event"          => $data['event']
        ]);



        $this->db->trans_complete();


        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->db->close();
            return FALSE;
        }

        return TRUE ;

    }


}