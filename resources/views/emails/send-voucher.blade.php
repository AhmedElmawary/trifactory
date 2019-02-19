<!DOCTYPE html>
<html>

    <body>
    <section class="container no-height">
   
    <div class="row">
        <div class="col-lg-6">
            <div>Dear {{ $meta->recipient_name }},</div><br>
            <div>
            Congratulations, {{ $user->name }} have gifted you a voucher to use in any of The TriFactory's current or upcoming races.</div><br>
            <div>
                {{ $meta->message }}
            </div><br>
            <div>
            This voucher can be used for one time only when registering in our races. In the case you did not use the full voucher amount, the rest of the amount not used will remain in your credit balance to be used in any upcoming races you wish to register to.
            </div><br>
            <div>
                <b>Voucher Code: </b> {{ $voucher->code }}
            </div><br>
            <div>
            Looking forward to seeing you in our events.
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