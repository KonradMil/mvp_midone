const state = () => {
    return {
        menu: [
            {
                icon: "HomeIcon",
                pageName: "dashboard",
                title: "Dashboard",
            },
            {
                icon: "HomeIcon",
                pageName: "models",
                title: "Models",
            },
            {
                icon: "BoxIcon",
                pageName: "#",
                title: "Wyzwania",
                subMenu: [
                    {
                        icon: "",
                        pageName: "challenges",
                        title: "Wszystkie",
                        ignore: true
                    },
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
                icon: "HomeIcon",
                pageName: "teams",
                title: "Zespoły",
            },
            {
                icon: "InboxIcon",
                pageName: "studio",
                title: "3D Studio"
            },
            {
                icon: "InboxIcon",
                pageName: "knowledgebase",
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
