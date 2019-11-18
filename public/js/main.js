function closeModal(){
    $('.custom-modal').modal('hide');
}
function refresh(){
    location.reload();
}
function hideevents(){

    $(".event-show").hide();
}
function show_details(event_id){
    $(".event-show").hide();
    $("#"+event_id).show();
}
function showlogoutmodal(){
    $("#logout_modal").modal();
}
function showEnduranceLeagueModal(){
    $("#endurance_league_details_modal").modal();
}
function openconfirmcancelmodal(event_id){
    $("#confirm_cancel_event_modal_"+event_id).modal();
    $("#confirm_cancel_event_modal_"+event_id).unbind();
}
function opencancelmodal(event_id){
    $.ajax({
        type: $("#form_"+event_id).attr("method"),
        url: $("#form_"+event_id).attr("action"),
        data: $("#form_"+event_id).serialize(),
        success: function(data) {
            $("#form_"+event_id)
                .get(0)
                .reset();
            $('#confirm_cancel_event_modal_'+event_id).modal('hide')
            $("#cancel_event_modal_"+event_id).modal();
        },
        error: function(data) {
            console.log("An error occurred.");
        }
    });
    $("#cancel_event_modal_"+event_id).unbind();
}
function validatePhone(){
    $.ajax({
        async: false,
        url: "/phoneValidation",
        type: "GET",
        data: { phone: document.getElementsByName("ticket_1_phone")[0].value, email: document.getElementsByName("ticket_1_email")[0].value} ,
        dataType: "json",   
        success: function(result) {
            if (result) {
                document.getElementsByName("ticket_1_phone")[0].setCustomValidity("This phone is linked to a different email address");
            } else {
                document.getElementsByName("ticket_1_phone")[0].setCustomValidity('');  
            }
        }
    });
}

function onFileChange(){
    if ($('#national_id_image').val()) {
        $('.fa-times-circle').hide();
        $('.fa-check-circle').show();
        if (document.getElementById("national_id_image") != null && document.getElementById("national_id_image").files[0] && document.getElementById("national_id_image").files[0].size > 26214400 ) {   // 15728640
            document.getElementById("national_id_image").setCustomValidity('Input file must be not greater than 25MB');
        } else {
            document.getElementById("national_id_image").setCustomValidity('');
        }
    } else {
        $('.fa-times-circle').show();
        $('.fa-check-circle').hide();
    }
}

function ticket_details(){
    validatePhone();
    document.getElementById("open_added_to_cart_modal").onclick = validatePhone;
}
function sortList() {
    var list, i, switching, b, shouldSwitch;
    list = document.getElementsByClassName("clubs");
    if (list.length > 0) {
    switching = true;
    /* Make a loop that will continue until
    no switching has been done: */
    while (switching) {
      // Start by saying: no switching is done:
      switching = false;
      b = list[0].getElementsByTagName("option");
      // Loop through all list items:
      for (i = 0; i < (b.length - 1); i++) {
        // Start by saying there should be no switching:
        shouldSwitch = false;
        /* Check if the next item should
        switch place with the current item: */
        
        if (b[i].innerHTML.toLowerCase() > b[i + 1].innerHTML.toLowerCase()) {
          /* If next item is alphabetically lower than current item,
          mark as a switch and break the loop: */
          
          shouldSwitch = true;
          break;
        }
      }
      if (shouldSwitch) {
        /* If a switch has been marked, make the switch
        and mark the switch as done: */
        b[i].parentNode.insertBefore(b[i + 1], b[i]);
        switching = true;
      }
      if (!switching) {
        b = list[0].getElementsByTagName("option");
        for (let i = 0; i < b.length - 1; i++) {
            if (b[i].innerHTML.toLowerCase().search("other") != -1) {
                b[b.length-1].parentNode.insertBefore(b[i], b[b.length-1].nextSibling);
            }
            if (b[i].innerHTML.toLowerCase().search("club") != -1) {
                b[0].parentNode.insertBefore(b[i], b[0]);
            }
        }
      }
    }
    }
    var list, i, switching, b, shouldSwitch;
    list = document.getElementsByClassName("teams");
    if (list.length > 0) {
    switching = true;
    /* Make a loop that will continue until
    no switching has been done: */
    while (switching) {
      // Start by saying: no switching is done:
      switching = false;
      b = list[0].getElementsByTagName("option");
      // Loop through all list items:
      for (i = 0; i < (b.length - 1); i++) {
        // Start by saying there should be no switching:
        shouldSwitch = false;
        /* Check if the next item should
        switch place with the current item: */
        
        if (b[i].innerHTML.toLowerCase() > b[i + 1].innerHTML.toLowerCase()) {
          /* If next item is alphabetically lower than current item,
          mark as a switch and break the loop: */
          
          shouldSwitch = true;
          break;
        }
      }
      if (shouldSwitch) {
        /* If a switch has been marked, make the switch
        and mark the switch as done: */
        b[i].parentNode.insertBefore(b[i + 1], b[i]);
        switching = true;
      }
      if (!switching) {
        b = list[0].getElementsByTagName("option");
        for (let i = 0; i < b.length - 1; i++) {
            if (b[i].innerHTML.toLowerCase().search("other") != -1) {
                b[b.length-1].parentNode.insertBefore(b[i], b[b.length-1].nextSibling);
            }
            if (b[i].innerHTML.toLowerCase().search("team name") != -1) {
                b[0].parentNode.insertBefore(b[i], b[0]);
            }
        }
      }
    }
    }
    
  }
$(document).ready(function() {
    $("#tickets_info").on('shown.bs.collapse', function() {
        window.location = "#tickets_info";
    })
    $("#open_login_modal").click(function() {
        $("#login_modal").modal();
    });

    // show active tab on reload
    if (location.hash !== "") $('a[href="' + location.hash + '"]').tab("show");

    // remember the hash in the URL without jumping
    $('a[data-toggle="pill"]').on("shown.bs.tab", function(e) {
        window.location.href = "?page=0#" +
                $(e.target)
                    .attr("href")
                    .substr(1);
        // URLSearchParams.delete(page)
        // if (history.pushState) {
        //     history.pushState(
        //         null,
        //         null,
        //         "#" +
        //             $(e.target)
        //                 .attr("href")
        //                 .substr(1)
        //     );
        // } else {
            // location.hash =
            //     "#" +
            //     $(e.target)
            //         .attr("href")
            //         .substr(1);
        // }
    });

    /*
     * Home Page
     */
    function initHome() {
        $(".home-gallery").slick({
            dots: true,
            slidesToShow: 1,
            centerMode: true,
            variableWidth: true
        });
    }

    /*
     * Event Details Page
     */
    function initEventDetails() {
        var countries = "";
        $.ajax({
            url: "/event-details/helper/countries",
            type: "GET",
            dataType: "json",

            success: function(data) {
                $.each(data, function(key, item) {
                    // item.iso_3166_1_alpha2
                    countries +=
                        '<option value="' +
                        item.name +
                        '">' +
                        item.name +
                        "</option>";
                });
            }
        });
        $("#ticket_1_use_myself").on("change", function(){
            if ($("#year_of_birth").length){
                $.ajax({
                    url: "/getUser",
                    type: "GET",
                    dataType: "json",   
                success: function(user) {
                    if (user['year_of_birth'] != 0){
                    var val = $('#year_of_birth option:contains('+user['year_of_birth']+')').val();
                    $("#year_of_birth").val(val);
                    $("#year_of_birth").prop("selected", true);
                    // $("#year_of_birth").prop("disabled", true);
                    document.getElementById("year_of_birth").style.pointerEvents='none';
                    document.getElementById("year_of_birth").style.backgroundColor='#e9ecef';
                    var elems = document.getElementsByClassName("year_of_birth");
                    // document.getElementsByClassName("year_of_birth").style.backgroundColor='#f5f5f5';
                    if (elems.length > 1)
                    for (var i = 0; i < elems.length; i++) {
                        elems[i].style.pointerEvents=null;
                        elems[i].style.backgroundColor='#f5f5f5';
                  }

                    }
                    if (user['club'] != ''){
                        var val = $('#club option:contains('+user['club']+')').val();
                    if (val) {
                        $("#club").val(val);
                        $("#others").val('');
                        $("#others").prop('required',false);
                        $(".other_club").hide();
                        $("#other_club").prop('required',false);
                    } else {
                        $("#club").val($('#club option:contains(Other)').val());
                        $("#others").val(user['club']);
                        $(".other_club").show();
                    }
                    $("#club").prop("selected", true);
                    // $("#others").prop("disabled", true);
                    // $("#club").prop("disabled", true);
                    if ($("#club").length){
                    document.getElementById("club").style.pointerEvents='none';
                    document.getElementById("club").style.backgroundColor='#e9ecef';
                    }
                    if ($("#others").length){
                    document.getElementById("others").style.pointerEvents='none';
                    document.getElementById("others").style.backgroundColor='#e9ecef';
                    }
                    }
                }
                })
            }
        });

        $("#ticket_1_use_someone").on("change", function(){
            if ($(".year_of_birth").length){
                // $("#year_of_birth").prop("disabled", false);
                var elems = document.getElementsByClassName("year_of_birth");
                // document.getElementsByClassName("year_of_birth").style.backgroundColor='#f5f5f5';
                for (var i = 0; i < elems.length; i++) {
                    elems[i].style.pointerEvents=null;
                    elems[i].style.backgroundColor='#f5f5f5';
                  }
                $('#open_added_to_cart_modal').prop("disabled", false);
            }
            if ($("#club").length){
                // $("#club").prop("disabled", false);
                // $("#others").prop("disabled", false);
                document.getElementById("club").style.pointerEvents=null;
                document.getElementById("club").style.backgroundColor='#f5f5f5';
                if ($("#others").length){
                    document.getElementById("others").style.pointerEvents=null;
                    document.getElementById("others").style.backgroundColor='#f5f5f5';
                }
                $('#open_added_to_cart_modal').prop("disabled", false);
            }
        });
        $(".ticket_race").on("change", function() {
            var raceId = $(this).val();

            var name = $(this).attr("name");
            name = name.split("_");
            var drop_name = "ticket_" + name[1] + "_type";
            var meta_name = "#ticket_info_" + name[1] + " .meta";
            var meta_field_name = "ticket_" + name[1] + "_meta";

            $.ajax({
                url: "/event-details/getTicketsByRaceId/" + raceId,
                type: "GET",
                dataType: "json",

                success: function(data) {
                    $('select[name="' + drop_name + '"]').empty();
                    $('select[name="' + drop_name + '"]').append(
                        '<option value="" disabled selected>Ticket Type</option>'
                    );

                    $.each(data, function(item, itemData) {
                        var d1 = new Date();
                        var d2 = new Date(itemData.ticket_end);

                        var disabled = "";

                        if (d2 < d1 && data['admin'] == false) {
                            disabled = "disabled";
                        }

                        if (!(itemData == false || itemData == true)) {
                        $('select[name="' + drop_name + '"]').append(
                            "<option " +
                            ((itemData.name.includes('General') && data['exception_user'] == true) ? '' : disabled) +
                                ' value="' +
                                itemData.id +
                                '">' +
                                itemData.name +
                                "</option>"
                        );
                        }
                    });
                }
            });

            $.ajax({
                url: "/event-details/getMetaByRaceId/" + raceId,
                type: "GET",
                dataType: "json",

                success: function(data) {
                    $(meta_name).empty();
                    if (data.length) {
                        var questions = data[0].question;
                        $.each(questions, function(key, question) {
                            str = "";
                            str += "<script>var usedNames = {};$(\".clubs > option\").each(function () {if(usedNames[this.text]) {$(this).remove();} else {usedNames[this.text] = this.value;}});</script>";
                            str += "<script>if (!$(\".clubs option:selected\").text().toLowerCase().includes('other') ){$(\".other_club\").hide();}$(\".clubs\").on(\"change\", function() {if ($(\".clubs option:selected\").text().toLowerCase().includes('other')){$(\".other_club\").show();$(\"#other_club\").prop('required',true);$(\"#others\").prop('required',true); document.getElementById(\"others\").style.pointerEvents=null;document.getElementById(\"others\").style.backgroundColor='#f5f5f5';} else {$(\"#others\").val('');$(\"#others\").prop('required',false);$(\".other_club\").hide();$(\"#other_club\").prop('required',false);document.getElementById(\"others\").style.pointerEvents='none';document.getElementById(\"others\").style.backgroundColor='#e9ecef';}});</script>";
                            str +=
                                '<div class="col-lg-6 mt-3 '+((question.question_text.search(/other/i) > -1 && data[0].event_id != 6) ? 'other_club' : '')+'"><div class="input-group">';

                            var validation = [];
                            var required = false;
                            var min = false;
                            var max = false;
                            var type = "text";

                            if (question.validation) {
                                validation = question.validation.split(";");
                                for (i = 0; i < validation.length; i++) {
                                    if (validation[i] === "required") {
                                        required = true;
                                    }

                                    if (validation[i].match("min")) {
                                        min = validation[i].split(":");
                                        min = min[1];
                                    }

                                    if (validation[i].match("max")) {
                                        max = validation[i].split(":");
                                        max = max[1];
                                    }

                                    if (validation[i].match("type")) {
                                        type = validation[i].split(":");
                                        type = type[1];
                                    }
                                }
                            }

                            if (question.answertype.type === "input") {
                                str += "<input ";

                                if (required) str += " required ";

                                if (type) str += ' type="' + type + '" ';

                                if (min && type === "number") {
                                    str += ' min="' + min + '" ';
                                } else if (min && type === "text") {
                                    str += ' minlength="' + min + '" ';
                                }

                                if (max && type === "number") {
                                    str += ' max="' + max + '" ';
                                } else if (max && type === "text") {
                                    str += ' maxlength="' + max + '" ';
                                }

                                if (question.question_text.search(/other/i) > -1 && data[0].event_id != 6){
                                    if ($(".clubs option:selected").text().toLowerCase().includes('other')) { 
                                        str += 'value="'+data[0]['user'].club+'"';
                                    } else {
                                        str += 'value=\'\'';
                                    }
                                    str += " id=\"others\" ";
                                    str += " style=\"pointer-events: none; background-color: #e9ecef\" ";
                                }
                                str +=
                                    ' class="form-control " placeholder="' +
                                    question.question_text +
                                    '" name="' +
                                    meta_field_name +
                                    "_" +
                                    question.id +
                                    '" '+(question.question_text.search(/year of birth/i) > -1 && data[0]['user'].year_of_birth != 0 ? 'value=\"Year of birth: '+data[0]['user'].year_of_birth+'\" style="pointer-events: none; background-color: #e9ecef" ' : '')+'/>';
                            }

                            if (question.answertype.type === "file") {
                                str += '<label style="cursor: pointer;" class="form-control" for="national_id_image">';
                                str += '<input ';
                                str += ' type="file"';
                                str += ' accept="image/*"';
                                str += ' id="national_id_image"';
                                str += ' name="' + meta_field_name + '_' + question.id + '"';
                                str += ' required';
                                str += ' data-max-size="1"';
                                str += ' form="add_to_cart"';
                                str += ' onchange="onFileChange()"';
                                str += ' style="opacity: 0;width: 1%;float: left;"';
                                str += ' />';
                                str += ' <span class="fas fa-upload"></span> &nbsp;&nbsp;Upload valid copy of ID/Passport (Less than 25MB ) <span style="float:right;color:green; display:none;" class="far fa-check-circle"></span><span style="float:right;color:red;" class="far fa-times-circle"></span></label>';
                            }

                            if (question.answertype.type === "dropdown") {
                                str += "<select ";
                                if (required) str += "required";
                                str +=
                                    ' class="custom-select '+(question.question_text.search(/club/i) > -1 ? 'clubs' : '')+' '+(question.question_text.search(/year of birth/i) > -1 ? 'year_of_birth' : '')+' '+(question.question_text.search(/team/i) > -1 ? 'teams' : '')+'" name="' +
                                    meta_field_name +
                                    "_" +
                                    question.id +
                                    '" '
                                    +(question.question_text.search(/year of birth/i) > -1 && data[0]['user'].year_of_birth != 0 ? " id=\"year_of_birth\" "  : "")
                                    +(question.question_text.search(/year of birth/i) > -1 && $( '#ticket_1_use_myself' ).is( ':checked' ) && data[0]['user'].year_of_birth != 0 && $(".ticket_race option:selected").text().toLowerCase().indexOf("relay") == -1 ? "style=\"pointer-events: none; background-color: #e9ecef\"" : "") //change
                                    +(question.question_text.search(/club/i) > -1 && data[0]['user'].club != '' ? " id=\"club\" "  : "")
                                    +(question.question_text.search(/club/i) > -1 && $( '#ticket_1_use_myself' ).is( ':checked' ) && data[0]['user'].club != '' ? "style=\"pointer-events: none; background-color: #e9ecef\"" : "")
                                    +'>';
                                    if (question.question_text.search(/year of birth/i) > -1 && $( '#ticket_1_use_myself' ).is( ':checked' ) && data[0]['user'].year_of_birth !== 0 && $(".ticket_race option:selected").text().toLowerCase().indexOf("relay") == -1){ //change
                                        var found = false;
                                        $.each(question.answervalue, function(
                                            key,
                                            answervalue
                                        ) {

                                            if (answervalue.value == data[0]['user'].year_of_birth){
                                                str +=
                                                '<option value="' +
                                                answervalue.id +
                                                '" selected>' +
                                                answervalue.value +
                                                "</option>";
                                                found = true;
                                                return;
                                            }
                                        });
                                        $('#open_added_to_cart_modal').prop("disabled", false);
                                        if (!found){
                                        str +=
                                        '<option value="" selected disabled>' +
                                        'Your age is not qualified for this race' +
                                        "</option>";
                                        $('#open_added_to_cart_modal').prop("disabled", true);
                                        }
                                    } else {
                                    str +=
                                    '<option value="" disabled selected>' +
                                    question.question_text +
                                    "</option>";
                                    }
                                    if (question.question_text.search(/club/i) > -1 && $( '#ticket_1_use_myself' ).is( ':checked' ) && data[0]['user'].club !== ''){
                                        var flag = false;
                                        $.each(question.answervalue, function(
                                            key,
                                            answervalue
                                        ) {
                                            if (answervalue.value == data[0]['user'].club){
                                                str +=
                                                '<option value="' +
                                                answervalue.id +
                                                '" selected>' +
                                                answervalue.value +
                                                "</option>";
                                                flag = true;
                                            }
                                        });
                                        if (!flag){
                                            $.each(question.answervalue, function(
                                                key,
                                                answervalue
                                            ) {
                                                if (answervalue.value.toLowerCase().includes('other')){
                                                    str +=
                                                    '<option value="' +
                                                    answervalue.id +
                                                    '" selected>' +
                                                    answervalue.value +
                                                    "</option>";
                                                }
                                            });
                                        }
                                    }
                                $.each(question.answervalue, function(
                                    key,
                                    answervalue
                                ) {
                                        str +=
                                        '<option value="' +
                                        answervalue.id +
                                        '">' +
                                        answervalue.value +
                                        "</option>";
                                });
                                str += "</select>";
                            }

                            if (question.answertype.type === "countries") {
                                str += "<select ";
                                if (required) str += "required";
                                str +=
                                    ' class="custom-select " name="' +
                                    meta_field_name +
                                    "_" +
                                    question.id +
                                    '">';
                                str +=
                                    '<option value="" disabled selected>' +
                                    question.question_text +
                                    "</option>";
                                str += countries;
                                str += "</select>";
                            }

                            str += "</div></div>";

                            $(meta_name).append(str);
                            sortList();
                        });
                    }
                }
            });
        });

        $(".event-slider").slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            asNavFor: ".event-slider-nav"
        });
        $(".event-slider-nav").slick({
            slidesToScroll: 1,
            slidesToShow: 4,
            asNavFor: ".event-slider",
            dots: false,
            arrows: false,
            centerMode: true,
            focusOnSelect: true
        });
        var data = null;
        // Handle Ticket Usage Radio Buttons
        $('input[type="radio"]').change(function() {
            if ($(this).val() == "myself") {
                $(this)
                    .parents(".ticket-info-section")
                    .find("*[own-ticket-hide] input")
                    .attr("disabled", true);

                if (data) {
                    var inputs = $(this)
                        .parents(".ticket-info-section")
                        .find("*[own-ticket-hide] input");
                    for (i = 0; i < 4; i++) inputs[i].value = data[i];
                }
            }
            if ($(this).val() == "someone") {
                if (!data) {
                    data = [];
                    var inputs = $(this)
                        .parents(".ticket-info-section")
                        .find("*[own-ticket-hide] input");

                    for (i = 0; i < 4; i++) data[i] = inputs[i].value;
                }

                $(this)
                    .parents(".ticket-info-section")
                    .find("*[own-ticket-hide] input")
                    .attr("disabled", false);

                var inputs = $(this)
                    .parents(".ticket-info-section")
                    .find("*[own-ticket-hide] input");
                for (i = 0; i < 4; i++) inputs[i].value = "";
            }
        });
        $('input[type="radio"]').each(function() {
            if ($(this).prop("checked", true) && $(this).val() == "myself") {
                $(this)
                    .parents(".ticket-info-section")
                    .find("*[own-ticket-hide] input")
                    .attr("disabled", true);
            }
            if ($(this).prop("checked", true) && $(this).val() == "someone") {
                $(this)
                    .parents(".ticket-info-section")
                    .find("*[own-ticket-hide]")
                    .show();
            }
        });
        // Add Tickets Form
        var ticketSection = $(".ticket-info-section").clone(true, true);
        $('.tickets-quantity input[type="number"]').change(function() {
            var ticketsQuantity = parseInt($(this).val());
            var currentTicketsQuantity = $(".ticket-info-section").length;
            if (currentTicketsQuantity < ticketsQuantity) {
                // Add Ticket
                var newTicketSection = ticketSection.clone(true, true);
                // Replace Section ID
                newTicketSection.attr("id", "ticket_info_" + ticketsQuantity);
                // Replace Ticket No
                newTicketSection.find(".ticket-no").each(function() {
                    $(this).text(
                        $(this)
                            .text()
                            .replace("1", ticketsQuantity)
                    );
                });
                // Replace IDs
                newTicketSection.find('[id*="ticket_1"]').each(function() {
                    $(this).attr(
                        "id",
                        $(this)
                            .attr("id")
                            .replace("ticket_1", "ticket_" + ticketsQuantity)
                    );
                });
                // Replace Names
                newTicketSection.find('[name*="ticket_1"]').each(function() {
                    $(this).attr(
                        "name",
                        $(this)
                            .attr("name")
                            .replace("ticket_1", "ticket_" + ticketsQuantity)
                    );
                });
                // Replace Fors
                newTicketSection.find('[for*="ticket_1"]').each(function() {
                    $(this).attr(
                        "for",
                        $(this)
                            .attr("for")
                            .replace("ticket_1", "ticket_" + ticketsQuantity)
                    );
                });
                // Replace Tickets Total No
                $("#open_added_to_cart_modal").each(function() {
                    $(this).text(
                        $(this)
                            .text()
                            .replace(currentTicketsQuantity, ticketsQuantity)
                    );
                });
                newTicketSection.insertAfter($(".ticket-info-section").last());
            } else if (currentTicketsQuantity > ticketsQuantity) {
                // Remove Ticket
                $(".ticket-info-section")
                    .last()
                    .remove();
                // Replace Tickets Total No
                $("#open_added_to_cart_modal").each(function() {
                    $(this).text(
                        $(this)
                            .text()
                            .replace(currentTicketsQuantity, ticketsQuantity)
                    );
                });
            }
        });
        // Added to cart modal
        $("#open_added_to_cart_modal").click(function(e) {
            // $('#open_added_to_cart_modal').val('Submitting Form...');
            // document.getElementById('open_added_to_cart_modal').innerHTML = 'Submitting Form...';
            if ($("#add_to_cart")[0].checkValidity()) {
                $("#add_to_cart").submit(function(e) {
                    
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        async: false,
                        type: $("#add_to_cart").attr("method"),
                        enctype: 'multipart/form-data',
                        processData: false,
                        contentType: false,
                        cache: false,
                        url: $("#add_to_cart").attr("action"),
                        data: new FormData($("#add_to_cart")[0]),
                        success: function(data) {
                            $("#add_to_cart")
                                .get(0)
                                .reset();
                            $("#added_to_cart_modal").modal();
                            fbq('track', 'AddToCart');
                        },
                        error: function(data) {
                            console.log("An error occurred.");
                        }
                    });
                    return false;
                });
            }
            // e.preventDefault();
            $("#open_added_to_cart_modal").unbind();
        });
    }

    /*
     * Cart Page
     */
    function initCart() {
        $(".undo-code").click(function(event) {
            $(this)
                .closest("#code")
                .val(null);
            $(this)
                .closest(".code-form")
                .submit();
            event.preventDefault();
        });
    }

    /*
     * Cart Payment Page
     */
    function initCartPayment() {
        $("#undo-credit").click(function(event) {
            $("#credit").val(0);
            $("#credit-form").submit();
            event.preventDefault();
        });

        $("#undo-voucher").click(function(event) {
            $("#code").val(null);
            $("#voucher-form").submit();
            event.preventDefault();
        });
    }

    /*
     * Profile Page
     */
    function initProfile() {
        // Upcoming Event Details Trigger
        $("#pills-upcoming-events .event-details-trigger").click(function() {
            if ($("#pills-upcoming-events").hasClass("event-shown")) {
                // Hide Details
                $("#pills-upcoming-events").removeClass("event-shown");
            } else {
                // Show Details
                $("#pills-upcoming-events").addClass("event-shown");
            }
        });
        // Previous Event Details Trigger
        $("#pills-previous-events .event-details-trigger").click(function() {
            if ($("#pills-previous-events").hasClass("event-shown")) {
                // Hide Details
                $("#pills-previous-events").removeClass("event-shown");
            } else {
                // Show Details
                $("#pills-previous-events").addClass("event-shown");
            }
        });

        // upload image
        $("#profile-image").click(function() {
            $("input[id='profile_image']").click();
        });

        $("#profile_image").change(function() {
            $("#profile-image-form").submit();
        });
    }

    /*
     * Sign In / Sign Up Page
     */
    function initSignIn() {
        $("#login_form").submit(function(e) {
            console.log("do login");
            e.preventDefault();
        });
        $("#register_form").submit(function(e) {
            $("#phone_verify_modal").modal();
            e.preventDefault();
        });
    }

    /*
     * General
     */
    // Clickable Dropdown menu
    if ($(window).width() > 769) {
        $(".navbar .dropdown > a").click(function() {
            location.href = this.href;
        });
    }

    // Handles number inputs
    $(".form-control.form-number").each(function() {
        var self = $(this),
            min = self.attr("min"),
            max = self.attr("max");
        $(
            '<img src="/images/arrow-up-icon.svg" class="quantity-add">'
        ).insertAfter($(this));
        $(
            '<img src="/images/arrow-down-icon.svg" class="quantity-mince">'
        ).insertAfter($(this));
        $(this)
            .next(".quantity-mince")
            .click(function() {
                if (self.val() != min) {
                    var value = parseInt(self.val()) - 1;
                    self.val(value);
                    self.change();
                }
            });
        $($(this).nextAll(".quantity-add")[0]).click(function() {
            if (self.val() != max) {
                var value = parseInt(self.val()) + 1;
                self.val(value);
                self.change();
            }
        });
    });

    // Retrieves current page id
    function getPageId() {
        var classList = document.querySelector("body").className.split(/\s+/);
        for (var i = 0; i < classList.length; i++) {
            if (classList[i].endsWith("-view")) {
                return classList[i].substring(0, classList[i].indexOf("-view"));
            }
        }
    }

    switch (getPageId()) {
        case "home":
            initHome();
            break;
        case "sign-in":
            initSignIn();
            break;
        case "event-details":
            initEventDetails();
            break;
        case "cart-payment":
            initCartPayment();
            break;
        case "cart":
            initCart();
            break;
        case "profile":
            initProfile();
            break;
        default:
    }
    $(".other_club").hide();
    $(".clubs").on("change", function() {
        if ($(this).val().toLowerCase().includes('other')){
            $(".other_club").show();
            $("#other_club").prop('required',true);
        } else {
            $(".other_club").hide();
            $("#other_club").prop('required',false);
        }
    });
});
