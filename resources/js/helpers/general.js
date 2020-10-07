export function initialize(store, router) {
    router.beforeEach((to, from, next) => {
        const requiresAuth = to.matched.some(
            record => record.meta.requiresAuth
        );
        const currentUser = store.state.auth.currentUser;

        if (requiresAuth && !currentUser) {
            next("/login");
        } else if (to.path === "/login" && currentUser) {
            next("/");
        } else {
            next();
        }
    });
    axios.interceptors.response.use(null, error => {
        if (error.response.status === 401) {
            store.commit("auth/LOGOUT");
            router.push("/");
        }
        return Promise.reject(error);
    });
}

export const notifyOptions = {
    type: "success",
    allow_dismiss: false,
    newest_on_top: false,
    mouse_over: false,
    showProgressbar: false,
    spacing: 10,
    timer: 2000,
    placement: {
        from: "bottom",
        align: "right"
    },
    offset: {
        x: 30,
        y: 30
    },
    delay: 1000,
    z_index: 10000,
    animate: {
        enter: "animated fadeInUp",
        exit: "animated fadeOutRight"
    }
};

export function displayErrors(error) {
    let list = [];
    let message = "";

    if (error.response.data.errors) {
        list = Object.values(error.response.data.errors);
        list = list.flat();
        message = list.map(err => `<li>${err}</li>`).join("");
    }

    notify("danger", {
        title: "Something went wrong",
        message: message ? message : error.response.data.message
    });

    return false;
}

export function notify(type, content) {
    const options = notifyOptions;
    options.type = type;

    $.notify(content, options);
}
