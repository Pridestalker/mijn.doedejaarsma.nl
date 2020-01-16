<template>
	<div>
		<div class="form-group"
			 v-for="(field, key) in product"
			 :key="key"
			 v-if="isCorrectKey(key) && !isValidJson(field)">

			<label :for="key">
				{{ key|translate|uppercase }}
			</label>
			<!--suppress HtmlFormInputWithoutLabel -->
			<input
				class="form-control"
				type="text"
				:value="field"
				:id="key"
				:name="key"
				readonly v-if="key !== 'attachment'">

			<section v-if="key === 'attachment' && isValidAttachment(field)">
				<a :href="'/products-standard/' + product.id + '/image'">
					Voorbeeld
				</a>
			</section>
		</div>

		<div v-else-if="canHaveOptions() && isCorrectKey(key) && isValidJson(field)">
			<div v-for="(option, key) in JSON.parse(field)" :key="key" class="form-group">
				<label :for="key">{{ key|uppercase }}</label>
				<input
					class="form-control"
					type="text"
					:value="option"
					:id="key"
					:name="key">
			</div>
		</div>

		<deadline-component />

		<div class="form-group">
			<label for="description">Omschrijving</label>
			<textarea id="description" class="form-control" name="description" />
		</div>

		<div class="form-group">
			<label for="kostenplaats">Kostenplaats</label>
			<select class="custom-select" id="kostenplaats" name="kostenplaats" aria-describedby="kostenplaatsHelp">
				<option v-for="location in locations" :key="location.id" :value="location.id">
					{{ location.name }}
				</option>
			</select>
		</div>

		<div class="form-group">
			<label for="referentie">Referentie</label>
			<input type="text" name="referentie" id="referentie" class="form-control" placeholder="Voor vermelding op factuur">
		</div>
	</div>
</template>

<script src="./form.js" />
