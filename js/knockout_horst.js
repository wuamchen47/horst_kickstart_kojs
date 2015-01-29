// ko extension for infinite scroll
ko.bindingHandlers.scroll = {

  updating: true,

  init: function(element, valueAccessor, allBindingsAccessor) {
      var self = this
      self.updating = true;
      ko.utils.domNodeDisposal.addDisposeCallback(element, function() {
            $(window).off("scroll.ko.scrollHandler")
            self.updating = false
      });
  },

  update: function(element, valueAccessor, allBindingsAccessor){
    var props = allBindingsAccessor().scrollOptions
    var offset = props.offset ? props.offset : "0"
    var loadFunc = props.loadFunc
    var load = ko.utils.unwrapObservable(valueAccessor());
    var self = this;

    if(load){
      element.style.display = "";
      $(window).on("scroll.ko.scrollHandler", function(){
        if(($(document).height() - offset <= $(window).height() + $(window).scrollTop())){
          if(self.updating){
            loadFunc()
            self.updating = false;
          }
        }
        else{
          self.updating = true;
        }
      });
    }
    else{
        element.style.display = "none";
        $(window).off("scroll.ko.scrollHandler")
        self.updating = false
    }
  }
 }
// end extensions


// outsourced
var news = function(id, name, avatar, comment, fulldate, t,  link, private, edit){
	var self = this;
	self.newsId = ko.observable(id);
	self.name = ko.observable(name);
    self.showEdit = ko.computed(function() {
        if(edit)
          return true;
        else
          return false;
    });
	self.avatar = ko.observable(avatar);
	self.imgavatar = ko.computed(function() {
        return "<img class='align-left' src='usr/av/" + self.avatar() + "' width='47px' />";
    });
	self.comment = ko.computed(function() {
        if(link != ""){
            return comment+"<a class='button blue small pull-right' href='" + link + "'><i class='fa fa-angle-right'></i> click</a>";
        } else {
            return comment;
        }
    });
                               
	self.fulldate = ko.observable(fulldate);
    self.t = ko.observable(t);
	self.lockIcon = ko.computed(function() {
        if (private == 1) {
		  return "&nbsp;<i class='fa fa-lock fa-2x'></i>";
	  	}
        });
};



var model = function(){
    
    // define observables
	var self = this;
    self.email = ko.observable();
    self.password = ko.observable();
    self.hehe = ko.observable();
    self.remember = ko.observable(false);
    self.showPostForm = ko.observable(false);
    self.showSmilies = ko.observable(false);
    self.postPrivate = ko.observable(false);
    self.postText = ko.observable("");
    self.postLink = ko.observable();
    self.news = ko.observableArray([]);
    self.lastNewsId = ko.observable("0");
    self.postWhat = ko.observable("newPost");
    
    //functions
    // loads news in inc_news.php
    self.loadNews = function(){
        //fetch existing data from database
        $.ajax({
            url : 'includes/ajax_get_news.php',
            type : 'POST',
            crossDomain: true,
            data: {
                lid: self.lastNewsId()
            },
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
                    var edit = data[i]['edit'];
                    self.news.push(new news(id, name, avatar, comment, fulldate, t, link, private, edit));
                }
              self.lastNewsId(id);
            }
        });
    };
        
    // inc_login_form: hash + replace password & submit
    self.processLogin = function(){
        //console.log("processLogin");
        self.hehe(hex_sha512(self.password()));
        self.password("horst");
        //console.log(self.hehe());

        // der eigentliche Submit
        $.ajax({
            url : 'includes/ajax_process_login.php',
            type : 'POST',
            data: {
                e: self.email(),
                p: self.hehe(),
                r: self.remember()
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
        
    // inc_post_form: process the post form. If you are not logged in, you cannot post :)
    self.processPost = function(){
        //console.log("processPost");
        $.ajax({
        url : 'includes/ajax_process_post.php',
            type : 'POST',
            data: {
                ppriv: self.postPrivate(),
                ptext: self.postText(),
                plink: self.postLink(),
                pwhat: self.postWhat()
            },
            success: function(data){    
                self.news.removeAll();
                self.postPrivate(false);
                self.postText("");
                self.postLink("");
                self.showPostForm(false);
                self.lastNewsId("0");
                self.loadNews();
            }
        });
    };
    
    //small things
    self.logout = function(){
        window.location='includes/logout.php';
    };
    
    self.togglePost = function(){
         self.showPostForm(!self.showPostForm());
    };
  
    self.toggleSmilies = function(){
         self.showSmilies(!self.showSmilies());
    };
    
    self.insertIntoText = function(smileItem){
      self.postText(self.postText() + ":!" + smileItem + ":");
    };
    
    //do initially
    //load some news
    self.loadNews();
    //activate lazy loding for smilies
    $(function() {
        $("img.lazy").lazyload({
            effect : "fadeIn"
        });
    });

}; 

ko.applyBindings(new model());