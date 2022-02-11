import axios from "axios";
(function ($) {
    $(document).ready(function () {
        const $body = $("body");

        $body.on('click', "#add-stopover", addStopover);

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
