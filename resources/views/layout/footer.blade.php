        <!--Import jQuery before materialize.js-->
        <script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/materialize.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/vue.min.js') }}"></script>
        <script type="text/javascript">
            $(function(){
                $(".button-collapse").sideNav();
            });
        </script>
        
        @stack('js-end')

    </body>
</html>