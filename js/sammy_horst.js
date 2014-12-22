;(function($) {
      var app = $.sammy('#loginForm', function() {
        this.get('#:lgn', function() {
          $('#loginForm').load( "includes/inc_login_form.php" );
        });
        this.notFound = function(){
            // do something
          }
      });
      
      $(function() {
        app.run()
      });
    })(jQuery);
    
    
    
    
    