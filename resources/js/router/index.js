import {createWebHistory, createRouter} from "vue-router";

import Register from '../pages/Register';
import Login from '../pages/Login';
import Dashboard from '../pages/Dashboard';
import SideMenu from '../layouts/side-menu/Main'
import Wizard from "../pages/Wizard";
import Profile from "../pages/Wizard";
import WizardOne from "../pages/WizardOne";
import Challenges from "../pages/Challenges/Main";
import Projects from "../pages/Projects/Main";
import ProjectCard from "../pages/Projects/Card";
import AddChallenge from "../pages/Challenges/New";
import Solutions from "../pages/Solutions/Main";
import AddSolution from "../pages/Solutions/New";
import Teams from "../pages/Teams/Teams";
import NotFound from "../pages/NotFound";
import Main from "../pages/Unity/Main";
import MainHangar from "../pages/Unity/Hangars/MainHangar";
import MainKnowledgebase from "../pages/KnowledgeBase/Main";
import AddKnowledgebase from "../pages/KnowledgeBase/Add";
import Profiles from "../pages/Profiles/Main";
import ChangePassword from "../pages/Profiles/ChangePassword";
import List from "../pages/Models/List";
import ModelAdd from "../pages/Models/ModelAdd";
import ModelEdit from "../pages/Models/ModelEdit";
import Card from "../pages/Challenges/Card";
import Communication from "../pages/Communication/Main";
import ReportReview from "../pages/Communication/ReportReview";
import TermsMain from "../pages/Terms/TermsMain";
import ForgotPassword from "../pages/ForgotPassword";
import Workshop from "../pages/Unity/Workshop/Workshop";
import NewOffer from "../pages/Offers/NewOffer";
import Offers from "../pages/Challenges/components/Offers";
import SolutionsPanel from "../pages/Challenges/components/SolutionsPanel";
import ProjectsList from "../pages/Admin/ProjectsList";
import UserList from '../pages/Admin/UserList';
import SolutionsArchive from "../pages/Solutions/SolutionsArchive";
import Notifications from "../pages/Notifications";

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
        name: 'studio',
        path: '/studio',
        component: Main,
        props: true
    },
    {
        name: 'challengeStudio',
        path: '/studio/:type/:id',
        component: Main,
        props: true
    },
    {
        name: 'hangarStudio',
        path: '/hangar',
        component: MainHangar,
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
                name: 'admin-projects',
                path: '/admin/projects',
                component: ProjectsList,
                props: true
            },
            {
                name: 'admin-users',
                path: '/admin/users',
                component: UserList,
                props: true
            },
            {
                name: 'workshop',
                path: '/workshop',
                component: Workshop,
                props: true
            },
            {
                name: 'notifications',
                path: "/notifications",
                component: Notifications,
                props: true
            },
            {
                name: 'offer-add',
                path: '/offer/add',
                component: NewOffer,
                props: true
            },
            {
                name: 'offers',
                path: '/offers',
                component: Offers,
                props: true
            },
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
                path: '/models/edit/:id',
                component: ModelEdit,
                props: true
            },
            {
                name: 'reportReview',
                path: '/report/show/:id',
                component: ReportReview,
                props: true
            },
            {
                name: 'projects',
                path: '/projects',
                component: Projects
            },
            {
                name: 'projectCard',
                path: '/projects/card/:id',
                component: ProjectCard,
                props: true
            },
            {
                name: 'addChallenge',
                path: '/challenge/add',
                component: AddChallenge,
                props: true
            },
            {
                name: 'challenges',
                path: '/challenges',
                component: Challenges,
                props: {type: 'normal'}
            },
            {
                name: 'challengesFollowed',
                path: '/challenges/followed',
                component: Challenges,
                props: {type: 'followed'}
            },
            {
                name: 'challengesArchive',
                path: '/challenges/archive',
                component: Challenges,
                props: {type: 'archive'}
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
                name: 'solutionsArchive',
                path: '/solutions/archive',
                component: SolutionsArchive,
                props: true
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
            },
            {
                name: 'wizardone',
                path: '/kreator-krok-jeden',
                component: WizardOne
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
