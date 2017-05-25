'use strict';

class permission
{
    constructor() {

    }

    static tab (index = null )
    {
        return document.getElementById("tab_" + index);
    }


    new_permission (name , $form){

        var toast_                  = new ga_toast();
        var ladda                   = Ladda.create($($form).find("button")[0]);


        toast_.config();
        ladda.start();

        ga_request({
           dir      : "system",
           func     : "save_perm",
           model    : "permissions"
        } , {
            name : name
        } , function (result) {

            result = JSON.parse(result);
            switch(result.status){
                case true :
                    toast_.set_toast(result.msj , 'Exito' , toast_.success_data);
                    break;
                case false:
                    toast_.set_toast(result.msj , 'Error' , toast_.warning_data);
                    break;
            }
            ladda.stop();
        });
    }



}

var perm_           = new permission();



