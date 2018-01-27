new Vue({
	el: '#wrapper',
	data: {
		data: [],
		headers: [],
		reqMethods: ['GET', 'POST'],
		method: '',
		url: '',
		valueTypes: ['text', 'file'],
		dataContainsFile: false,
		rawBody: false,
		bodyType: '',
		result: '',
		sendTime: null,
		responseTime: null
	},
	created: function () {
		this.data.push(['',this.valueTypes[0],'']);
		this.headers.push('');
		this.method = this.reqMethods[0];
	},
	methods: {
		addHeader: function (i) {
			if (i == undefined || i + 1 == this.headers.length) {
				this.headers.push('');
			}
		},
		focusAddHeader: function (i) {
			if (i + 1 == this.headers.length) {
				this.headers.push('');
			}
		},
		delHeader: function (i) {
			this.headers.splice(i, 1);
			if (this.headers.length == 0) {
				this.headers.push('');
			}
		},
		addPayload: function (i) {
			if (i == undefined || i + 1 == this.data.length) {
				this.data.push(['',this.valueTypes[0],'']);
			}
		},
		delPayload: function (i) {
			this.data.splice(i, 1);
			if (this.data.length == 0) {
				this.data.push(['',this.valueTypes[0],'']);
			}
		},
		onBodyTypeChange: function () {
			var mimeJson = 'content-type: application/json';
			var idx = this.headers.findIndex(function (h) { return h.toLowerCase().indexOf('application/json') >= 0; });
			if (idx >= 0) {
				this.delHeader(idx);
			}

			if (this.bodyType == 'json') {
				if (!this.headers[this.headers.length - 1]) {
					this.headers[this.headers.length - 1] = mimeJson;
				}
				else {
					this.headers.push(mimeJson);
				}
			}

			this.rawBody = !!this.bodyType;
		},
		onResponse: function () {
			var target = $('#wrapper iframe[name=target]');
			target.height(0);

			if (this.sendTime) {
				target.height(target.contents().height());
				var targetDoc = target.contents().get(0);
				console.log(target.contents())

				var msec = new Date - this.sendTime;
				var hh = Math.floor(msec / 1000 / 60 / 60);
				msec -= hh * 1000 * 60 * 60;
				var mm = Math.floor(msec / 1000 / 60);
				msec -= mm * 1000 * 60;
				var ss = Math.floor(msec / 1000);
				msec -= ss * 1000;

				this.responseTime = hh > 0 ? hh + ' h' :
									(mm > 0 ? mm + ' m' : 
									(ss > 0 ? ss + ' s' :
									msec + ' ms'));
				this.sendTime = null;
			}
		},
		sendRequest: function () {
			this.responseTime = null;
			this.sendTime = new Date;
		}
		/*,getHistory: function (url) {
			var history = localStorage.getItem('rest-history');
			return history ?
					(url ?
						[] :
						Array.apply(null, {length: history.length})
							.map(function (x, n) {
								return localStorage.getItem( localStorage.key(n) );
							})
					) :
					[];
		}*/
	}
});