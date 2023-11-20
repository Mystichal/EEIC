import baseBluprint from './blueprint.js'

const main = () => {
	let state = {
		blueprints: {},
		totOre: {},
		totPi: {},
		mat: 0,
		time: 0
	}

	let matRates = {
		0: 0,
		1: 6,
		2: 12,
		3: 18,
		4: 24,
		5: 30,
		6: 34,
		7: 38,
		8: 42,
		9: 46,
		10: 50,
		11: 51,
		12: 52,
		13: 53,
		14: 54,
		15: 55
	}

	const data = JSON.parse(document.getElementById('data-blueprints').innerHTML)

	const typeSelect = document.getElementById('type')
	const subtypeSelect = document.getElementById('sub-type')
	const nameSelect = document.getElementById('name')

	const alertMessage = document.getElementById('alert-message')
	const addButton = document.getElementById('add')
	const numberOfInput = document.getElementById('numberOf')
	const basicSkill = document.getElementById('basic-skill')
	const advancedSkill = document.getElementById('advanced-skill')
	const expertSkill = document.getElementById('expert-skill')

	const oreTable = document.getElementById('details-s1')
	const pioTable = document.getElementById('details-s2')
	const pidTable = document.getElementById('details-s3')

	let scrollEnabled = false;

	let oreRequirements = baseBluprint['ore requirements']
	let piRequirements = baseBluprint['pi requirements']

	for (let [key, value] of Object.entries(oreRequirements)) {
		let oreRow = oreTable.insertRow()
		createCell(oreRow, capitalize(key), [])
		createCell(oreRow, value, ['int', 'ore'])
	}

	let lastRow = oreTable.insertRow()
	createCell(lastRow, 'Manufacturing Cost', [])
	createCell(lastRow, '0 ISK', ['int', 'ore', 'isk'])

	for (let [key, value] of Object.entries(piRequirements).slice(0, Math.ceil(Object.keys(piRequirements).length / 2))) {
		let piRow = pioTable.insertRow()
		createCell(piRow, capitalize(key), [])
		createCell(piRow, value, ['int', 'pio'])
	}

	for (let [key, value] of Object.entries(piRequirements).slice(Math.ceil(Object.keys(piRequirements).length / 2))) {
		let piRow = pidTable.insertRow()
		createCell(piRow, capitalize(key), [])
		createCell(piRow, value, ['int', 'pit'])
	}

	// define events handler functions
	let handleTypeChange = (e) => {
		subtypeSelect.selectedIndex = 0
		nameSelect.selectedIndex = 0

		const nameOptions = nameSelect.querySelectorAll('option')
		const subtypeOption = subtypeSelect.querySelectorAll('option')

		nameOptions.forEach((option) => {
			option.style.display = 'none'
		})

		subtypeOption.forEach((option) => {
			option.style.display = 'none'
		})

		const targetType = e.target.value.replace(/\s+/g, '-')
		const filterdSubtypeOptions = subtypeSelect.querySelectorAll(`[data-type-${targetType}]`)

		filterdSubtypeOptions.forEach((option) => {
			option.style.display = 'block'
		})
	}

	let handleSubtypeChange = (e) => {
		nameSelect.selectedIndex = 0

		const nameOptions = nameSelect.querySelectorAll('option')
		nameOptions.forEach((option) => {
			option.style.display = 'none'
		})

		const targetType = e.target.value.replace(/\s+/g, '-')
		const filterdNameOptions = nameSelect.querySelectorAll(`[data-type-${targetType}]`)

		filterdNameOptions.forEach((option) => {
			option.style.display = 'block'
		})
	}

	let handleAddClick = (e) => {
		e.preventDefault()

		let bars = document.querySelectorAll('.skill-bar')
		let count = 0
		bars.forEach((bar) => {
			if (bar.style.backgroundColor == 'rgb(24, 61, 61)') {
				count++
			}
		})
		let timeRate = count * 5

		const run = parseInt(numberOf.value)
		const selectedName = nameSelect.options[nameSelect.selectedIndex].text

		if (selectedName === '') {
			alertMessage.innerHTML = 'pick blueprint by selecting values, retard'
			fadeIn(alertMessage.parentElement.parentElement, 100)
			setTimeout(() => {
				fadeOut(alertMessage.parentElement.parentElement, 100)
			}, 2000)
		} else {
			handleSelectedBlueprint(run, selectedName, matRates[count], timeRate)
			updateMaterialStats()
			updateUIElements()
		}
	}

	let handleSkillBarClick = (e) => {
		const x = e.pageX - e.currentTarget.offsetLeft;
		const math = x / e.currentTarget.offsetWidth;

		const skillBars = e.currentTarget.querySelectorAll('.skill-bar');
		const barWidth = skillBars[0].offsetWidth;
		const barMargin = parseInt(window.getComputedStyle(skillBars[0]).marginRight, 10);

		if (math < 0.1) {
			for (let i = 0; i < skillBars.length; i++) {
				skillBars[i].style.backgroundColor = '#040D12'
		    }
		} else {
			for (let i = 0; i < skillBars.length; i++) {
				const barPosition = (barWidth + barMargin) * i / basicSkill.offsetWidth;
				if (math < barPosition + (barWidth / basicSkill.offsetWidth)) {
					for (let j = 0; j <= i; j++) {
						skillBars[j].style.backgroundColor = '#183D3D'
					}
					for (let k = i + 1; k < skillBars.length; k++) {
						skillBars[k].style.backgroundColor = '#040D12'
					}
					break;
				}
			}
		}
	}

	typeSelect.addEventListener('change', handleTypeChange)
	subtypeSelect.addEventListener('change', handleSubtypeChange)
	addButton.addEventListener('click', handleAddClick)
	numberOfInput.addEventListener('wheel', preventScroll)
	basicSkill.addEventListener('click', handleSkillBarClick)
	advancedSkill.addEventListener('click', handleSkillBarClick)
	expertSkill.addEventListener('click', handleSkillBarClick)

	// misc functions
	let handleSelectedBlueprint = (run, selectedName, matRate, timeRate) => {
		const target = nameSelect.options[nameSelect.selectedIndex].text
		const cartRow = document.createElement('div')
		const cartLogo = document.createElement('img')
		const cartInfo = document.createElement('div')
		const tempInfo = data[target]['name']

		state.mat = baseBluprint['material efficiency'] - matRate
		state.time = baseBluprint['time efficiency'] - timeRate
		const matPro = state.mat / 100

		if (!state.blueprints[target]) {
			let merge = mergeObjects(baseBluprint, data[target])
			state.blueprints[target] = {...merge}
			state.blueprints[target].runs = run

			state.blueprints[target]['manufacturing time'] = multiplyTime(data[target]['manufacturing time'], run)

			const infoText = `${state.blueprints[target].runs}x [${tempInfo}]</br>${state.blueprints[target]['manufacturing time']}`
			cartInfo.id = 'cart-' + target
			cartInfo.classList.add('cart-info')
			cartInfo.innerHTML = `${infoText}`

			cartRow.classList.add('cart-row')
			cartLogo.classList.add('cart-logo')
			cartLogo.src = `http://localhost/public/images/blueprint/${target}.png`

			cartRow.appendChild(cartLogo)
			cartRow.appendChild(cartInfo)
			cart.appendChild(cartRow)
		} else {
			const newInfo = document.getElementById(`cart-${target}`)

			state.blueprints[target]['manufacturing time'] = addTimes(
				state.blueprints[target]['manufacturing time'],
				multiplyTime(data[target]['manufacturing time'], run)
			)

			state.blueprints[target]['runs'] += run

			const newInfoText = `${state.blueprints[target].runs}x [${tempInfo}]</br>${state.blueprints[target]['manufacturing time']}`
			newInfo.innerHTML = newInfoText
		}
	}

	let updateMaterialStats = () => {
		for (let key in state.blueprints) {
			if (state.blueprints.hasOwnProperty(key)) {
				const ores = state.blueprints[key]['ore requirements']
				ores['manufacturing cost'] = state.blueprints[key]['manufacturing cost']
				const pis = state.blueprints[key]['pi requirements']

				updateStateValues(ores, state.totOre)
				updateStateValues(pis, state.totPi)
			}
		}
	}

	let updateStateValues = (values, stateValues) => {
		for (let [key, value] of Object.entries(values)) {
			if (!stateValues[key]) {
				stateValues[key] = value * parseInt(numberOfInput.value)
			} else {
				stateValues[key] += value * parseInt(numberOfInput.value)
			}
		}
	}

	let updateUIElements = () => {
		updateUI('ore', state.totOre);
		updateUI('pio', state.totPi);
		updateUI('pit', state.totPi);
	}

	let updateUI = (className, stateValues) => {
		const elements = document.querySelectorAll('.' + className)
		elements.forEach((element) => {
			const target = element.parentElement.firstChild.innerHTML.toLowerCase()
			const numberToDisplay = stateValues[target] / 150

			if (!element.classList.contains('isk')) {
				element.innerHTML = new Intl.NumberFormat().format(numberToDisplay * state.mat)
			} else {
				element.innerHTML = new Intl.NumberFormat().format(stateValues[target]) + ' ISK'
			}
		})
	}
}

main()

export default main