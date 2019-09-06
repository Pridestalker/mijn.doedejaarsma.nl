<template>
    <b-table :data="detail.row.hours.data">
        <template slot-scope="props">
            <b-table-column field="id" label="ID" width="40" numeric>{{ props.row.id }}</b-table-column>
            <b-table-column field="user" label="Gebruiker">{{ props.row.user.data.name }}</b-table-column>
            <b-table-column field="hours" label="Uren" width="40" numeric>{{ props.row.hours }}</b-table-column>
            <b-table-column field="creation" label="Gemaakt op">{{ formattedDate(props.row.created_at) }}</b-table-column>
        </template>
    </b-table>
</template>

<script>
    import { format } from "date-fns";
    import { nl } from "date-fns/locale";
    export default {
        name: "HoursAdministrationDetail",
        props: {
            detail: {
                type: Object,
                default: () => ({})
            },
        },
        methods: {
            formattedDate(date) {
                return format(new Date(date), 'cccc dd MMMM yyyy', { locale: nl})
            },
        }
    }
</script>
