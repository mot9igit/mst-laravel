import Axios from 'axios'

export default {
    state: {
        organizations: {},
        organization: {},
        organizationUsers: {}
    },
    actions: {
        getOrganizations ({ commit }, {filter, filtersdata, page, sort, perpage}) {
            this.$app.config.globalProperties.$load(
                async () => {
                    const payload = {
                        filter: filter,
                        filtersdata: filtersdata,
                        sort: sort,
                        page: page,
                        perpage: perpage
                    }
                    const response = await this.$app.config.globalProperties.$api.organization.getOrganizations(payload).then((response) => {
                        commit('SET_ORGANIZATIONS', response.data)
                    })
                }
            )
        },
        getOrganization ({ commit }, { organizationId }) {
            this.$app.config.globalProperties.$load(
                async () => {
                    const response = await this.$app.config.globalProperties.$api.organization.getOrganization(organizationId).then((response) => {
                        commit('SET_ORGANIZATION', response.data)
                    })
                }
            )
        },
        getOrganizationUsers ({ commit }, {org_id, filter, filtersdata, page, sort, perpage}) {
            this.$app.config.globalProperties.$load(
                async () => {
                    const payload = {
                        org_id: org_id,
                        filter: filter,
                        filtersdata: filtersdata,
                        sort: sort,
                        page: page,
                        perpage: perpage
                    }
                    const response = await this.$app.config.globalProperties.$api.organization.getOrganizationUsers(org_id, payload).then((response) => {
                        commit('SET_ORGANIZATION_USERS', response.data)
                    })
                }
            )
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
