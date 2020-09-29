@extends('layout.page') 
@section('title') Agenda @endsection
 
@section('content') 
<div id="diaries">
    <div class="header-info-date-calendar text-uppercase">
        {{ ($date->formatLocalized('%A, %d de %B de %Y'))}}
        
        <button type="button" @click="openCalendar()" class="btn text-danger">
            <i class="far fa-calendar-alt fa-2x"></i>
        </button>
        <datetime 
            input-id="choose_day"
            value-zone="America/Sao_Paulo"
            input-class="invisible"
            v-model="day">
        </datetime>
    </div>
    <diary-table :data="data" date="{{$date}}" msg="{{$msg}}"></diary-table>
</div>
@endsection
@push('js-end')
<script>
    new Vue({
        el: '#diaries',
        data: {
            data: {!! json_encode($diaries) !!},
            day: null,
        },
        methods:{
            openCalendar(){
                $('#choose_day').click();
            }
        },
        watch:{
            day(){
                if(this.day.length >= 10){
                    let date = this.day.substring(0,10);
                    let url = laroute.route('diary.index', {date:date});
                    location.replace(url);
                }
            }
        }

    });

</script>
@endpush