
class Vars extends  React.Component{

    constructor(props){

        super(props);
        let vars = JSON.parse(this.props.variables);

         //conversion de variables ya agregadas
         let data = [];
         for(let i in vars){
            data.push({
                cod     : vars[i].code,
                name    : vars[i].name,
                pin     : vars[i].pin,
                type    : vars[i].type,
                format  : vars[i].format,
                active  : vars[i].state,
                enabled : vars[i].enabled
            });
         }

        this.state = {

            device : JSON.parse(this.props.device) ,
            //vars   : JSON.parse(this.props.variables),
            status : -1,
            time   : 0,
            table  : {
                count  : data.length ,
                data   : data,
                pins   : []
            },
            particle : {
                token  : null,
                device : null ,
                func   : $serv.func.war,
                args   : $serv.cmd.test + ";"
            }

        };

        this.state.particle.token = this.state.device.particle_id;
        this.state.particle.token = this.state.device.token_id;


        for(var i = 0 ; i < $serv.max ; i++ ){

            this.state.table.pins.push({
                 d: i ,
                 a : true
            });
        }

        this.get_status         =  this.get_status.bind(this);
        this.get_calc           =  this.get_calc.bind(this);
        this.render_table       =  this.render_table.bind(this);
        this.add_variable       =  this.add_variable.bind(this);
        this.getText            =  this.getText.bind(this);
        this.save_data          =  this.save_data.bind(this);
        this.saveVariable       =  this.saveVariable.bind(this);
        this.save_on_cloud      =  this.save_on_cloud.bind(this);
        this.delete_variable    =  this.delete_variable.bind(this);

    }

    componentWillMount() {

        var $this = this;
        var t     = this.get_calc();


        setInterval(function () {

            project_data.get_device_status($this.state.device.token_id ,(result)=>{

                let id = $this.state.device.particle_id;

                for(let r in result){
                    if(result[r].id === id){
                        let  c = 0;
                        if(result[r].connected == true )
                            c= 1;
                        $this.setState({
                            status : c
                        });

                        console.log("ParticleResp : " + result[r].name + " [" + result[r].connected + "]");
                    }
                }

                // console.log(result);

            });



        } , t );





    }


    save_on_cloud(event = null , id = null ){

        if(event !== null )
            id      = String($(event.target).parent().attr("id")).replace("su_" , "");

        let data = this.state.table.data;
        var $this = this;
        for(let i in data){

            if(data[i].cod === id ){

                $("#opt_" + id ).find("div[id='load_']").css({display : "block"});
                this._hideVar(data);
                var result = function ( r  ) {


                    if(typeof  r === 'object'){

                        if(typeof r.statusText !== 'undefined' && r.statusText === 'timeout'){
                            alert("En estos momentos no podemos subir la variable.\n Verifique si el dispositivo esta encendido. ");
                        }
                        else{
                            alert("Error desconocido :S");
                        }
                    }
                    else {

                    }


                    $("#opt_" + id ).find("div[id='load_']").css({display : "none"});
                    $this._hideVar(data, false);

                };

                project_data.variables.save_cloud(data[i] , result  , {
                    url         : $phurl ,
                    war         : $war ,
                    device      : this.state.device.particle_id,
                    token       : this.state.device.token_id

                })
            }

        }

    }


    _hideVar(data , hide = true ){

        for(let i in data){
            let cod = data[i].cod;
            switch(hide){
                case true:
                    $("#su_" + cod).css({display : "none"})
                    break;
                case false:
                    $("#su_" + cod).css({display : "block"})
                    break;
            }

        }

    }

    delete_variable(event ){

    }

    saveVariable(data){


        var $this = this;
        let e = false;
        let x = $("tr[id='" + data.cod +"']");

        if(String(data.format) == "-1")
            e = true;
        else if(String(data.type) == "-1")
            e = true;
        else if(String(data.pin) == "-1")
            e = true;

        if(e){
            x.css({
                    'border-style': 'dashed',
                    'opacity': '0.75',
                    'border-color': 'red',
                    'border-width': '2px'
            });

            $("#var-msj").html("<b class='alert alert-warning'>Los campos como nombre , pin , tipo y formato son obligatorios</b>");

            return false;
        }
        else{
            x.css({
                'border-style': 'none',
                'opacity': '1'
            });
        }


        data.device = this.state.device.id_device;


        let result = function (r) {


            let j = JSON.parse(r);
            console.log( "CONSOLE -> " +  j.msj);

            switch(String(j.type)){
                case "insert":

                    if(j.id >= 1){
                        $("#act_" + data.cod ).html('<i title="Subir al photon ..." class="fa fa-cloud-upload" aria-hidden="true"></i><i title="Guardado de forma correcta" class="fa fa-check-circle" aria-hidden="true"></i>');
                    }
                    else {
                        $("#act_" + data.cod ).html('<i title="Error al subir ..." class="fa fa-exclamation" aria-hidden="true"></i>');
                    }

                    break;
                case "update":
                    $("#act_" + data.cod ).html('<i title="Actualizar al photon" class="fa fa-cloud-upload" aria-hidden="true"></i>');
                    break;
            }



           for(let i in $this.state.table.data){
                if(typeof $this.state.table.data[i].cod == j.code){
                    console.log("CONSOLE -> PHOTON ENABLED TO " + j.code + " ITS CERO");
                    $this.state.table.data[i].enabled = 0;
                }
           }


            $("#opt_" + data.cod )
                .find("div[id='load_']")
                .css({ "display" : "none" });

        };


        $("#opt_" + data.cod )
            .find("div[id='load_']")
            .css({ "display" : "inline" });


        project_data.variables.save(data , result  );


    }

    save_data( ){

        console.log("CONSOLE -> GUARDANDO VARIABLES ....");
        var data = this.state.table.data;

       $("#table-data").find("tr").each(function () {

            let $cod_ = String($(this).attr("id"));

            for(let $i in data ){
                 if(data[$i].cod == $cod_){
                     data[$i].name      = $("#n_" + $cod_).val();
                     data[$i].pin       = $("#p_" + $cod_).val();
                     data[$i].type      = $("#t_" + $cod_).val();
                     data[$i].format    = $("#f_" + $cod_).val();
                     data[$i].active    = $("#a_" + $cod_).val();
                     break;
                 }
            }

       });



       var active       = false;
       var conflict     = 0 ;



       for(let i in data ){

           var j = data[i];
           var n = null;
           var p = false;

           for(let k in data){
               n = data[k];
               if(k !== i ){


                   if(data[k].name == j.name ){
                       p = true;
                       break;
                   }
                   else if(data[k].pin == j.pin ){
                       p = true;
                       break;
                   }
                   else if(String(data[k].pin) == "-1" ){
                       p = true ;
                       break;
                   }
               }

           }

           console.log(p);
           let m = $("tr[id='" + j.cod +"']");
           let x = $("tr[id='" + n.cod +"']");

           if(p === true ){


               m.css({
                    'border-style': 'dashed',
                    'opacity': '0.75',
                    'border-color': 'red',
                    'border-width': '2px'
               });

               x.css({
                   'border-style': 'dashed',
                   'opacity': '0.75',
                   'border-color': 'red',
                   'border-width': '2px'
               });

               $("#var-msj").html("<b class='alert alert-warning'>Existen conflictos que hay que resolver.</b>");
               active = true;
               conflict ++;

           }
           else {
               m.css({
                   'border-style': 'none',
                   'opacity': '1'
               });

               x.css({
                   'border-style': 'none',
                   'opacity': '1'
               });

               if(active == false)
                   $("#var-msj").html("");

           }
       }


        this.setState({
            count  : this.state.table.count ,
            data   : data,
            pins   : this.state.table.pins
        });


        //si existen conflictos entonces no guardara la data nada mas
        if(conflict >= 1) return;


        //vamos a agregar las variables a la base de datos

        for(let k in data ){
            //las variables se agregan de forma asincrona
            this.saveVariable(data[k]);

        }

    }

    add_variable(){

        console.log("Console: Agregando Variable ... ");

        if($serv.max == this.state.table.count)
            return null ;


        let p = {

            cod         : this.get_rand(),
            name        : "var" + this.state.table.count,
            pin         : -1 ,
            type        : "",
            format      : "",
            active      : true

        };

        let a = this.state.table.data;
        a.push(p);

        this.setState({

            table : {
                count  : (this.state.table.count + 1),
                data   : a,
                pins   : this.state.table.pins
            }

        })


    }

    getText(event){

        let t = event.target.value;
        let e = $(event.target);
        let d = this.state.table.data;
        let m = String(e.attr("id")).split("_");


        for(var k in d ){

            if(d[k].cod == m[1] ){

                switch (m[0]){
                    case "n":
                        d[k].name = t;
                        break;
                }

            }

        }

        this.setState({
           table : {
               data   : d,
               count  : this.state.table.count,
               pins   : this.state.table.pins
           }
        });


    }

    render_table ($this = this ){


         let a = $.map(this.state.table.data , (d)=>{

             let c = d.cod;
             let pins       = [] ;
             let active     = [] ;


             for(var i = 0 ; i < $serv.max ; i++ ){

                 if(d.pin == -1 && i === 0){
                     pins.push(<option selected="selected" value="-1">...</option>);
                     pins.push(<option  value={i}>{i}</option>);
                 }
                 else if(d.pin == i ){
                     pins.push(<option selected="selected" value={i}>{i}</option>);
                 }
                 else
                     pins.push(<option  value={i}>{i}</option>);

             }



             if(d.active == 1 ){
                 active.push(<option value="1" selected="selected" >Si</option>);
                 active.push(<option value="0"  >No</option>);
             }
             else{
                 active.push(<option value="0" selected="selected" >No</option>);
                 active.push(<option value="1"  >Si</option>);
             }


             //tipo de datos
             let type_data = $.map($serv.var_type , function (b) {
                  if(d.type == b.value )
                    return (<option selected="selected" value={b.value}>{b.name}</option>);
                  else
                      return (<option  value={b.value}>{b.name}</option>);
             }) ;

             //el formato de la data
             let format_data= $.map($serv.var_format , function (b) {
                 if(d.format == b.value )
                    return (<option selected="selected" value={b.value}>{b.name}</option>);
                 else
                     return (<option value={b.value}>{b.name}</option>);
             }) ;


             let varState = [] ;
             let system_state = {};
             if(typeof d.enabled !== 'undefined' && d.enabled == 0){
                 varState.push(<i title="Actualizar al photon" className="fa fa-cloud-upload" aria-hidden="true"></i>);
                 system_state = { display : 'block' }
             }
             else if(typeof d.enabled !== 'undefined' && d.enabled == 1){
                 varState.push(<i title="Variable creada en el photon" className="fa fa-bolt" aria-hidden="true"></i>);
                 system_state = { display : 'block' }
             }
             else {
                 varState.push(<i title="Variable no creada" className="fa fa-plus-circle" aria-hidden="true"></i>);
                 system_state = { display : 'none' }
             }

             if(this.state.status == -1 || this.state.status == 0 ){
                 system_state = { display : 'none' }
             }

             let var_go ={}
             if(typeof  d.enabled  !== 'undefined'){
                 var_go = { display : "block" };
             }else {
                 var_go = {display : "none" }
             }



             return (
                 <tr id={c}>
                     <td>
                         {c}
                     </td>
                     <td>
                         <div className="input-group" >
                             <input maxLength="5"
                                    type="text"
                                    className="form-control"
                                    name={ "n_" +  c}
                                    id={"n_" + c }
                                    value={d.name}
                                    onChange={this.getText}
                             />

                         </div>
                     </td>
                     <td>

                         <div className="input-group" >
                            <select id={"p_" + c } className="form-control">
                                { pins }
                            </select>
                         </div>
                     </td>
                     <td>

                         <div className="input-group" >
                             <select id={"t_" + c} className="form-control">
                                 <option value="-1">Seleccione</option>
                                 {type_data}
                             </select>
                         </div>

                     </td>
                     <td>

                         <div className="input-group" >
                             <select id={"f_" + c} className="form-control">
                                 <option value="-1">Seleccione</option>
                                 {format_data}
                             </select>
                         </div>

                     </td>
                     <td>

                         <div className="input-group" >
                             <select id={"a_" + c} className="form-control">
                                 {active}
                             </select>
                         </div>

                     </td>
                     <td id={"act_" + c } >
                         {varState}
                     </td>
                     <td>

                         <div id={"opt_" + c } >
                             <div style={{display : "none"}} id="load_" class="margin-bottom-5">
                                 <a className=" filter-submit margin-bottom">
                                     <i className="fa fa-spinner" aria-hidden="true"></i>
                                 </a>
                             </div>


                             <div style={system_state} id="upload_" class="margin-bottom-5">
                                 <a id={"su_" + c } href="javascript:void(0)" onClick={this.save_on_cloud} className=" filter-submit margin-bottom">
                                     <i className="icon-cloud-upload" aria-hidden="true"></i>
                                 </a>
                             </div>

                             <div id={"del_" + c} style={var_go} id="upload_" class="margin-bottom-5">
                                 <a id={"udel_" + c } href="javascript:void(0)" onClick={this.delete_variable} className=" filter-submit margin-bottom">
                                     <i className="fa fa-trash-o" aria-hidden="true"></i>
                                 </a>
                             </div>

                         </div>


                     </td>
                 </tr>
             );

         });

         return (a);

    }

    verify_variable($name){


        /* project_data.get_particle_request(
         (request)=>
         {


         }, this.state.particle , $act );*/

    }

    get_rand(){

        return String(Math.floor((Math.random() * 100) + 1) ) +
            String(Math.floor((Math.random() * 400) + 1) );

    }

    get_calc( i = 60 ){
        var  a = 1000 * Math.floor((Math.random() * i) + 1);

        this.setState({
            time : a
        });

        return a ;
    }

    get_status(){

        let e = this.state.status;
        switch (e){

            case -1:
                return "Conectando [Espera +" + ( this.state.time / 1000 ) + " seg ]";
            case 0 :
                return "Dispositivo Desconectado";
            case 1:
                return "Dispositivo Conectado";

        }

    }

    render (){


       // console.log(this.state);

        return(

            <div>
                <div className="col-md-12 col-sm-12">

                    <h3 className="page-title"> { this.state.device.name}
                        <small>id({this.state.device.particle_id})</small>
                    </h3>
                </div>

                <div className="col-md-12 col-sm-12">

                    <div className="portlet light bordered">
                        <div className="portlet-title">
                            <div className="caption">
                                <i className="fa fa-plug font-blue"></i>
                                <span className="caption-subject font-blue bold uppercase">
                                        {this.get_status()}
                                </span>
                                <span id="var-msj">

                                </span>
                            </div>
                            <div className="actions">
                                <a onClick={this.add_variable} title="Agregar variable" className="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                                    <i className="fa fa-plus"></i>
                                </a>
                                <a onClick={this.save_data} title="guardar data" className="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                                    <i className="fa fa-floppy-o"></i>
                                </a>

                            </div>
                        </div>


                        <div className="portlet-body">
                            <div className="table-scrollable">
                                <table className="table table-hover table-light">
                                    <thead>
                                    <tr>
                                        <th> Cod. </th>
                                        <th> Nombre </th>
                                        <th> Pin </th>
                                        <th> Tipo </th>
                                        <th> Formato </th>
                                        <th> Activo </th>
                                        <th><i className="fa fa-tag" aria-hidden="true"></i></th>
                                        <th><i className="fa fa-wrench" aria-hidden="true"></i></th>
                                    </tr>
                                    </thead>
                                    <tbody id="table-data">
                                         {this.render_table()}
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        );

    }


}


ReactDOM.render(<Vars device={$dev} variables={$vdata}  />, document.getElementById("react-variables"));
