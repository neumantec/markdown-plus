import Noty from 'noty'

// Noty mo.js based Animations - START

var mojsShow = function (promise) {
  var n = this
  var Timeline = new mojs.Timeline()
  var body = new mojs.Html({
	el: n.barDom,
	x: {500: 0, delay: 0, duration: 500, easing: 'elastic.out'},
	isForce3d: true,
	onComplete: function () {
	  promise(function (resolve) {
		resolve()
	  })
	}
  })

  var parent = new mojs.Shape({
	parent: n.barDom,
	width: 200,
	height: n.barDom.getBoundingClientRect().height,
	radius: 0,
	x: {[150]: -150},
	duration: 1.2 * 500,
	isShowStart: true
  })

  n.barDom.style['overflow'] = 'visible'
  parent.el.style['overflow'] = 'hidden'

  var burst = new mojs.Burst({
	parent: parent.el,
	count: 10,
	top: n.barDom.getBoundingClientRect().height + 75,
	degree: 90,
	radius: 75,
	angle: {[-90]: 40},
	children: {
	  fill: '#EBD761',
	  delay: 'stagger(500, -50)',
	  radius: 'rand(8, 25)',
	  direction: -1,
	  isSwirl: true
	}
  })

  var fadeBurst = new mojs.Burst({
	parent: parent.el,
	count: 2,
	degree: 0,
	angle: 75,
	radius: {0: 100},
	top: '90%',
	children: {
	  fill: '#EBD761',
	  pathScale: [.65, 1],
	  radius: 'rand(12, 15)',
	  direction: [-1, 1],
	  delay: .8 * 500,
	  isSwirl: true
	}
  })

  Timeline.add(body, burst, fadeBurst, parent)
  Timeline.play()
}

var mojsClose = function (promise) {
  var n = this
  new mojs.Html({
	el: n.barDom,
	x: {0: 500, delay: 10, duration: 500, easing: 'cubic.out'},
	isForce3d: true,
	onComplete: function () {
	  promise(function (resolve) {
		resolve()
	  })
	}
  }).play()
}

const options = {
	theme : 'mint',
	layout : 'topCenter',
	timeout : 2000,
	animation : {
		open: mojsShow,
		close: mojsClose
	}
}

// Noty mo.js based Animations - END

const formatText = (text) => {
	return `<div style="text-align: center;"><br/>${text}<br/>&nbsp;</div>`;	
};

const NotyPopup = {
	
	success : (text) => {
	  setTimeout( () => {
	  		//Noty.clearAll();
			var n = new Noty(options);
			n.setText(formatText(text), true);
			n.setType('success', true);
			n.show();
		}, 100);
	},
	
	warning : (text) => {
		setTimeout( () => {
			//Noty.clearAll();
			var n = new Noty(options);
			n.setText(formatText(text), true);
			n.setType('warning', true);
			n.show();
		}, 100);
	},
	
	error : (text) => {
		setTimeout( () => {
			//Noty.clearAll();
			var n = new Noty(options);
			n.setText(formatText(text), true);
			n.setType('error', true);
			n.show();
		}, 100);
	}
};

export default NotyPopup