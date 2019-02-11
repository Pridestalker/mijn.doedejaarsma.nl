<template>
    <div class="form-group">
        <label for="attachment">Kies een voorbeeld</label>
        <input type="file" class="form-control-file" id="attachment" name="attachment" aria-describedby="fileHelper">
        <small class="form-text text-muted" id="fileHelper">Een (eerder gebruikt) bestand ter referentie. Gelieve foto's en ander materiaal te mailen als antwoord op deze product aanvraag.</small>
    </div>
</template>

<script>
    export default {
        name: "FileComponent",
    }
</script>

<style scoped>

</style>
