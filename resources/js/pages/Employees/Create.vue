<template>
    <div class="form-wrapper">
        <div class="container">
            <h3 class="text-center">Add Book</h3>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <form @submit.prevent="handleSubmit">
                        <div class="form-group">
                            <label>First Name</label>
                            <input
                                type="text"
                                class="form-control"
                                v-model="employee.first_name"
                            />
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <input
                                type="text"
                                class="form-control"
                                v-model="employee.last_name"
                            />
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input
                                type="text"
                                class="form-control"
                                v-model="employee.email"
                            />
                        </div>
                        <div class="form-group">
                            <label>Company</label>
                            <v-select
                                label="name"
                                :options="companies"
                                @input="setSelected"
                            ></v-select>
                        </div>
                        <div class="form-group">
                            <label>Phone</label>
                            <input
                                type="text"
                                class="form-control"
                                v-model="employee.phone"
                            />
                        </div>
                        <button type="submit" class="btn btn-primary">
                            Add Employee
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
            employee: {
                first_name: "",
                last_name: "",
                email: "",
                company_id: null,
                phone: ""
            },
            companies: []
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
                .post("/api/employees", this.employee)
                .then(response => {
                    this.$router.push("/employees");
                })
                .catch(error => console.log(error));
        },
        handleBack() {
            this.$router.push("/employees");
        },
        setSelected(value) {
            //  trigger a mutation, or dispatch an action
            this.employee.company_id = value.id;
            console.log(value);
        }
    }
};
</script>
