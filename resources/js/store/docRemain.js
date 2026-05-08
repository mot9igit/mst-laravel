export default {
    state: {
        docRemains: [],
        docRemain: {}
    },
    actions: {
        getDocRemains ({ commit }, {docId, remainId, filter, page, sort, perpage}) {
            const payload = {
                doc_id: docId,
                remain_id: remainId,
                filter: filter,
                sort: sort,
                page: page,
                perpage: perpage
            }
            return this.$app.config.globalProperties.$api.docRemain.getDocRemains(payload).then((response) => {
                commit('SET_DOC_REMAINS', response.data)
            })
        },
        getDocRemain ({ commit }, id) {
            return this.$app.config.globalProperties.$api.docRemain.getDocRemain(id).then((response) => {
                commit('SET_DOC_REMAIN', response.data)
            })
        }
    },
    mutations: {
        SET_DOC_REMAINS: (state, data) => {
            state.docRemains = data
        },
        SET_DOC_REMAIN: (state, data) => {
            state.docRemain = data
        }
    },
    getters: {
        docRemains (state) {
            return state.docRemains
        },
        docRemain (state) {
            return state.docRemain
        }
    }
}
