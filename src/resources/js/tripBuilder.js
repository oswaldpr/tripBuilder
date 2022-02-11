import axios from "axios";
(function ($) {
    $(document).ready(function () {
        const $body = $("body");

        $body.on('click', "#add-stopover", addStopover);

        $body.on('click', ".remove-stopover", function () {
            removeStopover($(this));
        });
    });
}(jQuery));

// SERVICE EXECUTION SECTION
export function axiosOperation(serviceRoute, serviceData = '') {
    let params = new URLSearchParams();

    if(serviceData){
        for (const [key, value] of Object.entries(serviceData)) {
            params.append(key, JSON.stringify(value));
        }
    }
    // const config = {
    //     headers: {
    //         'Content-Type': 'application/x-www-form-urlencoded'
    //     }
    // }
    // debugger
    return axios.post(serviceRoute, params)
        .then(function (apiOutput) {
            return apiOutput.data;
        }).catch(function (apiError) {
            return apiError.message;
        }).finally(function (e) {
            // Finally opp
        });
}

async function addStopover(){
    const nbStopoverVal = parseInt($('#nb-stopover').val());
    if(nbStopoverVal < 5){
        const subView = await axiosOperation('/axiosRequest/addStopover', {'nbStopover': nbStopoverVal});
        $('#stopover-list').append(subView);
        const newNb = nbStopoverVal + 1
        $('#nb-stopover').val(newNb);
        if(newNb >= 5){
            $("#add-stopover").addClass('disabled')
        }
    }
}

async function removeStopover($this){
    const $form = $this.closest('form');
    const $parent = $this.parent();
    const $current = $parent.data('stopover');
    let formData = getFormDataObj($this);
    formData['stopover'] = parseFloat($current);
    formData['formData'] = $form.serialize();
    const subView = await axiosOperation('/axiosRequest/removeStopover', formData);
    debugger
    // $('#stopover-list').replaceWith(subView);
}

function getFormDataObj($this){
    const $form = $this.closest('form');
    const formData = $form.serialize();
    const formDataArr = typeof formData === 'string' ? formData.split('&') : [];
    let data = {};
    // if(formDataArr.length > 0){
    //     formDataArr.forEach(param => {
    //         const paramDefinition = param.split('=');
    //         data[paramDefinition[0]] = paramDefinition[1];
    //     })
    // }
    return data;
}
