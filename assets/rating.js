/*
 * rating.js
 * by Keith Gaughan
 *
 * Item rating using JavaScript remoting.
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

var ratingReset = Events.forTarget(function(t) {
	ratingShow(t.form, t.form.currently.value);
	return false;
});

var ratingSelect = Events.forTarget(function(t) {
	ratingShow(t.form, t.value);
	return false;
});

var rate = Events.forTarget(function(t) {
	var setSpinner = function(img) {
		var spinner = t.form.getElementsByTagName('img')[0];
		if (spinner) {
			spinner.src = img;
		}
	};

	Remoting.submit(t.form, { rating: t.value, callback: 1 }, function(s, txt) {
		switch (s) {
			case 200:
				t.form.currently.value = txt;
				ratingShow(t.form, txt);
				setSpinner('tick.png');
				break;
			case 403:
				setSpinner('tick.png');
				alert(txt);
				break;
		}
		return false;
	}, function(completed) {
		if (completed) {
			setSpinner('dot.png');
		} else {
			setSpinner('spinner.gif');
		}
	});
	return false;
});

function ratingShow(frm, n) {
	for (var e = frm.firstChild; e; e = e.nextSibling) {
		if (e.tagName == 'INPUT' && e.type == 'image' && e.name == 'rating') {
			if (parseInt(e.value) <= n) {
				e.src = 'star-on.png';
			} else {
				e.src = 'star-off.png';
			}
		}
	}
}
