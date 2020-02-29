<div id='form'>
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <label for="name">Nome da promoção/desconto</label>
                <input type="text" name="name" class="form-control" required value="{{old('name', $rebate->getName())}}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-3">
            <div class="form-group">
                <label for="value">Valor em % do desconto</label>
                <input type="number" name="value" id="value" class="form-control" value="{{old('value', $rebate->getValue())}}">
            </div>
        </div>
    </div>
    <fieldset>
        <legend>Serviços a ser aplicado o desconto</legend>
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="pet" name="pet" value="1" {{old('pet', $rebate->applyPet()) ? 'checked' : false}}>
                        <label class="form-check-label" for="pet">Serviços de Pet</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="vet" name="vet" value="1" {{old('vet', $rebate->applyVet()) ? 'checked' : false}}>
                        <label class="form-check-label" for="vet">Serviços Veterinário</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="product" name="product" value="1" {{old('product', $rebate->applyProduct()) ? 'checked' : false}}>
                        <label class="form-check-label" for="product">Produtos</label>
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
</div> 
