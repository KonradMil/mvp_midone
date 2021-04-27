import {createWebHistory, createRouter} from "vue-router";

import Register from '../pages/Register';
import Login from '../pages/Login';
import Dashboard from '../pages/Dashboard';
import SideMenu from '../layouts/side-menu/Main'
import Wizard from "../pages/Wizard";
import Profile from "../pages/Wizard";
import WizardOne from "../pages/WizardOne";
import WizardTwo from "../pages/WizardTwo";
import Challenges from "../pages/Challenges/Main";
import AddChallenge from "../pages/Challenges/New";
import Solutions from "../pages/Solutions/Main";
import AddSolution from "../pages/Solutions/New";
import Teams from "../pages/Teams/Teams";
import NotFound from "../pages/NotFound";
import Main from "../pages/Unity/Main";
import MainKnowledgebase  from "../pages/KnowledgeBase/Main";
import AddKnowledgebase  from "../pages/KnowledgeBase/Add";
import Profiles from "../pages/Profiles/Main";
import ChangePassword from "../pages/Profiles/ChangePassword";
import List from "../pages/Models/List";
import ModelAdd from "../pages/Models/ModelAdd";
import ModelEdit from "../pages/Models/ModelEdit";
import Card from "../pages/Challenges/Card";
import Communication from "../pages/Communication/Main";

export const routes = [
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
        name: 'studio',
        path: '/studio',
        component: Main,
        props: true
    },
    {
        path: "/",
        component: SideMenu,
        children: [
            {
                name: 'models',
                path: '/models',
                component: List,
                props: true
            },
            {
                name: 'modelsAdd',
                path: '/models/add',
                component: ModelAdd,
                props: true
            },
            {
                name: 'modelEdit',
                path: '/models/edit',
                component: ModelEdit,
                props: true
            },
            {
                name: 'addChallenge',
                path: '/challenge/add',
                component: AddChallenge
            },
            {
                name: 'challenges',
                path: '/challenges',
                component: Challenges
            },
            {
                name: 'internalChallenegeCard',
                path: '/challenges/card/:id',
                component: Card,
                props: true
            },
            {
                name: 'addSolution',
                path: '/solution/add',
                component: AddSolution
            },
            {
                name: 'solutions',
                path: '/solutions',
                component: Solutions
            },
            {
                name: 'knowledgebase',
                path: '/knowledgebase',
                component: MainKnowledgebase
            },
            {
                name: 'addKnowledgebasePost',
                path: '/knowledgebase/post/add',
                component: AddKnowledgebase
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
            },{
                name: 'wizardone',
                path: '/kreator-krok-jeden',
                component: WizardOne
            },
            {
                name: 'wizardtwo',
                path: '/kreator-krok-dwa',
                component: WizardTwo
            },
            {
                name: 'profile',
                path: '/profile',
                component: Profile,
            },
            {
                name: 'dashboard',
                path: '/dashboard',
                component: Dashboard
            },
            {
                name: 'profiles',
                path: '/profiles',
                component: Profiles
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
