/*
 * remoting.js
 * by Keith Gaughan
 *
 * Very simple, almost simplistic remoting using XHR. While fine for doing
 * POSTs on even highly trafficked sites, it needs work before it's suitable
 * for use to do GETs, POSTs, and PUTs on such sites.
 *
 * Copyright (c) Keith Gaughan, 2007.
 * All Rights Reserved.
 *
 * Permission is given to use, modify and distribute modified and unmodified
 * versions of this software on condition that all copyright notices are
 * retained and a record of changes made to this is software is kept and
 * distributed with any modified version. No warranty, implied or otherwise,
 * is given on this software as to its fitness for any purpose. The author is
 * not liable for any damage, loss of data, or other misfortune caused as a
 * result of the use/misuse of this software.
 */

function $(id) {
	return document.getElementById(id);
}

var Utils = {
	tryEachOf: function() {
		for (var i = 0; i < arguments.length; i++) {
			try { return arguments[i](); } catch (e) { }
		}
		return null;
	},
	mergeInto: function(dest, src) {
		for (var k in src) {
			dest[k] = src[k];
		}
	}
};

var Elements = {
	moveTo: function(id, x, y) {
		var e = $(id);
		if (e) {
			e.style.left = Elements.tX(x) + 'px';
			e.style.top  = Elements.tY(y) + 'px';
			e.style.display = "";
		}
	},
	hide: function(id) {
		var e = $(id);
		if (e) {
			e.style.display = "none";
		}
	}
};

if (document.documentElement) {
	Utils.mergeInto(Elements, {
		tX: function(x) {
			return x + document.documentElement.scrollLeft + document.body.scrollLeft;
		},
		tY: function(y) {
			return y + document.documentElement.scrollTop + document.body.scrollTop;
		}
	});
} else {
	Utils.mergeInto(Elements, {
		tY: function(x) {
			return x + window.scrollX;
		},
		tY: function(y) {
			return y + window.scrollY;
		}
	});
}

var Events = {};

if (document.all) {
	// Thank you, IE, for sucking rocks.
	Events.forTarget = function(callback) {
		return function() {
			var t = window.event.srcElement;
			if ('undefined' != typeof t.form) {
				return callback(t);
			}
			return false;
		}
	};
} else {
	Events.forTarget = function(callback) {
		return function(e) {
			var t = e.target;
			if (t.form) {
				return callback(t);
			}
			return false;
		}
	};
}

var Remoting = {
	transport: Utils.tryEachOf(
		function() { return new XMLHttpRequest() },
		function() { return new ActiveXObject('Msxml2.XMLHTTP') },
		function() { return new ActiveXObject('Microsoft.XMLHTTP') })
};

Remoting.cleanup = function() {
	Remoting.transport.onreadystatechange = null;
	Remoting.transport = null;
};

Remoting.queue = (function() {
	var queued = [];
	var free = true;

	Remoting.transport.onreadystatechange = function() {
		var t = Remoting.transport;
		if (t.readyState == 2 && queued[0].spinner) {
			queued[0].spinner(false);
		} else if (t.readyState == 4) {
			var r   = queued.shift();
			var s   = t.status;
			var txt = t.responseText;
			if (r.spinner) {
				r.spinner(true);
			}
			if (r.callback) {
				r.callback(s, txt);
			}
			sendQueued();
		}
	};

	var sendQueued = function() {
		if (queued.length > 0) {
			free = false;
			var r = queued[0];
			var t = Remoting.transport;
			t.open(r.method, r.endpoint, r.async);
			t.setRequestHeader("Content-Type", r.contentType);
			t.send(r.content);
		} else {
			free = true;
		}
	};

	return function(method, endpoint, content, contentType, async, callback, spinner) {
		queued[queued.length] = {
			method: method,
			endpoint: endpoint,
			content: content,
			contentType: contentType,
			async: async,
			callback: callback,
			spinner: spinner
		};
		if (free) {
			sendQueued();
		}
	};
})();

Remoting.submit = function(frm, toMerge, callback, spinner) {
	var vars = [];
	var enc = encodeURIComponent ? encodeURIComponent : escape;
	for (var i = 0; i < frm.elements.length; i++) {
		var e = frm.elements[i];
		if (e.tagName == 'INPUT') {
			vars[vars.length] = enc(e.name) + '=' + enc(e.value);
		}
	}
	for (var name in toMerge) {
		vars[vars.length] = enc(name) + '=' + enc(toMerge[name]);
	}
	Remoting.queue(
		frm.method, frm.action, vars.join('&'),
		'application/x-www-form-urlencoded; charset=UTF-8',
		true, callback, spinner);
};

/**
 * Attaches a remoting event handler to any forms with a given class.
 */
Remoting.autoremote = function(cls, callback) {
	var forms = document.getElementsByTagName('form');
	for (var i = 0; i < forms.length; i++) {
		Events.attach(forms[i], 'submit', callback);
	}
};
