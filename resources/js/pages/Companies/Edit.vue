<template>
    <div class="form-wrapper mt-5">
        <div class="container m-auto">
            <h3 class="text-center">Edit Company</h3>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <p v-if="errors.length" class="mt-3">
                        <b>Please correct the following error(s):</b>
                        <ul>
                        <li v-for="error in errors" :key="error.id">{{ error }}</li>
                        </ul>
                    </p>
                    <form
                        id="update_company_form"
                        enctype="multipart/form-data"
                        @submit.prevent="updateCompany"
                        novalidate="novalidate"
                    >
                        <div
                            v-if="errMessage"
                            class="alert alert-danger alert-dismissible"
                            role="alert"
                        >
                            <span>{{ errMessage }}</span>
                        </div>
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
                            <input
                                id="customFile"
                                type="file"
                                name="photo"
                                @change="onFileChange"
                            />
                            <label for="customFile">{{
                                this.company.logo
                            }}</label>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            Update Company
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
import _ from "lodash";
import { validateForm, notify } from "../../helpers/general";
export default {
    data() {
        return {
            company: {
                name: "",
                email: "",
                logo: ""
            },
            errMessage: null,
            photo: "",
            errors: [],
            notify: null
        };
    },
    mounted() {
        this.fetchCompany();
    },
    methods: {
        async fetchCompany() {
            await this.$http
                .get(`/api/companies/${this.$route.params.id}`)
                .then(response => {
                    console.log(response);
                    this.company = response.data;
                });
        },
        async updateCompany() {
            this.errors = [];
            const data = this.gatherFormData();
            await this.$http
                .post(`/api/companies/${this.$route.params.id}`, data)
                .then(response => {
                    if (response.data.status === "success") {
                        const type = "success";
                        const content = {
                            title: "Company has been updated",
                            message: `${this.company.name}'s info has been updated`
                        };
                        notify(type, content);
                        this.$router.push("/companies");
                    } else {
                        if (!this.company.name) {
                            this.errors.push(response.data.errors.name[0]);
                        }
                        if (!this.company.email) {
                            this.errors.push(response.data.errors.email[0]);
                        } else if (!this.validEmail(this.company.email)) {
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
                    const type = "danger";
                    const content = {
                        title: "Something went wrong",
                        message: `Update Failed.`
                    };
                    notify(type, content);
                });
        },
        handleBack() {
            this.$router.push("/companies");
        },
        setSelected(value) {
            //  trigger a mutation, or dispatch an action
            this.employee.company_id = value.id;
            this.company_name = value.name;
        },
        onFileChange(e) {
            console.log(e.target.files[0]);
            this.photo = e.target.files[0];
        },
        gatherFormData() {
            const formData = new FormData();
            formData.append("photo", this.photo);

            _.each(this.company, (value, key) => {
                formData.set(key, value);
            });
            formData.append("_method", "PUT");
            return formData;
        },
        validEmail: function(email) {
            var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(email);
        }
    }
};
</script>
