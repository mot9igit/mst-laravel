export default function (instance) {
    return {
        getDocRemains(payload) {
            return instance
                .get(`/api/integration/store/document/remain`, {params: payload})
        },
        getDocRemain(id) {
            return instance
                .get(`/api/integration/store/document/remain/${id}`)
        },
    }
}
