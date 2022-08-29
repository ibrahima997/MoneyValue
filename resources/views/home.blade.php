@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        
        <div id="app">
            <currency-converter></currency-converter>
        </div>
    </div>
    <script type="text/javascript" src="js/app.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</div>

@endsection
