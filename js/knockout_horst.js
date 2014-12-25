var news = function(id, name, avatar, comment, fulldate, t,  link, private){
	var self = this;
	self.id = ko.observable(id);
	self.name = ko.observable(name);
	self.avatar = ko.observable(avatar);
	self.imgavatar = ko.computed(function() {
        return "<img class='align-left' src='usr/av/" + self.avatar() + "' width='47px' />";
    });
	self.comment = ko.computed(function() {
        if(link != ""){
            return comment+"<a class='button blue small pull-right' href='" + link + "'><i class='icon-angle-right'></i> click</a>";
        } else {
            return comment;
        }
    });
                               
	self.fulldate = ko.observable(fulldate);
    self.t = ko.observable(t);
	self.lockIcon = ko.computed(function() {
        if (private == 1) {
		  return "&nbsp;<i class='icon-lock'></i>";
	  	}
        });
};



var model = function(){
	var self = this;
        self.email = ko.observable();
        self.password = ko.observable();
	    self.hehe = ko.observable();
        self.news = ko.observableArray([]);
	    self.loadNews = function(){
            //fetch existing data from database
            $.ajax({
                url : 'includes/ajax_get_news.php',
                dataType: 'json',
                success: function(data){
                    for(var i in data){
                        var id = data[i]['id']
                        var name = data[i]['name'];
                        var avatar = data[i]['avatar'];
                        var comment = data[i]['comment'];
                        var fulldate = data[i]['fulldate'];
                        var t = data[i]['time'];
                        var link = data[i]['link'];
                        var private = data[i]['private'];
                        self.news.push(new news(id, name, avatar, comment, fulldate, t, link, private));
                    }

                }
            });

            /*
            note: nothing would actually show up in the success function if the
            data that was returned from the server isn't a json string
            */
        };
        
        //submit the form, before hash pw
        self.processLogin = function(){
            //console.log("processLogin");
            self.hehe(hex_sha512(self.password()));
            self.password("horst");
            console.log(self.hehe());

            // der eigentliche Submit
            $.ajax({
            url : 'includes/ajax_process_login.php',
                        type : 'POST',
                        data: {
                            e: self.email(),
                            p: self.hehe()
                        },
                        success: function(data){    
                            if(data=="47"){
                                window.location='horst.php';
                            }
                            else    {
                                window.location='horst.php?error='+data;
                            }
                        }
            });
        };
        
        self.logout = function(){
            window.location='includes/logout.php';
        };
    
        self.loadPost = function(){
             $("#postForm").load("includes/inc_post.php");
        };
        

}; 

ko.applyBindings(new model());