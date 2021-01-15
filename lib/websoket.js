
  // WebSocet
 
  (function($){
    var settings = {};
    
    var methods = {
      init : function( options ) {
        settings = $.extend({
          'uri'   : 'ws://localhost:8080',
          'conn'  : null,
          'message' : '#message',
          'display' : '#display'
        }, options);
        $(settings['message']).keypress( methods['checkEvent'] );
        $(this).chat('connect');
      },
      
      checkEvent : function ( event ) {
        if (event && event.which == 13) {
          var message = $(settings['message']).val();
          if (message && settings['conn']) {
            settings['conn'].send(message + '');
            $(this).chat('drawText',message,'right');
            $(settings['message']).val('');
          }
        }
      },
      
      connect : function () {
        if (settings['conn'] == null) {
          settings['conn'] = new WebSocket(settings['uri']);
          settings['conn'].onopen = methods['onOpen'];
          settings['conn'].onmessage = methods['onMessage'];
          settings['conn'].onclose = methods['onClose'];
          settings['conn'].onerror = methods['onError'];
        }
      },
      
      onOpen : function ( event ) {
          console.log('接続成功');
      },
      
      onMessage : function (event) {
        if (event && event.data) {
          $(this).chat('drawText',event.data,'left');
        }
      },
          
      onError : function(event) {
        console.log('エラー発生');
      },
      
      onClose : function(event) {
        console.log('サーバーと切断');
        settings['conn'] = null;
        setTimeout(methods['connect'], 1000);
      },
      
      drawText : function (message, align='left') {
        if ( align === 'left' ) {
          var inner = $('<div class="left"></div>').text(message);
        } else {
          var inner = $('<div class="right"></div>').text(message);
        }
        var box = $('<div class="box"></div>').html(inner);
        $('#chat').prepend(box);
      },
    }; // end of methods
    
    $.fn.chat = function( method ) {
      if ( methods[method] ) {
        return methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ));
      } else if ( typeof method === 'object' || ! method ) {
        return methods.init.apply( this, arguments );
      } else {
        $.error( 'Method ' +  method + ' does not exist' );
      }
    } // end of function
  })( jQuery );
   
  $(function() {
    $(this).chat({
      'uri':'ws://localhost:8080',
      'message' : '#message',
      'display' : '#chat'
    });
  });