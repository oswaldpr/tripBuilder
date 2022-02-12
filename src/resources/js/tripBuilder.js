import axios from "axios";
(function ($) {
    $(document).ready(function () {
        const $body = $("body");

        $body.on("change", ".input-type", function () {
            changeFlightType($(this));
        });

        $body.on("change", "#preferred_airline_check", function () {
            hasPreferredAirline($(this));
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

        //Should trigger date picker element
        $('#departureDate input').click();
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

function datePickerAction($this){
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
            minDate = new Date(returnMonth+'/'+returnDay+'/'+returnYear);
            maxDate = new Date(returnMonth+'/'+returnDay+'/'+returnMaxYear);
        } else {
            openPicker = false;
            const msgHtml = '<p><b>Error:</b> Please choose the departure date first</p>'
            $('#error-message').html(msgHtml);
        }
    }
    if(openPicker){
        $this.datepicker({
            "minDate": minDate,
            "maxDate": maxDate
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
        $('#nb_stopover').val(1);
    } else {
        if($inputChecked.val() === 'round-trip'){
            $('#trip-dates').append('<p id="returnDate" class="col-6">Return date: <input type="text" name="returnDate" class="trip-datepicker"/></p>');

            if($('#departureDate input').val()){
                //Only if already picked departure date
                //Should trigger date picker element
                $('#returnDate input').click();
            }
        }
        $('#stopover-list-content').html('');
        $('.add-stopover-btn-wrap').html('');
        $('#nb_stopover').val(0);
    }
}

async function hasPreferredAirline($this){
    const isChecked = $this.is(':checked');
    if(isChecked){
        const subView = await axiosOperation('/axiosRequest/hasPreferredAirline');
        $('#preferred-airline').append(subView);
    } else {
        $('#preferred-airline-select').remove();
    }
}

async function addStopover($this){
    const $form = $this.closest('form');
    const nbStopoverVal = parseInt($('#nb_stopover').val());
    if(nbStopoverVal < 5){
        let formData = {};
        formData['formData'] = getFormDataObj($form);
        const subView = await axiosOperation('/axiosRequest/addStopover', formData);
        $('#stopover-list').replaceWith(subView);
        const newNb = parseInt($('#nb_stopover').val());
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

    $.map(formArray, function(n){
        formData[n['name']] = n['value'];
    });

    return formData;
}

async function searchFlight($this){
    $('#error-message').html('');
    $('#search-result-list').html('');
    const validDates = validateDates();
    const validAirports = validateAirportList();
    if(validDates && validAirports){
        let formData = getFormDataObj($this);
        const subView = await axiosOperation('/axiosRequest/searchFlight', {'formData': formData});
        $('#search-result-list').html(subView);
    }
}

function validateDates(){
    const $typeChecked = $('.element-wrapper-type').find('input:checked');
    const isRoundTrip = $typeChecked.val() === 'round-trip';
    const hasDepartureDate = $('#departureDate input').val();
    const hasReturnDate = isRoundTrip ? $('#returnDate input').val() : true;

    const isValid = hasDepartureDate && hasReturnDate;
    if(!isValid){
        const msgHtml = '<p><b>Error:</b> Please choose your flight(s) date(s).</p>'
        $('#error-message').append(msgHtml);
    }
    return isValid;
}

function validateAirportList(){
    let isValid = true;
    const airportTripList = getAirportTripList();
    for( let i = 0; i < airportTripList.length; i++) {
        if(airportTripList[i] === airportTripList[i+1]){
            isValid = false;
        }
    }

    if(!isValid){
        const msgHtml = '<p><b>Error:</b> You can not choose the same airport in a row, please review your selection.</p>'
        $('#error-message').append(msgHtml);
    }
    return isValid;
}

function getAirportTripList(){
    const departure = $('.element-wrapper-departure_airport select').val();
    const arrival = $('.element-wrapper-arrival_airport select').val();
    const nbStopover = $('#nb_stopover').val();
    const hasStopover = parseInt(nbStopover) > 0;
    let airportTripList = [departure];
    if(hasStopover){
        for( let i = 1; i <= nbStopover; i++) {
            const selector = '.single-stopover-' + i + ' select';
            const selectorValue = $(selector).val();
            airportTripList.push(selectorValue);
        }
    }
    airportTripList.push(arrival);

    return airportTripList;
}
