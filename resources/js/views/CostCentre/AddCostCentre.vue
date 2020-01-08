<template>
    <form @submit.prevent="storeCostCentre">
        <div class="form-group">
            <label for="kostenplaats">Kostenplaats</label>
            <input type="text" id="kostenplaats" name="kostenplaats" v-model="cost_centre" class="form-control" />
        </div>
        <input type="submit" value="Toevoegen" class="btn btn-primary" />
    </form>
</template>

<script src="./AddCostCentre.js" />
