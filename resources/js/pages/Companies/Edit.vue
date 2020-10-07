<template>
    <div class="form-wrapper mt-5">
        <div class="container m-auto">
            <h3 class="text-center">Edit Company</h3>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <form
                        enctype="multipart/form-data"
                        @submit.prevent="updateCompany"
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
                            <label>Company Logo</label>
                            <input type="file" name="logo" />
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
                    <!-- <form
                        enctype="multipart/form-data"
                        @submit.prevent="handleTestSubmit"
                    >
                        <input type="file" @change="onFileChange" />
                        <button type="submit">submit</button>
                    </form> -->
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
            },
            errMessage: null,
            image: ""
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
            await this.$http
                .put(`/api/companies/${this.$route.params.id}`, this.company)
                .then(response => {
                    this.$router.push("/companies");
                })
                .catch(error => {
                    console.log(error);
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
            this.company.log = e.target.files[0];
        },
        handleTestSubmit() {
            const formData = new FormData();
            formData.set("image", this.image);
            axios.post("/upload", formData);
        }
    }
};
</script>
