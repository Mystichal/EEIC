<?php $title = "EEIC" ?>

<?php require_once __DIR__ . "/../general/header.php"; ?>

<?php require_once __DIR__ . "/../general/navbar.php"; ?>

<?php require_once __DIR__ . "/../general/alert.php"; ?>

<link rel="stylesheet" href="<?= $this->public_dir('css/bpSelector.css') ?>">

<div class="container">
	<div class="card-wrapper">
		<form class="bp-selector">
			<? if ($props['types']): ?>
				<field class="bp-selector-item">
					<label for="type">Type</label>
					<select id="type" class="fl-r">
						<option style="display:none"></option>
						<? foreach ($props['types'] as $key => $value): ?>
						<option><? echo $value ?></option>
						<? endforeach; ?>
					</select>
				</field>
			<? else: ?>
				<field class="bp-selector-item">
					<label for="type">Type</label>
					<p>could not load types</p>
				</field>
			<? endif ?>

			<? if ($props['sub-types']): ?>
				<field class="bp-selector-item">
					<label for="sub-type">Sub-type</label>
					<select id="sub-type" class="fl-r">
						<option style="display:none"></option>
						<? foreach ($props['sub-types'] as $subkey => $sub): ?>
							<? foreach ($sub as $key => $val): ?>
								<option data-type-<? echo str_replace(' ', '-', $subkey); ?> style="display: none;"><? echo $val; ?></option>
							<? endforeach; ?>
						<? endforeach; ?>
					</select>
				</field>
			<? else: ?>
				<field class="bp-selector-item">
					<label for="type">Type:</label>
					<p>could not load types</p>
				</field>
			<? endif ?>

			<? if ($props['names']): ?>
				<field class="bp-selector-item">
					<label for="name">Name</label>
					<select id="name" class="fl-r">
						<option style="display:none"></option>
						<? foreach ($props['names'] as $subkey => $sub): ?>
							<? foreach ($sub as $typekey => $type): ?>
								<? foreach ($type as $key => $name): ?>
									<option data-type-<? echo str_replace(' ', '-', $typekey); ?> style="display: none;">
										<? echo $name; ?>
									</option>
								<? endforeach; ?>
							<? endforeach; ?>
						<? endforeach; ?>
					</select>
				</field>
			<? else: ?>
				<field class="bp-selector-item">
					<label for="type">Type:</label>
					<p>could not load types</p>
				</field>
			<? endif ?>
			
			<field>
				<div class="add-wrapper">
					<label for="numberOf">n</label>
					<input id="numberOf" type="text" class="int" value="1" onmouseover="enableScroll()" onmouseout="disableScroll()" />
					<button id="add" class="fl-r">ADD</button>
				</div>
				<p style="font-size: .6rem; text-align: center;">**dont forget that you use scroll wheel to increase runs**</p>
			</field>

			<field>
				<div class="skill-bar-wrapper">
					<span for="basic-skill" style="font-size: .6rem;">Basic</span>
					<div id="basic-skill" class="skill-bars">
						<div class="skill-bar"></div>
						<div class="skill-bar"></div>
						<div class="skill-bar"></div>
						<div class="skill-bar"></div>
						<div class="skill-bar"></div>
					</div>
				</div>
			</field>
			<field>
				<div class="skill-bar-wrapper">
					<span for="advanced-skill" style="font-size: .6rem;">Advanced</span>
					<div id="advanced-skill" class="skill-bars">
						<div class="skill-bar"></div>
						<div class="skill-bar"></div>
						<div class="skill-bar"></div>
						<div class="skill-bar"></div>
						<div class="skill-bar"></div>
					</div>
				</div>
			</field>
			<field>
				<div class="skill-bar-wrapper">
					<span for="expert-skill" style="font-size: .6rem;">Expert</span>
					<div id="expert-skill" class="skill-bars">
						<div class="skill-bar"></div>
						<div class="skill-bar"></div>
						<div class="skill-bar"></div>
						<div class="skill-bar"></div>
						<div class="skill-bar"></div>
					</div>
				</div>
			</field>
		</form>
	</div>
	
	<div class="cart-wrapper">
		<div id="cart">
			
		</div>
	</div>
	
	<? $oreRequirements = $props['blueprints']['griffin']['ore requirements']; ?>
	<? $piRequirements = $props['blueprints']['griffin']['pi requirements']; ?>

	<div class="details">
		<table id="details-s1">
			<? foreach ($oreRequirements as $name => $value): ?>
				<? echo '<tr><td>' . ucwords($name) . '</td><td class="int ore">0</td></tr>'; ?>
			<? endforeach; ?>
			<? echo '<tr><td>Manufacturing cost</td><td class="int ore isk">0 ISK</td></tr>'; ?>
			<? echo '<tr></tr>'; ?>
		</table>
		<table id="details-s2">
			<? $i = 0; ?> 
			<? foreach ($piRequirements as $name => $value): ?>
				<? echo '<tr><td>' . ucwords($name) . '</td><td class="int pio">0</td></tr>'; ?>
				<? if ($i === 14): ?>
					<? break; ?>
				<? endif ?>
				<? $i++; ?>
			<? endforeach; ?>
		</table>
		<table id="details-s3">
			<? $i = 0; ?> 
			<? foreach ($piRequirements as $name => $value): ?>
				<? if ($i > 14): ?>
					<? echo '<tr><td>' . ucwords($name) . '</td><td class="int pit">0</td></tr>'; ?>
				<? endif ?>
				<? $i++; ?>
			<? endforeach; ?>	
		</table>
	</div>

	<div id="data-blueprints" class="hidden">
		<? echo json_encode($props['blueprints']); ?> 
	</div>
</div>

<script async type="module" src="<?= $this->public_dir('js/main.js'); ?>"></script>

<? require_once __DIR__ . "/../general/footer.php"; ?>