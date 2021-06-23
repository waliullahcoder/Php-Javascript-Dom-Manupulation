

var submitForms = document.querySelectorAll('form');
submitForms.forEach(form => form.addEventListener('submit', formSubmitManage))

function afterActionResetForm(form) {
    form.reset();
    var submitButton = form.querySelector('input[type="submit"]');
    var forAction = form.querySelector('input.action');
    submitButton.className = 'btn btn-info'
    submitButton.value = 'Submit';
    forAction ? forAction.name = 'insert':false;
}

var validationElements = document.querySelectorAll('input.validation');
validationElements.forEach(element => element.addEventListener('keyup', validation));

function validation() {
    var errorShow,
        letters = /^[a-zA-Z\s]+$/,
        numbers = /^[-+]?[0-9]+$/,
        value = this.value.trim(),
        filterFor = this.dataset.validation,
        nextElement = this.nextElementSibling,
        errorElement = document.createElement('p');

    errorElement.className = 'invalid';;
    errorElement.textContent = `Please Input valid ${filterFor}`;

    if (value.length > 0) {
        switch (filterFor) {
            case 'number':
                errorShow = value.match(numbers) ? false : true;
                break;
            case 'alphabet':
                errorShow = value.match(letters) ? false : true;
                break;
            case 'math operation':
                errorShow = value.match(letters) || value.match(numbers) ? true : false;
                break;
            default:
                errorShow = false;
                break;
        }
    }

    if (errorShow) {
        nextElement && nextElement.className.includes('invalid') ? false : this.insertAdjacentElement(
            'afterend', errorElement)
    } else if (nextElement && nextElement.nodeName === 'P' && nextElement.className.includes('invalid')) {
        nextElement.remove();
    }
}

function messageControl(form, trueOrFalse, message) {
    var success = form.querySelector('.alert-success')
    var danger = form.querySelector('.alert-danger')
    var success_p = form.querySelector('.alert-success p')
    var danger_p = form.querySelector('.alert-danger p')
    if (trueOrFalse) {
        success.className = 'alert alert-success';
        danger.className = 'alert alert-danger none';
        success_p.textContent = message ? message : success_p.textContent;
    } else {
        danger_p.textContent = message ? message : danger_p.textContent;
        success.className = 'alert alert-success none';
        danger.className = 'alert alert-danger';
    }
    setTimeout(() => {
        success.className = 'alert alert-success none';
        danger.className = 'alert alert-danger none';
    }, 3000);
}

function newOrEdited(mainData, data) {
    if (data && data.id) {
        var index = mainData.findIndex(item => item.id === data.id);
        if (index > -1) {
            mainData[index] = data;
        } else {
            mainData.push(data);
        }
    }
    return mainData;
}


function upFirst(str) {
    return str.toLowerCase().replace(/\b[a-z]/g, function (letter) {
        return letter.toUpperCase();
    });
}

function dynamicallySetValueOfElements(formSelectId, filedData) {
    let formElement = document.querySelector(formSelectId);
    if(filedData && filedData.constructor === Object && Object.keys(filedData).length) {
        for (let [key, value] of Object.entries(filedData)) {
            let element = formElement.elements[key];
            if(value && element && value.constructor !== Object) {
                value = value.toString();
                if(element.nodeName !== 'TEXTAREA') {
                    if(element.nodeName === 'INPUT' && element.type === 'file') {
                        let image = element.parentElement.querySelector('img');
                        image ? image.src = `${base_url}${value}`:false;
                    }else {
                        element.value = value.includes('[') || value.includes('}') ? element.value:value;
                    }
                }else {
                    element.textContent = value;
                }
            }
        }

        let submitButton = document.querySelector(`${formSelectId} input[type="submit"]`);
        let forAction = document.querySelector(`${formSelectId} input.action`);
        submitButton.className = 'btn btn-warning'
        submitButton.value = 'Update';
        if(forAction && filedData.id) {
            forAction.value = filedData.id;
            forAction.name = 'update';
        }
    }


}


function daysInThisMonth() {
    var now = new Date();
    return new Date(now.getFullYear(), now.getMonth() + 1, 0).getDate();
}
var month = '<option selected disabled >Select day</option>';
for (let d = 0; d < daysInThisMonth(); d++) {
    month += `<option value="${d+1}">${d+1}</option>`;
}
var monthContainer = document.getElementById('month');
monthContainer = monthContainer ? monthContainer.innerHTML = month : false;
