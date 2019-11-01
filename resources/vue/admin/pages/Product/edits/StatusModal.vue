<template>
    <form action="" @submit.prevent>
        <div class="modal-card">
            <header class="modal-card-head">
                Status aanpassen
            </header>
            
            <section class="modal-card-body">
                <b-field label="Nieuwe status">
                    <b-select placeholder="Nieuwe status selecteren" required>
                        <option value="aangevraagd">Aangevraagd</option>
                        <option value="opgepakt">Opgepakt</option>
                        <option value="afgerond">Afgerond</option>
                    </b-select>
                </b-field>
            </section>
            <footer class="modal-card-foot">
                <button class="button" type="button" @click="$parent.close()">Close</button>
                <b-button icon-left="done" class="button is-primary">Update</b-button>
            </footer>
        </div>
    </form>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';
    import { productModule, ProductModule } from '../../../../store/product.module'
    import { UserModule } from '../../../../constants/user.model'
    import { userModule } from '../../../../store/user.module'
    
    @Component
    export default class HoursModal extends Vue {
        productModule: ProductModule = productModule;
        userModule: UserModule = userModule;
        
        oldStatus: string|null = null;
        newStatus: string|null = null;
        notify: { team: boolean, owner: boolean, designers: boolean, } = {
            team: false, owner: false, designers: false
        };
        
        
    }
</script>
