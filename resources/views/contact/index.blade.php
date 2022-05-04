<!DOCTYPE html>

@extends('layout')

@section('content')

<h1>Contact</h1>
<p>To contact us, you can either use this form or directly send a message to:
tapscan(at)plantcode-mail.biologie.uni-marburg.de</p>
  <form>
    <div class="form-group">
      <label for="exampleFormControlInput1">Your name</label>
      <input type="Name" class="form-control" id="exampleFormControlInput1" placeholder="Max Mustermann">
    </div>

    <div class="form-group">
      <label for="exampleFormControlInput2">Your Email address</label>
      <input type="email" class="form-control" id="exampleFormControlInput2" placeholder="name@example.com">
    </div>

    <div class="form-group">
      <label for="exampleFormControlTextarea1">Your message</label>
      <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
    </div>
  </form>

  <p>Please note that if you decide to use the contact form we will use google recaptcha to make sure that you are a human being. In this process data will be transmitted to google. This data transfer is not under our control (see privacy and terms link in the recaptcha box). If you click submit you agree to these conditions. You can also reach us via normal e-mail (see top of this form) instead of using the contact form.</p>


@endsection
