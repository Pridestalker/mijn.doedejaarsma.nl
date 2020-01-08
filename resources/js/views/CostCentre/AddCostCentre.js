export default {
    name: "AddCostCentre",
    props: ['team_id'],
    data() {
        return {
            cost_centre: null,
        }
    },
    methods: {
        storeCostCentre() {
            if (null === this.cost_centre) {
                return;
            }

            this.$http.post('/api/v2/cost_centres', {
                name: this.cost_centre,
                team_id: this.team_id
            }).then(res => this.clearFields())
                .catch(err => window.alert);
        },
        clearFields() {
            this.cost_centre = null;
        }
    }
}
