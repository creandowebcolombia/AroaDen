@extends('layouts.main')

@section('content')

    @include('includes.patients_nav')

    @include('includes.messages')
    @include('includes.errors')

    {{ addText("Editar Tratamiento") }}

    <div class="row">
     <div class="col-sm-12 mar10">

        <p class="pad4 fonsi15"> {{ $surname }}, {{ $name }} </p>
        <hr>

        <p class="pad4 fonsi15">
            {{ $object->name }}:
            <br>
            <br>
            Precio: {{ $object->price }} €.
            <br>
            Cantidad: {{ $object->units }}.
            <br>
            IVA: {{ $object->tax }} %.
            <br>
            Total: {{ numformat($object->units * $object->price) }} €.      
            <br>
            Pagado: {{ $object->paid }} €.
            <br>
            Fecha: {{ date('d-m-Y', strtotime ($object->day) ) }}.        
        </p>

        <hr>

        @include('form_fields.edit.openform')

            <input type="hidden" name="price" value="{{ $object->price }}">

            @include('form_fields.edit_alternative')

        @include('form_fields.edit.closeform')

    @include('form_fields.edit.closediv')

@endsection


@section('footer_script')

    <script>
        
        $(document).ready(function() {
            var append = ' <a id="multiply_units_price" class="pad4 bgwi fuengrisoscu" title="{{ Lang::get('aroaden.multiply_units_price') }}"><i class="fa fa-lg fa-close"></i></a>';
            $('input[name="paid"]').parent().find('label').append(append);

            var append = ' <a id="put_zero" class="pad4 bgwi fuengrisoscu" title="{{ Lang::get('aroaden.put_zero') }}"><i class="fa fa-close fa-lg text-danger"></i></a>';
            $('input[name="paid"]').parent().find('label').append(append);

            $('#multiply_units_price').click(function (evt) {
                var price = {{ $object->price }};
                var units = $('input[name="units"]').val();
                var paid = util.multiply(units, price);    

                $('input[name="paid"]').val(paid);

                evt.preventDefault();
                evt.stopPropagation();              
            });

            $('#put_zero').click(function (evt) {
                $('input[name="paid"]').val(0);

                evt.preventDefault();
                evt.stopPropagation();              
            });
        });

    </script>

@endsection

@section('js')
    @parent   
      <script type="text/javascript" src="{{ asset('assets/js/modernizr.js') }}"></script>
      <script type="text/javascript" src="{{ asset('assets/js/minified/polyfiller.js') }}"></script>
      <script type="text/javascript" src="{{ asset('assets/js/webshims.js') }}"></script>
      <script type="text/javascript" src="{{ asset('assets/js/areyousure.js') }}"></script>
      <script type="text/javascript" src="{{ asset('assets/js/forgetChanges.js') }}"></script>
@endsection