@extends('layout.page') 
@section('title') Agenda @endsection
 
@section('content') 

<div id="diaries">
    <diary-table :data="data" date="{{$date}}"></diary-table>
</div>
@endsection
@push('js-end')
<script>
    new Vue({
        el: '#diaries',
        data: {
            data: {!! json_encode($diaries) !!}
        },
        methods:{},

    });

</script>
@endpush