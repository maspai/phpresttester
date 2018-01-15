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
		result: ''
	},
	created: function () {
		var v = this;
		v.data.push(['',this.valueTypes[0],'']);
		v.headers.push('');
		v.method = v.reqMethods[0];
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
		adjustTargetHeight: function () {
			var target = $('#wrapper iframe[name=target]');
			target.height(target.contents().height());
		}
	}
});