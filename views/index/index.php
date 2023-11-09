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

	<div class="details">
		<table id="details-s1"></table>
		<table id="details-s2"></table>
		<table id="details-s3"></table>
	</div>

	<div id="data-blueprints" class="hidden">
		<? echo json_encode($props['blueprints']); ?> 
	</div>
</div>

<script async type="module" src="<?= $this->public_dir('js/main.js'); ?>"></script>

<? require_once __DIR__ . "/../general/footer.php"; ?>