'use strict';


class Pvariables extends React.Component
{


    constructor(props){
        super(props)
    }

    componentDidmount(){

    }


    render (){

        console.log(this.props);
        return (<div>HOLA MUNDO RENDER</div>);
    }


}


class ProjectRender extends React.Component {

    constructor(props) {

        //obtenemos las propiedades del componente
        super(props);

        //estados iniciales , cambios por setstate
        this.state = {
            projects            : [],
            current_project     : {
                id          :  0,
                name        : null,
                actions     :  {
                    activate : false ,
                    delete   : false ,
                    update   : false ,
                    create   : false
                },
                start_date    : null ,
                end_date      : null,
                active        : false,
                packages      : []
            },
             current_device   : null ,
             current_package  : null ,
             packages_count   : 0
        };


        //estado del dispositivo actual ....
        this._dev_status = false ;

        //preparamos las funciones que apunten a la clase
        this.prepare_project            = this.prepare_project.bind(this);
        this.get_functions              = this.get_functions.bind(this);
        this.change_package             = this.change_package.bind(this);
        this.load_render_device         = this.load_render_device.bind(this);
        this.select_device              = this.select_device.bind(this);
        this._device_status             = this._device_status.bind(this);
        this.load_x                     = this.load_x.bind(this);
    }

    componentWillMount(){

        var $this = this;
        project_data.get_projects((data)=>{
             $this.setState({
                 projects :  data != '' ? JSON.parse(data) : []
             });
        } ,  2 );


    }


    prepare_project( event ){

        /*****PREPAREMOS EL PROYECTO ******/

        let target = event.target;
        let id = $(target).attr("id");
        var $this = this;


        this.state.packages_count = 0 ;
        this.state.current_device = null;
        //this.state.device_state =true ;
        this.state.current_package = null ;
        project_data.prepare_project(id , function (p) {


            try{
                var p_ = JSON.parse(p);
                p_.packages = JSON.parse(p_.packages)  ;
                $this.setState({ current_project : p_});
            }catch(e){

                $this.setState({
                    current_project : {
                        id          :  0,
                        name        : null,
                        actions     :  {
                            activate : false ,
                            delete   : false ,
                            update   : false ,
                            create   : false
                        },
                        start_date    : null ,
                        end_date      : null,
                        active        : false,
                        packages      : []
                    },
                    current_device   : null ,
                    current_package  : null ,
                    packages_count   : 0
                });
            }

        });

    }

    render_project_list (){

        var $this = this;
        return $.map( this.state.projects , (project)=>{

            let a = true ;
            if(project.active == 0)
                a = false;

            return (
                <li>
                    <a onClick={$this.prepare_project} id={project.id } title={ project.name  } href="javascript:;">
                        <span title={ a == true ? "Activo" : "Inactivo" }
                              className={ a == true ? "badge badge-info" : "badge badge-danger" }> { a== true ? "A" : "N" }
                        </span>  { String(project.name).substr(0,15 ) + "..."  } </a>
                </li>
            );
        });
    }

    render_active (){

        let pactive;
        if(this.state.current_project.actions.activate){
            if (this.state.current_project.active){
                pactive = (<li> <a onClick={this.get_functions} id="0" name="active_" ><span className="badge badge-info"> <i className="fa fa-floppy-o" aria-hidden="true"></i> </span> Desactivar Proyecto </a>  </li>);
            }
            else {
                pactive = (<li> <a onClick={this.get_functions}  id="1" name="active_"  ><span className="badge badge-info"> <i className="fa fa-floppy-o" aria-hidden="true"></i> </span> Activar Proyecto </a>  </li>);
            }    
        }
        else {
             if (this.state.current_project.active){
                pactive = (<li> <a ><span className="badge badge-info"> <i className="fa fa-exclamation-circle" aria-hidden="true"></i> </span> Proyecto Activo</a>  </li>);
            }
            else {
                pactive = (<li> <a  ><span className="badge badge-info"> <i className="fa fa-exclamation-circle" aria-hidden="true"></i> </span> Proyecto Inactivo</a>  </li>);
            }  
        }
        return pactive;
        
    }

    render_delete(){
        if(this.state.current_project.actions.delete){
            return (<li> <a data-toggle="modal" href="#delete_confirm"  ><span className="badge badge-info"> <i className="fa fa-close" aria-hidden="true"></i> </span> Eliminar </a>  </li>);
        }
        else {
            return (<li><a id="perm_null" ><span className="badge badge-info"> <i className="fa fa-pencil" aria-hidden="true"></i> </span> [No permisos] </a> </li>)
        }
    }


    get_functions(event){
       let target = event.target;
       let name   = $(target).attr("name");
       let id     = $(target).attr("id");
       var $this  = this;

       switch(name){
                case "active_":
                    $(target).attr("style" , "font-style: italic;text-decoration: line-through;");
                    project_data.save_function_order("change_active" , function(result){

                        let toast  = new ga_toast();
                        toast.config();

                        try{

                            result = JSON.parse(result);
                        
                            if(result.status){
                                $this.state.current_project.active = id  == 1 ? true : false ;
                                $this.forceUpdate();
                                toast.set_toast( result.msj , "Exito"  );
                            }
                            else {
                                toast.set_toast(result.msj , "Error" , toast.warning_data);
                            }
                           

                        }catch(e){
                            console.log(e);
                            toast.set_toast("Error critico al momento de generar la consulta" , "Error" , toast.warning_data);
                        }

                    } , {
                        data        : id ,
                        project     : this.state.current_project.id 
                    });
                    break;
                case "delete_auth":
                    $("#delete_confirm").modal('toggle');
                    break;
       }

    }


    load_todo(){


        let prj_ = null ;
        let active = null ;
        let serial_pkg = null ;
        let pkg_count = 0;
        let device_msj = "---DISPOSITIVOS---"

        if(this.state.current_project.id === 0){
            return (<div className="col-md-12">  <div className="portlet light "> ... </div></div>)
        }

        
        if(this.state.current_project.active == true )
            active = "Proyecto activo";
        else 
            active = "proyecto no activo ";
    
         
        if(this.state.current_package != null ){
             pkg_count = this.state.packages_count;
             prj_ = $.map(this.state.current_package.data , (d)=>{
                 return (<option value={ d.id_device } >{d.device_name}</option>);
             });
             device_msj = "Seleccione un dispositivo";
        }
        else {
            serial_pkg = project_data.serial_package(this.state.current_project.packages.data);
            pkg_count = serial_pkg.count;
            this.state.packages_count = pkg_count;
            this.state.current_project.packages.data = serial_pkg.data;
        }

         let pkg_opt =  $.map(this.state.current_project.packages.data , (p)=>{
             try{
                return (<option value={p.id} >{p.name}</option>);
             }catch(e){}
         });

        

        return (
            <div className="col-md-12">
               <div className="portlet light ">
                     <div className="portlet-title">
                            <div className="caption caption-md">
                                   <i className="icon-bar-chart theme-font hide"></i>
                                    <span className="caption-subject font-blue-madison bold uppercase">
                                        {this.state.current_project.name }
                                    </span>
                            </div>
                            <div className="actions">
                                 <div className="btn-group btn-group-devided" data-toggle="buttons">
                                    <label className="btn btn-transparent grey-salsa btn-circle btn-sm active">
                                         {active}
                                    </label>
                                     <label className="btn btn-transparent red  btn-circle btn-sm">
                                           {pkg_count} paquete(s)
                                    </label>
                                     <label className="btn btn-transparent grey-salsa btn-circle btn-sm">
                                         Creado por  {this.state.current_project.create_by}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div className="portlet-body">
                             <div className="row number-stats margin-bottom-30">
                                <div className="col-md-12">
                                <form  className="form-horizontal form-row-seperated">
                                    <div className="form-group">
                                                <div className="col-md-6 col-xs-12" >
                                                     <select onChange={this.change_package} className="bs-select form-control">
                                                       <option>Seleccione un paquete</option>
                                                       {pkg_opt}
                                                    </select>
                                                </div>
                                                <div className="col-md-6 col-xs-12">
                                                     <select onChange={this.select_device} className="bs-select form-control">
                                                        <option>{device_msj}</option>
                                                        {prj_}
                                                     </select>
                                                </div>
                                                <div>

                                                </div>
                                            </div>
                                     </form>
                                </div>
                            </div>
                        </div>
                     
               </div>
            </div>
        );
    }


    change_package(event){
        let val    = event.target.value;

        $.map(this.state.current_project.packages.data , (p)=>{
            try{
                if(p.id == val){
                   this.setState({
                       current_package : p 
                   });
                   return true;
                }
            }catch(e){}
        });

    }


    select_device(event){
       let val    = event.target.value;
       let dev    =  'undefined' ;

       for(let k in this.state.current_package.data){
           if(this.state.current_package.data[k].id_device == val){
               dev = this.state.current_package.data[k];
               break;
           }
       }

       if(typeof dev !== 'undefined')
           this.setState({
               current_device : dev
           });
       else
           this.setState({
               current_device : null
           });

    }


    load_x(event){

        let e = $(event.target);
        switch (e.attr("href")){
            case "#tab1":
                break;
            case "#tab2":
                ReactDOM.render(<Pvariables device ={this.state.current_device} />, document.getElementById("tab2"));
                break;
        }
    }


    load_render_device(){


        if(this.state.current_device == null )
            return (<div></div>);


        this._device_status();
        var $this  =  this;
        window.setInterval(()=>{
            $this._device_status();
        } , 1000*60);




        /****************************ZONA RENDER PARA DISPOSITIVOS****************************************/

        return ( <div className="todo-ui">
            <div className="col-md-6 col-xs-12 col-lg-6">
                <div className="portlet light ">
                    <div className="portlet-title">

                        <div className="caption" data-toggle="collapse" data-target=".todo-project-list-content">
                            <span id="dev_status" className="text"><strong
                                title={this.state.device_state == true ? "Dispositivo activo" : "Dispositivo desactivado"} >
                                •</strong>
                            </span>
                            <span id="dev_name" className="caption-subject font-green-sharp bold uppercase">
                                {this.state.current_device.device_name}
                            </span>
                        </div>

                    </div>
                    <div id="dev_body" className="portlet-body todo-project-list-content" style={{height: 'auto' }}>

                        <div className="margin-top-20 profile-desc-link">
                            <i className="fa fa-circle"></i>
                            <a href="javascript:void(0);" id="id_particle">ID : {this.state.current_device.particle_id}</a>
                        </div>

                        <div className="margin-top-20 profile-desc-link">
                            <i className="fa fa-building"></i>
                            <a href="javascript:void(0);" id="dev_build">Compilacion : [compilation]</a>
                        </div>

                        <div className="margin-top-20 profile-desc-link">
                            <i className="fa fa-clock-o"></i>
                            <a href="javascript:void(0);" id="dev_activity">Ultima actividad : [activity] </a>
                        </div>

                        <div className="margin-top-20 profile-desc-link">
                            <i className="fa fa-laptop"></i>
                            <a href="javascript:void(0);" id="dev_ip">Ultima IP : [last_ip] </a>
                        </div>

                        <div className="margin-top-20 profile-desc-link">
                            <i className="fa fa-thumbs-o-up"></i>
                            <a href="javascript:void(0);" id="status_">Estado : [status_dev] </a>
                        </div>



                    </div>
                </div>
            </div>

                <div className="col-md-6 col-xs-12 col-lg-6">
                    <div className="portlet light ">
                        <div className="portlet-title">

                            <div className="caption" data-toggle="collapse" data-target=".todo-project-list-content">
                                <span id="config_name" className="caption-subject font-green-sharp bold uppercase">
                                Configuraciones
                            </span>
                            </div>

                        </div>
                        <div id="config_body" className="portlet-body todo-project-list-content" style={{height: 'auto' }}>
                            <div className="tabbable tabbable-tabdrop">
                                    <ul className="nav nav-tabs"><li className="dropdown pull-right tabdrop"><a className="dropdown-toggle" data-toggle="dropdown" href="#"><i className="fa fa-ellipsis-v"></i>&nbsp;<i className="fa fa-angle-down"></i> <b className="caret"></b></a><ul className="dropdown-menu"><li>
                                        <a href="#tab4" data-toggle="tab">Paquete </a>
                                    </li>
                                </ul>
                                </li>
                                    <li className="">
                                        <a href="#tab1" onClick={this.load_x} data-toggle="tab" aria-expanded="false">General</a>
                                    </li>
                                    <li className="">
                                        <a href="#tab2" onClick={this.load_x} data-toggle="tab" aria-expanded="false">Variables</a>
                                    </li>
                                    <li className="">
                                        <a href="#tab3"  data-toggle="tab" aria-expanded="false">
                                            <i  className="fa fa-code" aria-hidden="true"></i>
                                        </a>
                                    </li>
                                </ul>
                                <div className="tab-content">
                                    <div className="tab-pane" id="tab1">
                                        <p> CARGANDO ...</p>
                                    </div>
                                    <div className="tab-pane" id="tab2">
                                        <p> CARGANDO ...</p>
                                    </div>
                                    <div className="tab-pane active" id="tab3">
                                        <p> CARGANDO ...</p>
                                    </div>
                                    <div className="tab-pane" id="tab4">
                                        <p> CARGANDO ...</p>
                                    </div>
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        );


    }

    _device_status(){
        var $this = this;
        project_data.get_device_status(
            $this.state.current_device.device_token_id  , (result)=>{
                //console.log(result);
                for(let i  in result ){
                    if(result[i].id == $this.state.current_device.particle_id)
                    {


                        let a = String($("#dev_name").html())
                                    .replace(" (Conectado)" , "")
                                    .replace(" (Desconectado)" , "");


                        $("#dev_build").html(
                                String($("#dev_build").html()).replace("[compilation]"
                                    , result[i].current_build_target ));

                        $("#dev_activity").html(
                            String($("#dev_activity").html()).replace("[activity]"
                                ,  $this.parseISOString(result[i].last_heard ) ));

                        $("#dev_ip").html(
                            String($("#dev_ip").html()).replace("[last_ip]"
                                , result[i].last_ip_address ));

                        $("#status_").html(
                            String($("#status_").html()).replace("[status_dev]"
                                , result[i].status ));

                        this._dev_status = result[i].connected;

                        if(result[i].connected == true){
                            $("#dev_status").addClass("parpadea text");
                            $("#dev_name").html(a + " (Conectado)");
                        }
                        else {
                            $("#dev_status").removeClass("parpadea");
                            $("#dev_name").html(a + " (Desconectado)");
                        }


                        break;
                    }
                }

            });
    }

    parseISOString(s) {
        var b = s.split(/\D+/);
        return new Date(Date.UTC(b[0], --b[1], b[2], b[3], b[4], b[5], b[6]));
    }


    componentDidMount() {

        $("#nav_projects")
            .find("li")
            .find("a").each(function () {
                console.log("hola mundo");
            });

    }

    componentWillUnmount() {

    }

    render() {


        return (
            <div className="todo-ui">
                <div className="todo-sidebar">
                    <div className="portlet light ">
                        <div className="portlet-title">

                            <div className="caption" data-toggle="collapse" data-target=".todo-project-list-content">
                                <span className="caption-subject font-green-sharp bold uppercase">Tus Proyectos </span>
                            </div>

                        </div>
                        <div className="portlet-body todo-project-list-content" style={{height: 'auto' }}>
                            <div className="todo-project-list">
                                <ul id="nav_projects" className="nav nav-stacked">
                                    {this.render_project_list()}
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div className="portlet light ">
                        <div className="portlet-title">

                            <div className="caption" data-toggle="collapse" data-target=".todo-project-list-content">
                                <span className="caption-subject font-green-sharp bold uppercase">Propiedades</span>
                            </div>

                        </div>
                        <div className="portlet-body todo-project-list-content" style={{height: 'auto' }}>
                            <div className="todo-project-list">

                                <div style={{
                                    "line-height" : "3px"
                                }}>
                                    <p><b>Creacion :</b> </p>
                                    <p>{ this.state.current_project.start_date }</p>
                                    {(() => {
                                        if(this.state.current_project.end_date != null)
                                            return (<p><b>Cierre :</b> { this.state.current_project.end_date }</p>);
                                    })()}
                                </div>

                                <ul id="nav_projects" className="nav nav-stacked">
                                    {this.render_active()}
                                    {this.render_delete()}
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="profile-content">
                    <div className="row">
                         {this.load_todo()}
                    </div>
                    <div className="row">
                        { this.load_render_device()}
                    </div>
                </div>

                <div className="modal fade" id="delete_confirm" tabindex="-1" role="delete_confirm" aria-hidden="true" style={{ "display" : "none" }}>
                                        <div className="modal-dialog">
                                            <div className="modal-content">
                                                <div className="modal-header">
                                                    <button type="button" className="close" data-dismiss="modal" aria-hidden="true"></button>
                                                    <h4 className="modal-title ">
                                                        <i className="fa fa-close" ></i> &nbsp;
                                                        Eliminar {this.state.current_project.name}
                                                    </h4>
                                                </div>
                                                <div className="modal-body">
                                                    Al momento de eliminar todas las configuraciones , dispositivos 
                                                    y packetes asociados a <b> {this.state.current_project.name} </b> tambien 
                                                    seran eliminados pero el dispositivo fisico seguira funcionando. 
                                                    <b style={{ "text-align" : "center" }}> ¿Seguro que deseas continuar ?</b>
                                                </div>
                                                <div className="modal-footer">
                                                    <button type="button" className="btn btn-danger" data-dismiss="modal">Sacame de aqui</button>
                                                    <button onClick={this.get_functions} name="delete_auth" type="button" className="btn btn-outline">Eliminar</button>
                                                </div>
                                            </div>
                                         
                    </div>
                                
                </div>

            </div>
        );
    }
}


ReactDOM.render(<ProjectRender  />, document.getElementById("render_project"));