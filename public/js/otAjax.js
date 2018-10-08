/**
 *
 *  My AJAX code
 *
 */

window.otAjax = {

    reqListener: function() {
        console.log(this.responseText);
    },


    add_admin: function(id) {
        let oReq = new XMLHttpRequest();
        if (oReq.addEventListener)
            oReq.addEventListener("load", otAjax.reqListener, false);
        else if (oReq.attachEvent)
            oReq.addEventListener("onload", otAjax.reqListener);
        oReq.open("GET", "/user/" + id + "/admin");
        oReq.send();
    },

    rm_admin: function(id) {
        let oReq = new XMLHttpRequest();
        oReq.addEventListener("load", otAjax.reqListener);
        oReq.open("GET", "/user/" + id + "/admin/destroy");
        oReq.send();

    }
};