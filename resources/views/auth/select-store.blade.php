@extends('layout.page') 
@section('title') Selecione a loja @endsection
 
@section('form') 
<form method="POST" action="{{route('auth-definition.setCurrenteStore')}}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="card">
        <div class="card-header filter-header">Selecione a loja </div>
            <div class="card-body">
                <div id='form' v-cloak>
                    <div class="row">
                        <div class="col-6">
                            <div class="input-group mb-3">
                                <select name="store_id" id="store_id" class="form-control" v-model="store_id" required>
                                    <option value>Selecione</option>
                                    <option v-for="store in stores" :value="store.id" :key="store.id">@{{ store.name }}</option>
                                </select>
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit"> Confirmar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
 

@push('js-end')
    <script>
        new Vue({
            el: '#form',
            data:{
                stores:@json(auth()->user()->stores),
                store_id: "{{ request()->input('store_id') }}",
            },
        });
    </script>
@endpush
