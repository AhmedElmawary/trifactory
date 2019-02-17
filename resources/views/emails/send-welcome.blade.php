<!DOCTYPE html>
<html>

    <body>
    <section class="container no-height">
   
    <div class="row">
        <div class="col-lg-6">
            <div>Dear {{ $user->name }},</div><br>
            <div>
            Thank you for signing up to The TriFactory. Now you can access and keep track of your race results and ranking through your <a href="{{url('/profile')}}" >account page</a>.
            </div><br>
            <div>
            With this account, you are officially enrolled in The TriFactory Ranking Program. Brief Description of the program: The program ranks each individual per their age group. Athletes generate points by registering in any of The TriFactory races and their finish time behind the first official finisher in their age group. Athletes accumulate points at every race they complete and included in the leaderboard on a yearly basis.
            </div><br>
            <div>
            When an Athletes link their accounts with a team (the Trifactory, PowerRide,… etc.), their total points of the year will be added to the total team points giving them the chance to compete on The TriFactory’s leaderboard.
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