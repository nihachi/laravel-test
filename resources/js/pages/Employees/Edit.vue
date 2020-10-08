<template>
    <div class="form-wrapper mt-5">
        <div class="container m-auto">
            <h3 class="text-center">Edit Employee</h3>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <p v-if="errors.length" class="mt-3">
                        <b>Please correct the following error(s):</b>
                        <ul>
                        <li v-for="error in errors" :key="error.id">{{ error }}</li>
                        </ul>
                    </p>
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
                                id="vselect"
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
import { notify } from "../../helpers/general";
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
            company_name: "",
            errors: [],
            notify: null
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
            this.errors = [];
            await this.$http
                .put(`/api/employees/${this.$route.params.id}`, this.employee)
                .then(response => {
                    if (response.data.status === "success") {
                        const type = "success";
                        const content = {
                            title: "Employee has been updated",
                            message: `${this.employee.first_name}'s info has been updated`
                        };
                        notify(type, content);
                        this.$router.push("/employees");
                    } else {
                        if (!this.employee.first_name) {
                            this.errors.push(response.data.errors.first_name[0]);
                        }
                        if (!this.employee.last_name) {
                            this.errors.push(response.data.errors.last_name[0]);
                        }
                        if (!this.employee.email) {
                            this.errors.push(response.data.errors.email[0]);
                        } else if (!this.validEmail(this.employee.email)) {
                            this.errors.push("Valid email required.");
                        }
                        const type = "danger";
                        const content = {
                            title: "Something went wrong",
                            message: `Update Failed.`
                        };
                        notify(type, content);
                    }
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
        },
        validEmail: function(email) {
            var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(email);
        }
    }
};
</script>
