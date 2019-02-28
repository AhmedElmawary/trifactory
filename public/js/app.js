$(document).ready(function() {

  $('#open_login_modal').click(function() {
    $('#login_modal').modal();
  });
  
  /*
   * Home Page
   */
  function initHome() {
    $('.home-gallery').slick({
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

    $('.ticket_race').on('change', function(){

      var raceId = $(this).val();
      
      var name = $(this).attr('name');
      name = name.split('_');
      var drop_name = "ticket_" + name[1] + "_type";
      var meta_name = "#ticket_info_" + name[1] + " .meta";
      var meta_field_name = "ticket_" + name[1] + "_meta";

      $.ajax({
          url: '/event-details/getTicketsByRaceId/'+raceId,
          type:"GET",
          dataType:"json",

          success:function(data) {

              $('select[name="'+drop_name+'"]').empty();
              $('select[name="'+drop_name+'"]').append('<option value="" disabled selected>Ticket Type</option>');

              $.each(data, function(key, value){
                $('select[name="'+drop_name+'"]').append('<option value="'+ key +'">' + value + '</option>');
              });
          }
      });

      $.ajax({
        url: '/event-details/getMetaByRaceId/'+raceId,
        type:"GET",
        dataType:"json",

        success:function(data) {
        
            $(meta_name).empty();
            if(data.length)
            {
              var questions = data[0].question;
              $.each(questions, function(key, question){
                str = '';
                str +='<div class="col-lg-6 mt-3"><div class="input-group">';
                
                
                if(question.answertype.type === 'input')
                {
                  str += '<input type="text" class="form-control " placeholder="' + question.question_text + '" name="' + meta_field_name + "_" + question.id +'" required>';
                }
                
                if(question.answertype.type === 'dropdown')
                {
                  str += '<select class="custom-select " name="'+ meta_field_name + "_" + question.id +'" required>';
                  str += '<option value="" disabled selected>' + question.question_text + '</option>';
                  $.each(question.answervalue, function(key, answervalue){
                    str += '<option value="' + answervalue.id + '">' + answervalue.value + '</option>';
                  });
                  str += '</select>';
                }

                if(question.answertype.type === 'countries')
                {
                  str += '<select class="custom-select " name="'+ meta_field_name + "_" + question.id +'" required>';
                  str += '<option value="" disabled selected>' + question.question_text + '</option>';
                  $.each(question.answervalue, function(key, answervalue){
                    str += '<option value="' + answervalue.id + '">' + answervalue.value + '</option>';
                  });
                  // temp
                  str += '<option value="Egypt">Egypt</option>';
                  str += '</select>';
                }
                
                str += '</div></div>';

                $(meta_name).append(str);
              });
            }
            
        }
    });

    
      
    });

    $('.event-slider').slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: false,
      asNavFor: '.event-slider-nav'
    });
    $('.event-slider-nav').slick({
      slidesToScroll: 1,
      slidesToShow: 4,
      asNavFor: '.event-slider',
      dots: false,
      arrows: false,
      centerMode: true,
      focusOnSelect: true,
    });
    // Handle Ticket Usage Radio Buttons
    $('input[type="radio"]').change(function() {
      if($(this).val() == 'myself'){
        $(this).parents('.ticket-info-section').find('*[own-ticket-hide]').hide();
        $(this).parents('.ticket-info-section').find('*[own-ticket-hide] input').attr('required', false);
      }
      if($(this).val() == 'someone'){
        $(this).parents('.ticket-info-section').find('*[own-ticket-hide]').show();
        $(this).parents('.ticket-info-section').find('*[own-ticket-hide] input').attr('required', true);
      }
    });
    $('input[type="radio"]').each(function() {
      if($(this).prop("checked", true) && $(this).val() == 'myself'){
        $(this).parents('.ticket-info-section').find('*[own-ticket-hide]').hide();
      }
      if($(this).prop("checked", true) && $(this).val() == 'someone'){
        $(this).parents('.ticket-info-section').find('*[own-ticket-hide]').show();
      }
    });
    // Add Tickets Form
    var ticketSection = $(".ticket-info-section").clone(true, true);
    $('.tickets-quantity input[type="number"]').change(function() {
      var ticketsQuantity = parseInt($(this).val());
      var currentTicketsQuantity = $('.ticket-info-section').length;
      if(currentTicketsQuantity < ticketsQuantity){
        // Add Ticket
        var newTicketSection = ticketSection.clone(true, true);
        // Replace Section ID
        newTicketSection.attr('id', 'ticket_info_'+ticketsQuantity);
        // Replace Ticket No
        newTicketSection.find('.ticket-no').each(function() {
          $(this).text($(this).text().replace('1', ticketsQuantity));
        });
        // Replace IDs
        newTicketSection.find('[id*="ticket_1"]').each(function() {
          $(this).attr('id', $(this).attr('id').replace('ticket_1', 'ticket_'+ticketsQuantity));
        });
        // Replace Names
        newTicketSection.find('[name*="ticket_1"]').each(function() {
          $(this).attr('name', $(this).attr('name').replace('ticket_1', 'ticket_'+ticketsQuantity));
        });
        // Replace Fors
        newTicketSection.find('[for*="ticket_1"]').each(function() {
          $(this).attr('for', $(this).attr('for').replace('ticket_1', 'ticket_'+ticketsQuantity));
        });
        // Replace Tickets Total No
        $('#open_added_to_cart_modal').each(function() {
          $(this).text($(this).text().replace(currentTicketsQuantity, ticketsQuantity));
        });
        newTicketSection.insertAfter($('.ticket-info-section').last());
      }else if(currentTicketsQuantity > ticketsQuantity){
        // Remove Ticket
        $('.ticket-info-section').last().remove();
        // Replace Tickets Total No
        $('#open_added_to_cart_modal').each(function() {
          $(this).text($(this).text().replace(currentTicketsQuantity, ticketsQuantity));
        });
      }
    });
    // Added to cart modal
    $('#open_added_to_cart_modal').click(function(e) {
      if($('#add_to_cart')[0].checkValidity())
      {
        $('#add_to_cart').submit(function (e) {
          $.ajax({
              type: $('#add_to_cart').attr('method'),
              url: $('#add_to_cart').attr('action'),
              data: $('#add_to_cart').serialize(),
              success: function (data) {
                  $("#add_to_cart").get(0).reset();
                  $('#added_to_cart_modal').modal();
              },
              error: function (data) {
                  console.log('An error occurred.');
              },
          });
          return false;
        });        
      }
      // e.preventDefault();
      $('#open_added_to_cart_modal').unbind();
    });

  }

  /*
   * Cart Payment Page
   */
  function initCartPayment() {
    
    $("#undo-credit").click(function(event) {
      $('#credit').val(0);
      $('#credit-form').submit();
      event.preventDefault();
    });

    $("#undo-voucher").click(function(event) {
      $('#code').val(null);
      $('#voucher-form').submit();
      event.preventDefault();
    });
    
  }

  /*
   * Profile Page
   */
  function initProfile() {
    // Upcoming Event Details Trigger
    $('#pills-upcoming-events .event-details-trigger').click(function() {
      if($('#pills-upcoming-events').hasClass('event-shown')){
        // Hide Details
        $('#pills-upcoming-events').removeClass('event-shown');
      }else{
        // Show Details
        $('#pills-upcoming-events').addClass('event-shown');
      }
    });
    // Previous Event Details Trigger
    $('#pills-previous-events .event-details-trigger').click(function() {
      if($('#pills-previous-events').hasClass('event-shown')){
        // Hide Details
        $('#pills-previous-events').removeClass('event-shown');
      }else{
        // Show Details
        $('#pills-previous-events').addClass('event-shown');
      }
    });

    // upload image
    $("#profile-image").click(function() {
      $("input[id='profile_image']").click();
    });

    $('#profile_image').change(function() {
      $('#profile-image-form').submit();
    });
  }

  /*
   * Sign In / Sign Up Page
   */
  function initSignIn() {
    $("#login_form").submit(function(e) {
      console.log('do login');
      e.preventDefault();
    });
    $("#register_form").submit(function(e) {
      $('#phone_verify_modal').modal();
      e.preventDefault();
    });
  }

  /*
   * General
   */
  // Clickable Dropdown menu
  if ($(window).width() > 769) {
    $('.navbar .dropdown > a').click(function() {
      location.href = this.href;
    });
  }

  // Handles number inputs
  $('.form-control.form-number').each(function() {
    var self = $(this),
        min = self.attr('min'),
        max = self.attr('max');
    $('<img src="/images/arrow-up-icon.svg" class="quantity-add">').insertAfter($(this));
    $('<img src="/images/arrow-down-icon.svg" class="quantity-mince">').insertAfter($(this));
    $(this).next('.quantity-mince').click(function() {
      if(self.val() != min){
        var value = parseInt(self.val()) - 1;
        self.val(value);
        self.change();
      }
    });
    $($(this).nextAll('.quantity-add')[0]).click(function() {
      if(self.val() != max){
        var value = parseInt(self.val()) + 1;
        self.val(value);
        self.change();
      }
    });
  });

  // Retrieves current page id
  function getPageId() {
    var classList = document.querySelector('body').className.split(/\s+/);
    for (var i = 0; i < classList.length; i++) {
      if (classList[i].endsWith('-view')) {
        return classList[i].substring(0, classList[i].indexOf("-view"));
      }
    }
  }
  
  switch (getPageId()) {
    case 'home':
      initHome();
      break;
    case 'sign-in':
      initSignIn();
      break;
    case 'event-details':
      initEventDetails();
      break;
    case 'cart-payment':
      initCartPayment();
      break;
    case 'profile':
      initProfile();
      break;
    default:

  }
});
