<div id='form'>
    <div class="row">
        <div class="col-8">
            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" name="name" class="form-control" required value="{{old('name', $costCenter->getName())}}">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-8">
            <div class="form-group">
                <label for="cost_center_category_id">Categoria</label>
                <select name="cost_center_category_id" id="cost_center_category_id" class="form-control" v-model="id">
                    <option value>Selecione</option>
                    <option v-for="category in categories" :value="category.id" :key="category.id">@{{ category.name }}</option>
                </select>
            </div>
        </div>
    </div>
</div> 

@push('js-end')
    <script>
        new Vue({
            el: '#form',
            data: {
                categories: [],
                id: "{{old('cost_center_category_id', $costCenter->cost_center_category_id)}}",
            },
            methods:{
              
                getCategories(){
                    $.get(laroute.route("costCenter.category.allOptions"))
                    .done(function(data) {
                        this.categories = data;
                    }.bind(this));
                }
            },
            created(){
                this.getCategories();
            }
            
        });
    </script>
@endpush