export default function (instance) {
    return {
        getRequisites(payload) {
            const data = instance
                .get(`/api/integration/requisite/`, { params: payload })
            return data
        },
        getRequisite(requisiteId) {
            const data = instance
                .get(`/api/integration/requisite/${requisiteId}`)
            return data
        }
    }
}
