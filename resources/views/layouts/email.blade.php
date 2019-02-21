<table border="0" cellspacing="0" cellpadding="0" align="center" width="600p">
    <tr>
        <td style="text-align: center;">
            <img width="166px" src="{{ $message->embed(public_path() . '/images/logo.png') }}" />
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
                    <img src="{{ $message->embed(public_path() . '/images/facebook-icon.svg') }}" alt="facebook">
                </a>
            </span>
            <span>
                <a style="text-decoration: none;" href="https://www.instagram.com/thetrifactory/">
                    <img src="{{ $message->embed(public_path() . '/images/instagram-icon.svg') }}" alt="instagram">
                </a>
            </span>
        </td>
    </tr>
</table>