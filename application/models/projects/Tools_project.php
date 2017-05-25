<?php


class Tools_project extends CI_Model implements CoreInterface
{

    protected $querys = [
        "get_project"       => "select [table].id as 'id' , [table].name as 'name' , [table].active as 'active' from [table] where [table].active = ? and [table].privs like ?;",
        "get_project_all"   => "select [table].id as 'id' , [table].name as 'name' , [table].active as 'active' from [table] where  [table].privs like ?;",
        "privs"             => "select  p.privs as 'privs' from [table] p where p.id = ?",
        "all_data_project"  => "select * from [table] where id = ?",
        "package_project"   => "select 
	                                pkg.id 				as 'id_package',
                                    pkg.name			as 'package_name',
                                    gd.id_device		as 'id_device',
                                    gd.name				as 'device_name',
                                    gd.global_var       as 'device_global_var',
                                    gd.token_id         as 'device_token_id',
                                    gd.particle_id		as 'particle_id',
                                    gd.meta_data        as 'device_metadata',
                                    gd.product_id       as 'device_prod_id',
                                    pkg.privs 			as 'package_privs'
                                from [T_PACKAGE] pkg 
                                inner join [T_DEVICE] gd on gd.id_package = pkg.id
                                where pkg.id_project = ? and pkg.privs sounds like ?;"
    ];


    protected  $table = "project";

    protected  $table_package = "package";

    protected  $table_device  = "device";

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper(["database"]);

        $this->table            = $this->db->dbprefix($this->table);
        $this->table_package    = $this->db->dbprefix($this->table_package);
        $this->table_device     = $this->db->dbprefix($this->table_device);
    }

    public function get_privs_project($id)
    {
        $query = set_database_query($this->table , "[table]" , $this->querys["privs"]);
        return $this->db->query($query, [$id])->result()[0]->privs ?? 0 ;
    }


    public function  get_projects(){


        $ver        = $this->input->post("ver") ?? 1;

        $query      = set_database_query( $this->table ,"[table]"  , $this->querys['get_project']);
        $uid        = $this->user->get()->id();

        if($ver == 1 || $ver == 0)
            $result     = $this->db->query($query , [ 1 ,   "%"  . $uid . "%"  ])->result();
        else
        {
            $query      = set_database_query( $this->table ,"[table]"  , $this->querys['get_project_all']);
            $result     = $this->db->query($query , [  "%"  . $uid . "%"  ])->result();
        }


        //print_r($this->db->last_query());
        return json_encode($result);
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
        // TODO: Implement _render() method.
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
        // TODO: Implement _javascript() method.
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


    public function prepare_project($id_project = null ){
        /*
         * {
                id          :  0,
                name        : null,
                actions     :  {
                    activate : false ,
                    delete   : false ,
                    update   : false ,
                    create   : false
                },
                start_date    : null ,
                end_date      : null
            }
         * **/

        if(is_null($id_project))
            $id_project = $this->input->post("project") ?? 0 ;

        $query      = set_database_query( $this->table
                                            ,"[table]"
                                            , $this->querys['all_data_project']
                                        );

        $result = $this->db->query($query , [$id_project])->result()[0] ?? null ;

        if(is_null($result))
            return json_encode([
                "id"            => 0 ,
                "name"          => null ,
                "actions"       => [
                    "activate"      => false ,
                    "delete"        => false ,
                    "update"        => false ,
                    "create"        =>false
                ],
                "start_date"        => null ,
                "end_date"          => null
            ]);


        $my_id              = $this->user->get()->id();

        $privs              = explode("," , $result->privs) ?? [];
        $grant              = false;


        foreach ($privs as $priv)
        {
            if($priv === $my_id){
                $grant = true;
                break;
            }
        }

        $create_by = "Anonimo";
        if($result->create_by !== null)
             $create_by = $this->user->get_other_user($result->create_by)->get_all_name();
        

        return json_encode([
            "id"            => $result->id  ,
            "name"          => $result->name ,
            "actions"       => [
                "activate"      => $grant ,
                "delete"        => $grant ,
                "update"        => $grant ,
                "create"        => $grant
            ],
            "start_date"        => $result->start_date ,
            "end_date"          => $result->end_date,
            "active"            => (int) $result->active ==  1 ? true : false,
            "packages"          => $this->get_devices($id_project) ,
            "create_by"         => $create_by
        ]);

    }



    public function get_devices($id_project = 0){

            /**

                 pkg.id 				as 'id_package',
                                    pkg.name			as 'package_name',
                                    gd.id_device		as 'id_device',
                                    gd.name				as 'device_name',
                                    gd.global_var       as 'device_global_var',
                                    gd.token_id         as 'device_token_id',
                                    gd.particle_id		as 'particle_id',
                                    gd.meta_data        as 'device_metadata',
                                    gd.product_id       as 'device_prod_id',
                                    pkg.privs 			as 'package_privs'

            ***/


            if($id_project == 0 )
                   $id_project =  $this->input->post_get("project");
        
            
            $id_user = $this->user->get()->id() ?? null ; 

            if(is_null($id_user))
                    return json_encode([
                        "status"  => 0 ,
                        "msj"     => "Error al momento de identificar el usuario" ,
                        "data"    => null 
                    ]);

            
            $query = set_database_query($this->table_package , "[T_PACKAGE]" , $this->querys['package_project']);
            $query = set_database_query($this->table_device , "[T_DEVICE]" , $query);


            $result = $this->db->query($query , [
                $id_project , 
                "%" . $id_user . "%"
            ])->result();


            if(sizeof($result) == 0 )
                return json_encode([
                        "status"  => 2 ,
                        "msj"     => "No exite paquetes con este proyecto " ,
                        "data"    =>  []
                    ]);


            return json_encode([
                        "status"  => 1 ,
                        "msj"     => "" ,
                        "data"    =>  $result
                    ]);

    }


    public function save_status_project($status = null , $id = null ){
         if(is_null($status))
            $status = $this->input->post("data");

         if(is_null($id))
            $id = $this->input->post("project");

         $this->db->where([ "id" => $id  ]);

         if($status == 0 )
            $this->db->update($this->table , [
                 "active"  => $status
            ]);
        else {
            $date = new DateTime("now");
            $this->db->update($this->table , [
                 "active"       => $status,
                 "end_date"     => $date->format("y-m-d h:M:s")
            ]);
        }
            

         $status = $this->db->affected_rows() >= 1 ? true : false ;
         
         return json_encode([
             "status"   => $status ,
             "msj"      => $status == true ? "Cambio realizado con exito " : "No se realizo cambio alguno"     
         ]);
         
    }
}