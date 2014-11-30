var newsModel = function(id, name, avatar, comment, fulldate, link){
	var self = this;
	self.id = ko.observable(id);
	self.name = ko.observable(name);
	self.avatar = ko.observable(avatar);
	self.imgavatar = ko.computed(function() {
        return "<img src='usr/av/" + self.avatar() + "' width='47px' />";
    });
	self.comment = ko.observable(comment);
	self.fulldate = ko.observable(fulldate);
	self.link = ko.observable(link);
	self.btnlink = ko.computed(function() {
		if (self.link() != "") {
		  return "<a class='button orange' href='" + self.link() + "'><i class='icon-music'></i></a>";
	  	}
    });

};

var model = function(){
	var self = this;
	self.news = ko.observableArray([]);
	self.loadData = function(){
		//fetch existing data from database
		$.ajax({
			url : 'includes/getinsertupdate_news.php',
			dataType: 'json',
			success: function(data){
				for(var i in data){
					var id = data[i]['id']
					var name = data[i]['name'];
					var avatar = data[i]['avatar'];
					var comment = data[i]['comment'];
					var fulldate = data[i]['fulldate'];
					var link = data[i]['link'];
					self.news.push(new newsModel(id, name, avatar, comment, fulldate, link));
				}
				
			}
		});

		/*
		note: nothing would actually show up in the success function if the
		data that was returned from the server isn't a json string
		*/
	};

};

ko.applyBindings(new model());