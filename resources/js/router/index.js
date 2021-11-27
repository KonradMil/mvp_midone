import {createWebHistory, createRouter} from "vue-router";

import Register from '../pages/Register';
import Login from '../pages/Login';
import Dashboard from '../pages/Dashboard';
import SideMenu from '../layouts/side-menu/Main'
import Wizard from "../pages/Wizard";
import Profile from "../pages/Wizard";
import Teams from "../pages/Teams/Teams";
import NotFound from "../pages/NotFound";
import Profiles from "../pages/Profiles/Main";
import ChangePassword from "../pages/Profiles/ChangePassword";
import Communication from "../pages/Communication/Main";
import ReportReview from "../pages/Communication/ReportReview";
import TermsMain from "../pages/Terms/TermsMain";
import ForgotPassword from "../pages/ForgotPassword";
import Notifications from "../pages/Notifications";
import Impersonate from "../pages/Impersonate";

export const routes = [
    {
        name: 'reset-password',
        path: '/reset-password/:token',
        component: ForgotPassword,
        props: true
    },
    {
        name: 'login',
        path: '/login',
        component: Login
    },
    {
        name: 'register',
        path: '/register',
        component: Register
    },
    {
        name: 'acceptInvite',
        path: '/teams/user/accept_invite/:token',
        component: Register,
        props: true
    },
    {
        name: 'terms',
        path: "/terms/:page",
        component: TermsMain,
        props: true
    },
    {
        path: "/",
        component: SideMenu,
        children: [
            {
                name: 'impersonate',
                path: '/impersonate',
                component: Impersonate
            },
            {
                name: 'notifications',
                path: "/notifications",
                component: Notifications,
                props: true
            },
            {
                name: 'reportReview',
                path: '/report/show/:id',
                component: ReportReview,
                props: true
            },
            {
                name: 'teams',
                path: '/teams',
                component: Teams
            },
            {
                name: 'communication',
                path: '/communication',
                component: Communication
            },
            {
                name: 'communication',
                path: '/communication',
                component: Communication
            },
            {
                name: 'wizard',
                path: '/kreator',
                component: Wizard
            },
            {
                name: 'profile',
                path: '/profile',
                component: Profile,
            },
            {
                name: 'profiles',
                path: '/profiles',
                component: Profiles,
                props: true
            },
            {
                name: 'change-password',
                path: '/change-password',
                component: ChangePassword
            },
        ]
    },
    {
        path: "/:catchAll(.*)",
        component: NotFound,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});

export default router;
