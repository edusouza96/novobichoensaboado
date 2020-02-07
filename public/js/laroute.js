(function () {

    var laroute = (function () {

        var routes = {

            absolute: false,
            rootUrl: 'http://localhost',
            routes : [{"host":null,"methods":["GET","HEAD"],"uri":"api\/user","name":null,"action":"Closure"},{"host":null,"methods":["GET","HEAD"],"uri":"\/","name":null,"action":"Closure"},{"host":null,"methods":["GET","HEAD"],"uri":"sair","name":"logout","action":"Closure"},{"host":null,"methods":["GET","HEAD"],"uri":"dashboard","name":"dashboard.index","action":"Closure"},{"host":null,"methods":["GET","HEAD"],"uri":"agenda\/{date?}","name":"diary.index","action":"BichoEnsaboado\Http\Controllers\DiaryController@index"},{"host":null,"methods":["POST"],"uri":"agenda\/salvar","name":"diary.store","action":"BichoEnsaboado\Http\Controllers\DiaryController@store"},{"host":null,"methods":["POST"],"uri":"agenda\/checkin","name":"diary.checkin","action":"BichoEnsaboado\Http\Controllers\DiaryController@checkin"},{"host":null,"methods":["POST"],"uri":"agenda\/cancelar","name":"diary.destroy","action":"BichoEnsaboado\Http\Controllers\DiaryController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"vendas\/estorno","name":"sales.chargeback","action":"BichoEnsaboado\Http\Controllers\SaleController@chargeback"},{"host":null,"methods":["GET","HEAD"],"uri":"vendas\/do-dia\/{date?}","name":"sales.ofDay","action":"BichoEnsaboado\Http\Controllers\SaleController@ofDay"},{"host":null,"methods":["GET","HEAD"],"uri":"vendas\/itens-por-venda\/{id}","name":"sales.itemsBySale","action":"BichoEnsaboado\Http\Controllers\SaleController@itemsBySale"},{"host":null,"methods":["GET","HEAD"],"uri":"pdv\/{id?}","name":"pdv.index","action":"BichoEnsaboado\Http\Controllers\PdvController@index"},{"host":null,"methods":["POST"],"uri":"pdv\/registrar-pagamento","name":"pdv.registerPayment","action":"BichoEnsaboado\Http\Controllers\PdvController@registerPayment"},{"host":null,"methods":["GET","HEAD"],"uri":"pdv\/nota-fiscal\/{id}","name":"pdv.invoice","action":"BichoEnsaboado\Http\Controllers\PdvController@invoice"},{"host":null,"methods":["GET","HEAD"],"uri":"pdv\/compras\/{ids}","name":"pdv.getBuys","action":"BichoEnsaboado\Http\Controllers\PdvController@getBuys"},{"host":null,"methods":["GET","HEAD"],"uri":"fonte\/buscar-por-loja\/{id}","name":"treasure.findByStore","action":"BichoEnsaboado\Http\Controllers\TreasureController@findByStore"},{"host":null,"methods":["GET","HEAD"],"uri":"fonte\/lista-maquinas-cartoes\/{id}","name":"treasure.findOptionsCardMachineByStore","action":"BichoEnsaboado\Http\Controllers\TreasureController@findOptionsCardMachineByStore"},{"host":null,"methods":["GET","HEAD"],"uri":"financeiro\/despesas","name":"outlay.index","action":"BichoEnsaboado\Http\Controllers\OutlayController@index"},{"host":null,"methods":["POST"],"uri":"financeiro\/despesas\/cadastrar","name":"outlay.store","action":"BichoEnsaboado\Http\Controllers\OutlayController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"financeiro\/despesas\/cadastrar","name":"outlay.create","action":"BichoEnsaboado\Http\Controllers\OutlayController@create"},{"host":null,"methods":["GET","HEAD"],"uri":"financeiro\/despesas\/editar\/{id}","name":"outlay.edit","action":"BichoEnsaboado\Http\Controllers\OutlayController@edit"},{"host":null,"methods":["POST"],"uri":"financeiro\/despesas\/editar\/{id}","name":"outlay.update","action":"BichoEnsaboado\Http\Controllers\OutlayController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"financeiro\/despesas\/deletar\/{id}","name":"outlay.destroy","action":"BichoEnsaboado\Http\Controllers\OutlayController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"financeiro\/despesas\/buscar\/{id}","name":"outlay.showJson","action":"BichoEnsaboado\Http\Controllers\OutlayController@showJson"},{"host":null,"methods":["POST"],"uri":"financeiro\/despesas\/pagar","name":"outlay.pay","action":"BichoEnsaboado\Http\Controllers\OutlayController@pay"},{"host":null,"methods":["GET","HEAD"],"uri":"financeiro\/despesas\/lista\/{type}","name":"outlay.listDashboard","action":"BichoEnsaboado\Http\Controllers\OutlayController@listDashboard"},{"host":null,"methods":["GET","HEAD"],"uri":"financeiro\/despesas\/deletar\/{type}","name":"outlay.destroy","action":"BichoEnsaboado\Http\Controllers\OutlayController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"financeiro\/despesas\/buscar-por-dia","name":"outlay.findByDate","action":"BichoEnsaboado\Http\Controllers\OutlayController@findByDate"},{"host":null,"methods":["GET","HEAD"],"uri":"financeiro\/receita\/buscar-por-dia","name":"sale.findByDate","action":"BichoEnsaboado\Http\Controllers\SaleController@findByDate"},{"host":null,"methods":["GET","HEAD"],"uri":"financeiro\/extrato-do-dia","name":"cashdesk.extractOfDay","action":"BichoEnsaboado\Http\Controllers\CashdeskController@extractOfDay"},{"host":null,"methods":["POST"],"uri":"financeiro\/transferencia","name":"cashdesk.moneyTransfer","action":"BichoEnsaboado\Http\Controllers\CashdeskController@moneyTransfer"},{"host":null,"methods":["GET","HEAD"],"uri":"financeiro\/blacklist","name":"cashdesk.blacklist","action":"BichoEnsaboado\Http\Controllers\DiaryController@blacklist"},{"host":null,"methods":["POST"],"uri":"caixa\/aporte","name":"cashdesk.contribute","action":"BichoEnsaboado\Http\Controllers\CashdeskController@contribute"},{"host":null,"methods":["POST"],"uri":"caixa\/sangria","name":"cashdesk.bleed","action":"BichoEnsaboado\Http\Controllers\CashdeskController@bleed"},{"host":null,"methods":["POST"],"uri":"caixa\/abrir","name":"cashdesk.open","action":"BichoEnsaboado\Http\Controllers\CashdeskController@open"},{"host":null,"methods":["POST"],"uri":"caixa\/fechar","name":"cashdesk.close","action":"BichoEnsaboado\Http\Controllers\CashdeskController@close"},{"host":null,"methods":["GET","HEAD"],"uri":"caixa\/checar-status","name":"cashdesk.status","action":"BichoEnsaboado\Http\Controllers\CashdeskController@status"},{"host":null,"methods":["GET","HEAD"],"uri":"caixa\/valor-gaveta","name":"cashdesk.getCashDrawer","action":"BichoEnsaboado\Http\Controllers\CashdeskController@getCashDrawer"},{"host":null,"methods":["GET","HEAD"],"uri":"caixa\/inconsistencia-caixa-nao-finalizado","name":"cashdesk.inconsistencyUnfinishedCashdesk","action":"BichoEnsaboado\Http\Controllers\CashdeskController@inconsistencyUnfinishedCashdesk"},{"host":null,"methods":["GET","HEAD"],"uri":"proprietario","name":"owner.index","action":"BichoEnsaboado\Http\Controllers\OwnerController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"proprietario\/meus-pets\/{id}","name":"owner.myPets","action":"BichoEnsaboado\Http\Controllers\OwnerController@myPets"},{"host":null,"methods":["GET","HEAD"],"uri":"proprietario\/cadastrar","name":"owner.create","action":"BichoEnsaboado\Http\Controllers\OwnerController@create"},{"host":null,"methods":["POST"],"uri":"proprietario\/cadastrar","name":"owner.store","action":"BichoEnsaboado\Http\Controllers\OwnerController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"proprietario\/editar\/{id}","name":"owner.edit","action":"BichoEnsaboado\Http\Controllers\OwnerController@edit"},{"host":null,"methods":["POST"],"uri":"proprietario\/editar\/{id}","name":"owner.update","action":"BichoEnsaboado\Http\Controllers\OwnerController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"proprietario\/deletar\/{id}","name":"owner.destroy","action":"BichoEnsaboado\Http\Controllers\OwnerController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"pet\/localizar-por-nome\/{name}","name":"client.findByName","action":"BichoEnsaboado\Http\Controllers\ClientController@findByName"},{"host":null,"methods":["GET","HEAD"],"uri":"pet\/deletar\/{id}","name":"client.destroy","action":"BichoEnsaboado\Http\Controllers\ClientController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"pet\/cadastrar\/{id}","name":"client.create","action":"BichoEnsaboado\Http\Controllers\ClientController@create"},{"host":null,"methods":["POST"],"uri":"pet\/cadastrar","name":"client.store","action":"BichoEnsaboado\Http\Controllers\ClientController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"pet\/editar\/{id}","name":"client.edit","action":"BichoEnsaboado\Http\Controllers\ClientController@edit"},{"host":null,"methods":["POST"],"uri":"pet\/editar\/{id}","name":"client.update","action":"BichoEnsaboado\Http\Controllers\ClientController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"pet\/historico\/{client_id}","name":"client.historic","action":"BichoEnsaboado\Http\Controllers\DiaryController@historic"},{"host":null,"methods":["GET","HEAD"],"uri":"servico\/localizar-por-raca\/{id}","name":"service.findByBreed","action":"BichoEnsaboado\Http\Controllers\ServiceController@findByBreed"},{"host":null,"methods":["GET","HEAD"],"uri":"servico\/veterinario","name":"service.allVet","action":"BichoEnsaboado\Http\Controllers\ServiceController@allVet"},{"host":null,"methods":["GET","HEAD"],"uri":"servico","name":"service.index","action":"BichoEnsaboado\Http\Controllers\ServiceController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"servico\/deletar\/{id}","name":"service.destroy","action":"BichoEnsaboado\Http\Controllers\ServiceController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"servico\/cadastrar","name":"service.create","action":"BichoEnsaboado\Http\Controllers\ServiceController@create"},{"host":null,"methods":["POST"],"uri":"servico\/cadastrar","name":"service.store","action":"BichoEnsaboado\Http\Controllers\ServiceController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"servico\/editar\/{id}","name":"service.edit","action":"BichoEnsaboado\Http\Controllers\ServiceController@edit"},{"host":null,"methods":["POST"],"uri":"servico\/editar\/{id}","name":"service.update","action":"BichoEnsaboado\Http\Controllers\ServiceController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"produto\/localizar-por-nome\/{name}","name":"product.findByName","action":"BichoEnsaboado\Http\Controllers\ProductController@findByName"},{"host":null,"methods":["GET","HEAD"],"uri":"produto\/aviso-baixa-quantidade","name":"product.lowQuantity","action":"BichoEnsaboado\Http\Controllers\ProductController@lowQuantity"},{"host":null,"methods":["GET","HEAD"],"uri":"produto","name":"product.index","action":"BichoEnsaboado\Http\Controllers\ProductController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"produto\/deletar\/{id}","name":"product.destroy","action":"BichoEnsaboado\Http\Controllers\ProductController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"produto\/cadastrar","name":"product.create","action":"BichoEnsaboado\Http\Controllers\ProductController@create"},{"host":null,"methods":["POST"],"uri":"produto\/cadastrar","name":"product.store","action":"BichoEnsaboado\Http\Controllers\ProductController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"produto\/editar\/{id}","name":"product.edit","action":"BichoEnsaboado\Http\Controllers\ProductController@edit"},{"host":null,"methods":["POST"],"uri":"produto\/editar\/{id}","name":"product.update","action":"BichoEnsaboado\Http\Controllers\ProductController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"produto\/codigo-barras\/{id}\/{count?}","name":"product.barcode","action":"BichoEnsaboado\Http\Controllers\ProductController@barcode"},{"host":null,"methods":["GET","HEAD"],"uri":"bairro","name":"neighborhood.index","action":"BichoEnsaboado\Http\Controllers\NeighborhoodController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"bairro\/cadastrar","name":"neighborhood.create","action":"BichoEnsaboado\Http\Controllers\NeighborhoodController@create"},{"host":null,"methods":["GET","HEAD"],"uri":"bairro\/editar\/{id}","name":"neighborhood.edit","action":"BichoEnsaboado\Http\Controllers\NeighborhoodController@edit"},{"host":null,"methods":["GET","HEAD"],"uri":"bairro\/deletar\/{id}","name":"neighborhood.destroy","action":"BichoEnsaboado\Http\Controllers\NeighborhoodController@destroy"},{"host":null,"methods":["POST"],"uri":"bairro\/cadastrar","name":"neighborhood.store","action":"BichoEnsaboado\Http\Controllers\NeighborhoodController@store"},{"host":null,"methods":["POST"],"uri":"bairro\/editar\/{id}","name":"neighborhood.update","action":"BichoEnsaboado\Http\Controllers\NeighborhoodController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"bairro\/opcoes","name":"neighborhood.allOptions","action":"BichoEnsaboado\Http\Controllers\NeighborhoodController@allOptions"},{"host":null,"methods":["GET","HEAD"],"uri":"racas","name":"breed.index","action":"BichoEnsaboado\Http\Controllers\BreedController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"racas\/cadastrar","name":"breed.create","action":"BichoEnsaboado\Http\Controllers\BreedController@create"},{"host":null,"methods":["GET","HEAD"],"uri":"racas\/editar\/{id}","name":"breed.edit","action":"BichoEnsaboado\Http\Controllers\BreedController@edit"},{"host":null,"methods":["GET","HEAD"],"uri":"racas\/deletar\/{id}","name":"breed.destroy","action":"BichoEnsaboado\Http\Controllers\BreedController@destroy"},{"host":null,"methods":["POST"],"uri":"racas\/cadastrar","name":"breed.store","action":"BichoEnsaboado\Http\Controllers\BreedController@store"},{"host":null,"methods":["POST"],"uri":"racas\/editar\/{id}","name":"breed.update","action":"BichoEnsaboado\Http\Controllers\BreedController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"racas\/opcoes","name":"breed.allOptions","action":"BichoEnsaboado\Http\Controllers\BreedController@allOptions"},{"host":null,"methods":["GET","HEAD"],"uri":"centro-custo","name":"costCenter.index","action":"BichoEnsaboado\Http\Controllers\CostCenterController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"centro-custo\/cadastrar","name":"costCenter.create","action":"BichoEnsaboado\Http\Controllers\CostCenterController@create"},{"host":null,"methods":["GET","HEAD"],"uri":"centro-custo\/editar\/{id}","name":"costCenter.edit","action":"BichoEnsaboado\Http\Controllers\CostCenterController@edit"},{"host":null,"methods":["GET","HEAD"],"uri":"centro-custo\/deletar\/{id}","name":"costCenter.destroy","action":"BichoEnsaboado\Http\Controllers\CostCenterController@destroy"},{"host":null,"methods":["POST"],"uri":"centro-custo\/cadastrar","name":"costCenter.store","action":"BichoEnsaboado\Http\Controllers\CostCenterController@store"},{"host":null,"methods":["POST"],"uri":"centro-custo\/editar\/{id}","name":"costCenter.update","action":"BichoEnsaboado\Http\Controllers\CostCenterController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"centro-custo\/opcoes","name":"costCenter.allOptions","action":"BichoEnsaboado\Http\Controllers\CostCenterController@allOptions"},{"host":null,"methods":["GET","HEAD"],"uri":"centro-custo\/categoria\/opcoes","name":"costCenter.category.allOptions","action":"BichoEnsaboado\Http\Controllers\CostCenterCategoryController@allOptions"},{"host":null,"methods":["GET","HEAD"],"uri":"promocao\/todos-ativos","name":"rebate.findActive","action":"BichoEnsaboado\Http\Controllers\RebateController@findActive"},{"host":null,"methods":["GET","HEAD"],"uri":"promocao","name":"rebate.index","action":"BichoEnsaboado\Http\Controllers\RebateController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"promocao\/cadastrar","name":"rebate.create","action":"BichoEnsaboado\Http\Controllers\RebateController@create"},{"host":null,"methods":["GET","HEAD"],"uri":"promocao\/editar\/{id}","name":"rebate.edit","action":"BichoEnsaboado\Http\Controllers\RebateController@edit"},{"host":null,"methods":["POST"],"uri":"promocao\/cadastrar","name":"rebate.store","action":"BichoEnsaboado\Http\Controllers\RebateController@store"},{"host":null,"methods":["POST"],"uri":"promocao\/editar\/{id}","name":"rebate.update","action":"BichoEnsaboado\Http\Controllers\RebateController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"promocao\/ativar\/{id}","name":"rebate.active","action":"BichoEnsaboado\Http\Controllers\RebateController@active"},{"host":null,"methods":["GET","HEAD"],"uri":"promocao\/inativar\/{id}","name":"rebate.inactive","action":"BichoEnsaboado\Http\Controllers\RebateController@inactive"},{"host":null,"methods":["GET","HEAD"],"uri":"loja\/cadastrar","name":"store.create","action":"BichoEnsaboado\Http\Controllers\StoreController@create"},{"host":null,"methods":["POST"],"uri":"loja\/cadastrar","name":"store.store","action":"BichoEnsaboado\Http\Controllers\StoreController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"loja\/editar\/{id}","name":"store.edit","action":"BichoEnsaboado\Http\Controllers\StoreController@edit"},{"host":null,"methods":["POST"],"uri":"loja\/editar\/{id}","name":"store.update","action":"BichoEnsaboado\Http\Controllers\StoreController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"loja\/deletar\/{id}","name":"store.destroy","action":"BichoEnsaboado\Http\Controllers\StoreController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"loja","name":"store.index","action":"BichoEnsaboado\Http\Controllers\StoreController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario","name":"user.index","action":"BichoEnsaboado\Http\Controllers\UserController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/deletar\/{id}","name":"user.destroy","action":"BichoEnsaboado\Http\Controllers\UserController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/cadastrar","name":"user.create","action":"BichoEnsaboado\Http\Controllers\UserController@create"},{"host":null,"methods":["POST"],"uri":"usuario\/cadastrar","name":"user.store","action":"BichoEnsaboado\Http\Controllers\UserController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"usuario\/editar\/{id}","name":"user.edit","action":"BichoEnsaboado\Http\Controllers\UserController@edit"},{"host":null,"methods":["POST"],"uri":"usuario\/editar\/{id}","name":"user.update","action":"BichoEnsaboado\Http\Controllers\UserController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"info","name":null,"action":"Closure"}],
            prefix: '',

            route : function (name, parameters, route) {
                route = route || this.getByName(name);

                if ( ! route ) {
                    return undefined;
                }

                return this.toRoute(route, parameters);
            },

            url: function (url, parameters) {
                parameters = parameters || [];

                var uri = url + '/' + parameters.join('/');

                return this.getCorrectUrl(uri);
            },

            toRoute : function (route, parameters) {
                var uri = this.replaceNamedParameters(route.uri, parameters);
                var qs  = this.getRouteQueryString(parameters);

                if (this.absolute && this.isOtherHost(route)){
                    return "//" + route.host + "/" + uri + qs;
                }

                return this.getCorrectUrl(uri + qs);
            },

            isOtherHost: function (route){
                return route.host && route.host != window.location.hostname;
            },

            replaceNamedParameters : function (uri, parameters) {
                uri = uri.replace(/\{(.*?)\??\}/g, function(match, key) {
                    if (parameters.hasOwnProperty(key)) {
                        var value = parameters[key];
                        delete parameters[key];
                        return value;
                    } else {
                        return match;
                    }
                });

                // Strip out any optional parameters that were not given
                uri = uri.replace(/\/\{.*?\?\}/g, '');

                return uri;
            },

            getRouteQueryString : function (parameters) {
                var qs = [];
                for (var key in parameters) {
                    if (parameters.hasOwnProperty(key)) {
                        qs.push(key + '=' + parameters[key]);
                    }
                }

                if (qs.length < 1) {
                    return '';
                }

                return '?' + qs.join('&');
            },

            getByName : function (name) {
                for (var key in this.routes) {
                    if (this.routes.hasOwnProperty(key) && this.routes[key].name === name) {
                        return this.routes[key];
                    }
                }
            },

            getByAction : function(action) {
                for (var key in this.routes) {
                    if (this.routes.hasOwnProperty(key) && this.routes[key].action === action) {
                        return this.routes[key];
                    }
                }
            },

            getCorrectUrl: function (uri) {
                var url = this.prefix + '/' + uri.replace(/^\/?/, '');

                if ( ! this.absolute) {
                    return url;
                }

                return this.rootUrl.replace('/\/?$/', '') + url;
            }
        };

        var getLinkAttributes = function(attributes) {
            if ( ! attributes) {
                return '';
            }

            var attrs = [];
            for (var key in attributes) {
                if (attributes.hasOwnProperty(key)) {
                    attrs.push(key + '="' + attributes[key] + '"');
                }
            }

            return attrs.join(' ');
        };

        var getHtmlLink = function (url, title, attributes) {
            title      = title || url;
            attributes = getLinkAttributes(attributes);

            return '<a href="' + url + '" ' + attributes + '>' + title + '</a>';
        };

        return {
            // Generate a url for a given controller action.
            // laroute.action('HomeController@getIndex', [params = {}])
            action : function (name, parameters) {
                parameters = parameters || {};

                return routes.route(name, parameters, routes.getByAction(name));
            },

            // Generate a url for a given named route.
            // laroute.route('routeName', [params = {}])
            route : function (route, parameters) {
                parameters = parameters || {};

                return routes.route(route, parameters);
            },

            // Generate a fully qualified URL to the given path.
            // laroute.route('url', [params = {}])
            url : function (route, parameters) {
                parameters = parameters || {};

                return routes.url(route, parameters);
            },

            // Generate a html link to the given url.
            // laroute.link_to('foo/bar', [title = url], [attributes = {}])
            link_to : function (url, title, attributes) {
                url = this.url(url);

                return getHtmlLink(url, title, attributes);
            },

            // Generate a html link to the given route.
            // laroute.link_to_route('route.name', [title=url], [parameters = {}], [attributes = {}])
            link_to_route : function (route, title, parameters, attributes) {
                var url = this.route(route, parameters);

                return getHtmlLink(url, title, attributes);
            },

            // Generate a html link to the given controller action.
            // laroute.link_to_action('HomeController@getIndex', [title=url], [parameters = {}], [attributes = {}])
            link_to_action : function(action, title, parameters, attributes) {
                var url = this.action(action, parameters);

                return getHtmlLink(url, title, attributes);
            }

        };

    }).call(this);

    /**
     * Expose the class either via AMD, CommonJS or the global object
     */
    if (typeof define === 'function' && define.amd) {
        define(function () {
            return laroute;
        });
    }
    else if (typeof module === 'object' && module.exports){
        module.exports = laroute;
    }
    else {
        window.laroute = laroute;
    }

}).call(this);

