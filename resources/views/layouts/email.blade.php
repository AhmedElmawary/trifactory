<table border="0" cellspacing="0" cellpadding="0" align="center" width="600p">
    <tr>
        <td style="text-align: center;">
            @if (isset($ticket->Event) && preg_match("/mudder/i", $ticket->Event))
            <img width="166px" src="{{ $message->embed(public_path() . '/images/toughmudderlogo.png') }}" />
            @else
            <img width="166px" src="{{ $message->embed(public_path() . '/images/logo.png') }}" />
            @endif
        </td>
    </tr>
    <tr style="height:50px;"></tr>
    @yield('content')
    <tr style="height:30px;"></tr>
    <tr>
        <td>
            <span style="font-family: AvenirNext-Medium;font-size: 12px;color: #474747;">
                Best Regards,
            </span>
        </td>
    </tr>
    <tr>
        <td>
            <span style="font-family: AvenirNext-Medium;font-size: 12px;color: #474747;">
                The TriFactory Team
            </span>
        </td>
    </tr>
    <tr style="height:50px;"></tr>
    <tr>
        <td>
            <span>
                <a style="text-decoration: none;color: #D31D00;" href="{{url('/')}}">{{url('/')}}</a>
            </span>
        </td>
    </tr>
    <tr style="height:10px;"></tr>
    <tr>
        <td>
            <span>
                <a style="text-decoration: none;" href="https://www.facebook.com/thetrifactory">
                    <img style="height:32px; width:32px;" src="{{ $message->embed(public_path() . '/images/facebook.png') }}" alt="facebook">
                </a>
            </span>
            <span>
                <a style="text-decoration: none;" href="https://www.instagram.com/thetrifactory/">
                    <img style="height:32px; width:32px;" src="{{ $message->embed(public_path() . '/images/instagram.png') }}" alt="instagram">
                </a>
            </span>
        </td>
    </tr>
</table>