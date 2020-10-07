<template>
    <div>
        <b-navbar toggleable="lg" type="dark" variant="info">
            <b-navbar-brand href="#">Laravel Test</b-navbar-brand>

            <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

            <b-collapse id="nav-collapse" is-nav>
                <b-navbar-nav>
                    <b-nav-item href="#" @click="routeToEmplyoees"
                        >Employees</b-nav-item
                    >
                    <b-nav-item href="#" @click="routeToCompanies"
                        >Companies</b-nav-item
                    >
                </b-navbar-nav>

                <!-- Right aligned nav items -->
                <b-navbar-nav class="ml-auto">
                    <b-nav-item-dropdown right>
                        <!-- Using 'button-content' slot -->
                        <template v-slot:button-content>
                            <em>Admin</em>
                        </template>
                        <b-dropdown-item @click="handleLogout"
                            >Sign Out</b-dropdown-item
                        >
                    </b-nav-item-dropdown>
                </b-navbar-nav>
            </b-collapse>
        </b-navbar>
    </div>
</template>
<script>
import { logout } from "../services/auth";
export default {
    name: "Header",
    methods: {
        handleLogout() {
            logout()
                .then(response => {
                    this.$store.commit("auth/LOGOUT");
                    this.$router.push({ path: "/login" });
                })
                .catch(error => console.log(error));
        },
        routeToEmplyoees() {
            this.$router.push("/employees");
        },
        routeToCompanies() {
            this.$router.push("/companies");
        }
    }
};
</script>
