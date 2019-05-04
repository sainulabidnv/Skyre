( function( $ ) {
	/**
 	 * @param $scope The Widget wrapper element as a jQuery element
	 * @param $ The jQuery alias
	 */ 
	var IcoStatusHandler = function( $scope, $ ) {
		// Count Down
		
		
		var $count_token = $('.countdown .row');
			if ($count_token.length > 0 ) {
				$count_token.each(function() {
					var $self = $(this), datetime = $self.attr("data-date");
					$self.countdown(datetime).on('update.countdown', function(event) {
						$(this).html(event.strftime('' + '<div class="col-3"> <div class="sk-time">%D <span>Days</span> </div> </div>  <div class="col-3"> <div class="sk-time">%H <span>Hours</span> </div> </div> <div class="col-3"> <div class="sk-time">%M <span>Minuts</span> </div> </div>  <div class="col-3"> <div class="sk-time">%S <span>Seconds</span> </div> </div>'));
					});
				});
				
			}
	};
	
	// Make sure you run this code under Elementor.
	$( window ).on( 'elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/sk-status.default', IcoStatusHandler );
	} );
} )( jQuery );
