<!DOCTYPE html>
<html>

    <body>
    <section class="container no-height">
   
    <div class="row">
        <div class="col-lg-6">
            <div>Dear {{ $user->name }},</div><br>
            @if($other === false)
                @if($self)
                <div>
                    Thank you for registering in {{ $ticket->Event }}.  This is your registration confirmation for {{ $ticket->Event }}.
                </div><br>
                @else
                <div>
                You successfully registered in {{ $ticket->Event }}, a ticket to {{ $ticket->Race }} for {{ $ticket->For }}
                </div><br>
                @endif
            @else
                @if($fromUser)
                <div>
                    You have successfully registered to {{ $fromUser->name }} to {{ $ticket->Race }}.
                </div><br>
                @endif
            @endif

            <div>
                Ticket Information:<br>
                <br>
                1. <b>Ticket ID: </b>{{ $ticketId }} <br>
                2. <b>Event: </b> {{ $ticket->Event }} <br>
                3. <b>Race: </b>{{ $ticket->Race }} <br>
                4. <b>Participant Name: </b>{{ $ticket->For }} <br>
                5. <b>Price: </b>EGP {{ $ticket->Price }} <br>
                6. <b>Payment Method: </b>@if($ticket->paymentMethod === 'card')
                    Credit Card.
                    @else
                        Cash
                    @endif
                    <br> 
                    @if($ticket->paymentMethod === 'cash')
                    Your race ticket will be confirmed and a race number will be assigned when the payment is completed successfully.<br>
                    @endif

            </div><br>

            <div>
                @if($other)
                    To complete your account and benefit from the The TriFactory’s ranking program, <a href="{{ url('/password/reset') }}">click here</a><br>
                @endif
            </div><br>
            
            <div>
                --<br>
                Best Regards,<br>
                The TriFactory Team
            </div><br>
            <div>
                <a href="{{url('/')}}">Webiste</a><br>
                <a href="https://www.facebook.com/thetrifactory">Facebook</a><br>
                <a href="https://www.instagram.com/thetrifactory/">Instagram</a><br>
            </div>
        </div>
    </div>

    </section>
        
    </body>

</html>