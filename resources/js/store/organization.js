import Axios from 'axios'

export default {
    state: {
        organizations: {},
        organization: {},
        organizationUsers: {}
    },
    actions: {
        getOrganizations ({ commit }, {filter, filtersdata, page, sort, perpage}) {
            return Axios('/api/integration/organization/', {
                method: 'GET',
                params: {
                    filter: filter,
                    filtersdata: filtersdata,
                    sort: sort,
                    page: page,
                    perpage: perpage
                }
            })
                .then((response) => {
                    commit('SET_ORGANIZATIONS', response.data)
                })
                .catch(error => {
                    if (error.response.status === 403) {
                        // TODO: to auth page
                    }
                })
        },
        getOrganization ({ commit }, {organizationId}) {
            return Axios(`/api/integration/organization/${organizationId}`, {
                method: 'GET'
            })
                .then((response) => {
                    commit('SET_ORGANIZATION', response.data)
                })
                .catch(error => {
                    if (error.response.status === 403) {
                        // TODO: to auth page
                    }
                })
        },
        getOrganizationUsers ({ commit }, {org_id, filter, filtersdata, page, sort, perpage}) {
            return Axios(`/api/integration/organization/${org_id}/user`, {
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
                    commit('SET_ORGANIZATION_USERS', response.data)
                })
                .catch(error => {
                    if (error.response.status === 403) {
                        // TODO: to auth page
                    }
                })
        },
    },
    mutations: {
        SET_ORGANIZATION: (state, data) => {
            state.organization = data
        },
        SET_ORGANIZATIONS: (state, data) => {
            state.organizations = data
        },
        SET_ORGANIZATION_USERS: (state, data) => {
            state.organizationUsers = data
        }
    },
    getters: {
        organizations (state) {
            return state.organizations
        },
        organization (state) {
            return state.organization
        },
        organizationUsers (state) {
            return state.organizationUsers
        },
    }
}
