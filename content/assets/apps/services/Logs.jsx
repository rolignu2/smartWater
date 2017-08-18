class LogParams {

    constructor(){


        $.mockjax( {
            url:"/error", status:400, statusText:"Bad Request", response:function(e) {
                this.responseText="Please input correct value", a(e, this)
            }
        });

        $.mockjax( {
            url:"/status", status:500, response:function(e) {
                this.responseText="Internal Server Error", a(e, this)
            }
        });

    }


    called( func = (e)=>{ console.log(e); }){

        $.mockjax( {
            url:"/post",
            response:func
        });

    }

    init( devices = [] ){
        //{value: 1, text: "Dispositivo A -> x"},
        "inline"==App.getURLParameter("mode")?($.fn.editable.defaults.mode="inline", $("#inline").attr("checked", !0)):$("#inline").attr("checked", !1),
            $.fn.editable.defaults.inputclass="form-control",
            $.fn.editable.defaults.url="/post",
            $("#device-log").editable(
                {
                    prepend:"Seleccione un dispositivo",
                    inputclass:"form-control",
                    source:devices,
                    display:function(a, e) {
                        var i= {
                            "": "gray", 1: "green", 2: "blue"
                        }
                            , n=$.grep(e, function(e) {
                                return e.value==a
                            }
                        );
                        n.length?$(this).text(n[0].text).css("color", i[a]):$(this).empty()
                    }
                }
            ),
            $("#log-date").editable( {
                rtl: App.isRTL()
            });

    }

    initTableLog(){


        this.logTable =$("#log-table");
        this.logTable.dataTable( {
                language: {
                    aria: {
                        sortAscending: ": activate to sort column ascending", sortDescending: ": activate to sort column descending"
                    }
                    , emptyTable:"No data available in table", info:"Mostrando _START_ a _END_ de _TOTAL_ Datos",
                    infoEmpty:"No ha encontrado datos de la bitacora",
                    infoFiltered:"(filtered1 from _MAX_ total entries)",
                    lengthMenu:"_MENU_ Entradas",
                    search:"Buscar:",
                    zeroRecords:"No encontro resultados"
                },
                buttons:[],
                scrollY:400,
                deferRender:!0,
                scroller:!0,
                stateSave:!0,
                order:[[0, "asc"]],
                lengthMenu:[[10, 15, 20, -1], [10, 15, 20, "All"]],
                pageLength:10, dom:"<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>"
            }
        );

    }

}


var logs = new LogParams();

class Logs extends React.Component {

    constructor(){

        super();

        this.data = project_data;

        this.state = {
            devices : [] ,
            data    : null ,
            date    : '',
            idDevice : null,
            variables : null,
            params : {
                start   : 0 ,
                end     : 200,
                isloop  : false ,
                isdata  : true 
            }
        }

        this.getVariables = this.getVariables.bind(this);
        this.getTableHead = this.getTableHead.bind(this);
        this.getTableBody = this.getTableBody.bind(this);
        this.callBackData = this.callBackData.bind(this);

        this.callLoop = null ;


    }



    callBackData($this = this ){

        console.log("LLAMANDO AL CALLBACK DATA");
        $this.data.services.getData(
            $this.state.idDevice,
            $this.state.params.start ,
            $this.state.params.end ,
            $this.state.date ,
            (c)=>{

                let d = false 
                try{
                     c = JSON.parse(c);  
                     d = c.length >= 1 ? true : false ;
                }
                catch(e){ console.log(e); }
                console.log(c);
                $this.setState({
                    devices : $this.state.devices,
                    data    : c , 
                    date    : $this.state.date,
                    idDevice : $this.state.idDevice,
                    variables : $this.state.variables ,
                    params : {
                        start : $this.state.params.end  + 1 ,
                        end  : $this.state.params.end + 200 ,
                        isloop : true ,
                        isdata : d 
                    }
                });
            }
         );
    }

    unsetLoop(){
        try{
         clearInterval(this.callLoop);
        }catch(e){ console.log(e); }
    }

    componentWillMount(){

        var $this = this;

        logs.called((c)=>{

            switch(c.data.name){
                case 'device-log':

                    $this.setState({
                        devices : $this.state.devices,
                        data    : null ,
                        date    : $this.state.date ,
                        idDevice : c.data.value,
                        variables : null,
                        params : {
                            start : 0 ,
                            end   : 200,
                            isloop  : true ,
                            isdata  : true 
                        }
                    });


                    $this.data.variables.getVariables(c.data.value , (call)=>{
                            $this.setState({
                                devices : this.state.devices,
                                data : this.state.data,
                                date : this.state.date,
                                idDevice : this.state.idDevice,
                                variables : JSON.parse(call),
                                params : {
                                     start : 0 ,
                                     end   : 200,
                                     isloop  : true , 
                                     isdata  : true 
                                }
                            });

                    });

                    break;
                case 'log-date' :

                    let mdate = new Date(c.data.value);
                    let f     = (mdate.getFullYear()) + "-" + (mdate.getMonth() +1 ) + "-" + (mdate.getDate() +1);
                    $this.setState({
                        devices : $this.state.devices,
                        data    : null ,
                        date    : f,
                        idDevice : $this.state.idDevice,
                        variables : $this.state.variables,
                        params : {
                            start : 0 ,
                            end   : 200 ,
                            isloop  : true  ,
                            isdata  : true 
                        }
                    });
                    break;
            }



            $this.callBackData($this);

        });

        this.data.get_deviceInfo((c)=>{

            c       = JSON.parse(c);
            var a   = [];


            console.log(c);
            for(let i in c ){
                let p = c[i].active == "1" ? "Activo" : "Inactivo";
                a.push({
                    value : c[i].id_device,
                    text  : c[i].name + ' | ' + c[i].package + ' | ' + c[i].project  + ' [' + p + ']'
                });
            }


            $this.setState({
                project : null ,
                devices : a,
                data    : null ,
                date    : null,
                variables : null,
                params : this.state.params
            });

            logs.init(a);

        });


    }


    getTableHead(){

        if(this.state.variables == null ){
            return(<tr></tr>);
        }

      let a  = $.map(this.state.variables , function (p) {
            return (<th>{p.name}</th>);
       })

       return (
       <tr>
           <th>Fecha/Hora</th>
            {a}
            <th>Error</th>
            <th>Servicio</th>
        </tr>);

    }

     getTableBody(){


    
        try {
            //logs.initTableLog();
        }
        catch(w){ 
            console.log("ERROR AL CARGAR LA TABLA ... ");
            console.log(w);
        }

        return (null);

    }

    getVariables(){

        if(this.state.variables == null ){
            return (<div> No hay variables</div>);
        }
        else if(typeof this.state.variables == 'object' && this.state.variables.lenght == 0){
            return (<div>No existen variables en este dispositivo</div>);
        }

       
        let a = $.map(this.state.variables , function (p) {
             return (<p>{p.name}</p>);
        })


        return (<span id="act">{a}</span>);

    }

    componentDidMount(){

        var $this = this;
        if(this.state.params.isdata && this.state.params.isloop ){

            this.callLoop = setInterval( ()=>{
                  $this.callBackData($this);
            }  , 1000 );

        }
        else {
             this.unsetLoop();
        }
            
    }



    projectContructor(){

       

        return (
            <div>

            <div className="row">
                <div className="col-md-12 ">
                    <div className="portlet light bordered">
                        <div className="portlet-title">
                            <div className="caption font-red-sunglo">
                                <i className="icon-settings font-red-sunglo"></i>
                                <span className="caption-subject bold uppercase"> PARAMETROS DE LA BITACORA</span>
                            </div>

                        </div>
                        <div className="portlet-body form">

                            <div className="row">
                                <div className="col-md-12">
                                    <table id="user" className="table table-bordered table-striped">
                                        <tbody>

                                        <tr>
                                            <td> Dispositivo  ({this.state.idDevice})</td>
                                            <td>
                                                <a href="javascript:;" id="device-log" data-type="select" data-pk="1" data-value="" data-original-title="Seleccione un dispositivo"> </a>
                                            </td>
                                            <td>
                                                <span className="text-muted"> Selecciona un dispositivo para ver la informacion en tiempo real o por fechas </span>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td> Fecha de la informacion</td>
                                            <td>
                                                <a href="javascript:;" id="log-date" data-type="date" data-viewformat="dd/mm/yyyy" data-pk="1" data-placement="right" data-original-title="Fecha en cual cargaran los servicios "> Este dia </a>
                                            </td>
                                            <td>
                                                <span className="text-muted"> Fecha en cual desea ver la informacion.</span>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td> Variables cargadas </td>
                                            <td>
                                                {this.getVariables()}
                                            </td>
                                            <td>
                                                    <span className="text-muted">
														Las variables que se crearon en el dispositivo.
                                                    </span>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>

                                </div>

                            </div>
                        </div>

                    </div>

                </div>

            </div>


                <div className="row">
                    <div className="col-md-12">
                        <div className="portlet light bordered">
                            <div className="portlet-title">
                                <div className="caption font-dark">
                                    <i className="icon-settings font-dark"></i>
                                    <span className="caption-subject bold uppercase">BITACORA </span>
                                </div>
                                <div className="tools"> </div>
                            </div>
                            <div className="portlet-body">
                                <table className="table table-striped table-bordered table-hover order-column" id="log-table">
                                    <thead>
                                        {this.getTableHead()}
                                    </thead>
                                    <tbody>
                                        {this.getTableBody()}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

             </div>
        );
    }


    render(){
        return (<div className="row">
            {this.projectContructor()}
        </div>);
    }

}

ReactDOM.render(<Logs/>, document.getElementById("logs-components"));
