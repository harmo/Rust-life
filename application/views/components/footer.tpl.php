    <div class="footer container-fluid">
        <div class="container">
            &copy; Rust Life <?php echo date('Y'); ?>
        </div>

        <?php if(!DEV): ?>
            <script>
                (function(i,s,o,g,r,a,m){
                    i['GoogleAnalyticsObject'] = r;
                    i[r] = i[r] || function(){
                        (i[r].q = i[r].q || []).push(arguments);
                    },
                    i[r].l = 1*new Date();
                    a = s.createElement(o),
                    m = s.getElementsByTagName(o)[0];
                    a.async = 1;
                    a.src = g;
                    m.parentNode.insertBefore(a,m);
                })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

                ga('create', 'UA-50681419-1', 'rust-life.fr');
                ga('send', 'pageview');
            </script>
            <script>
                (function() {
                    var ferank = document.createElement('script');
                    ferank.type = 'text/javascript';
                    ferank.async = true;
                    ferank.src = ('https:' == document.location.protocol ? 'https://static' : 'http://static') + '.ferank.fr/pixel.js';
                    var s = document.getElementsByTagName('script')[0];
                    s.parentNode.insertBefore(ferank, s);
                })();
            </script>
        <?php endif ?>
    </div>