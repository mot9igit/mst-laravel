export default {
    state: {
        docs: [],
        doc: {}
    },
    actions: {
        getDocs ({ commit }, {storeId, filter, page, sort, perpage}) {
            const payload = {
                store_id: storeId,
                filter: filter,
                sort: sort,
                page: page,
                perpage: perpage
            }
            return this.$app.config.globalProperties.$api.doc.getDocs(payload).then((response) => {
                commit('SET_DOCS', response.data)
            })
        },
        getDoc ({ commit }, { storeId, docId }) {
            return this.$app.config.globalProperties.$api.doc.getDoc(storeId, docId).then((response) => {
                commit('SET_DOC', response.data)
            })
        }
    },
    mutations: {
        SET_DOCS: (state, data) => {
            state.docs = data
        },
        SET_DOC: (state, data) => {
            state.doc = data
        }
    },
    getters: {
        docs (state) {
            return state.docs
        },
        doc (state) {
            return state.doc
        }
    }
}
