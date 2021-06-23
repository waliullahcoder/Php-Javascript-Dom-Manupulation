
// process for form data
function formData(form) {
    if(form) {
        form = typeof form === 'string' ? document.querySelector(form):form;
        var formData = form.constructor === Object ? new FormData():new FormData(form);

        if (form && form.constructor === Object) {
            Object.entries(form).map(obj => formData.append(obj[0], obj[1]));
        }else if(form) {
            [...form.elements].map((el, i) => isNaN(i) && el.name.length > 0 ? formData.append(el.name.trim(), el.value.trim()):false);
            form.querySelectorAll('input[type="file"]').forEach(file => formData.append(file.name.trim(), file.files[0]));
        }
        return formData;
    }
    return new FormData();
}


// to get request.js folder assets path and generate base path
var scriptEls = document.getElementsByTagName( 'script' ), paths = [];
var thisScriptEl = scriptEls[scriptEls.length - 1], basePath = true;
var scriptPath = thisScriptEl.src.split('/').map(path => {
    if(path === 'assets') {
        basePath = false;
    }

    if(basePath) {
        paths.push(path);
    }
});
var base_url = paths.join('/');

function requestProcess(url, method, options) {
    const {
        callBack
    } = options;
    const {
        sendObject
    } = options;

    if (method !== 'GET' && sendObject) {
        return fetch(url, {
            method,
            body: formData(sendObject)
        }).then(data => data.json()).then(callBack).catch(callBack);
    }

    return fetch(url, {
        method
    }).then(data => data.json()).then(callBack).catch(callBack);
}

class Request {

    static paramsManage(sendObject, callBack) {
        callBack = sendObject && typeof sendObject === "function" ? sendObject : callBack;
        sendObject = sendObject && Object.keys(sendObject).length ? sendObject : '';

        callBack = callBack || typeof callBack === "function" ? callBack : function () {};
        return {
            sendObject,
            callBack
        };
    }

    static get = (url, sendObject = '', callBack) => {
        return requestProcess(url, 'GET', Request.paramsManage(sendObject, callBack));
    }

    static post = (url, sendObject = '', callBack) => {
        return requestProcess(url, 'POST', Request.paramsManage(sendObject, callBack));
    }

    static update = (url, sendObject = '', callBack) => {
        return requestProcess(url, 'POST', Request.paramsManage(sendObject, callBack));
    }

    static deleteData = (url, sendObject = '', callBack) => {
        return requestProcess(url, 'POST', Request.paramsManage(sendObject, callBack));
    }

}
