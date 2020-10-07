<template>
    <div class="main-wrapper companies-wrapper">
        <div class="container mt-5">
            <h1 class="text-left">Companies</h1>
            <br />
            <a
                href="javascript:;"
                class="btn btn-primary mb-3 float-right"
                @click.prevent="hanldeCreate()"
                >Add Company</a
            >
            <b-table
                hover
                :fields="fields"
                :items="companies"
                :current-page="currentPage"
                :per-page="perPage"
                :filter="filter"
            >
                <template v-slot:cell(logo)="data">
                    <img v-if="data.value" :src="data.value" height="70" />
                    <img
                        v-else
                        src="https://via.placeholder.com/70"
                        height="70"
                    />
                </template>
                <template v-slot:cell(actions)="{ item }">
                    <b-btn @click="handleEdit(item)">
                        Edit
                    </b-btn>
                    <b-btn @click="handleDelete(item)">
                        Delete
                    </b-btn>
                </template>
            </b-table>
            <b-pagination
                size="md"
                :total-rows="this.companies.length"
                :per-page="perPage"
                v-model="currentPage"
            />
        </div>
    </div>
</template>
<script>
export default {
    name: "Employee",
    data() {
        return {
            companies: [],
            companies: [],
            fields: [
                { key: "id", sortable: true },
                { key: "logo", label: "Logo" },
                { key: "name", label: "Name" },
                { key: "email", label: "Email" },
                { key: "actions", label: "" }
            ],
            currentPage: 1,
            perPage: 10,
            filter: null
        };
    },
    mounted() {
        this.fetchCompanies();
    },
    methods: {
        async fetchCompanies() {
            await this.$http
                .get("/api/companies")
                .then(response => {
                    this.companies = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        handleEdit(row) {
            this.$router.push(`/companies/edit/${row.id}`);
        },
        handleDelete(row) {
            this.$http.delete(`api/companies/${row.id}`).then(response => {
                let i = this.companies.map(item => item.id).indexOf(row.id); // find index of your object
                this.companies.splice(i, 1);
            });
        },
        hanldeCreate() {
            this.$router.push("/companies/new");
        }
    }
};
</script>
