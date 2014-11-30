var newsModel = function(id, name, comment){
	var self = this;
	self.id = ko.observable(id);
	self.name = ko.observable(name);
	self.comment = ko.observable(comment);
};

var model = function(){
	var self = this;
	self.news = ko.observableArray([]);
	self.loadData = function(){
		//fetch existing data from database
		$.ajax({
			url : 'includes/get_news.php',
			dataType: 'json',
			success: function(data){
				for(var x in data){
					var id = data[x]['id']
					var name = data[x]['name'];
					var comment = data[x]['comment'];
					self.news.push(new newsModel(id, name, comment));
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