export default function (instance) {
    return {
        getOrganizationUsers(organizationId, payload) {
            const data = instance
                .get(`/api/integration/organization/${organizationId}/user`, { params: payload })
            return data
        },
        getOrganizationVendors(organizationId, payload) {
            const data = instance
                .get(`/api/integration/organization/${organizationId}/vendor`, { params: payload })
            return data
        },
        getOrganizationStores(organizationId, payload) {
            const data = instance
                .get(`/api/integration/organization/${organizationId}/store`, { params: payload })
            return data
        },
        getOrganizations() {
            const data = instance
                .get('/api/integration/organization/')
            return data
        },
        getOrganization(organizationId) {
            const data = instance
                .get(`/api/integration/organization/${organizationId}`)
            return data
        },
    }
}
