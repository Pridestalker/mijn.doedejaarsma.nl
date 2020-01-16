<template>
	<div class="form-group">
		<label for="template_id">Kies een voorbeeld product</label>
		<select name="template_id" id="template_id" class="custom-select" v-model="selected">
			<option placeholder disabled selected :value="null">Kies een standaard</option>
			<option v-for="product in products" :key="product.id" :value="product.id">
				{{ product.name }}
			</option>
		</select>
	</div>
</template>

<script src="./ProductSelector.js" />
