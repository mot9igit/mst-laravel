export default function (instance) {
    return {
        getBankRequisites(payload) {
            const data = instance
                .get(`/api/integration/bank-requisite/`, { params: payload })
            return data
        },
        getBankRequisite(requisiteId) {
            const data = instance
                .get(`/api/integration/bank-requisite/${requisiteId}`)
            return data
        }
    }
}
