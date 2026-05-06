export default {
    state: {
        apiKeys: [],
        apiKey: {}
    },
    actions: {
        getApiKeys ({ commit }, {org_id, store_id, filter, page, sort, perpage}) {
            const payload = {
                org_id: org_id,
                store_id: store_id,
                filter: filter,
                sort: sort,
                page: page,
                perpage: perpage
            }
            return this.$app.config.globalProperties.$api.apiKey.getApiKeys(payload).then((response) => {
                commit('SET_API_KEYS', response.data)
            })
        },
        getApiKey ({ commit }, { contactPersonId }) {
            return this.$app.config.globalProperties.$api.apiKey.getApiKey(contactPersonId).then((response) => {
                commit('SET_API_KEY', response.data)
            })
        }
    },
    mutations: {
        SET_API_KEYS: (state, data) => {
            state.apiKeys = data
        },
        SET_API_KEY: (state, data) => {
            state.apiKey = data
        }
    },
    getters: {
        apiKeys (state) {
            return state.apiKeys
        },
        apiKey (state) {
            return state.apiKey
        }
    }
}
