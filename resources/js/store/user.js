export default {
    state: {
        profile: [],
        users: [],
        user: {}
    },
    actions: {
        getUsers({commit}, {filter, filtersdata, page, sort, perpage}) {
            const payload = {
                filter: filter,
                filtersdata: filtersdata,
                sort: sort,
                page: page,
                perpage: perpage
            }
            return this.$app.config.globalProperties.$api.user.getUsers(payload).then((response) => {
                commit('SET_USERS', response.data)
            })
        },
        getProfile({commit}, {user_id}) {
            return this.$app.config.globalProperties.$api.user.getProfile(user_id).then((response) => {
                commit('SET_PROFILE', response.data)
            })
        },
        getUser({commit}, {userid}) {
            return this.$app.config.globalProperties.$api.user.getUser(userid).then((response) => {
                commit('SET_USER', response.data)
            })
        }
    },
    mutations: {
        SET_PROFILE: (state, data) => {
            state.profile = data
        },
        SET_USER: (state, data) => {
            state.user = data
        },
        SET_USERS: (state, data) => {
            state.users = data
        }
    },
    getters: {
        profile(state) {
            return state.profile
        },
        users(state) {
            return state.users
        },
        userData(state) {
            return state.user
        }
    }
}
