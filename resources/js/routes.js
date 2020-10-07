import Home from "./pages/Home";
import Employees from "./pages/Employees/Index.vue";
import CreateEmployee from "./pages/Employees/Create.vue";
import EditEmployee from "./pages/Employees/Edit.vue";
import Companies from "./pages/Companies/Index.vue";
import CreateCompany from "./pages/Companies/Create.vue";
import EditCompany from "./pages/Companies/Edit.vue";
import Login from "./pages/Login";

export const routes = [
    {
        path: "/",
        component: Home,
        children: [
            { path: "", component: Employees },
            { path: "employees", component: Employees },
            { path: "employees/new", component: CreateEmployee },
            { path: "employees/edit/:id", component: EditEmployee },
            { path: "companies", component: Companies },
            { path: "companies/new", component: CreateCompany },
            { path: "companies/edit/:id", component: EditCompany }
        ],
        meta: { requiresAuth: true }
    },
    { path: "/login", component: Login }
];
