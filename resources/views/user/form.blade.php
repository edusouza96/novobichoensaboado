<div id='form'>
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <label for="name">Nome completo</label>
                <input type="text" name="name" class="form-control" required value="{{old('name', $user->getName())}}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <label for="nickname">Nome de usuário</label>
                <input type="text" name="nickname" class="form-control" required value="{{old('name', $user->getNickname())}}">
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label for="password">Senha</label>
                <input type="password" name="password" class="form-control" value="{{old('password', $user->getPassword())}}">
            </div>
        </div>
    </div>
</div> 