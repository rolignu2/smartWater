

'use strict';

export default function() {}

DashBoardProject =  new React.createClass({


    getInitialState: function () {
        return {
            projects: [],
            current_project: {
                id: null,
                name: null
            }
        };
    },

    componentWillMount : function () {
        console.log("{CONSOLE}  -> INICIANDO WILL MOUNT");

        var $that = this;
        project_data.get_projects(function (data) {
            try{
                data = JSON.parse(data);
                $that.setState({projects : data});
            }catch (e){}
        });
    },

    componentDidMount: function () {
        console.log("{CONSOLE}  -> INICIANDO DID MOUNT ");
    },


    render : () => {

        console.log("[CONSOLE]  -> INICIANDO RENDER DE DASHBOARD ");

        return (<div>HOLA RENDER</div>)

    }

});


//ReactDOM.render(<project_dash />, document.getElementsById("project-dash"));
