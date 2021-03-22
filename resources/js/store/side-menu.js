const state = () => {
    return {
        menu: [
            {
                icon: "HomeIcon",
                pageName: "ashboard",
                title: "Dashboard",
            },
            {
                icon: "BoxIcon",
                pageName: "challenges",
                title: "Wyzwania",
                subMenu: [
                    {
                        icon: "",
                        pageName: "challenges-active",
                        title: "Aktywne",
                        ignore: true
                    },
                    {
                        icon: "",
                        pageName: "challenges-archived",
                        title: "Archiwalne",
                        ignore: true
                    },
                    {
                        icon: "",
                        pageName: "challenges-watched",
                        title: "Obserwowane",
                        ignore: true
                    }
                ]
            },
            {
                icon: "BoxIcon",
                pageName: "solutions",
                title: "Rozwiązania",
                subMenu: [
                    {
                        icon: "",
                        pageName: "solutions-active",
                        title: "Aktywne",
                        ignore: true
                    },
                    {
                        icon: "",
                        pageName: "solutions-archived",
                        title: "Archiwalne",
                        ignore: true
                    },
                    {
                        icon: "",
                        pageName: "solutions-watched",
                        title: "Obserwowane",
                        ignore: true
                    }
                ]
            },
            {
                icon: "BoxIcon",
                pageName: "offers",
                title: "Oferty",
                subMenu: [
                    {
                        icon: "",
                        pageName: "offers-active",
                        title: "Aktywne",
                        ignore: true
                    },
                    {
                        icon: "",
                        pageName: "offers-archived",
                        title: "Archiwalne",
                        ignore: true
                    },
                ]
            },
            {
                icon: "BoxIcon",
                pageName: "projects",
                title: "Projekty",
                subMenu: [
                    {
                        icon: "",
                        pageName: "projects-active",
                        title: "Aktywne",
                        ignore: true
                    },
                    {
                        icon: "",
                        pageName: "projects-archived",
                        title: "Archiwalne",
                        ignore: true
                    },
                ]
            },
            {
                icon: "InboxIcon",
                pageName: "studio",
                title: "3D Studio"
            },
            {
                icon: "InboxIcon",
                pageName: "knowledge-base",
                title: "Baza wiedzy"
            },
            {
                icon: "InboxIcon",
                pageName: "object-marketplace",
                title: "Marketplace obiektów"
            },
            {
                icon: "InboxIcon",
                pageName: "communication",
                title: "Komunikacja"
            },
        ]
    };
};

// getters
const getters = {
    menu: state => state.menu
};

// actions
const actions = {};

// mutations
const mutations = {};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};
