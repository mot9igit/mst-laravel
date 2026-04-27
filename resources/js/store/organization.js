import Axios from 'axios'

export default {
    state: {
        organizations: {},
        organization: {},
        organizationUsers: {},
        organizationStores: {},
        organizationVendors: {}
    },
    actions: {
        getOrganizations ({ commit }, {filter, filtersdata, page, sort, perpage}) {
            const payload = {
                filter: filter,
                filtersdata: filtersdata,
                sort: sort,
                page: page,
                perpage: perpage
            }
            return this.$app.config.globalProperties.$api.organization.getOrganizations(payload).then((response) => {
                commit('SET_ORGANIZATIONS', response.data)
            })
        },
        getOrganization ({ commit }, { organizationId }) {
            return this.$app.config.globalProperties.$api.organization.getOrganization(organizationId).then((response) => {
                commit('SET_ORGANIZATION', response.data)
            })
        },
        getOrganizationUsers ({ commit }, {org_id, filter, filtersdata, page, sort, perpage}) {
            const payload = {
                org_id: org_id,
                filter: filter,
                filtersdata: filtersdata,
                sort: sort,
                page: page,
                perpage: perpage
            }
            return this.$app.config.globalProperties.$api.organization.getOrganizationUsers(org_id, payload).then((response) => {
                commit('SET_ORGANIZATION_USERS', response.data)
            })
        },
        getOrganizationStores ({ commit }, {org_id, filter, filtersdata, page, sort, perpage}) {
            const payload = {
                org_id: org_id,
                filter: filter,
                filtersdata: filtersdata,
                sort: sort,
                page: page,
                perpage: perpage
            }
            return this.$app.config.globalProperties.$api.organization.getOrganizationStores(org_id, payload).then((response) => {
                commit('SET_ORGANIZATION_STORES', response.data)
            })
        },
        getOrganizationVendors ({ commit }, {org_id, filter, filtersdata, page, sort, perpage}) {
            const payload = {
                org_id: org_id,
                filter: filter,
                filtersdata: filtersdata,
                sort: sort,
                page: page,
                perpage: perpage
            }
            return this.$app.config.globalProperties.$api.organization.getOrganizationVendors(org_id, payload).then((response) => {
                commit('SET_ORGANIZATION_VENDORS', response.data)
            })
        }
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
        },
        SET_ORGANIZATION_STORES: (state, data) => {
            state.organizationStores = data
        },
        SET_ORGANIZATION_VENDORS: (state, data) => {
            state.organizationVendors = data
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
        organizationStores (state) {
            return state.organizationStores
        },
        organizationVendors (state) {
            return state.organizationVendors
        }
    }
}
