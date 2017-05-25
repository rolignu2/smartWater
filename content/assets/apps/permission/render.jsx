


class PermsNew extends React.Component
{

    constructor(props)
    {
        super(props);
        this.state = {};
    }

    componentDidMount() {

        $("#permission_").submit(function (e) {
            try{
                perm_.new_permission($("#perm_name_").val() , $("#permission_"));
            }catch(e){
                console.log(e);
            }
            e.preventDefault();
        });

    }

    componentWillUnmount() {}

    render (){

        return (
            <div className="col-md-12 col-sm-12 col-xs-12 ">

                <div className="portlet light ">

                <div className="portlet-body form">
                    <form id="permission_" method="post" action="" role="form">
                        <div className="form-body">

                            <div className="note note-sucess">
                                <h4 className="block">Acerca de permisos </h4>
                                <p>
                                    Esta seccion solo se crean los nombres de permisos,
                                    Estos permisos deben de heredarse a los diferentes modulos
                                    creados por el administrador u otro ente autorizado.
                                </p>
                                <br />
                                <p>
                                    Este nombre de permiso no tendra efecto a ningun modulo de forma
                                    automatica y si se asigna a un usuario sin modulo este mismo vera
                                    el dashboard vacio o con modulos cuya asignacion sea nula.
                                </p>
                            </div>

                            <div className="form-group">
                                <div className="input-group">
                                                    <span className="input-group-addon">
                                                        <i className="fa fa-users"></i>
                                                    </span>
                                    <input id="perm_name_" type="text" className="form-control" placeholder="Nombre del permiso" />

                                </div>
                            </div>


                            <div className="form-actions">
                                <button type="submit" className="btn blue mt-ladda-btn ladda-button">Guardar</button>
                            </div>


                        </div>
                    </form>
                </div>
            </div>
            </div>
        );
    }

}



ReactDOM.render(<PermsNew /> , permission.tab(1));