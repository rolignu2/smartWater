
var project_data =
{

    exist_project : (name  , func) => {
        ga_request({
            dir : "projects",
            model : "create_project",
            func : "exist_project"
        } , {
            data : name
        } , func );
    },

    create_project: (name , active = null , func ) => {

        let a = 0 ;
        if(active == true ) a = 1;

        ga_request({
            dir : "projects",
            model : "create_project",
            func : "new_project"
        } , {
            name : name,
            active : a
        } , func );
    },

    loaders : () =>{

        $("#create_new_project").click(function () {
            let name = $("#txt-project").val();


            if(name == '' || name === null ){
                alert("favor agregar un nombre de proyecto");
                return;
            }


            project_data.exist_project(name , function (data) {

                var toast = new ga_toast();
                toast.config();

                if(data === "")
                {
                    toast.set_toast("Error al procesar la data" , "Error" , toast.warning_data);
                    $("#research").html("Error al momento de procesar la data.").css({"opacity": "1"});
                    return false ;
                }


                data = JSON.parse(data);



                if(data.result >= 1)
                {
                    toast.set_toast("Proyecto ya existente" , "" , toast.warning_data);
                    $("#research").html("Ya existe un proyecto con este nombre").css({"opacity": "1"});
                    return false ;
                }


                let name            = $("#txt-project").val();
                let active          = $("#txt-new-active").prop("checked");



                project_data.create_project(name , active , function (result) {

                        let name            = $("#txt-project").val();

                        var toast = new ga_toast();
                        toast.config();

                       if(result === ''){
                           toast.set_toast("Error al momento de crear el proyecto" , "" , toast.warning_data);
                           return false;
                       }


                       result = JSON.parse(result);

                       if(result.result == true ){

                           ReactDOM.render( React.createElement(end_project_render,{
                                  name : name
                               })
                               , document.getElementById("_render")
                           );


                           return true;

                       }else{
                           toast.set_toast("No se pudo crear el proyecto , intente denuevo mas tarde." , "" , toast.warning_data);
                       }

                       return true;

                });


            });
        });

    },

    get_projects : ( func , e =1) => {
        ga_request({
            dir : "projects",
            model : "tools_project",
            func : "get_projects"
        } , {
            ver : e
        } , func );
    },

    prepare_project : (id , func) => {
        ga_request({
            dir : "projects",
            model : "tools_project",
            func : "prepare_project"
        } , {
            project : id
        } , func );
    },

    prepare_packages : (id , func ) => {
        ga_request({
            dir : "projects",
            model : "tools_project",
            func : "get_devices"
        } , {
            project : id
        } , func );
    },

    save_function_order :  (action , func  , params = {}) =>{
         
        let  request  = {
            dir : "projects",
            func : "" ,
            model : "tools_project"
        };

        switch(action ){
            case "change_active" :
                request.func = "save_status_project"
                break;
        }

        ga_request( request , params , func );

    },

    serial_package($packages){
        
        let count = 0 ;
        let data  = [];
        let c     = null ;

        $.map($packages , (a)=>{

            if(c === null  || c !== a.id_package ) {
                c = a.id_package;
                count++;
                data[a.id_package] = {
                    name        :  a.package_name ,
                    id          :  a.id_package,
                    data        :  [a]
                }
                return true ;
            }

            data[a.id_package].data.push(a);

        });

        return {
            count : count , 
            data  : data 
        };
    },

    get_device_status(token_ , particle_){
        let $p_ =String($purl).replace('{id_token}' , token_);
        $.getJSON( $p_  , particle_);
    },

    get_particle_request : function ($function , $params = null , $act = ''  ) {

        if($params == null ) return false;

        //device_id}/{device_function}/
        let $p      =String($phurl).replace('{id_token}' , $params.token);
        $p          = $p.replace('{device_id}' , $params.device);
        $p          = $p.replace('{device_function}' , $params.func );
        $p          = $p.replace('{params_args}' , $params.args + $act )

        console.log("Log:Request ->" + $p );

        $.getjSON($p , $function);

        return true;

    },

    variables : {

        save            : function (data , result , wait ) {

            let  request  = {
                dir : "variables",
                func : "save_variables" ,
                model : "variables"
            };


            ga_request( request , data , result );

        },

        save_cloud      : function (data, result  , params = {} ) {


            /**
             * {
                    url         : $phurl ,
                    war         : $war ,
                    device      : this.state.device.particle_id,
                    token       : this.state.device.token_id

                }
             * https://api.spark.io/v1/devices/{device_id}/{device_function}/?access_token={id_token}&args={params_args}
             * VAR;{"n":"var0","p":"0","t":"A","f":"D","a":"f"}
             * ***/

            let k = {
                n : data.name ,
                p : data.pin ,
                t : data.type,
                f : data.format,
                a : data.active == 1 ? 't' : 'f',
                v : 0
            };

            k = String(JSON.stringify(k));

            let u  = params.url;
            u = String(u)
                .replace("{device_id}" , params.device )
                .replace("{device_function}" , params.war )
                .replace("{id_token}" , params.token )
                .replace("{params_args}" , "" ) //al parecer particle actualizo a solo post
                .replace("&args=" , ""); //se eliminara el args como parametro especifico


            console.log("CONSOLE -> ENVIANDO PARAMETROS : " );
            console.log("CONSOLE -> URL : " + u );
            console.log("CONSOLE -> PARAMS : " + k);


            $.ajax({
                url     : u,
                type    : "POST",
                timeout : 30*1000,
                crossDomain : true,
                data : {
                    args : "VAR;" + k
                }
            }).done(function (r) {
                result(r);
            }).fail(function (f) {
                console.log("CONSOLE -> ERROR EN COMUNICACION CON PARTICLE ");
                result(f);
            });

        },

        remove_         : function(code , result  ){},

        remove_cloud    : function(data , result , params = {}){

             //elimina la informacion de la nube si y solo si ha sido eliminada del sistema
            //si existe un error entonces se podria aplicar un rollback de las variables
            //con el metodo sabe , se hara el rollback
            // los pasos son primero eliminar del cloud , luego con el ok eliminar la variable del sistema


        }


    }

};



project_data.loaders();
