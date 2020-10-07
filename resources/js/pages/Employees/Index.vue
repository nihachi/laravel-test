<template>
    <div class="main-wrapper">
        <div class="container">
            <a
                href="javascript:;"
                class="btn btn-label btn-label-brand btn-sm btn-bold"
                @click.prevent="handleLogout"
                >Logout</a
            >
            <h3 class="text-center">Employees</h3>
            <br />
            <a
                href="javascript:;"
                class="btn btn-primary mb-3"
                @click.prevent="hanldeCreate()"
                >Add Employee</a
            >
            <table class="table table-bordered d-none">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Company</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="employee in employees" :key="employee.id">
                        <td>{{ employee.id }}</td>
                        <td>
                            {{ employee.first_name + " " + employee.last_name }}
                        </td>
                        <td>{{ employee.email }}</td>
                        <td>{{ employee.company_id }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <router-link
                                    :to="{
                                        path: `employees/edit/${employee.id}`,
                                        params: { id: employee.id }
                                    }"
                                    class="btn btn-primary"
                                    >Edit
                                </router-link>
                                <button
                                    class="btn btn-danger"
                                    @click="handleDelete(employee.id)"
                                >
                                    Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <vuetable
                ref="vuetable"
                :fields="fields"
                :api-mode="false"
                :data="employees"
                :per-page="10"
                @vuetable:pagination-data="onPaginationData"
                @vuetable:loading="onLoading"
                @vuetable:loaded="onLoaded"
            >
                <template slot="actions" slot-scope="props">
                    <div class="table-button-container">
                        <button
                            class="small ui button"
                            @click="editRow(props.rowData)"
                        >
                            <i class="fa fa-pencil"></i>
                        </button>
                        <button
                            class="small ui button"
                            @click="deleteRow(props.rowData)"
                        >
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                </template>
            </vuetable>
            <vuetable-pagination
                ref="pagination"
                @vuetable-pagination:change-page="onChangePage"
            ></vuetable-pagination>
        </div>
    </div>
</template>
<script>
import { logout } from "../../services/auth";
import Vuetable from "vuetable-2";
import VuetablePagination from "vuetable-2/src/components/VuetablePagination";
export default {
    name: "Employee",
    components: {
        Vuetable,
        VuetablePagination
    },
    data() {
        return {
            employees: [],
            companies: [],
            fields: [
                {
                    name: "first_name",
                    title: "First Name"
                },
                {
                    name: "last_name",
                    title: "Last Name"
                },
                {
                    name: "email",
                    title: "Email"
                },
                {
                    name: "company_id",
                    title: "Company",
                    formatter(value) {
                        // var get_company_name = companies.filter(
                        //     x => x.id === value
                        // );
                        console.log(this.companies);
                        return value;
                    }
                },
                "actions"
            ]
        };
    },
    mounted() {
        this.fetchEmployees();
        this.fetchCompany();
    },
    methods: {
        async fetchEmployees() {
            await this.$http
                .get("/api/employees")
                .then(response => {
                    this.items = response.data;
                    this.employees = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        async fetchCompany() {
            await this.$http.get("/api/companies").then(response => {
                this.companies = response.data;
                console.log(this.companies);
            });
        },
        handleDelete(id) {
            this.$http.delete(`api/employees/${id}`).then(response => {
                let i = this.employees.map(item => item.id).indexOf(id); // find index of your object
                this.employees.splice(i, 1);
            });
        },
        handleLogout() {
            logout()
                .then(response => {
                    this.$store.commit("auth/LOGOUT");
                    this.$router.push({ path: "/login" });
                })
                .catch(error => console.log(error));
        },
        hanldeCreate() {
            this.$router.push("/employees/new");
        },
        onPaginationData(paginationData) {
            this.$refs.pagination.setPaginationData(paginationData);
        },
        onChangePage(page) {
            this.$refs.vuetable.changePage(page);
        },
        editRow(rowData) {
            alert("You clicked edit on" + JSON.stringify(rowData));
        },
        deleteRow(rowData) {
            alert("You clicked delete on" + JSON.stringify(rowData));
        },
        onLoading() {
            console.log("loading... show your spinner here");
        },
        onLoaded() {
            console.log("loaded! .. hide your spinner here");
        }
    }
};
</script>
