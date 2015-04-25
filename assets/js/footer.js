(function($){


HD = {

$container: $('.posts'),
$loader: $('.loader'),
$removeFilters: $('.remove-filters'),
msnry: null,
ajax: $.ajax(),
page: 1,
tags: [],
secTags: [],
spinner: '<div class="loader hid"><div class="spinner"><div class="spinner-container spinner-container1"><div class="circle1"></div><div class="circle2"></div><div class="circle3"></div><div class="circle4"></div></div><div class="spinner-container spinner-container2"><div class="circle1"></div><div class="circle2"></div><div class="circle3"></div><div class="circle4"></div></div><div class="spinner-container spinner-container3"><div class="circle1"></div><div class="circle2"></div><div class="circle3"></div><div class="circle4"></div></div></div></div>',
show_loader:function(){
    HD.$loader.removeClass('hid');
},
hide_loader:function(){
    HD.$loader.addClass('hid');
},
show_container:function(){
    HD.hide_loader();
    // HD.$container.removeClass('hid');
},
hide_container:function(){
    HD.show_loader();
    // HD.$container.addClass('hid');
},


reset_container: function(){
    imagesLoaded( HD.$container, function() {
        HD.msnry = new Masonry( HD.$container[0], {
            gutter: 20,
            itemSelector: '.posts .box, .get-more-wrapper'
        });
    });
    HD.share();
    HD.magniPopup();

},
append_container: function(data){
HD.$container.append( data );
imagesLoaded( HD.$container, function() {
    HD.msnry.appended( data );
    HD.msnry.reloadItems();
    HD.msnry.layout();
});
HD.share();
HD.magniPopup();
},
init: function(){
    // imagesLoaded( HD.$container, function() {
        HD.msnry = new Masonry( HD.$container[0], {
            gutter: 20,
            itemSelector: '.posts .box, .get-more-wrapper'
        });
    // });
    HD.handlers();
    HD.init_ajax();
},
magniPopup: function(){
$('.video-wrapper a').magnificPopup({
  type:'iframe',
  midClick: true // Allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source in href.
});

},
share: function(){
    new Share(".share-post", {
        ui: {
            button_font: false,
            icon_font: true,
        },
      networks: {
        google_plus: {
      before: function(element) {
        this.url = element.getAttribute("data-url");
        console.log('aleliuja')
        console.log(element)
      },
      after: function() {
        console.log("User shared:", this.url);
      },
          enabled: true,
          url: null
        },
      tumblr: {
      before: function(element) {
        this.url = encodeURIComponent(element.getAttribute("data-url"));
        console.log('aleliuja')
        console.log(element)
      },
      after: function() {
        console.log("User shared:", this.url);
      },
          enabled: true,
          url: null
        },
      stumbleupon: {
      before: function(element) {
        this.url = encodeURIComponent(element.getAttribute("data-url"));
        console.log('aleliuja')
        console.log(element)
      },
      after: function() {
        console.log("User shared:", this.url);
      },
          enabled: true,
          url: null
        },
      linkedin: {
      before: function(element) {
        this.url = element.getAttribute("data-url");
        console.log('aleliuja')
        console.log(element)
      },
      after: function() {
        console.log("User shared:", this.url);
      },
          enabled: true,
          url: null
        },
      delicious: {
      before: function(element) {
        this.url = element.getAttribute("data-url");
        console.log('aleliuja')
        console.log(element)
      },
      after: function() {
        console.log("User shared:", this.url);
      },
          enabled: true,
          url: null
        },
      twitter: {
      before: function(element) {
        this.url = element.getAttribute("data-url");
        console.log('aleliuja')
        console.log(element)
      },
      after: function() {
        console.log("User shared:", this.url);
      },
          enabled: true,
          url: null,
          description: null
        },
        facebook: {
      before: function(element) {
        this.url = element.getAttribute("data-url");
        console.log('aleliuja')
        console.log(element)
      },
      after: function() {
        console.log("User shared:", this.url);
      },
          enabled: true,
          load_sdk: true,
          url: null,
          app_id: null,
          title: null,
          caption: null,
          description: null,
          image: null
        },
        pinterest: {
      before: function(element) {
        this.url = element.getAttribute("data-url");
        console.log('aleliuja')
        console.log(element)
      },
      after: function() {
        console.log("User shared:", this.url);
      },
          enabled: false,
          url: null,
          image: null,
          description: null
        },
        email: {
      before: function(element) {
        this.title = element.getAttribute("data-url");
        console.log('aleliuja')
        console.log(element)
      },
      after: function() {
        console.log("User shared:", this.url);
      },
          enabled: true,
          title: null,
          description: null
        }
      }
    });
},
reloadRemoveFilters: function(){
    HD.page = 1;
    if(HD.tags.length || HD.secTags.length){
        console.log('remove');
        HD.$removeFilters.removeClass('filters-inactive').addClass('filters-active')
    }else{
        console.log('noeremove');
        HD.$removeFilters.removeClass('filters-active').addClass('filters-inactive')
    }
},
handlers: function(){
    $(document).on('submit', '.sub', function(e){
        e.preventDefault();
        jQuery.ajax({
        url: meta.ajaxurl+'?action=subscribe_to_list',
        data: {email_sub: $('.email_sub').val()},
        type: 'GET',

        success:function(data){
        // console.log($(data));
        $('.extra-info').html(data);
        },
        error: function(){
            // HD.$container.html('<h2>error</h2>');
            // $this.prop("disabled",false)
        }
      });

    })
    $(document).on('click', '.nav li.inactive', function(e){
        e.preventDefault();
        HD.hide_container();
        HD.tags.push($(this).data('id'));
        $(this).removeClass('inactive');
        $(this).addClass('active');
        HD.reloadRemoveFilters();
        HD.init_ajax();
    })
    $(document).on('click', '.nav li.active', function(e){
        e.preventDefault();
        HD.hide_container();
        var index = HD.tags.indexOf($(this).data('id'));
        if (index > -1) {
            HD.tags.splice(index, 1);
        }
        $(this).removeClass('active');
        $(this).addClass('inactive');
        HD.reloadRemoveFilters();
        HD.init_ajax();
    })
    $(document).on('click', 'a.secTag.inactive', function(e){
        e.preventDefault();
        HD.hide_container();
        HD.secTags.push($(this).data('field'));
        $(this).removeClass('inactive');
        $(this).addClass('active');
        HD.reloadRemoveFilters();
        HD.init_ajax();
    })
    $(document).on('click', 'a.secTag.active', function(e){
        e.preventDefault();
        HD.hide_container();
        var index = HD.secTags.indexOf($(this).data('field'));
        if (index > -1) {
            HD.secTags.splice(index, 1);
        }
        $(this).removeClass('active');
        $(this).addClass('inactive');
        HD.reloadRemoveFilters();
        HD.init_ajax();
    })
    $(document).on('click', '.nav li.filters-active', function(e){
        e.preventDefault()
        HD.hide_container();
        HD.tags = [];
        HD.secTags = [];
        $('.nav .active').removeClass('active').addClass('inactive');
        HD.reloadRemoveFilters();
        HD.init_ajax();
    })
    $(document).on('click', 'a.next-page', function(e){
        e.preventDefault()
        $(this).text('loading');
        HD.init_ajax();
    })
    // $(document).scroll(function(e){
    //     if (HD.Helpers.element_in_scroll(".next-page")) {
    //         $('.next-page').text('loading...')
    //         $('.next-page').click();
    //     };
    // });

},
init_ajax: function(){
        HD.ajax.abort();
        HD.ajax = jQuery.ajax({
        url: meta.ajaxurl+'?action=get_boxes',
        data: {tags: HD.tags,page: HD.page,secTags: HD.secTags},
        type: 'GET',

        success:function(data){
        console.log($(data));

        if(HD.page==1){
          HD.$container.html(data);
          HD.reset_container();
          HD.show_container();
        } else {
          $('.get-more-wrapper').remove();
          HD.append_container($(data).filter('.box, .get-more-wrapper'));
        }
        HD.page++;
        },
        error: function(){
            // HD.$container.html('<h2>error</h2>');
            // $this.prop("disabled",false)
        }
    });

},
next_page: function(){
            // HD.$container.append( elem );
        // HD.$container.imagesLoaded( function() {
        // HD.$container.masonry( 'appended', elem )
        // .masonry()
        // });
},
Helpers:{
  element_in_scroll: function(elem){
    var docViewTop = $(window).scrollTop();
    var docViewBottom = docViewTop + $(window).height();
    var elemTop = $(elem).offset().top;
    var elemBottom = elemTop + $(elem).height();

    return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
  }
}
}

HD.init();




}(jQuery))

        function element_in_scroll(elem){

        var docViewTop = $(window).scrollTop();
        var docViewBottom = docViewTop + $(window).height();

        var elemTop = $(elem).offset().top;
        var elemBottom = elemTop + $(elem).height();

        return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
        }

