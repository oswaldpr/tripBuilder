import axios from "axios";
(function ($) {
    $(document).ready(function () {
        const $body = $("body");

        $body.on("change", ".input-type", function () {
            changeFlightType($(this));
        });

        $body.on("click", "#add-stopover", addStopover);

        $body.on("click", ".remove-stopover", function () {
            removeStopover($(this));
        });
    });
}(jQuery));

// SERVICE EXECUTION SECTION
export function axiosOperation(serviceRoute, serviceData = '') {
    let params = new URLSearchParams();

    if(serviceData){
        for (let [key, value] of Object.entries(serviceData)) {
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

async function changeFlightType($this){
    const $parent = $this.closest('.element-wrapper-type');
    const $inputChecked = $parent.find('input:checked');
    if($inputChecked.val() === 'multi-destination'){
        await addStopover();
        const subView = await axiosOperation('/axiosRequest/getAddStopoverBtn');
        $('.add-stopover-btn-wrap').html(subView);
        $('#nb-stopover').val(1);
    } else {
        $('#stopover-list-content').html('');
        $('.add-stopover-btn-wrap').html('');
        $('#nb-stopover').val(0);
    }
}

function hasRemoveBtnToFirstStopover(shouldHave = true){
    if(shouldHave){
        const subView = '<button type="button" class="close remove-stopover" aria-label="Close"><span class="" aria-hidden="true">x</span></button>'
        $('#stopover-list-content .single-stopover-1 .select-wrapper').append(subView);
    } else {
        $('#stopover-list-content .single-stopover-1 .close.remove-stopover').remove();
    }
}

async function addStopover(){
    const nbStopoverVal = parseInt($('#nb-stopover').val());
    if(nbStopoverVal < 5){
        const subView = await axiosOperation('/axiosRequest/addStopover', {'nbStopover': nbStopoverVal});
        $('#stopover-list-content').append(subView);
        const newNb = nbStopoverVal + 1;
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
    let formData = {};
    formData['stopover'] = parseFloat($current);
    formData['formData'] = getFormDataObj($form);
    const subView = await axiosOperation('/axiosRequest/removeStopover', formData);
    debugger
    // $('#stopover-list').replaceWith(subView);
}

function getFormDataObj($this){
    const $form = $this.closest('form');
    let formArray = $form.serializeArray();
    let formData = {};

    $.map(formArray, function(n, i){
        formData[n['name']] = n['value'];
    });

    return formData;
}
