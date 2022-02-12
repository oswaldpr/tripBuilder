import axios from "axios";
(function ($) {
    $(document).ready(function () {
        const $body = $("body");

        $body.on("change", ".input-type", function () {
            changeFlightType($(this));
        });

        $body.on("click", ".trip-datepicker", function () {
            datePickerAction($(this));
        });

        $body.on("click", "#add-stopover", function () {
            addStopover($(this));
        });

        $body.on("click", ".remove-stopover", function () {
            removeStopover($(this));
        });

        $body.on("click", "#searchFlight", function () {
            searchFlight($(this));
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

function datePickerAction($this, e){
    const isDeparture = $this.attr('name') === 'departureDate';
    let minDate = 0;
    let maxDate = 365
    let openPicker = true;
    if(!isDeparture){
        const departureVal = $('#departureDate input').val()
        if(departureVal){
            const minDaysToComeBack = 2;
            const departureDate = new Date(departureVal);
            const returnDay = departureDate.getDate() + minDaysToComeBack;
            const returnMonth = departureDate.getMonth() + 1;
            const returnYear = departureDate.getFullYear();
            const returnMaxYear = returnYear + 1;
            minDate = new Date(returnDay, returnMonth, returnYear);
            maxDate = new Date(returnDay, returnMonth, returnMaxYear);
        } else {
            openPicker = false;
            alert('Please choose the departure date first');
        }
    }
    if(openPicker){
        $this.datepicker({
            // minDate: minDate,
            // maxDate: maxDate
        });
    }
}

async function changeFlightType($this){
    const $parent = $this.closest('.element-wrapper-type');
    const $inputChecked = $parent.find('input:checked');
    $('#returnDate').remove();
    if($inputChecked.val() === 'multi-destination'){
        await addStopover($this);
        const subView = await axiosOperation('/axiosRequest/getAddStopoverBtn');
        $('.add-stopover-btn-wrap').html(subView);
        $('#nb-stopover').val(1);
    } else {
        if($inputChecked.val() === 'round-trip'){
            $('#trip-dates').append('<p id="returnDate" class="col-6">Return date: <input type="text" name="returnDate" class="trip-datepicker"/></p>')
        }
        $('#stopover-list-content').html('');
        $('.add-stopover-btn-wrap').html('');
        $('#nb-stopover').val(0);
    }
}

async function addStopover($this){
    const $form = $this.closest('form');
    const nbStopoverVal = parseInt($('#nb-stopover').val());
    if(nbStopoverVal < 5){
        let formData = {};
        formData['formData'] = getFormDataObj($form);
        const subView = await axiosOperation('/axiosRequest/addStopover', formData);
        $('#stopover-list').replaceWith(subView);
        const newNb = parseInt($('#nb-stopover').val());
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
    $('#stopover-list').replaceWith(subView);
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

async function searchFlight($this){
    let formData = getFormDataObj($this);
    const subView = await axiosOperation('/axiosRequest/searchFlight', {'formData': formData});
    $('#search-result-list').html(subView);
}
