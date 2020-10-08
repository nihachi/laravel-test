<template>
    <div class="main-wrapper employees-wrapper">
        <div class="container mt-5">
            <h1 class="text-left">Employees</h1>
            <br />
            <a
                href="javascript:;"
                class="btn btn-primary mb-3 float-left"
                @click.prevent="importData()"
                >Import Employee</a
            >
            <a
                href="javascript:;"
                class="btn btn-primary mb-3 float-right"
                @click.prevent="hanldeCreate()"
                >Add Employee</a
            >
            <b-table
                hover
                ref="table"
                :fields="fields"
                :items="employees"
                :current-page="currentPage"
                :per-page="perPage"
                :filter="filter"
            >
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
                :total-rows="this.employees.length"
                :per-page="perPage"
                v-model="currentPage"
            />
        </div>
    </div>
</template>
<script>
import { notify } from "../../helpers/general";
export default {
    name: "Employee",
    data() {
        return {
            employees: [],
            companies: [],
            fields: [
                { key: "id", sortable: true },
                { key: "first_name", label: "First Name" },
                { key: "last_name", label: "Last Name" },
                {
                    key: "company_id",
                    label: "Company",
                    formatter: data => {
                        const name = this.companies.filter(x => x.id === data);
                        if (!name[0]) return;
                        return name[0].name;
                    }
                },
                { key: "email", label: "Email" },
                { key: "phone", label: "Phone" },
                { key: "actions", label: "" }
            ],
            currentPage: 1,
            perPage: 10,
            filter: null
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
            });
        },
        handleEdit(row) {
            this.$router.push(`/employees/edit/${row.id}`);
        },
        handleDelete(row) {
            this.$http.delete(`api/employees/${row.id}`).then(response => {
                let i = this.employees.map(item => item.id).indexOf(row.id); // find index of your object
                this.employees.splice(i, 1);
                const type = "success";
                const content = {
                    title: "Delete Employee",
                    message: `Employee is successfully deleted.`
                };
                notify(type, content);
            });
        },
        hanldeCreate() {
            this.$router.push("/employees/new");
        },
        async importData() {
            await this.$http.post("/api/import_employee").then(response => {
                const type = "success";
                const content = {
                    title: "Import Employee",
                    message: `Employee is successfully imported.`
                };
                notify(type, content);
                if (response.data.status == "success") {
                    console.log("refresh here");
                    location.reload();
                }
            });
        }
    }
};
</script>
