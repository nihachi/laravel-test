<template>
    <div class="form-wrapper mt-5">
        <div class="container">
            <h3 class="text-center">Add Book</h3>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <form @submit.prevent="handleSubmit">
                        <div class="form-group">
                            <label>Name</label>
                            <input
                                type="text"
                                class="form-control"
                                v-model="company.name"
                            />
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input
                                type="text"
                                class="form-control"
                                v-model="company.email"
                            />
                        </div>
                        <div class="form-group">
                            <label>Company Logo</label>
                            <input type="file" name="logo" />
                        </div>
                        <button type="submit" class="btn btn-primary">
                            Add Company
                        </button>
                        <button
                            type="button"
                            class="btn btn-secondary"
                            @click="handleBack()"
                        >
                            Back
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            company: {
                name: "",
                email: "",
                logo: ""
            }
        };
    },
    mounted() {
        this.fetchCompany();
    },
    methods: {
        async fetchCompany() {
            await this.$http.get("/api/companies").then(response => {
                this.companies = response.data;
            });
        },
        async handleSubmit() {
            await this.$http
                .post("/api/companies", this.company)
                .then(response => {
                    this.$router.push("/companies");
                })
                .catch(error => console.log(error));
        },
        handleBack() {
            this.$router.push("/companies");
        },
        setSelected(value) {
            //  trigger a mutation, or dispatch an action
            this.employee.company_id = value.id;
            console.log(value);
        }
    }
};
</script>
