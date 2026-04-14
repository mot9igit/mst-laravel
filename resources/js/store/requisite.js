import Axios from 'axios'

export default {
    state: {
        requisites: [],
        requisite: {}
    },
    actions: {
        getRequisites ({ commit }, {org_id, filter, filtersdata, page, sort, perpage}) {
            const payload = {
                org_id: org_id,
                filter: filter,
                filtersdata: filtersdata,
                sort: sort,
                page: page,
                perpage: perpage
            }
            return this.$app.config.globalProperties.$api.requisite.getRequisites(payload).then((response) => {
                commit('SET_REQUISITES', response.data)
            })
        },
        getRequisite ({ commit }, { requisite_id }) {
            return this.$app.config.globalProperties.$api.requisite.getRequisite(requisite_id).then((response) => {
                commit('SET_REQUISITE', response.data)
            })
        }
    },
    mutations: {
        SET_REQUISITES: (state, data) => {
            state.requisites = data
        },
        SET_REQUISITE: (state, data) => {
            state.requisite = data
        }
    },
    getters: {
        requisites (state) {
            return state.requisites
        },
        requisite (state) {
            return state.requisite
        }
    }
}
