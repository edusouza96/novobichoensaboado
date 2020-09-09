        <script src="{{ asset('js/app.js') }}" charset="utf-8"></script>
        @if(config('app.env') == 'local')
            <script src="http://localhost:35729/livereload.js"></script>
        @endif
        @stack('js-end')
    </body>
</html>