function fadeIn(elem, ms) {
	if (!elem) return

	elem.style.opacity = 0
	elem.style.filter = 'alpha(opacity=0)'
	elem.style.display = 'inline-block'
	elem.style.visibility = 'visible'

	if (ms) {
		let opacity = 0
		let timer = setInterval(() => {
			opacity += 50 / ms

			if (opacity >= 1) {
				clearInterval(timer)
				opacity = 1
			}
	
			elem.style.opacity = opacity
			elem.style.filter = 'alpha(opacity=' + opacity * 100 + ')'
		}, 50);
	} else {
		elem.style.opacity = 1
		elem.style.filter = 'alpha(opacity=1)'
	}
}

function fadeOut(elem, ms) {
	if (!elem) return;

	if (ms) {
		let opacity = 1
		let timer = setInterval(() => {
			opacity -= 50 / ms

			if (opacity <= 0) {
				clearInterval(timer)
				opacity = 0;
				elem.style.display = 'none'
				elem.style.visibility = 'hidden'
			}

			elem.style.opacity = opacity
			elem.style.filter = 'alpha(opacity=' + opacity * 100 + ')'
		}, 50 );
	} else {
		elem.style.opacity = 0
		elem.style.filter = 'alpha(opacity=0)'
		elem.style.display = 'none'
		elem.style.visibility = 'hidden'
	}
}

function enableScroll() {
	scrollEnabled = true;
	document.addEventListener('wheel', increaseValue)
}

function disableScroll() {
	scrollEnabled = false;
	document.removeEventListener('wheel', increaseValue)
}

function increaseValue(e) {
	if (scrollEnabled) {
		let currentValue = parseInt(numberOf.value) || 0
		let delta = Math.max(-1, Math.min(1, (event.wheelDelta || -event.detail)))
		if (currentValue + delta > 0) {
			numberOf.value = currentValue + delta
		}
	}
}

function preventScroll(e) {
	e.preventDefault()
	return false
}

function addTimes(startTime, endTime) {
	let times = [0, 0, 0]
	let max = times.length

	let a = (startTime || '').split(':')
	let b = (endTime || '').split(':')

	// normalize time values
	for (let i = 0; i < max; i++) {
		a[i] = isNaN(parseInt(a[i])) ? 0 : parseInt(a[i])
		b[i] = isNaN(parseInt(b[i])) ? 0 : parseInt(b[i])
	}

	// store time values
	for (let i = 0; i < max; i++) {
		times[i] = a[i] + b[i]
	}

	let hours = times[0]
	let minutes = times[1]
	let seconds = times[2]

	if (seconds >= 60) {
		let m = (seconds / 60) << 0
		minutes += m
		seconds -= 60 * m
	}

	if (minutes >= 60) {
		let h = (minutes / 60) << 0
		hours += h
		minutes -= 60 * h
	}

	return (
		Number('0' + hours) +
		':' +
		('0' + minutes).slice(-2) +
		':' +
		('0' + seconds).slice(-2)
	)
}

const multiplyTime = (time, factor) => {
	let [hours, minutes, seconds] = time.split(':').map(part => parseInt(part) || 0)
	let totalSeconds = hours * 3600 + minutes * 60 + seconds
	totalSeconds *= factor

	let resultHours = Math.floor(totalSeconds / 3600) % 24
	totalSeconds %= 3600

	let resultMinutes = Math.floor(totalSeconds / 60)
	let resultSeconds = totalSeconds % 60
	
	return `${resultHours.toString().padStart(2, '0')}:${resultMinutes.toString().padStart(2, '0')}:${resultSeconds.toString().padStart(2, '0')}`
}

function mergeObjects(obj1, obj2) {
	const merged = { ...obj1 }

	for (let key in obj2) {
		if (obj2.hasOwnProperty(key)) {
			if (obj2[key] && typeof obj2[key] === 'object' && !Array.isArray(obj2[key])) {
				if (!obj1[key]) {
					merged[key] = obj2[key]
				} else {
					merged[key] = mergeObjects(obj1[key], obj2[key])
				}
			} else {
				merged[key] = obj2[key]
			}
		}
	}

	return merged;
}

const capitalize = (str, lower = false) =>
	(lower ? str.toLowerCase() : str).replace(/(?:^|\s|["'([{])+\S/g, match => match.toUpperCase())

const addClass = (element, ...classNames) => {
	element.classList.add(...classNames)
}

const createCell = (row, content, classNames = []) => {
	const cell = row.insertCell()
	cell.innerHTML = content
	addClass(cell, ...classNames)
}