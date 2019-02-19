<!DOCTYPE html>
<html>

    <body>
    <section class="container no-height">
   
    <div class="row">
        <div class="col-lg-6">
            <div>Dear {{ $user->name }},</div><br>
            <div>
                You have successfully purchased a voucher amounting to EGP {{ $meta->discount_amount }} for {{ $meta->recipient_name }}.<br>
                The holder of this voucher will be able to use it for any of The TriFactory's current and upcoming races for one time only.</div><br>
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