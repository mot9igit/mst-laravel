import Axios from 'axios'

export default {
    state: {
        requisites: []
    },
    actions: {
        getRequisites ({ commit }, {org_id, filter, filtersdata, page, sort, perpage}) {
            return Axios('/api/integration/requisite/', {
                method: 'GET',
                params: {
                    org_id: org_id,
                    filter: filter,
                    filtersdata: filtersdata,
                    sort: sort,
                    page: page,
                    perpage: perpage
                }
            })
                .then((response) => {
                    commit('SET_REQUISITES', response.data)
                })
                .catch(error => {
                    if (error.response.status === 403) {
                        // TODO: to auth page
                    }
                })
        }
    },
    mutations: {
        SET_REQUISITES: (state, data) => {
            state.requisites = data
        }
    },
    getters: {
        requisites (state) {
            return state.requisites
        }
    }
}
