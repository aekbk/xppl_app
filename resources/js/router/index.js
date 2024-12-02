
import { createWebHistory, createRouter } from "vue-router";
import { useAuthStore } from "../stores/auth.js";


const routes = [
    { path: '/', redirect: '/home' },
    { path: '/home', name: 'homePage', component: () => import('../pages/home.vue'), meta: { requiresAuth: true } },
    { path: '/login', name: 'loginPage', component: () => import('../pages/login.vue') },
    { path: '/register', name: 'registerPage', component: () => import('../pages/register.vue') },
    { path: '/maintenance', name: 'maintenancePage', component: () => import('../pages/maintenance.vue') },
    { path: '/authorise', name: 'authorisePage', component: () => import('../pages/authorise.vue'), meta: { requiresAuth: true } },

    { path: '/control-tower', name: 'controlTower', component: () => import('../pages/control_tower.vue'), meta: { requiresAuth: true } },
    { path: '/drilldown-mining', name: 'drilldownMining', component: () => import('../pages/drilldown_mining.vue'), meta: { requiresAuth: true } },
    { 
        path: '/drilldown-processing', 
        name: 'processingDrilldown', 
        component: () => import('../pages/drilldown_processing.vue'), 
        meta: { requiresAuth: true },
        redirect: to => { return '/drilldown-processing/input' },
        children: [
            {
                path: 'input',
                default: true,
                component: () => import('../pages/drilldown_processing_input.vue'),
                meta: { requiresAuth: true },
            },
        ],

    },

    { path: '/admin-menu', name: 'adminPage', component: () => import('../pages/admin_menu.vue'), meta: { requiresAuth: true } },
    { path: '/admin-email-register', name: 'adminEmailPage', component: () => import('../pages/admin_email_register.vue'), meta: { requiresAuth: true } },

    { path: '/dashboard-sale', name: 'saleDashboardPage', component: () => import('../pages/dash_sale.vue'), meta: { requiresAuth: true } },
    { path: '/dashboard-production', name: 'prodDashboardPage', component: () => import('../pages/dash_production.vue'), meta: { requiresAuth: true } },
    { path: '/dashboard-sale-ldb', name: 'sale2DashboardPage', component: () => import('../pages/dash_sale2.vue'), meta: { requiresAuth: true } },

    { path: '/sale-customer', name: 'saleCustomerPage', component: () => import('../pages/sale_customer.vue'), meta: { requiresAuth: true } },
    { path: '/sale-contract', name: 'saleContractPage', component: () => import('../pages/sale_contract.vue'), meta: { requiresAuth: true } },
    { path: '/sale-data', name: 'saleDataPage', component: () => import('../pages/sale_data.vue'), meta: { requiresAuth: true } },
    { path: '/sale-code', name: 'saleCodePage', component: () => import('../pages/sale_code.vue'), meta: { requiresAuth: true } },
    { path: '/sale-filemanager', name: 'saleFilePage', component: () => import('../pages/sale_filemanager.vue'), meta: { requiresAuth: true } },

    { path: '/safety-code', name: 'stCodePage', component: () => import('../pages/safety_code.vue'), meta: { requiresAuth: true } },
    { path: '/safety-incident', name: 'stIncidentPage', component: () => import('../pages/safety_incident.vue'), meta: { requiresAuth: true } },

    { path: '/clinic-treatment', name: 'clinicTreatmentPage', component: () => import('../pages/clinic_treatment.vue'), meta: { requiresAuth: true } },
    { path: '/clinic-medicine', name: 'clinicPatienPage', component: () => import('../pages/clinic_medicine.vue'), meta: { requiresAuth: true } },
    { path: '/clinic-store', name: 'clinicStorePage', component: () => import('../pages/clinic_store.vue'), meta: { requiresAuth: true } },
    { path: '/clinic-code', name: 'clinicCodePage', component: () => import('../pages/clinic_code.vue'), meta: { requiresAuth: true } },

    { path: '/production-geodata', name: 'mineProductionPage', component: () => import('../pages/prod_geo_data.vue'), meta: { requiresAuth: true } },
    { path: '/production-georeport', name: 'mineProdReportPage', component: () => import('../pages/prod_geo_report.vue'), meta: { requiresAuth: true } },

    { path: '/sample-ticket', name: 'sampleTicketPage', component: () => import('../pages/sample_ticket.vue'), meta: { requiresAuth: true } },

    { path: '/employee-name', name: 'empNamePage', component: () => import('../pages/emp_name.vue'), meta: { requiresAuth: true } },
    { path: '/employee-roster', name: 'empRosterPage', component: () => import('../pages/emp_roster.vue'), meta: { requiresAuth: true } },
    { path: '/employee-fingerprint', name: 'empFingerprintPage', component: () => import('../pages/emp_fingerprint.vue'), meta: { requiresAuth: true } },
    { path: '/employee-overtime', name: 'empOvertimePage', component: () => import('../pages/emp_overtime.vue'), meta: { requiresAuth: true } },
    { path: '/employee-annualleave', name: 'empAnnualLeavePage', component: () => import('../pages/emp_annual_leave.vue'), meta: { requiresAuth: true } },
    { path: '/employee-dayleave', name: 'empDayLeavePage', component: () => import('../pages/emp_day_leave.vue'), meta: { requiresAuth: true } },
    { path: '/employee-code', name: 'empCodePage', component: () => import('../pages/emp_code.vue'), meta: { requiresAuth: true } },

];


const router = createRouter({
    history: createWebHistory(),
    routes: routes,
    scrollBehavior() {
        window.scrollTo(0, 0);
    }
});

router.beforeEach((to, from, next) => {

    const token = localStorage.getItem('token');
    const user = localStorage.getItem('user');
    const authStore = useAuthStore();

    if (token) {
        authStore.setToken(token);
        authStore.setUser(JSON.parse(user));

        if (to.path == '/login' || to.path == '/register') {
            return next({
                path: '/',
                replace: true
            })
        }

    } else {
        authStore.removeToken();
        authStore.removeUser();
    };

    if (to.meta.requiresAuth) {
        if (!token) {
            return next({
                path: '/login',
                replace: true
            })
        }
    }
    next()
});

export default router;