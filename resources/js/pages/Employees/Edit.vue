<template>
    <div class="form-wrapper">
        <div class="container m-auto">
            <h3 class="text-center">Edit Employee</h3>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <form @submit.prevent="updateEmployee">
                        <div
                            v-if="errMessage"
                            class="alert alert-danger alert-dismissible"
                            role="alert"
                        >
                            <span>{{ errMessage }}</span>
                        </div>
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
                                :value="company_name"
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
                            Update Employee
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
            errMessage: null,
            companies: [],
            company_name: ""
        };
    },
    mounted() {
        this.fetchEmployee();
    },
    methods: {
        async fetchEmployee() {
            await this.$http
                .get(`/api/employees/${this.$route.params.id}`)
                .then(response => {
                    this.employee = response.data;
                    this.fetchCompany();
                });
        },
        async fetchCompany() {
            await this.$http.get("/api/companies").then(response => {
                this.companies = response.data;
                var get_company_name = response.data.filter(
                    x => x.id === this.employee.company_id
                );
                this.company_name = get_company_name[0].name;
            });
        },
        async updateEmployee() {
            await this.$http
                .put(`/api/employees/${this.$route.params.id}`, this.employee)
                .then(response => {
                    this.$router.push("/employees");
                })
                .catch(error => {
                    console.log(error);
                });
        },
        handleBack() {
            this.$router.push("/employees");
        },
        setSelected(value) {
            //  trigger a mutation, or dispatch an action
            this.employee.company_id = value.id;
            this.company_name = value.name;
        }
    }
};
</script>