@extends('layouts.app', ['body_class' => 'home-view'])  @section('title', 'Gender Filling')
@section('content')

<div class="container">
    <section class="login-section no-height">
        <div class="row">
            <div class="col-lg-6 offset-lg-3 text-center">
                <h3>
                 Hello {{ $user->name}}, 
                  We apologize for redirecting you, but you need to submit your gender in order to proceed</h3>
                    <form method="POST" action="{{ route('gender', ['user'=>$user]) }}">
                    @csrf
                    <div class="input-group">
                        <input id="email" placeholder="E-mail" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="input-group">
                        <select style="margin-top:20px;" class="custom-select" name="gender" required>
                            <option disabled value="" selected>Gender</option>

                            @foreach($gender as $type)
                            <option value="{{$type['value']}}">{{$type['label']}}</option>
                            @endforeach

                        </select>

                        @if ($errors->has('gender'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('gender') }}</strong>
                        </span>
                        @endif
                    </div>
                    <button type="submit" class="btn dark btn-clear float-right mt-2">Submit</button>
                </form>
            </div>
        </div>
    </section>
</div>

@endsection 