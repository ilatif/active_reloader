var ActiveReloader = {
	last_reload_time: 0,
	start: function(options) {
		this._prepare_options(options);
		this._start();
	},
	_prepare_options: function(options) {
		this.options = options;
		if (!this.options.delay) {
			this.options.delay = 1000;
		}
	},
	_start: function() {
		var self = this;
		setTimeout(function() {
			self._check_for_reloading();
		}, self.options.delay);
	},
	_check_for_reloading: function() {
		var self = this;
		$.get(self.options.path, self.options, function(response) {
			if (response.reloading_status == 1) {
				window.location.reload();
			} else {
				self.options.last_reload_time = response.last_reload_time;
			}
			self._start();
		});
	}
}
