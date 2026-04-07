import Axios from 'axios'

export default {
    state: {
        bankRequisites: [],
        bankRequisite: {}
    },
    actions: {
        getBankRequisites ({ commit }, {org_id, requisite_id, filter, filtersdata, page, sort, perpage}) {
            return Axios('/api/integration/bank-requisite/', {
                method: 'GET',
                params: {
                    org_id: org_id,
                    requisite_id: requisite_id,
                    filter: filter,
                    filtersdata: filtersdata,
                    sort: sort,
                    page: page,
                    perpage: perpage
                }
            })
                .then((response) => {
                    commit('SET_BANK_REQUISITES', response.data)
                })
                .catch(error => {
                    if (error.response.status === 403) {
                        // TODO: to auth page
                    }
                })
        },
        getBankRequisite ({ commit }, { bank_requisite_id }) {
            return Axios(`/api/integration/bank-requisite/${bank_requisite_id}`, {
                method: 'GET'
            })
                .then((response) => {
                    commit('SET_BANK_REQUISITE', response.data)
                })
                .catch(error => {
                    if (error.response.status === 403) {
                        // TODO: to auth page
                    }
                })
        }
    },
    mutations: {
        SET_BANK_REQUISITES: (state, data) => {
            state.bankRequisites = data
        },
        SET_BANK_REQUISITE: (state, data) => {
            state.bankRequisite = data
        }
    },
    getters: {
        bankRequisites (state) {
            return state.bankRequisites
        },
        bankRequisite (state) {
            return state.bankRequisite
        }
    }
}
